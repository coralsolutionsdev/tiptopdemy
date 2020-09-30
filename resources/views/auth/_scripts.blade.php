<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    var userFieldId = null;
    var userFieldOptionId = null;
    var userLevelId = null;
    @if(!empty($user))
        userFieldId = '{{$user->field_id}}';
        userFieldOptionId = '{{$user->field_option_id}}';
        userLevelId = '{{$user->level}}';
    @endif
    // initials
    $(".birthday").flatpickr();
    /**
     * functions
     */
    function resetFieldOptions() {
        $('.field-item-options').html('');
        {{--$('.field-item-options').append('<option selected="true" disabled="disabled">{{__('Study type')}}</option>');--}}
    }
    function resetFieldLevels() {
        $('.field-level-options').html('');
        {{--$('.field-level-options').append('<option selected="true" disabled="disabled">{{__('Study Level')}}</option>');--}}
    }
    function resetFields() {
        $('.fields').html('');
        {{--$('.fields').append('<option selected="true" disabled="disabled">{{__('Study field')}}</option>');--}}
    }
    function updateFieldLevelsMenu(id) {
        $.get('/get/institution/scope/field/'+id+'/levels').done(function (response) {
            var levels = response.items;
            resetFieldLevels();
            if (levels !== undefined){
                if(levels.length != 0){
                    $.each(levels, function (id, level) {
                        var selected = '';
                        if (level.status === 1){
                            if (userLevelId != null){
                                if (userLevelId == id){
                                    selected = 'selected';
                                }
                            }else{
                                if (level.default === 1){
                                    selected = 'selected';
                                }
                            }
                            $('.field-level-options').append('<option value="'+id+'" '+selected+'>'+level.title+'</option>');
                        }
                    });
                    // done
                }
            }
        });

    }
    function updateFieldOptionsMenu(id) {
        $.get('/get/institution/scope/field/'+id+'/options').done(function (response) {
            var items = response.items;
            resetFieldOptions();
            if(items.length !== 0){
                $.each(items,  function (id, option) {
                    var selected = '';
                    if(userFieldOptionId != null && userFieldOptionId == option.id){
                        selected = 'selected';
                    }else if (option.default == 1){
                        selected = 'selected';
                    }
                    var description = ''
                    if(option.description != null)
                    {
                        description = option.description;
                    }
                    $('.field-item-options').append('<option value="'+option.id+'" '+selected+' title="'+description+'">'+option.title+'</option>');
                })
                // done
            } else {
                // field
            }
        });

    }
    function updateFieldsMenu(id){
        $.get('/get/institution/scope/'+id+'/fields').done(function (response) {
            var fields = response.items;
            resetFields();
            resetFieldLevels();
            resetFieldOptions();
            if(fields.length !== 0){
                var defaultFieldId = null;
                var levels = null;
                $.each(fields,  function (id, field) {
                    var selected = '';
                    if(userFieldId != null && userFieldId == field.id){
                        selected = 'selected';
                        defaultFieldId = field.id;
                        levels = field.levels;
                    }else if (field.default == 1){
                        selected = 'selected';
                        defaultFieldId = field.id;
                        levels = field.levels;
                    }
                    var description = ''
                    if(field.description != null)
                    {
                        description = field.description;
                    }
                    $('.fields-items').append('<option value="'+field.id+'" '+selected+' title="'+description+'">'+field.title+'</option>');
                });
                if (defaultFieldId != null){
                    // update levels
                    updateFieldLevelsMenu(defaultFieldId);
                    // update options
                    updateFieldOptionsMenu(defaultFieldId);
                }


            }
            // done
        });

    }

    function initiateDefaults()
    {
        var id = $('.scope').val();
        toggleScreenSpinner(true);
        updateFieldsMenu(id);
    }
    /**
     * methods
     */


    $('.scope').change(function () {
        var id = $(this).val();
        toggleScreenSpinner(true);
        updateFieldsMenu(id);
    });

    $('.fields').change(function () {
        var id = $(this).val();
        toggleScreenSpinner(true);
        // update levels
        updateFieldLevelsMenu(id);
        // update options
        updateFieldOptionsMenu(id);

    });

    $( document ).ready(function() {
        initiateDefaults();
    });

    $( document ).ajaxComplete(function() {
        toggleScreenSpinner(false);
    });

</script>