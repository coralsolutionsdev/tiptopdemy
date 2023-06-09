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
    var typeFillTheBlankDragAndDrop = '{{\App\Modules\Form\FormItem::TYPE_FILL_THE_BLANK_DRAG_AND_DROP}}';
    var typeFillTheBlankReArrange = '{{\App\Modules\Form\FormItem::TYPE_FILL_THE_BLANK_RE_ARRANGE}}';

    var multiOptionsArray = [parseInt(typeSingleChoice), parseInt(typeMultiChoice), parseInt(typeDropDown),  parseInt(typeShortAnswer)]

    var settingMode = false;
    var typesArray = [
        '{{__('main.Section')}}',
        '{{__('main.Short text')}}',
        '{{__('main.Long text')}}',
        '{{__('main.Single choice')}}',
        '{{__('main.Multiple choice')}}',
        '{{__('main.Drop menu')}}',
        '{{__('main.Fill the blank')}}',
        '{{__('main.Fill the blank (drag and drop)')}}',
        '{{__('main.Fill the blank (re arrange)')}}',
    ];

    function refreshSettingMode(){
        if (settingMode){
            $('.setting-panel').show();
            $('.form-panel').hide();
        }else {
            $('.form-panel').show();
            $('.setting-panel').hide();
        }
    }
    refreshSettingMode();

    function toggleSetting(){
        settingMode = !settingMode;
        refreshSettingMode();
    }

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

        $('.editor-action').click(function () {
            var item = $(this);
            var dataValue = item.attr('data-value');
            var formItem = item.closest('.form-item');
            var editor = formItem.find('.fill-the-blank-div');
            editor.designMode = 'on';
            if (item.hasClass('color-item')){
                var colorMenu =  formItem.find('.font-color-pallet');
                document.execCommand('ForeColor', false, dataValue);
                colorMenu.hide();

            }else {
                document.execCommand(dataValue);
            }
            document.getSelection().removeAllRanges();

            // switch(actionType) {
            //     case 'bold':
            //         document.execCommand("Bold");
            //         break;
            //     case 'italic':
            //         document.execCommand("Italic");
            //         break;
            //     case 'underline':
            //         document.execCommand("underline");
            //         break;
            //     default:
            //     // code block
            // }

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
        $('.question-type').each(function () {
            $(this).find('.count').html(0);
        });
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
            item.find('.item-review-content').html(review);
        }else if(itemType == typeParagraph){
            review = '<div class="pt-2">\n' +
                '<span class="question-text">'+question+'</span>\n' +
                '<textarea class="uk-textarea" rows="3" placeholder="" disabled></textarea>\n' +
                '</div>';
            item.find('.item-review-content').html(review);
        }else if(itemType == typeSingleChoice){
            review = '<div class="pt-2">\n' +
                '<span class="question-text">'+question+'</span>\n' +
                '<div class="preview-options-section uk-margin-small"></div>\n' +
                '</div>';
            item.find('.item-review-content').html(review);
            var options = item.find('.item_option');
            options.each(function () {
                item.find('.preview-options-section').append('<label><input type="radio" name="prev-option-item-'+itemId+'"> '+$(this).val()+'</label></br>');
            });
        }else if(itemType == typeMultiChoice){
            review = '<div class="pt-2">\n' +
                '<span class="question-text">'+question+'</span>\n' +
                '<div class="preview-options-section uk-margin-small"></div>\n' +
                '</div>';
            item.find('.item-review-content').html(review);
            var options = item.find('.item_option');
            options.each(function () {
                item.find('.preview-options-section').append('<label><input type="checkbox" name="prev-option-item-'+itemId+'"> '+$(this).val()+'</label></br>');
            });
        }else if(itemType == typeDropDown){
            review = '<div class="pt-2">\n' +
                '<span class="question-text">'+question+'</span>\n' +
                '<select class="preview-options-section uk-select uk-margin-small" disabled></select>\n' +
                '</div>';
            item.find('.item-review-content').html(review);
            var options = item.find('.item_option');
            options.each(function () {
                item.find('.preview-options-section').append('<option>'+$(this).val()+'</option>');
            });
        }else if(itemType == typeFillTheBlank){
            var blankParagraph = item.find('.fill-the-blank-div').html();
            var blanks = item.find('.blank_item');
            question = blankParagraph.replace(/<tag>[\s\S]*?<\/tag>/g, ' <input class="input-blank" type="text" disabled>');
            // question = blankParagraph.replace(new RegExp(/<tag>[\s\S]*?<\/tag>/, "g"), ' <input class="input-blank" type="text" disabled>');
            // date.replace(new RegExp("/", "g"), '')
            // date.replace(/\//g, '')

            review = '<div class="pt-2">\n' +
                '<span class="question-text">'+question+'</span>\n' +
                '</div>';
            item.find('.item-review-content').html(review);
            pasteAsPlainText();
        }else if(itemType == typeFillTheBlankDragAndDrop || itemType == typeFillTheBlankReArrange){
            var blankParagraph = item.find('.fill-the-blank-div').html();
            // console.log(item.find('.blank_item').length);
            var blanks = item.find('.editable-div').find('.blank-item-value');

            question = blankParagraph.replace(/<tagdraggableblank>[\s\S]*?<\/tagdraggableblank>/g, ' <input class="input-blank" type="text" disabled>');
            // question = blankParagraph.replace(new RegExp(/<tag>[\s\S]*?<\/tag>/, "g"), ' <input class="input-blank" type="text" disabled>');
            // date.replace(new RegExp("/", "g"), '')
            // date.replace(/\//g, '')
            review = `<div class="pt-2">
                <div><span class="question-text">`+question+`</span></div>
                </div>`;
            item.find('.item-review-content').html(review);
            item.find('.item-pre-review').html('');
            var myArray = [];
            $.each( blanks, function( key, value ) {
                if (!myArray.includes($(value).val())){
                    item.find('.item-pre-review').append(
                        `<span class="uk-badge" style="margin: 2px; padding: 15px">`+$(value).val()+`</span>`
                    );
                }
                myArray.push($(value).val());
            });
            var extraWord = item.find('.input-extra-blanks').val();
            if (extraWord && extraWord != null && extraWord != ''){
                item.find('.item-pre-review').append(
                    `<span class="uk-badge" style="margin: 2px; padding: 15px">`+extraWord+`</span>`
                );
            }
            // console.log(myArray)
            pasteAsPlainText();
        }else if(itemType == typeSection){
            var sectionText = item.find('.input-title').val();
            review = '<div class="pt-2">\n' +
                '<span class="uk-text-bold">'+sectionText+'</span></br>\n' +
                '<span class="question-text">'+question+'</span>\n' +
                '</div>';
            item.find('.item-review').html(review);
        }

    }
    function pasteAsPlainText(){
        $('.fill-the-blank-div').off('paste').on('paste', function(e) {
            // cancel paste
            e.preventDefault();

            // get text representation of clipboard
            var text = (e.originalEvent || e).clipboardData.getData('text/plain');

            // insert text manually
            document.execCommand("insertHTML", false, text);
        });
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
    function drawOptionItem(itemId, type, item = null, option = null, defaultTitle =  null) {
        if(item == null){
            item = $('#form_item-'+itemId);
        }
        var optionID = generateRandomString(6);

        var optionTitle = '{{__('main.Option title')}}';
        if(defaultTitle != null){
            optionTitle = defaultTitle;
        }
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
            '    <div id="option-'+optionID+'" class="uk-grid-column-small uk-flex uk-flex-middle uk-text-center" uk-grid>\n' +
            '        <div class="uk-width-auto@m"><span class="uk-sortable-handle" uk-icon="icon: table"></span></div>\n' +
            '        <div class="uk-width-expand@m"><input class="uk-input uk-form-small invisible-input item_option" type="text" name="item_option_title['+itemId+']['+optionID+']" id="itemOption_'+itemId+'-'+optionID+'"  value="'+optionTitle+'"><input type="hidden"  name="item_option_position['+itemId+'][]" value="'+optionID+'"></div>\n' +
            '        <div class="uk-width-auto@m"><input class="uk-checkbox item-default" name="item_option_default['+itemId+']['+optionID+']" type="checkbox" '+optionSelected+'></div>\n' +
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
            // UIkit.notification('Card has been moved.', 'success');
        });
    }
    function removeItem() {
        $('.remove-form-item').off('click');
        $('.remove-form-item').click(function () {
            var item = $(this).closest('.form-item');
            var type = item.find('.input-type').val();

            if(!confirm('Are you sure that you want to remove this item?')){
                return false;
            }
            item.remove();
            if(count >= 1) {
                count--;
            }
            var formListItem = $('#questionType-'+type);
            var formListItemCurrentCount = formListItem.find('.count');
            if(parseInt(formListItemCurrentCount.html()) > 0){
                formListItemCurrentCount.html(parseInt(formListItemCurrentCount.html()) - 1);
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
        } else if(formItemType == typeFillTheBlank || formItemType == typeFillTheBlankDragAndDrop || formItemType == typeFillTheBlankReArrange){
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
            var formItem = $(this).closest('.form-item');
            var blankType = $(this).attr('data-blank-type');
            if (blankType == 1){
                $(this).closest('tag').remove();
            }else if (blankType == 2){
                $(this).closest('tagdraggableblank').remove();
            }
            recalculateItemScore(formItem);
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
                            '                    <input type="hidden" name="item_blank_type['+formItemId+']['+blankId+'][]" class="" value="1">\n' +
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
                            '                <span class="uk-button uk-button-default uk-button-small uk-width-1-1 hover-danger delete-item-blank" data-blank-type="1">{{__('main.Delete blank')}}</span>\n' +
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

        $('.insert-drag-and-drop-blank').click(function () {
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
                        var html = '<tagdraggableblank><div contenteditable="false" id="item_blank-'+blankId+'" class="uk-inline blank-menu">\n' +
                            '    <button class="bg-white btn-blank-dropdown uk-text-primary" type="button">'+range+' <span uk-icon="icon: triangle-down"></span></button>\n' +
                            '    <div class="p-2 m-0" uk-dropdown="mode: click">\n' +
                            '        <div class="blank-options">\n' +
                            '            <div class="uk-grid-collapse p-1" uk-grid>\n' +
                            '                <div class="uk-width-expand">\n' +
                            '                    <input type="hidden" name="item_blank_type['+formItemId+']['+blankId+'][]" class="" value="1">\n' +
                            '                    <input type="text" name="item_blank_option['+formItemId+']['+blankId+'][]" class="blank_item blank-item-value" style="width:95%" value="'+range+'">\n' +
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
                            '                <span class="uk-button uk-button-default uk-button-small uk-width-1-1 hover-danger delete-item-blank" data-blank-type="2">{{__('main.Delete blank')}}</span>\n' +
                            '            </div>\n' +
                            '        </div>\n' +
                            '    </div>\n' +
                            '</div></tagdraggableblank>';
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

        item.find('.input-section-allowed-number').attr('name', 'item_section_allowed_number['+itemId+']');

        item.find('.input-evaluation-auto').attr('name', 'item_evaluation['+itemId+']');
        item.find('.input-evaluation-manual').attr('name', 'item_evaluation['+itemId+']');

        // input-taxonomy
        var taxonomies = item.find('.input-taxonomy');
        $.each(taxonomies, function (key, index){
            $(index).attr('name', 'item_taxonomy['+itemId+'][]');
        });

        // addMinyTinyEditor('.item-content-editor-'+itemId);

        var itemTags = item.find('.input-tags');
        item.find('.input-taxonomy-b').attr('name', 'item_taxonomy_b['+itemId+'][]');
        // itemTags.attr('name', 'item_placeholder['+itemId+'][]');
        itemTags.select2({
            tags:true, // change to false to disable add new tags
        });

        item.find('.input-extra-blanks').attr('name', 'item_extra_blanks['+itemId+'][]');


        if(type == typeFillTheBlank){
            item.find('.fill-the-blank-div').attr('id', 'fillTheBlank-'+itemId);
            item.find('.input-blanks').attr('name', 'item_blanks['+itemId+']');
            item.find('.input-blanks-alignment').attr('name', 'item_blank_alignment['+itemId+']');
            item.find('.fill-the-blank-section').removeClass('hidden-div');
            item.find('.insert-blank').removeClass('hidden');
        } else if (type == typeFillTheBlankDragAndDrop || type == typeFillTheBlankReArrange){
            item.find('.fill-the-blank-div').attr('id', 'fillTheBlank-'+itemId);
            item.find('.input-blanks').attr('name', 'item_blanks['+itemId+']');
            item.find('.input-blanks-alignment').attr('name', 'item_blank_alignment['+itemId+']');
            item.find('.fill-the-blank-section').removeClass('hidden-div');
            item.find('.insert-drag-and-drop-blank').removeClass('hidden');
        }
        else if(type == typeParagraph) {
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
            item.find('.input-score').val(formItem.score);
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
                item.find('.input-section-allowed-number').val(properties.allowed_number);

                if(properties.evaluation != null){
                    if(properties.evaluation == 1){
                        item.find('.input-evaluation-auto').prop('checked', true);
                    }else{
                        item.find('.input-evaluation-manual').prop('checked', true);
                    }
                }

                if(properties.uniform != null){
                    if(properties.uniform == 1){
                        item.find('.input-uniform').prop('checked', true);
                    }
                }

                // update width
                if(properties.width != null){
                    item.find('.input-width').val(properties.width);
                    item.removeClass('uk-width-1-1');
                    item.addClass('uk-width-'+properties.width);
                }

                //
                $.each(taxonomies, function (key, index){
                    if (properties.taxonomies_a != undefined && properties.taxonomies_a.includes($(index).val().toString())){
                        $(index).prop('checked', true);
                    }
                });
                // TODO:
                if (properties.extra_blanks != null){
                    if (properties.extra_blanks.length > 0 && properties.extra_blanks[0]){
                        item.find('.input-extra-blanks').val(properties.extra_blanks[0] && properties.extra_blanks[0] != null ? properties.extra_blanks[0] : '');
                    }
                }

            }
            // update tag_taxonomies
            var tagTaxonomies = formItem.tag_taxonomies;
            if (tagTaxonomies != null){
                var newDataArray = [];
                var dataEntry = null;
                var selected = false;
                var itemOptions = item.find('.input-taxonomy-b').find('option');
                item.find('.input-taxonomy-b').html('');
                $.each(itemOptions, function (key, option){
                    selected = false;
                    $.each(tagTaxonomies, function (tagKey, tagIndex){
                        if ($(option).val() == tagIndex){
                            selected = true;
                        }
                    });
                    dataEntry = {
                        id: $(option).val(),
                        text: $(option).val(),
                        "selected": selected
                    }
                    newDataArray.push(dataEntry);
                });

                item.find('.input-taxonomy-b').select2({
                    data: newDataArray,
                    tags:true,
                });
            }


            item.find('#itemOptionList-'+itemId).html('');
            item.find('.item-review-options').html('');
            // add options
            if(multiOptionsArray.includes(parseInt(type))){
                var options = formItem.options;
                if(options != null){
                    options.map(function (option) {
                        drawOptionItem(itemId, type, item, option)
                    });
                }

            }else if(type == typeFillTheBlank || type == typeFillTheBlankDragAndDrop || type == typeFillTheBlankReArrange){
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
            if(type == typeSingleChoice){
                drawOptionItem(itemId, type, null, null, 'True');
                drawOptionItem(itemId, type, null, null, 'False');

            }else{
                drawOptionItem(itemId, type)
            }
        }
        closeCurrentlyOpenedConfig();
        // activateItem(itemId);
        count++;
        if(count >= 3) {
            if(formItem == null){
                scrollToEndOfPage(item);
            }

        }
        var formListItem = $('#questionType-'+type);
        var formListItemCurrentCount = formListItem.find('.count');
        formListItemCurrentCount.html(parseInt(formListItemCurrentCount.html()) + 1);
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
        replicateFormItem();

    }
    function replaceAll(string, search, replace) {
        return string.split(search).join(replace);
    }
    function replicateFormItem() {
        $('.replicate-form-item').off('click');
        $('.replicate-form-item').click(function () {
            closeCurrentlyOpenedConfig();
            var item = $(this).closest('.form-item');
            var itemId = item.attr('id').split('-')[1];
            var itemType = item.find('.input-type').val();
            var formItem = [];
            var properties = [];
            var options = [];
            var newItemId = generateRandomString(6);
            // build item properties
            if(item.find('.input-shuffle-questions').is(":checked")){
                properties.shuffle_questions = 1;
            }
            if(item.find('.input-shuffle-options').is(":checked")){
                properties.shuffle_options = 1;
            }
            if(item.find('.input-answer-time').is(":checked")){
                properties.answer_time = 1;
            }
            properties.answer_time_within = item.find('.input-answer-time-within').val();

            if(item.find('.input-source-internal').is(":checked")){
                properties.source = 0;
            }else if(item.find('.input-source-internal-modified').is(":checked")){
                properties.source = 1;
            }else if(item.find('.input-source-external').is(":checked")){
                properties.source = 2;
            }
            if(item.find('.input-display-inline').is(":checked")){
                properties.display = 0;
            }else if(item.find('.input-display-block').is(":checked")){
                properties.display = 1;
            }
            properties.width = item.find('.input-width').val();

            // update options
            if(itemType == typeFillTheBlank || itemType == typeFillTheBlankDragAndDrop || itemType == typeFillTheBlankReArrange){
                var blankParagraph = item.find('.fill-the-blank-div').html();
                const searchRegExp = 'item_blank_option['+itemId+']';
                const replaceWith = 'item_blank_option['+newItemId+']';
                var result = replaceAll(blankParagraph, searchRegExp, replaceWith)
                const searchRegExp2 = 'item_blank_option_mark['+itemId+']';
                const replaceWith2 = 'item_blank_option_mark['+newItemId+']';
                options.paragraph = replaceAll(result, searchRegExp2, replaceWith2);
                options.align = item.find('.input-blanks-alignment').val();
            } else if (multiOptionsArray.includes(parseInt(itemType))){
                var itemOptions = item.find('.item_option');
                itemOptions.each(function (){
                    var optionItem = $(this).parent();
                    var optionId = generateRandomString(6);
                    var option = [];
                    option.id = optionId;
                    option.title = optionItem.find('.item_option').val();
                    option.mark = 0;
                    option.default = 0;
                    options.push(option);
                });
            }

            // build item values
            formItem.id = newItemId;
            formItem.title = item.find('.input-title').val();
            formItem.description = item.find('.input-description').val();
            formItem.score = 0;
            formItem.properties = properties;
            formItem.options = options;

            currentlyActiveId = itemId;
            // drawFormItem(type, formItem = null)
            drawFormItem(itemType, formItem)
        });

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
        if(count == 0){
            if (!confirm('There is no question items in this form, are you sure you want to proceed?')){
                return false;
            }
        }
        $('.form').submit();
    });
    $('.submit-form').click(function () {
        updateBlanksHiddenValues();
        if(count == 0){
            if (!confirm('There is no question items in this form, are you sure you want to proceed?')){
                return false;
            }
        }
        $('.form').submit();
    });

    @if(empty($form))
        /*Add section by default*/
        drawFormItem(typeSection);
        settingMode = true;
        refreshSettingMode();
    @else
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
    @endif





</script>
