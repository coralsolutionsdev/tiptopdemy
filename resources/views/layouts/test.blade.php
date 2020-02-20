<script>

    function deleteLayoutItem() {
        $('.delete-layout-item').click(function () {
            if (!confirm('Are you sure you want to delete this item?')){
                return false;
            }
            $(this).parent().parent().parent().remove();
        });
    }

    var count = 1;

    $( function() {

        // $( "#sortable" ).disableSelection();
        $('.add-item').click(function () {
            resetModalFields();
            $('#editLayoutItem').modal('show');

            // $('.no-items-yet').slideUp();
            // var item = $('.item-template').clone().removeClass('item-template').show();
            // // item.find('.bg-dark-input').attr('id','bg-dark-color-item-'+count);
            // $('.layout-items').append(item);
            // count++;
            // deleteLayoutItem();
        });
    } );
    function editBannerItem() {
        $('.edit-layout-item').click(function () {
            var edit_item = $(this);
            var edit_item_id = edit_item.attr('id');
            var item = edit_item.parent().parent().parent();
            var edit_model = $('#editLayoutItem');
            // var modal_input_model_id = item.model;
            // var modal_input_model_title = item.model_name;
            var modal_input_name = item.find("input[name='item_name[]']").val();
            var modal_input_model = item.find("input[name='item_model[]']").val();
            var modal_input_group = item.find("input[name='item_banner_group[]']").val();
            var modal_input_description = item.find("input[name='item_description[]']").val();
            var modal_input_grid = item.find("input[name='item_grid[]']").val();
            var modal_input_parallel = item.find("input[name='item_parallel[]']").val();
            var modal_input_alignment = item.find("input[name='item_alignment[]']").val();
            var modal_input_background = item.find("input[name='item_background[]']").val();
            // var model_input_banner_input = item.find("input[name='item_name[]']").val();
            console.log(modal_input_group);
            $('.modal-input-name').val(modal_input_name);
            $('.modal-input-description').val(modal_input_description);
            $('.modal-input-grid').val(modal_input_grid);
            // $('.modal-input-parallel').prop('checked',false);
            // $('.modal-input-container').prop('checked',false);
            // $('.modal-input-alignment:checked').prop('checked',false);
            // $('.modal-input-background:checked').prop('checked',false);
            $('.modal-input-layout-model').val(modal_input_model);
            $('.modal-input-banner-group').val(modal_input_group);
            // $('.layout-models').slideDown();
            // $('.layout-item-banners').html('');
            edit_model.find('.submit-layout-item').html('Submit'+' ('+edit_item_id+')');
            edit_model.modal('show');

        });
    }

    function drawLayout(structure) {
        structure.map(function (item) {
            var item_code = item.code;
            var item_class = 'banner-'+item_code;
            // form data
            var modal_input_model_id = item.model;
            var modal_input_model_title = item.model_name;
            var modal_input_name = item.name;
            var modal_input_group = item.banner_group;
            var modal_input_description = item.description;
            var modal_input_grid = item.grid;
            var modal_input_parallel = item.parallel;
            var modal_input_alignment = item.text_alignment;
            var modal_input_background = item.background;
            var model_input_banner_input = item.banners;
            //
            var new_item = $('.item-template').clone().removeClass('item-template').addClass(item_class).attr('id',item_class).show();
            var layout_banner_elements_data_field = new_item.find('.layout-banner-elements-data-field');
            var new_item_edit_layout_item = new_item.find('.edit-layout-item');
            layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_model[]" value="'+modal_input_model_id+'">\n');
            layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_model_name[]" value="'+modal_input_model_title+'">\n');
            layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_code[]" value="'+item_code+'">\n');
            layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_name[]" value="'+modal_input_name+'">\n');
            layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_description[]" value="'+modal_input_description+'">\n');
            layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_grid[]" value="'+modal_input_grid+'">\n');
            layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_parallel[]" value="'+modal_input_parallel+'">\n');
            layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_alignment[]" value="'+modal_input_alignment+'">\n');
            layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_background[]" value="'+modal_input_background+'">\n');
            layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_banner_group[]" value="'+modal_input_group+'">\n');
            //
            new_item_edit_layout_item.attr('id', item_code);
            $.each(model_input_banner_input, function (index, banner_id) {
                layout_banner_elements_data_field.append('<input class="" type="hidden" name="banners['+item_code+'][]" value="'+banner_id+'">\n');
            });

            new_item.find('.layout-item-name').html(modal_input_model_title+': '+modal_input_name);
            $('.layout-items').append(new_item);
            editBannerItem();
        });
    }

    @if (!empty($layout))
    $('.no-items-yet').slideUp();
    $.get('{{ route('layout.get.structure', $layout->id) }}')
    .done(function (response) {
        drawLayout(response.structure);
    });
    @endif

    // Create new items
    function generateRandomString(length) {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < length; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

    function drawGroupBanners(banners) {
        $('.layout-item-banners').html('');
        $.each(banners, function( id, name ){
            var new_item = $('.banner-template').clone().removeClass('banner-template').addClass('modal-input-banner-item').show();
            new_item.find('.banner-input').val(id);
            new_item.find('.banner-input').attr('id','banner-'+id);
            new_item.find('.banner-name').html(name);
            new_item.find('.banner-name').attr('for','banner-'+id);
            $('.layout-item-banners').append(new_item);
        });

    }

    var basic_banner = '{{\App\Banner::GROUP_BASIC_BANNER}}';
    var slide_show_banner = '{{\App\Banner::GROUP_SLIDE_SHOW_BANNER}}';
    $('.modal-input-banner-group').change(function () {
        $('.loading-spinner').slideDown();
        var selected_group = $(this);
        if (selected_group.val() === basic_banner && $('.parallel').hasClass('inactive-div')){
            $('.parallel').removeClass('inactive-div');
        }else {
            $('.parallel').addClass('inactive-div');
            $('.modal-input-parallel').prop('checked', false);

        }
        if (selected_group.val() === slide_show_banner && !$('.grid').hasClass('inactive-div')){
            $('.grid').addClass('inactive-div');
            $('.modal-input-grid').val(1);
        }else {
            $('.grid').removeClass('inactive-div');

        }
        // get banners with id
        $.get('/manage/layouts/get/banners/'+selected_group.val())
            .done(function (response) {
                $('.loading-spinner').slideUp();
                drawGroupBanners(response.banners);
            }).fail(function () {
            $('.loading-spinner').slideUp();
            $('.layout-item-banners').html('');
        });
    });
    $('.modal-input-layout-model').change(function () {
        var layout_model_banners = '{{\App\Layout::LAYOUT_MODEL_BANNERS}}';
        var layout_model_blog = '{{\App\Layout::LAYOUT_MODEL_BLOG}}';
        var layout_model = $(this);
        if (layout_model.val() === layout_model_blog){
            $('.layout-models').slideUp();
        } else {
            $('.layout-models').slideDown();
        }
    });

    $('.submit-layout-item').click(function () {
        var item_code = generateRandomString(6);
        var item_class = 'banner-'+item_code;
        // form data
        var modal_input_model_id = $('.modal-input-layout-model').val();
        var modal_input_name = $('.modal-input-name').val();
        var modal_input_group = $('.modal-input-banner-group').val();
        var modal_input_description = $('.modal-input-description').val();
        var modal_input_grid = $('.modal-input-grid').val();
        var modal_input_parallel = $('.modal-input-parallel').val();
        var modal_input_alignment = $('.modal-input-alignment:checked').val();
        var modal_input_background = $('.modal-input-background:checked').val();
        var model_input_banner_input = $('.modal-input-banner-item input:checked');
        var modal_input_model_title = $('.modal-input-layout-model').find(":selected").text();
        if (modal_input_name === ''){
            alert('Item name is required!');
            return false;
        }
        //
        var new_item = $('.item-template').clone().removeClass('item-template').addClass(item_class).show();
        var layout_banner_elements_data_field = new_item.find('.layout-banner-elements-data-field');
        var new_item_edit_layout_item = new_item.find('.edit-layout-item');
        layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_model[]" value="'+modal_input_model_id+'">\n');
        layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_model_name[]" value="'+modal_input_model_title+'">\n');
        layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_code[]" value="'+item_code+'">\n');
        layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_name[]" value="'+modal_input_name+'">\n');
        layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_description[]" value="'+modal_input_description+'">\n');
        layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_grid[]" value="'+modal_input_grid+'">\n');
        layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_parallel[]" value="'+modal_input_parallel+'">\n');
        layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_alignment[]" value="'+modal_input_alignment+'">\n');
        layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_background[]" value="'+modal_input_background+'">\n');
        layout_banner_elements_data_field.append('<input class="" type="hidden" name="item_banner_group[]" value="'+modal_input_group+'">\n');
        //
        new_item_edit_layout_item.attr('id', item_code);
        model_input_banner_input.map(function () {
            layout_banner_elements_data_field.append('<input class="" type="hidden" name="banners['+item_code+'][]" value="'+$(this).val()+'">\n');
        });
        new_item.find('.layout-item-name').html(modal_input_model_title+': '+modal_input_name);
        $('.layout-items').append(new_item);
        $('#editLayoutItem').modal('hide');
        resetModalFields();
        deleteLayoutItem();
    });



</script>