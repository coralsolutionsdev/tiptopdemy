<script>
    var count = 0;
    var currentlyOpenedId = 0;
    var currentlyActiveId = 0;

    var typeSection = '{{\App\Modules\Form\FormItem::TYPE_SECTION}}';
    var typeShortAnswer = '{{\App\Modules\Form\FormItem::TYPE_SHORT_ANSWER}}';
    var typeParagraph = '{{\App\Modules\Form\FormItem::TYPE_PARAGRAPH}}';
    var typeSingleChoice = '{{\App\Modules\Form\FormItem::TYPE_SINGLE_CHOICE}}';
    var typeMultiChoice = '{{\App\Modules\Form\FormItem::TYPE_MULTI_CHOICE}}';
    var typeDropDown = '{{\App\Modules\Form\FormItem::TYPE_DROP_DOWN}}';
    var typeFillTheBlank = '{{\App\Modules\Form\FormItem::TYPE_FILL_THE_BLANK}}';

    var multiOptionsArray = [parseInt(typeSingleChoice), parseInt(typeMultiChoice), parseInt(typeDropDown),  parseInt(typeShortAnswer)]


    var typesArray = [
        '{{__('main.Section')}}',
        '{{__('main.Short text')}}',
        '{{__('main.Long text')}}',
        '{{__('main.Single choice')}}',
        '{{__('main.Multiple choice')}}',
        '{{__('main.Drop menu')}}',
        '{{__('main.Fill the blank')}}',

    ];

    function editorActions(){
        $('.editor-align').off('click');
        $('.editor-align').click(function () {
            var actionBtn = $(this);
            var align = actionBtn.attr('data-value');
            var fillableDiv = actionBtn.closest('.fill-the-blank-section').find('.editable-div');
            actionBtn.closest('.fill-the-blank-section').find('.input-blanks-alignment').val(align);
            fillableDiv.removeClass('text-left');
            fillableDiv.removeClass('text-center');
            fillableDiv.removeClass('text-right');
            fillableDiv.addClass('text-'+align);
        });

        $('.editor-format').off('click');
        $('.editor-format').click(function () {
            var actionBtn = $(this);
            var format = actionBtn.attr('data-value');
            var fillableDiv = actionBtn.closest('.fill-the-blank-section').find('.editable-div');
            alert('Action under development');

        });

    }

    function openMediaList(){
        $('.open-media-list').click(function () {
            var item = $(this).closest('.form-item');
            item.find('.media-list-section').toggleClass('hidden-div');
        });
    }
    function resetDescription() {
        $('.reset-description').off('click');
        $('.reset-description').click(function () {
            var item = $(this).closest('.form-item');
            item.find('.description').val('');
        });
    }
    function resetCount() {
        count = 0;
        currentlyActiveId = 0;
    }
    function reBuildItemReview(itemId){
        var item = $('#form_item-'+itemId);
        var itemTitle = item.find('.hidden-input-title').val();
        var itemType = item.find('.input-type').val();
        var question = 'Click on the setting icon to edit your question';
        if(itemTitle != ''){
            // question = $.parseHTML(itemTitle);
            question = itemTitle;
        }
        var review = '';
        if(itemType == typeShortAnswer){
            review = '<div class="pt-2">\n' +
                '<span class="question-text">'+question+'</span>\n' +
                '<input type="text" class="uk-input uk-form-small" disabled >\n' +
                '</div>';
            item.find('.item-review').html(review);
        }else if(itemType == typeParagraph){
            review = '<div class="pt-2">\n' +
                '<span class="question-text">'+question+'</span>\n' +
                '<textarea class="uk-textarea" rows="3" placeholder="" disabled></textarea>\n' +
                '</div>';
            item.find('.item-review').html(review);
        }else if(itemType == typeSingleChoice){
            review = '<div class="pt-2">\n' +
                '<span class="question-text">'+question+'</span>\n' +
                '<div class="preview-options-section uk-margin-small"></div>\n' +
                '</div>';
            item.find('.item-review').html(review);
            var options = item.find('.item_option');
            options.each(function () {
                item.find('.preview-options-section').append('<label><input type="radio" name="prev-option-item-'+itemId+'"> '+$(this).val()+'</label></br>');
            });
        }else if(itemType == typeMultiChoice){
            review = '<div class="pt-2">\n' +
                '<span class="question-text">'+question+'</span>\n' +
                '<div class="preview-options-section uk-margin-small"></div>\n' +
                '</div>';
            item.find('.item-review').html(review);
            var options = item.find('.item_option');
            options.each(function () {
                item.find('.preview-options-section').append('<label><input type="checkbox" name="prev-option-item-'+itemId+'"> '+$(this).val()+'</label></br>');
            });
        }else if(itemType == typeDropDown){
            review = '<div class="pt-2">\n' +
                '<span class="question-text">'+question+'</span>\n' +
                '<select class="preview-options-section uk-select uk-margin-small" disabled></select>\n' +
                '</div>';
            item.find('.item-review').html(review);
            var options = item.find('.item_option');
            options.each(function () {
                item.find('.preview-options-section').append('<option>'+$(this).val()+'</option>');
            });
        }else if(itemType == typeFillTheBlank){
            var blankParagraph = item.find('.fill-the-blank-div').html();
            // question = blankParagraph.replace(/<tag>[\s\S]*?<\/tag>/, ' <input class="input-blank" type="text" disabled>');
            question = blankParagraph;
            // review = '<div class="pt-2">\n' +
            //     '<span class="question-text">'+question+'</span>\n' +
            //     '</div>';
            review = 'preview has been disabled for development porpuses';
            item.find('.item-review').html(review);
        }else if(itemType == typeSection){
            var sectionText = item.find('.input-title').val();

            review = '<div class="pt-2">\n' +
                '<span class="uk-text-bold">'+sectionText+'</span></br>\n' +
                '<span class="question-text">'+question+'</span>\n' +
                '</div>';
            item.find('.item-review').html(review);
        }

    }
    function closeCurrentlyOpenedConfig() {
        var openedItem = $('#form_item-'+currentlyOpenedId);
        reBuildItemReview(currentlyOpenedId);
        removeEditor(currentlyOpenedId);

        // close currently opened settings.
        var openedItemConfigDiv = openedItem.find('.item-config');
        var openedItemReviewDiv = openedItem.find('.item-review');
        if(openedItemConfigDiv.hasClass('opened-config')){
            openedItemConfigDiv.removeClass('opened-config');
            openedItemConfigDiv.slideUp();
            openedItemReviewDiv.slideDown();
        }
    }
    function closeCurrentlyOpenedConfigOnSorting() {
        $(document).on('start', '.uk-sortable', function(e) {
            // var item = $(this).closest('.form-item');
            // var itemId = item.attr('id').split('-')[1];
            // addMinyTinyEditor('.item-content-editor-'+itemId);
            // console.log('movied');
            closeCurrentlyOpenedConfig();
        });
    }
    function removeEditor(itemId) {
        tinyMCE.remove('.item-content-editor-'+itemId);
    }
    function removeEditorOnResorting() {
        $('.uk-sortable-handle').off('click');
        $('.uk-sortable-handle').click(function () {
            var item = $(this).closest('.form-item');
            var itemId = item.attr('id').split('-')[1];
            closeCurrentlyOpenedConfig();
            removeEditor(itemId);
        });
    }
    function openItemConfig() {
        $('.open-config').off('click');
        $('.open-config').click(function () {
            var item = $(this).closest('.form-item');
            var itemId = item.attr('id').split('-')[1];

            var configDiv = item.find('.item-config');
            var reviewDiv = item.find('.item-review');

            reBuildItemReview(itemId);


            // close currently opened settings.
            if(currentlyOpenedId != itemId){
                closeCurrentlyOpenedConfig();
            }

            // toggle settings.
            if(configDiv.hasClass('opened-config')){
                configDiv.removeClass('opened-config');
                configDiv.slideUp();
                reviewDiv.slideDown();
                removeEditor(itemId);
            } else {
                configDiv.addClass('opened-config');
                reviewDiv.slideUp();
                configDiv.slideDown();
                addMinyTinyEditor('.item-content-editor-'+itemId);
            }
            // update currently opened item
            currentlyOpenedId = itemId;
        });
    }
    function updateOptionItem() {
        $('.item_option').off('click');
        $('.item_option').keyup(function () {
            var item = $(this);
            var formItem = $(this).closest('.form-item');
            var itemId = item.attr('id').split('_')[1];
            var type = formItem.find('.input-type').val();
            if (type == typeSingleChoice) {
                $('.itemOptionLabelReview_'+itemId).html(item.val());
            } else if (type == typeMultiChoice) {
                $('.itemOptionLabelReview_'+itemId).html(item.val());
            } else if (type == typeDropDown) {
                $('#itemOptionReview_'+itemId).html(item.val());
            }
        });
    }
    updateOptionItem();
    function drawOptionItem(itemId, type, item = null, option = null) {
        if(item == null){
            item = $('#form_item-'+itemId);
        }
        var optionID = generateRandomString(6);
        var optionTitle = '{{__('main.Option title')}}';
        var optionSelected = '';
        var optionScore = 0;
        if(option != null){
            optionID = option.id;
            optionTitle = option.title;
            optionScore = option.mark;
            if(option.default == 1){
                optionSelected = 'checked'
            }
        }
        var itemsList = item.find('#itemOptionList-'+itemId);
        itemsList.append('<li class="pb-1">\n' +
            '    <div class="uk-grid-column-small uk-flex uk-flex-middle uk-text-center" uk-grid>\n' +
            '        <div class="uk-width-auto@m"><span class="uk-sortable-handle" uk-icon="icon: table"></span></div>\n' +
            '        <div class="uk-width-expand@m"><input class="uk-input uk-form-small invisible-input item_option" type="text" name="item_option_title['+itemId+']['+optionID+']" id="itemOption_'+itemId+'-'+optionID+'"  value="'+optionTitle+'"><input type="hidden"  name="item_option_position['+itemId+'][]" value="'+optionID+'"></div>\n' +
            '        <div class="uk-width-auto@m"><input class="uk-checkbox" name="item_option_default['+itemId+']['+optionID+']" type="checkbox" '+optionSelected+'></div>\n' +
            '        <div class="uk-width-auto@m"><input class="uk-input uk-form-small uk-form-width-xsmall item-score" name="item_option_marks['+itemId+']['+optionID+']" type="text" placeholder="score" value="'+optionScore+'"></div>\n' +
            '        <div class="uk-width-auto@m"><div class="js-upload" uk-form-custom><input type="file" multiple><button class="uk-button uk-button-default uk-button-small" type="button" tabindex="-1"><span uk-icon="icon: image"></span></button></div></div>\n' +
            '        <div class="uk-width-auto@m"><span id="removeItemOption_'+itemId+'-'+optionID+'" class="hover-danger remove-item-option" uk-icon="icon: trash"></span></div>\n' +
            '    </div>\n' +
            '</li>');

        var previewItem = '';

        if (type == typeSingleChoice) {
            previewItem = '<div><label><input id="itemOptionReview_'+itemId+'-'+optionID+'" class="uk-radio" type="radio" name="optionDisplay_'+itemId+'"> <span class="itemOptionLabelReview_'+itemId+'-'+optionID+'">'+optionTitle+'</span></label></div>';
        } else if (type == typeMultiChoice) {
            previewItem = '<div><label><input id="itemOptionReview_'+itemId+'-'+optionID+'" class="uk-checkbox" type="checkbox"> <span class="itemOptionLabelReview_'+itemId+'-'+optionID+'">'+optionTitle+'</span></label></div>';
        } else if (type == typeDropDown) {
            previewItem = '<option id="itemOptionReview_'+itemId+'-'+optionID+'">'+optionTitle+'</option>';
        }
        item.find('.item-review-options').append(previewItem);
        updateOptionItem();
        reArrangeItemOptions();
        removeItemOption();
        updateQuestionTotalScore();
    }
    function addItemOption() {
        $('.add-item-option').off('click');
        $('.add-item-option').click(function () {
            var item = $(this).closest('.form-item');
            var itemId = item.attr('id').split('-')[1]
            var type = item.find('.input-type').val();
            drawOptionItem(itemId, type)
        });
    }
    // activate question item
    function activateItem(itemId){
        var item = $('#form_item-'+itemId);
        $('.uk-card').removeClass('active-card');
        var card = item.find('.uk-card');
        card.addClass('active-card')
        currentlyActiveId = itemId;
    }
    function activeClickedItem() {
        $('.form-item').off('click');
        $('.form-item').click(function () {
            var item = $(this);
            var itemId = item.attr('id').split('-')[1]
            // close currently opened settings.
            if(currentlyOpenedId != itemId){
                closeCurrentlyOpenedConfig();
            }
            activateItem(itemId);
        });
    }
    // generate random item code
    function generateRandomString(length) {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < length; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }
    function reArrangeItemOptions() {
        $('.item-options-list').off('moved');
        UIkit.util.on('.item-options-list', 'moved', function () {
            //console.log();
            // UIkit.notification('Card has been moved.', 'success');
        });
    }
    function removeItem() {
        $('.remove-form-item').off('click');
        $('.remove-form-item').click(function () {
            var item = $(this).closest('.form-item');
            if(!confirm('Are you sure that you want to remove this item?')){
                return false;
            }
            item.remove();
            if(count >= 1) {
                count--;
            }
        });
    }
    function recalculateItemScore(formItem)
    {
        var calculateMaxScoreArrayTypes = [typeSingleChoice, typeDropDown, typeShortAnswer]
        var formItemType = formItem.find('.input-type').val();
        var itemOptions = formItem.find('.item-score');
        var itemTotalMarks = 0;
        var blankMenus = formItem.find('.blank-menu');
        if(calculateMaxScoreArrayTypes.includes(formItemType)){
            itemOptions.each(function () {
                if($(this).val() != ''){
                    if(itemTotalMarks < parseFloat($(this).val())){
                        itemTotalMarks = parseFloat($(this).val())
                    }
                }
            });
        } else if(formItemType == typeFillTheBlank){
            blankMenus.each(function () {
                var menuMaxScore = 0;
                var menuId = $(this).attr('id').split('-')[1];
                var blankItemsScores = formItem.find('.blank-'+menuId+'-score');
                blankItemsScores.each(function () {
                    if(menuMaxScore < parseFloat($(this).val())){
                        menuMaxScore = parseFloat($(this).val())
                    }
                });
                itemTotalMarks = itemTotalMarks + menuMaxScore;
            });

        }else if(formItemType == typeMultiChoice){
            itemOptions.each(function () {
                if($(this).val() != ''){
                    itemTotalMarks = itemTotalMarks + parseFloat($(this).val());
                }
            });
        }
        formItem.find('.item-score-widget').html(itemTotalMarks);
        formItem.find('.input-score').val(itemTotalMarks);

    }
    function updateQuestionTotalScore() {
        $('.item-score').off('keyup');
        $('.item-score').keyup(function () {
            var item = $(this);
            var formItem = item.closest('.form-item');
            recalculateItemScore(formItem);
        });
    }
    function removeItemOption() {
        $('.remove-item-option').off('click');
        $('.remove-item-option').click(function () {
            var item = $(this);
            if(!confirm('Are you sure that you want to remove this item?')){
                return false;
            }
            var formItem = item.closest('.form-item');
            var itemToRemoveId = item.attr('id').split('_')[1];
            var type = formItem.find('.input-type').val();
            if (type == typeSingleChoice) {
                $('#itemOptionReview_'+itemToRemoveId).parent().parent().remove();
            } else if (type == typeMultiChoice) {
                $('#itemOptionReview_'+itemToRemoveId).parent().parent().remove();
            } else if (type == typeDropDown) {
                $('#itemOptionReview_'+itemToRemoveId).remove();
            }
            item.parent().parent().remove();

            // update question score
            recalculateItemScore(formItem);
        });
    }
    function changeItemWidth() {
        $("[id^='itemWidth_']").off('click');
        $("[id^='itemWidth_']").click(function () {
            var item = $(this);
            var itemId = item.attr('id').split('_')[1];
            var formItem = item.closest('.form-item');
            formItem.removeClass('uk-width-1-1');
            formItem.removeClass('uk-width-1-2');
            formItem.removeClass('uk-width-1-3');
            formItem.removeClass('uk-width-2-3');
            formItem.addClass('uk-width-'+itemId);
            formItem.find('.input-width').val(itemId);

        });
    }
    function deleteItemBlank(){
        $('.delete-item-blank').off('click');
        $('.delete-item-blank').click(function () {
            if(!confirm('Are you sure that you want to remove this blank?')){
                return false;
            }
            $(this).closest('tag').remove();
        });
    }
    function insertParagraphBlank(itemId = null) {
        $('.insert-blank').click(function () {
            var item = $(this);
            var formItem = item.closest('.form-item');
            var formItemId = formItem.attr('id').split('-')[1];
            var blankId = generateRandomString(6);
            var sel, range;
            if (window.getSelection) {
                sel = window.getSelection();
                var itemBaseNode = $(window.getSelection().baseNode);
                var itemBaseNodeID = itemBaseNode.closest('.form-item').attr('id');

                if(itemBaseNodeID == formItem.attr('id') && itemBaseNode.closest('.fill-the-blank-div').hasClass('editable-div')){
                    if (sel.getRangeAt && sel.rangeCount && sel) {
                        range = window.getSelection().getRangeAt(0); // get selected text
                        var html = '<tag><div contenteditable="false" id="item_blank-'+blankId+'" class="uk-inline blank-menu">\n' +
                            '    <button class="bg-white btn-blank-dropdown uk-text-primary" type="button">'+range+' <span uk-icon="icon: triangle-down"></span></button>\n' +
                            '    <div class="p-2 m-0" uk-dropdown="mode: click">\n' +
                            '        <div class="blank-options">\n' +
                            '            <div class="uk-grid-collapse p-1" uk-grid>\n' +
                            '                <div class="uk-width-3-5">\n' +
                            '                    <input type="text" name="item_blank_option['+formItemId+']['+blankId+'][]" class="blank_item blank-item-value" value="'+range+'">\n' +
                            '                </div>\n' +
                            '                <div class="uk-width-1-5">\n' +
                            '                    <input type="text" name="item_blank_option_mark['+formItemId+']['+blankId+'][]" class="blank_item blank-item-mark item-score blank-'+blankId+'-score" value="0">\n' +
                            '                </div>\n' +
                            '                <div class="uk-width-1-5 uk-text-right pt-1">\n' +
                            '                    <span class="hover-danger remove-blank-option" uk-icon="icon: trash"></span>\n' +
                            '                </div>\n' +
                            '            </div>\n' +
                            '        </div>\n' +
                            '        <div class="uk-grid-collapse p-1" uk-grid>\n' +
                            '            <div class="uk-width-1-1 uk-text-right">\n' +
                            '                <span class="hover-primary add-blank-option" uk-icon="icon: plus-circle"></span>\n' +
                            '            </div>\n' +
                            '            <div class="uk-width-1-1 uk-text-right pt-2">\n' +
                            '                <span class="uk-button uk-button-default uk-button-small uk-width-1-1 hover-danger delete-item-blank">{{__('main.Delete blank')}}</span>\n' +
                            '            </div>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '</div></tag>';
                        range.deleteContents();
                        var el = document.createElement("div");
                        el.innerHTML = html;
                        var frag = document.createDocumentFragment(), node, lastNode;
                        while ( (node = el.firstChild) ) {
                            lastNode = frag.appendChild(node);
                        }
                        range.insertNode(frag);
                        addParagraphBlankItem();
                        removeParagraphBlankItem();
                        updateBlankItemValue();
                        deleteItemBlank();
                        updateQuestionTotalScore();
                        document.getSelection().removeAllRanges();
                    }
                }

            }
        });
    }
    insertParagraphBlank();
    function updateBlankItemValue() {
        $('.blank_item').change(function () {
            var item = $(this)
            var value = item.val();
            item.attr('value', value);
        });
    }
    function addParagraphBlankItem() {
        $('.add-blank-option').off('click');
        $('.add-blank-option').click(function () {
            var item = $(this);
            var blankOptions = item.closest('.blank-menu');
            var formItem = item.closest('.form-item');
            var formItemId = formItem.attr('id').split('-')[1];
            var blankId = blankOptions.attr('id').split('-')[1];
            blankOptions.find('.blank-options').append('' +
                '<div class="uk-grid-collapse p-1" uk-grid>\n' +
                '    <div class="uk-width-3-5">\n' +
                '        <input type="text" name="item_blank_option['+formItemId+']['+blankId+'][]" class="blank_item blank-item-value" placeholder="New option" value="">\n' +
                '    </div>\n' +
                '    <div class="uk-width-1-5">\n' +
                '        <input type="text" name="item_blank_option_mark['+formItemId+']['+blankId+'][]" class="blank_item blank-item-mark item-score blank-'+blankId+'-score" value="0">\n' +
                '    </div>\n' +
                '    <div class="uk-width-1-5 uk-text-right pt-1">\n' +
                '        <span class="hover-danger remove-blank-option" uk-icon="icon: trash"></span>\n' +
                '    </div>\n' +
                '</div>\n'
            );
            removeParagraphBlankItem();
            updateBlankItemValue();
            deleteItemBlank();
            updateQuestionTotalScore();
        });
    }
    function removeParagraphBlankItem() {
        $('.remove-blank-option').off('click');
        $('.remove-blank-option').click(function () {
            var item = $(this);
            item.parent().parent().remove();
        });

    }

    function drawFormItem(type, formItem = null){
        $('.no-items').remove();
        var templateType = 'item';
        if(type == 0){
            templateType = 'section';
        }
        var item = $('.'+templateType+'-template').clone().removeClass(templateType+'-template').show();
        var itemId = generateRandomString(8);
        if(formItem != null){
            itemId = formItem.id;
        }
        if(currentlyActiveId != 0){
            $( "#form_item-"+currentlyActiveId).after(item);
        } else{
            $('#form-items').append(item);
        }
        item.find('.form-item-title').html(typesArray[type]);
        item.attr('id', 'form_item-'+itemId);
        item.find('.item-options-list').attr('id', 'itemOptionList-'+itemId);

        item.find('.input-id').attr('name', 'item_id[]');
        item.find('.input-id').val(itemId);

        item.find('.input-type').attr('name', 'item_type['+itemId+']');
        item.find('.input-type').val(type);

        item.find('.input-title').attr('name', 'item_title['+itemId+']');

        if(type == typeSection){
            item.find('.input-description').addClass('item-content-editor-'+itemId);
        }else{
            item.find('.input-title').addClass('item-content-editor-'+itemId);
        }

        item.find('.input-description').attr('name', 'item_description['+itemId+']');

        item.find('.input-width').attr('name', 'item_width['+itemId+']');

        item.find('.input-score').attr('name', 'item_score['+itemId+']');

        // item.find('.input-placeholder').attr('name', 'item_placeholder['+itemId+']');

        // item.find('.input-difficulty').attr('name', 'item_difficulty['+itemId+']');

        item.find('.input-source-internal').attr('name', 'item_source['+itemId+']');
        item.find('.input-source-external').attr('name', 'item_source['+itemId+']');
        item.find('.input-source-internal-modified').attr('name', 'item_source['+itemId+']');

        item.find('.input-display-block').attr('name', 'item_display['+itemId+']');
        item.find('.input-display-inline').attr('name', 'item_display['+itemId+']');

        item.find('.input-answer-time').attr('name', 'item_answer_time['+itemId+']');
        item.find('.input-answer-time-within').attr('name', 'item_answer_time_within['+itemId+']');

        item.find('.input-shuffle-options').attr('name', 'item_shuffle_options['+itemId+']');
        item.find('.input-shuffle-questions').attr('name', 'item_shuffle_questions['+itemId+']');

        item.find('.input-uniform').attr('name', 'item_uniform['+itemId+']');

        // addMinyTinyEditor('.item-content-editor-'+itemId);

        // item tags
        var itemTags = item.find('.input-tags');
        itemTags.attr('name', 'item_placeholder['+itemId+'][]');
        itemTags.select2({
            tags:true, // change to false to disable add new tags
        });

        if(type == typeFillTheBlank){
            item.find('.fill-the-blank-div').attr('id', 'fillTheBlank-'+itemId);
            item.find('.input-blanks').attr('name', 'item_blanks['+itemId+']');
            item.find('.input-blanks-alignment').attr('name', 'item_blank_alignment['+itemId+']');
            item.find('.fill-the-blank-section').removeClass('hidden-div')
        }else if(type == typeParagraph) {
            item.find('.title-section').removeClass('hidden-div');
            item.find('.score-section').removeClass('disabled-div');
        } else {
            item.find('.title-section').removeClass('hidden-div');
            item.find('.answers-list-section').removeClass('hidden-div');
        }

        if(formItem != null) {
            // update values
            item.find('.input-title').val(formItem.title);
            if(type == typeSection){
                item.find('.hidden-input-title').val(formItem.description);
            }else{
                item.find('.hidden-input-title').val(formItem.title);
            }
            item.find('.input-description').val(formItem.description);
            item.find('.item-score-widget').html(formItem.score);
            // update properties
            var properties = formItem.properties;
            if(properties != null){
                item.find('.input-score').val(properties.score);
                // item.find('.input-placeholder').val(properties.placeholder);
                // item.find('.input-difficulty').val(properties.difficulty);
                if(properties.source != null){
                    if(properties.source == 1){
                        item.find('.input-source-external').prop('checked', true);
                    }else{
                        item.find('.input-source-internal').prop('checked', true);
                    }
                }
                if(properties.recommended != null){
                    if(properties.recommended ==1){
                        item.find('.input-recommended').prop('checked', true);
                    }else{
                        item.find('.input-not-recommended').prop('checked', true);
                    }
                }
                if(properties.shuffle_questions != null){
                    if(properties.shuffle_questions == 1){
                        item.find('.input-shuffle-questions').prop('checked', true);
                    }
                }
                if(properties.answer_time != null){
                    if(properties.answer_time == 1){
                        item.find('.input-answer-time').prop('checked', true);
                    }
                }
                if(properties.answer_time_within != null){
                        item.find('.input-answer-time-within').val(properties.answer_time_within);
                }
                if(properties.shuffle_options != null){
                    if(properties.shuffle_options == 1){
                        item.find('.input-shuffle-options').prop('checked', true);
                    }
                }
                if(properties.source != null){
                    if(properties.source == 0){
                        item.find('.input-source-internal').prop('checked', true);
                    }else if(properties.source == 1){
                        item.find('.input-source-internal-modified').prop('checked', true);
                    }else if(properties.source == 2){
                        item.find('.input-source-external').prop('checked', true);
                    }
                }
                if(properties.display != null){
                    if(properties.display == 0){
                        item.find('.input-display-inline').prop('checked', true);
                    }else if(properties.source == 1){
                        item.find('.input-display-block').prop('checked', true);
                    }
                }

                // update width
                if(properties.width != null){
                    item.find('.input-width').val(properties.width);
                    item.removeClass('uk-width-1-1');
                    item.addClass('uk-width-'+properties.width);
                }

            }


            item.find('#itemOptionList-'+itemId).html('');
            item.find('.item-review-options').html('');
            // add options
            if(multiOptionsArray.includes(parseInt(type))){
                var options = formItem.options;
                if(options != null){
                    console.log('passed');
                    options.map(function (option) {
                        drawOptionItem(itemId, type, item, option)
                    });
                }

            }else if(type == typeFillTheBlank){
                var formItemOptions = formItem.options;
                if(formItemOptions != null){
                    item.find('.fill-the-blank-div').html(formItemOptions.paragraph);
                    var align = formItemOptions.alignment;
                    var fillableDiv = item.find('.editable-div');
                    item.find('.input-blanks-alignment').val(align);
                    fillableDiv.addClass('text-'+align);
                }
                addParagraphBlankItem();
                removeParagraphBlankItem();
                updateBlankItemValue();
                deleteItemBlank();
            }
        }else{
            drawOptionItem(itemId, type)
        }
        closeCurrentlyOpenedConfig();
        // activateItem(itemId);
        count++;
        if(count >= 3) {
            if(formItem == null){
                scrollToEndOfPage(item);
            }

        }
        /*Load default actions*/
        resetDescription();
        activeClickedItem();
        addItemOption();
        openItemConfig();
        removeItem();
        changeItemWidth();
        insertParagraphBlank();
        openMediaList();
        editorActions();
        reBuildItemReview(itemId);
        removeEditorOnResorting();
        closeCurrentlyOpenedConfigOnSorting();
        updateQuestionTotalScore();

    }
    function scrollToEndOfPage(item){
        $('body, html').animate({
            scrollTop: item.offset().top
        }, 300);
    }
    $('.question-type').click(function () {
        var date = Date();
        var item = $(this);
        var itemId = item.attr('id').split('-')[1];
        drawFormItem(itemId);
    });
    function resetFormItems(){
        $('#form-items').html('' +
            '<li class="uk-width-1-1 uk-margin-remove pr-1 pl-1 pt-0 no-items">\n' +
            '<div class="uk-placeholder uk-text-center bg-white uk-text-meta">{{__('main.There is no form items yet, please select new item from the items list')}}.</div>\n' +
            '</li>');
        resetCount()
    }
    $('.reset-form').click(function () {
        if(!confirm('Are you sure that you want to remove all the items?')){
            return false;
        }
        resetFormItems();
    });
    function updateBlanksHiddenValues(){
        var fillbalnks =  $('.fill-the-blank-div');
        fillbalnks.each(function () {
            var id = $(this).attr('id');
            var itemHtml = $(this).html();
            $(this).parent().find('.input-blanks').val(itemHtml);
        });
    }
    // submit functions
    $('.btn-update').click(function () {
        if($(this).hasClass('update-as-new')){
            $('.update-type').val(1) // CREATE_NEW_VERSION
        }else{
            $('.update-type').val(0) // UPDATE_EXISTING_VERSION
        }
        updateBlanksHiddenValues();
        $('.form').submit();
    });
    $('.submit-form').click(function () {
        updateBlanksHiddenValues();
        $('.form').submit();
    });
    @if(!empty($form))
        var formId = '{{$form->hash_id}}';
        $('.items-message').html(
            '<span class="uk-text-primary" uk-spinner="ratio: 2"></span></br></br>\n' +
            '{{__('main.Please wait, items are loading.')}}'
        );
        $.get('/manage/form/'+formId+'/get/items').done(function (items) {
            if(items.length < 1){
                resetFormItems();
            }
            items.map(function (item) {
                drawFormItem(item.type, item);
            });
        });
        @else
        $('#formSettingModal').modal('show');
    @endif





</script>
