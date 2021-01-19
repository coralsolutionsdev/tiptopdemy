<script>

    var toolBar = 'image media';

    let formItemTerm = {{\App\Modules\Form\FormItem::TYPE_MEMORIZE_TERM}};
    let formItemTermTranslateA = {{\App\Modules\Form\FormItem::TYPE_MEMORIZE_TERM_TRANSLATE_A}};
    let formItemImage = {{\App\Modules\Form\FormItem::TYPE_MEMORIZE_MEDIA_IMAGE}};
    let formItemAudio = {{\App\Modules\Form\FormItem::TYPE_MEMORIZE_MEDIA_AUDIO}};

    addMinyTinyEditor('.memorize-description-editor');

    // functions
    function generateRandomString(length) {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < length; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }
    function itemActions(){
        $('input:radio').change(function() {
            var radio = $(this);
            var radioLabel = radio.closest('label');
            var item = radio.closest('li');
            if (radioLabel.hasClass('memorize-item-language-label')){
                item.find('.memorize-item-en-label').removeClass('checked');
                item.find('.memorize-item-ar-label').removeClass('checked');
            }else{
                item.find('.memorize-item-status-correct-label').removeClass('checked');
                item.find('.memorize-item-status-incorrect-label').removeClass('checked');

            }
            radioLabel.addClass('checked');

        });

        UIkit.util.on('.items-list', 'start', function (item) {
            var movedLi =  item.detail[1];
            var itemId = movedLi.id.split('-')[1];
            tinyMCE.remove('.memories-content-'+itemId);

        });
        UIkit.util.on('.items-list', 'moved', function (item) {
            var movedLi =  item.detail[1];
            var itemId = movedLi.id.split('-')[1];
            addTinyEditor('.memories-content-'+itemId, toolBar, false);

        });
        $('.media-source-input').off('change').change(function (){
            var mediaSrc = $(this).val();
            $('.item-media-url-'+currentOnEditMemorizeItemId).val(mediaSrc);
            var media = $('#memorizeMedia-'+currentOnEditMemorizeItemId);
            media.attr('src', mediaSrc)
            // media.remove();

        });
        $('.insert-selected-media-file').off('click').click(function (){
            var selectedFileUrlInput = $('.selected-file-url');
            var mediaSrc = selectedFileUrlInput.val();
            $('.item-media-url-'+currentOnEditMemorizeItemId).val(mediaSrc);
            var media = $('#memorizeMedia-'+currentOnEditMemorizeItemId);
            media.attr('src', mediaSrc);
            UIkit.modal('#mediaModal').hide();
        });

    }
    function deleteItem(event)
    {
        UIkit.modal.confirm('<h3 class="uk-text-warning uk-margin-remove">Alert!</h3>Are you sure that you want to remove this item?').then(function() {
            var item = $(event);
            var itemId = item.closest('.memorize-item').attr('id').split('-')[1];
            $('#deleted-items').append('<input type="hidden" name="deleted_items[]" value="'+itemId+'">');
            event.closest('li').remove();
        }, function () {
            console.log('Rejected.')
        });
    }
    var currentOnEditMemorizeItemId = null;
    function openMediaModal(event){
        var item = event.closest('li');
        var itemId = $(item).find('.memorize-item').attr('id').split('-')[1];
        currentOnEditMemorizeItemId = itemId;
        $('.media-source-input').val($('#memorizeMedia-'+itemId).attr('src'));
        UIkit.modal("#mediaModal").show();

    }

    function addFormItem(groupType, item = null)
    {
        var itemId = generateRandomString(6);
        var ItemsUl = $('.group-'+groupType+'-items-list');
        var termTypesArray = [formItemTerm, formItemTermTranslateA];
        var placeholderExtraWord = $('.memorize-group-'+groupType+'-title').val();
        var title = '';
        var correctStatus = '';
        var unCorrectStatus = 'checked';
        var imageSrcUrl = '{{asset_image('assets/no-image.png')}}';
        var audioSrcUrl = '';
        if (item != null){
            title = item.title;
            itemId = item.id;
            if (item.status == 1){
                correctStatus = 'checked';
                unCorrectStatus = '';

            }else{
                unCorrectStatus = 'checked';
            }
            if (groupType == formItemImage){

                if (item.properties.media_url != undefined && item.properties.media_url  != ''){
                    imageSrcUrl = item.properties.media_url ;
                }
            } else if (groupType == formItemAudio){
                if (item.properties.media_url != undefined && item.properties.media_url  != ''){
                    audioSrcUrl = item.properties.media_url ;
                }
            }
        }
        if (groupType == formItemTerm || groupType == formItemTermTranslateA){
            ItemsUl.append(`<li>
                <div id="memorizeItem-`+itemId+`" class="memorize-item uk-grid-small" uk-grid>
                    <div class="uk-width-1-1">
                        <input type="hidden" name="item_type[`+itemId+`]" value="`+groupType+`">
                        <input type="text" class="uk-input" name="item_title[`+itemId+`]" placeholder="Word item (`+placeholderExtraWord+`)" value="`+title+`">
                    </div>
                    <div class="uk-width-expand">
                        <div class="uk-grid-small uk-child-width-1-2@xl uk-child-width-1-1@l uk-child-width-1-1@m uk-child-width-1-1@s" uk-grid>
                            <div>
                                <label class="memorize-item-status-label memorize-item-status-correct-label `+correctStatus+`">
                                    <input class="uk-radio" type="radio" name="item_status[`+itemId+`]" value="1" `+correctStatus+`>
                                    <i class="far fa-check-circle"></i> Correct
                                </label>
                            </div>
                            <div>
                                <label class="memorize-item-status-label memorize-item-status-incorrect-label `+unCorrectStatus+`">
                                    <input class="uk-radio" type="radio" name="item_status[`+itemId+`]" value="0" `+unCorrectStatus+`>
                                    <i class="far fa-times-circle"></i> Incorrect
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-auto">
                        <span onclick="deleteItem(this)" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-danger uk-tooltip="{{__('main.delete')}}"><span uk-icon="icon: trash"></span></span>
                    </div>
                </div>
            </li>`);
        } else if (groupType == formItemImage){
            ItemsUl.append(`
            <li>
                <div id="memorizeItem-`+itemId+`" class="memorize-item uk-grid-small" uk-grid>
                    <div class="uk-width-1-1">
                        <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-1">
                                <input type="hidden" name="item_type[`+itemId+`]" value="`+groupType+`">
                                <input type="hidden" class="item-media-url-`+itemId+`" name="item_media_url[`+itemId+`]" value="`+imageSrcUrl+`">
                                <div style="height: 200px; width: 100%;">
<img onclick="openMediaModal(this)" id="memorizeMedia-`+itemId+`" src="`+imageSrcUrl+`"  style="height: 100%" alt="" uk-img>
                                </div>
                            </div>
                            <div class="uk-width-1-1"><span onclick="openMediaModal(this)" class="uk-button uk-button-default uk-width-1-1">Change</span></div>
                        </div>
                    </div>
                    <div class="uk-width-expand">
                        <div class="uk-grid-small uk-child-width-1-2@xl uk-child-width-1-1@l uk-child-width-1-1@m uk-child-width-1-1@s" uk-grid>
                            <div>
                                <label class="memorize-item-status-label memorize-item-status-correct-label `+correctStatus+`">
                                    <input class="uk-radio" type="radio" name="item_status[`+itemId+`]" value="1" `+correctStatus+`>
                                    <i class="far fa-check-circle"></i> Correct
                                </label>
                            </div>
                            <div>
                                <label class="memorize-item-status-label memorize-item-status-incorrect-label `+unCorrectStatus+`">
                                    <input class="uk-radio" type="radio" name="item_status[`+itemId+`]" value="0" `+unCorrectStatus+`>
                                    <i class="far fa-times-circle"></i> Incorrect
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-auto">
                        <span onclick="deleteItem(this)" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-danger" uk-tooltip="{{__('main.delete')}}"><span uk-icon="icon: trash"></span></span>
                    </div>
                </div>
            </li>`);
        }else if (groupType == formItemAudio){
            console.log(item);
            ItemsUl.append(`
            <li>
                <div id="memorizeItem-`+itemId+`" class="memorize-item uk-grid-small" uk-grid>
                    <div class="uk-width-1-1">
                        <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-1">
                                <input type="hidden" name="item_type[`+itemId+`]" value="`+groupType+`">
                                <input type="hidden" class="item-media-url-`+itemId+`" name="item_media_url[`+itemId+`]" value="`+audioSrcUrl+`">
                                <audio controls controlsList="nodownload" id="memorizeMedia-`+itemId+`">
                                  <source src="`+audioSrcUrl+`" class="audio-file" type="audio/mpeg">
                                </audio>
                            </div>
                            <div class="uk-width-1-1"><span onclick="openMediaModal(this)" class="uk-button uk-button-default uk-width-1-1">Change</span></div>
                        </div>
                    </div>
                    <div class="uk-width-expand">
                        <div class="uk-grid-small uk-child-width-1-2@xl uk-child-width-1-1@l uk-child-width-1-1@m uk-child-width-1-1@s" uk-grid>
                            <div>
                                <label class="memorize-item-status-label memorize-item-status-correct-label `+correctStatus+`">
                                    <input class="uk-radio" type="radio" name="item_status[`+itemId+`]" value="1" `+correctStatus+`>
                                    <i class="far fa-check-circle"></i> Correct
                                </label>
                            </div>
                            <div>
                                <label class="memorize-item-status-label memorize-item-status-incorrect-label `+unCorrectStatus+`">
                                    <input class="uk-radio" type="radio" name="item_status[`+itemId+`]" value="0" `+unCorrectStatus+`>
                                    <i class="far fa-times-circle"></i> Incorrect
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-auto">
                        <span onclick="deleteItem(this)" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-danger" uk-tooltip="{{__('main.delete')}}"><span uk-icon="icon: trash"></span></span>
                    </div>
                </div>
            </li>`);
        }

        itemActions();

    }
    @if(!empty($form))
        var data = {
            'hash_id': '{{$form->hash_id}}',
        };
        $.get('{{route('store.memorize.get.items')}}', data).done(function (items){
            items.map(function (item) {
                addFormItem(item.type, item);
            });
        });
    @else
        addFormItem(formItemTerm);
        addFormItem(formItemTermTranslateA);
        addFormItem(formItemImage);
        addFormItem(formItemAudio);
    @endif

    addTinyEditor('.option-description', toolBar, false);
    itemActions();

</script>