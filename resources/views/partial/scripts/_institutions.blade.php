<script>
    /**
     * functions
     */
    function toggleScreenSpinner($status = false) {
        if($status === true){
            $('.Loading-status').html('<span class="text-warning">Loading in process...</span>');
        }else {
            $('.Loading-status').html("");
        }
    }
    function resetFieldOptions() {
        $('.field-item-options').html('');
        $('.field-item-options').append('<option selected="true" disabled="disabled">{{__('Study type')}}</option>');
    }
    function resetFieldLevels() {
        $('.field-level-options').html('');
        $('.field-level-options').append('<option selected="true" disabled="disabled">{{__('Study Level')}}</option>');
    }
    function resetFields() {
        $('.fields').html('');
        $('.fields').append('<option selected="true" disabled="disabled">{{__('Study field')}}</option>');
    }
    function updateFieldLevelsMenu(id) {
        $.get('/get/institution/scope/field/'+id+'/levels').done(function (response) {
            var levels = response.items;
            resetFieldLevels();
            if (levels !== undefined){
                if(levels.length != 0){
                    $.each(levels, function (id, level) {
                        var selected = '';
                        var selectedLevelId = null;
                        if (level.status == 1){
                            // if product get selected
                            @if(!empty($product) && !empty($product->level))
                                selectedLevelId = parseInt('{{$product->level}}');
                                if (id == selectedLevelId){
                                    selected = 'selected';
                                }
                            @else
                                if (level.default == 1){
                                    selected = 'selected';
                                }
                            @endif

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
                    var selectedFieldOptionId = null;
                    // if product get selected
                    @if(!empty($product) && !empty($product->field_option_id))
                        selectedFieldOptionId = parseInt('{{$product->field_option_id}}');
                    if (option.id == selectedFieldOptionId){
                        selected = 'selected';
                    }
                    @else
                    if (option.default == 1){
                        selected = 'selected';
                    }
                    @endif
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
                    var selectedFieldId = null;
                    // if product get selected
                    @if(!empty($product) && !empty($product->field_id))
                    selectedFieldId = parseInt('{{$product->field_id}}');
                    if (field.id == selectedFieldId){
                        selected = 'selected';
                        defaultFieldId = field.id;
                        levels = field.levels;
                    }
                    @else // else get default
                    if (field.default == 1){
                        selected = 'selected';
                        defaultFieldId = field.id;
                        levels = field.levels;
                    }
                    @endif
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