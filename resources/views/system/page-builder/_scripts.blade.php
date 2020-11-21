<script>

    // toggle control panel //
    $('.pb-control-toggle').click(function (){
        var btn = $(this);
        $('#gjs-control').toggleClass('hidden-div');
    });

    // functions
    function generateRandomString(length) {
        var text = "";
        var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (var i = 0; i < length; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }
    // templates
    var pbContentListItemTemplate = '' +
        '<li id="" class="pb-content-item">\n' +
        '  <div class="pb-row uk-card bg-white uk-padding-remove">\n' +
        '    <!--row control bar-->\n' +
        '    <span class="pb-row-control-bar uk-background-primary uk-light uk-position-top-center" style="margin-top: -24px; padding:2px 5px; border-radius: 5px 5px 0 0">\n' +
        '      <span class="uk-margin-small-right"><span class="uk-sortable-handle" uk-icon="icon: table;  ratio: 0.8"></span></span>\n' +
        '      <span class=""><span uk-icon="icon: copy; ratio: 0.8"></span></span>\n' +
        '      <span class="uk-margin-small-right uk-margin-small-left"><span uk-icon="icon: cog; ratio: 0.8"></span></span>\n' +
        '      <span class=""><span uk-icon="icon: close; ratio: 0.8"></span></span>\n' +
        '    </span>\n' +
        '    <div class="pb-row-components">\n' +
        '      <!-- grid -->\n' +
        '      <div class="pb-grid uk-grid-small" uk-grid>\n' +
        '        \n' +
        '      </div>\n' +
        '    </div>\n' +
        '  </div>\n' +
        '</li>';

    var draggable =  null;
    var draggableType =  null;
    var dragoverItem =  null;
    var dragIn =  null;
    var dragAfter =  null;
    var dragOver =  null;
    var columnsCount =  1;
    var elementType =  null;
    var currentHoveredRowId =  null;
    var currentHoveredColumnId =  null;
    var currentHoveredElementId =  null;

    function resetParameters(){
        draggableType = currentHoveredRowId = null;
    }

    /*
     *
     */
    function getHoveredContentItem(){
        if (draggableType == 'column'){
            $('.pb-content-item').on({
                dragover: function (e){
                    e.preventDefault();
                    draggable = $(this);
                    currentHoveredRowId = draggable.attr('id');
                    draggable.addClass('pg-hovered');
                },
                dragleave: function (){
                    draggable = $(this);
                    draggable.removeClass('pg-hovered');

                }
            });
        } else if (draggableType == 'element'){
            $('.pb-grid-column').on({
                dragover: function (e){
                    e.preventDefault();
                    dragOver = $(this);
                    currentHoveredColumnId = dragOver.attr('id');
                },
            });
        }

    }

    $('.pb-draggable-item').on({
        dragstart: function (e){
            draggable = $(this);
            resetParameters();
            draggableType = draggable.attr('pb-draggableType');
            if (draggableType == 'column'){
                columnsCount = draggable.attr('pb-columns-count');
            }else if (draggableType == 'element'){
                elementType = draggable.attr('pb-elementType');
            }
        },
        dragend: function (){
            if (draggableType == 'column'){
                var newId = generateRandomString(6);
                var newRow = $(pbContentListItemTemplate);
                newRow.find('.pb-row').closest('li').attr('id', 'pbRow-'+newId);
                for (i = 1; i <= columnsCount; i++) {
                    var newColumnId = generateRandomString(6);
                    newRow.find('.pb-grid').append('' +
                        '<div id="pbColumn-'+newColumnId+'" class="pb-grid-column uk-width-1-1 uk-width-1-'+columnsCount+'@m">\n' +
                        '  <span class="pb-column-control-bar uk-light">\n' +
                        '     <span class=""><span uk-icon="icon: close; ratio: 0.5"></span></span>\n' +
                        '  </span>\n' +
                        '  <div class="pb-column-content uk-text-center">\n' +
                        '    +\n' +
                        '  </div>\n' +
                        '</div>');
                }
                if (currentHoveredRowId == null){
                    $('#pb-content').append(newRow);
                }else {
                    $( "#"+currentHoveredRowId).after(newRow);
                }
                draggable.removeClass('pg-hovered');
                getHoveredContentItem();
                console.log(currentHoveredRowId);
                resetParameters();
            } else if (draggableType == 'element'){
                console.log(currentHoveredColumnId);

            }


        }
    });

    $('.pb-element').on({
        dragstart: function (e){
            draggable = $(this);
            draggableType = draggable.attr('pb-draggableType');
            elementType = draggable.attr('pb-elementType');
            currentHoveredRowId = null;
            console.log(draggableType);
        },
        // dragend: function (){
        //     var newId = generateRandomString(6);
        //     var newRow = $(pbContentListItemTemplate);
        //     newRow.find('.pb-row').closest('li').attr('id', 'bgRow-'+newId);
        //     for (i = 1; i <= columnsCount; i++) {
        //         newRow.find('.pb-grid').append('' +
        //             '<div class="pb-grid-column uk-width-1-1 uk-width-1-'+columnsCount+'@m">\n' +
        //             '  <span class="pb-column-control-bar uk-light">\n' +
        //             '     <span class=""><span uk-icon="icon: close; ratio: 0.5"></span></span>\n' +
        //             '  </span>\n' +
        //             '  <div class="pb-column-content uk-text-center">\n' +
        //             '    +\n' +
        //             '  </div>\n' +
        //             '</div>')
        //     }
        //     if (currentHoveredRowId == null){
        //         $('#pb-content').append(newRow);
        //     }else {
        //         $( "#"+currentHoveredRowId).after(newRow);
        //     }
        //     draggable.removeClass('pg-hovered');
        //     getHoveredContentItem();
        //     resetParameters();
        //
        // }
    });

    @if(false)
    $('#pb-content').on({
        dragover: function (e){
            e.preventDefault();
            draggable = $(this);
            // draggableType = draggable.attr('id');
            console.log('mehmet');
        },
        drop: function (){
            var newId = generateRandomString(6);
            var newRow = $(pbContentListItemTemplate);
            newRow.find('.pb-row').closest('li').attr('id', 'bgRow-'+newId);
            for (i = 1; i <= columnsCount; i++) {
                newRow.find('.pb-grid').append('' +
                    '<div class="pb-grid-column uk-width-1-1 uk-width-1-'+columnsCount+'@m">\n' +
                    '  <span class="pb-column-control-bar uk-light">\n' +
                    '     <span class=""><span uk-icon="icon: close; ratio: 0.5"></span></span>\n' +
                    '  </span>\n' +
                    '  <div class="pb-column-content uk-text-center" style="border: 1px dotted gray">\n' +
                    '    +\n' +
                    '  </div>\n' +
                    '</div>')
            }
            $(this).append(pbContentListItemTemplate);
            // alert(dragAfter);
        },
    });
    @endif
</script>

@if(false)
<script>

    var pbContentListItemTemplate = '' +
        '<li id="" class="pb-content-list-item">\n' +
        '  <div class="pb-row uk-card bg-white uk-padding-remove">\n' +
        '    <!--row control bar-->\n' +
        '    <span class="pb-row-control-bar uk-background-primary uk-light uk-position-top-center" style="margin-top: -24px; padding:2px 5px; border-radius: 5px 5px 0 0">\n' +
        '      <span class=""><span uk-icon="icon: copy; ratio: 0.8"></span></span>\n' +
        '      <span class="uk-margin-small-right uk-margin-small-left"><span class="uk-sortable-handle" uk-icon="icon: table;  ratio: 0.8"></span></span>\n' +
        '      <span class=""><span uk-icon="icon: close; ratio: 0.8"></span></span>\n' +
        '    </span>\n' +
        '    <div class="pb-row-components">\n' +
        '      <!-- grid -->\n' +
        '      <div class="pb-grid uk-grid-small" uk-grid>\n' +
        '        \n' +
        '      </div>\n' +
        '    </div>\n' +
        '  </div>\n' +
        '</li>';

    var draggableItem = document.querySelector('.draggableItem');
    var droppableArea = document.querySelector('#pb-content');
    var draggable =  null;
    var draggableType =  null;
    var dragoverItem =  null;
    var dragIn =  null;
    var dragAfter =  null;
    $('.draggableItem, .draggable-column-template').on({
        dragstart: function (){
            draggable = $(this);
            draggableType = draggable.attr('pb-draggableType');
            if (draggableType == 'column'){
                console.log(draggable.attr('pb-draggableType'));
            }
        },

    });

    $('#pb-content').on({
        dragover: function (e){
            e.preventDefault();
            dragoverItem = $(this);
            dragAfter = dragoverItem.attr('id');
        },
    });
    $('.pb-content-list-item').on({
        dragover: function (e){
            e.preventDefault();
            dragoverItem = $(this);
            dragAfter = dragoverItem.attr('id');
        },
        drop: function (){
            // $(this).append(pbContentListItemTemplate);
            alert(dragAfter);
        },
    });


    draggableItem.addEventListener('dragend', dragend);

    function dragend(){
        // console.log('dragend')
    };


    // droppableArea.addEventListener('dragover', dragover);
    droppableArea.addEventListener('dragenter', dragenter);
    droppableArea.addEventListener('dragleave', dragleave);
    // droppableArea.addEventListener('drop', dragDrop);

    // function dragover(e){
    //     e.preventDefault();
    //     // console.log('dragover')
    // };
    function dragenter(){
        // console.log('dragenter')
    };
    function dragleave(){
        // console.log('dragleave')
    };


    var data = '';

    // jQuery.event.props.push('dataTransfer');
    $('.sss').on({
        // on commence le drag
        dragstart: function() {
            // $(this).css('opacity', '0.5');
            // data = $(this).html();
            draggable = $(this).attr('id');
            console.log(draggable)
        },
        // on quitte l'élément concerné par le drag
        dragleave: function() {
            $(this).removeClass('over');
        },
        // on passe sur un élément draggable
        dragenter: function(e) {
            $(this).addClass('over');
            //e.preventDefault();
        },
        dragover: function(e) {
            //$(this).addClass('over');
            e.preventDefault();
        },
        // on lâche l'élément, le drag est terminé
        dragend: function() {
            $(this).css('opacity', '1');
        },
        //
        drop: function(e) {
            console.log(e);
            alert('drop');
            //$(this).append(dataTransfer);
            $(this).append(data);
        }
    });


</script>
@endif