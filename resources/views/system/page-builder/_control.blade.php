<div id="pb-control" class="pb-control uk-width-1-5@m display-table-cell" style="background-color: #34383C; height: 100vh">
    <div>
        <!--Header-->
        <div class="pb-control-header">
            <div class="uk-grid-collapse uk-light uk-padding-small" uk-grid>
                <div class="uk-width-expand@m">
                    <h5 class=""><b>PageBuilder</b></h5>
                </div>
                <div class="uk-width-auto@m">
                    <span class="pb-view-widgets-list hover-primary" uk-icon="icon: thumbnails; ratio: 1"></span>
                </div>
            </div>
        </div>
        <!--Widgets-->
        <div uk-sticky class="pb-widgets-wrapper">
            <ul class="uk-padding-small" uk-accordion="multiple: true">
                <li class="uk-open">
                    <a class="uk-accordion-title" href="#">Basic</a>
                    <div class="uk-accordion-content">
                        <div id="pb-items" class=" uk-grid-small uk-grid-match uk-child-width-1-2@s uk-text-center" uk-grid>
                            <div class="pb-draggable-item pb-element" pb-draggableType="element" pb-elementType="textEditor" draggable="true">
                                <div class="uk-card uk-card-body uk-padding-small uk-box-shadow-hover-medium draggableItem">
                                    <div class="pb-element-icon-wrapper uk-flex uk-flex-middle uk-flex-center"><i class="fas fa-align-left fa-2x"></i></div>
                                    <div class="pb-element-title-wrapper">Text editor</div>
                                </div>
                            </div>
                            <div class="pb-draggable-item pb-element" pb-draggableType="element" pb-elementType="image" draggable="true">
                                <div class="uk-card uk-card-body uk-padding-small uk-box-shadow-hover-medium draggableItem">
                                    <div class="pb-element-icon-wrapper uk-flex uk-flex-middle uk-flex-center"><span uk-icon="icon:image; ratio:1.5"></span></div>
                                    <div class="pb-element-title-wrapper">Image</div>
                                </div>
                            </div>
                            <div class="pb-draggable-item pb-element" pb-draggableType="element" pb-elementType="video" draggable="true">
                                <div class="uk-card uk-card-body uk-padding-small uk-box-shadow-hover-medium draggableItem">
                                    <div class="pb-element-icon-wrapper uk-flex uk-flex-middle uk-flex-center"><span uk-icon="icon:play-circle; ratio:1.5"></span></div>
                                    <div class="pb-element-title-wrapper">Video</div>
                                </div>
                            </div>
                            <div class="pb-draggable-item pb-element" pb-draggableType="element" pb-elementType="hotspotImage" draggable="true">
                                <div class="uk-card uk-card-body uk-padding-small uk-box-shadow-hover-medium draggableItem">
                                    <div class="pb-element-icon-wrapper uk-flex uk-flex-middle uk-flex-center"><i class="far fa-images fa-2x"></i></div>
                                    <div class="pb-element-title-wrapper">Hotspot</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <!--Settings-->
        <div uk-sticky class="pb-setting-wrapper" style="display: none">
            <div class="pb-widget-setting textEditor-setting">
                text editor
            </div>
            <div class="pb-widget-setting image-setting uk-padding-small">
                <div>
                    <!-- This is a button toggling the modal -->
                    <img class="image-setting-image-thump" data-src="{{asset_image('assets/blank_image.png')}}" sizes="(min-width: 650px) 650px, 100vw" width="650" alt="" uk-img>
                    <button class="uk-button uk-button-secondary uk-width-expand uk-margin-small-right" type="button" uk-toggle="target: #media-library-modal" style="border-radius: 0px"><span uk-icon="icon: image" class="uk-margin-small-right uk-margin-small-left"></span> Change image</button>
                </div>
            </div>
            <div class="pb-widget-setting hotspotImage-setting uk-padding-small">
                <div>
                    <!-- This is a button toggling the modal -->
                    <img class="image-setting-image-thump" data-src="{{asset_image('assets/blank_image.png')}}" sizes="(min-width: 650px) 650px, 100vw" width="650" alt="" uk-img>
                    <button class="uk-button uk-button-secondary uk-width-expand uk-margin-small-right" type="button" uk-toggle="target: #media-library-modal" style="border-radius: 0px"><span uk-icon="icon: image" class="uk-margin-small-right uk-margin-small-left"></span> Change image</button>
                    <button class="uk-button uk-button-secondary uk-width-expand uk-margin-small-right uk-margin-small" type="button" uk-toggle="target: #hotspot-manager-modal" style="border-radius: 0px"><i class="fas fa-map-pin uk-margin-small-right uk-margin-small-left"></i> Hotspot Manager</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{--Modals--}}

<!-- This is the modal -->
<div id="media-library-modal" class="uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Media Library</h2>
        </div>
        <div class="uk-modal-body uk-padding-small">

            <ul uk-tab>
                <li><a href="#">My Media</a></li>
                <li><a href="#">Upload Files</a></li>
            </ul>

            <ul class="uk-switcher uk-margin">
                <li>
                    <div id="media-items" class="uk-grid-small uk-child-width-1-5@s" uk-grid="masonry: true">
                        <div class="media-item selected-media-item">
                            {{--                                            <img data-src="https://images.unsplash.com/photo-1522201949034-507737bce479?fit=crop&w=1300&h=866&q=80" width="" height="" alt="" uk-img>--}}
                        </div>
                    </div>
                </li>
                <li>
                    <div class="uk-grid-small uk-text-center uk-flex uk-flex-middle uk-flex-center" uk-grid>
                        <div class="uk-width-1-3@m uk-placeholder uk-padding-small uk-margin-small">
                            @include('system.file-manager._media_uploader')
                        </div>
                    </div>
                </li>
            </ul>
            <div>
            </div>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
            <button class="uk-button uk-button-primary replace-widget-image" type="button">Insert</button>
        </div>
    </div>
</div>
<div id="hotspot-manager-modal" class="uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Hotspot map manger</h2>
        </div>
        <div class="uk-modal-body uk-padding-small">
            <div class="uk-grid-small uk-text-center" uk-grid="masonry: true">
                <div class="uk-width-1-2@m">
                    <img class="image-setting-image-thump" data-src="{{asset_image('assets/blank_image.png')}}" sizes="(min-width: 650px) 650px, 100vw" width="650" alt="" uk-img>
                </div>
                <div class="uk-width-1-2@m">
                    <div class="uk-card uk-card-default uk-card-body">click on the hotspot to edit</div>
                </div>
            </div>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
            <button class="uk-button uk-button-primary replace-widget-image" type="button">Insert</button>
        </div>
    </div>
</div>
