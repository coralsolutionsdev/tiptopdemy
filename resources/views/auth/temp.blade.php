<script>
    @if(false)
    function updateScopeFieldOptionsDropMenu($id)
    {
        $.get('/get/institution/scope/field/'+id+'/options').done(function (response) {
            var items = response.items;
            $('.field-item-options').html('');
            $('.field-item-options').append('<option selected="true" disabled="disabled">{{__('Study type')}}</option>');
            if(items.length !== 0){
                $.each(items,  function (id, option) {
                    $('.field-item-options').append('<option value="'+option.id+'">'+option.title+'</option>');
                });
                // $('.fields-items-section').slideDown();
                toggleScreenSpinner(false);
            } else {
                // $('.fields-items-section').slideUp();
                toggleScreenSpinner(false);
            }
        });
    }

    /*
    get directorates
     */
    $('.countries-items').change(function () {
        var id = $(this).val();
        toggleScreenSpinner(true);
        $.get('/get/country/'+id+'/directorates').done(function (response) {
            var directorates = response.items;
            $('.directorates-items').html('');
            $('.directorates-items').append('<option selected="true" disabled="disabled">{{__('Select directorate')}}</option>');
            if(directorates.length !== 0){
                $.each(directorates,  function (id, directorate) {
                    $('.directorates-items').append('<option value="'+directorate.id+'">'+directorate.title+'</option>');
                });
                // $('.directorates-section').slideDown();
                toggleScreenSpinner(false);
            } else {
                // $('.directorates-section').slideUp();
                toggleScreenSpinner(false);
            }
        });
    });
    /*
    get fields items
     */
    $('.scope-items').change(function () {
        var id = $(this).val();
        toggleScreenSpinner(true);
        $.get('/get/institution/scope/'+id+'/fields').done(function (response) {
            var fields = response.items;
            $('.fields-items').html('');
            $('.fields-items').append('<option selected="true" disabled="disabled">{{__('Study field')}}</option>');
            if(fields.length !== 0){
                var defultField = null;
                $.each(fields,  function (id, field) {
                    var selected = '';
                    if (field.default === 1){
                        selected = 'selected'
                        defultField = field.id;
                    }
                    $('.fields-items').append('<option value="'+field.id+'" '+selected+'>'+field.title+'</option>');
                });

                // $('.fields-section').slideDown();
                $('.field-item-options').html('');
                $('.field-item-options').append('<option selected="true" disabled="disabled">{{__('Study type')}}</option>');

                // $('.fields-items-section').slideUp();
                toggleScreenSpinner(false);
            } else {
                // $('.fields-section').slideUp();
                $('.field-item-options').html('');
                // $('.fields-items-section').slideUp();
                toggleScreenSpinner(false);
            }
        });
    });
    /*
    get field options
     */
    $('.fields-items').change(function () {
        var id = $(this).val();
        toggleScreenSpinner(true);
        $.get('/get/institution/scope/field/'+id+'/options').done(function (response) {
            var items = response.items;
            $('.field-item-options').html('');
            $('.field-item-options').append('<option selected="true" disabled="disabled">{{__('Study type')}}</option>');
            if(items.length !== 0){
                $.each(items,  function (id, option) {
                    $('.field-item-options').append('<option value="'+option.id+'">'+option.title+'</option>');
                });
                // $('.fields-items-section').slideDown();
                toggleScreenSpinner(false);
            } else {
                // $('.fields-items-section').slideUp();
                toggleScreenSpinner(false);
            }
        });
    });
    @endif
</script>