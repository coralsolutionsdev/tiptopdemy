<script>

    var toolBar = 'image media';

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

    }
    function deleteItem(event)
    {
        UIkit.modal.confirm('<h3 class="uk-text-warning uk-margin-remove">Alert!</h3>Are you sure that you want to remove this item?').then(function() {
            event.closest('li').remove();
        }, function () {
            console.log('Rejected.')
        });
    }
    function addNewItem()
    {
        var newId = generateRandomString(6);
        $('.items-list').append(`
    <li id="memorize-`+newId+`" class="memorize-item">
    <div class="uk-card uk-card-default uk-card-body uk-padding-small">
    <div class="uk-margin-small-bottom uk-grid-collapse"  uk-grid>
        <div class="uk-width-expand@m">
        </div>
        <div class="uk-width-auto@m">
            <span class="uk-sortable-handle uk-margin-small-right uk-text-center" uk-icon="icon: table"></span>
            <span class="uk-text-center hover-danger" uk-icon="icon: trash" onclick="deleteItem(this)"></span>
        </div>
    </div>
    <div>
        <input type="hidden" name="item_id[]" value="`+newId+`">
        <textarea class="uk-textarea option-description memories-content-`+newId+`" name="item_description[`+newId+`]"></textarea>
    </di v>
    <hr>
    <div>
        <div class="uk-grid-small uk-child-width-1-2" uk-grid>
            <div>
                <label class="memorize-item-language-label memorize-item-en-label checked">
                    <input class="uk-radio" type="radio" name="item_lang[`+newId+`]" value="en" checked>
                    English
                </label>
            </div>
            <div>
                <label class="memorize-item-language-label memorize-item-ar-label">
                    <input class="uk-radio" type="radio" name="item_lang[`+newId+`]" value="ar">
                    عربي
                </label>
            </div>
            <div>
                <label class="memorize-item-status-label memorize-item-status-correct-label checked">
                    <input class="uk-radio" type="radio" name="item_status[`+newId+`]" value="1" checked>
                    <i class="far fa-check-circle"></i> Correct
                </label>
            </div>
            <div>
                <label class="memorize-item-status-label memorize-item-status-incorrect-label">
                    <input class="uk-radio" type="radio" name="item_status[`+newId+`]" value="0">
                    <i class="far fa-times-circle"></i> Incorrect
                </label>
            </div>
        </div>
    </div>
    <div class="uk-margin-small">
        <input type="text" class="uk-input" placeholder="Add Meaning here" name="item_default_title[`+newId+`]">
    </div>
</div>
</li>`);

        addTinyEditor('.memories-content-'+newId, toolBar, false);
        itemActions();

    }

    addTinyEditor('.option-description', toolBar, false);
    itemActions();

</script>