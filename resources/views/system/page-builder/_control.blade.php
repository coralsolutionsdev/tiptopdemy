<div id="pb-control" class="pb-control uk-width-1-5@m display-table-cell" style="background-color: #34383C; height: 100vh">
    <div>
        <!--Header-->
        <div class="pb-control-header">
            <div class="uk-grid-collapse uk-light uk-padding-small" uk-grid>
                <div class="uk-width-expand@m">
                    <h5 class=""><b>PageBuilder</b></h5>
                </div>
                <div class="uk-width-auto@m">
                    <span class="pb-view-page-settings hover-primary uk-margin-small-right" uk-icon="icon: cog; ratio: 1"></span>
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
                            <div class="pb-draggable-item pb-element" pb-draggableType="element" pb-elementType="customButton" draggable="true">
                                <div class="uk-card uk-card-body uk-padding-small uk-box-shadow-hover-medium draggableItem">
                                    <div class="pb-element-icon-wrapper uk-flex uk-flex-middle uk-flex-center"><i class="fas fa-mouse-pointer fa-2x"></i></div>
                                    <div class="pb-element-title-wrapper">Custom Button</div>
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
            <div class="pb-widget-setting image-setting uk-padding-small pb-settings">
                <div>
                    <!-- This is a button toggling the modal -->
                    <img class="image-setting-image-thump" data-src="{{asset_image('assets/blank_image.png')}}" sizes="(min-width: 650px) 650px, 100vw" width="650" alt="" uk-img>
                    <button class="uk-button uk-button-secondary uk-width-expand open-media-library-modal" type="button" uk-toggle="target: #media-library-modal" style="border-radius: 0px"><span uk-icon="icon: image" class="uk-margin-small-right uk-margin-small-left"></span> Change image</button>
                </div>
                <div class="uk-margin-small pb-dark">
                    <label class="uk-form-label" for="form-stacked-text">Border margin (<span class="current-margin-value"></span>px)</label>
                    <div class="slidecontainer">
                        <input type="range" class="left-position uk-width-1-1 input-margin-value" min="0" max="50" value="5">
                    </div>
                </div>
            </div>
            <div class="pb-widget-setting video-setting uk-padding-small pb-settings">
                <div class="uk-margin-small pb-dark">
                    <label class="uk-form-label" >Video source</label>
                    <select class="uk-select video-source-input">
                        <option value="internal">Media library</option>
                        <option value="youtube">Youtube</option>
                    </select>

                </div>
                <div class="uk-margin-small pb-dark video-source-setting video-source-setting-internal" style="display: none">
                    <button class="uk-button uk-button-secondary uk-width-expand open-media-library-modal" type="button" uk-toggle="target: #media-library-modal" style="border-radius: 0px"><span uk-icon="icon: play-circle" class="uk-margin-small-right uk-margin-small-left"></span> Change video</button>
                </div>
                <div class="uk-margin-small pb-dark video-source-setting video-source-setting-youtube" style="display: none">
                    <input class="uk-input" type="text" placeholder="https://video_link/">
                </div>
                <div class="uk-margin-small pb-dark">
                    <label class="uk-form-label" for="form-stacked-text">Border margin (<span class="current-margin-value"></span>px)</label>
                    <div class="slidecontainer">
                        <input type="range" class="left-position uk-width-1-1 input-margin-value" min="0" max="50" value="5">
                    </div>
                </div>
            </div>
            <div class="pb-widget-setting hotspotImage-setting uk-padding-small pb-settings">
                <div>
                    <!-- This is a button toggling the modal -->
                    <img class="image-setting-image-thump" data-src="{{asset_image('assets/blank_image.png')}}" sizes="(min-width: 650px) 650px, 100vw" width="650" alt="" uk-img>
                    <button class="uk-button uk-button-secondary uk-width-expand open-media-library-modal" type="button" uk-toggle="target: #media-library-modal" style="border-radius: 0px"><span uk-icon="icon: image" class="uk-margin-small-right uk-margin-small-left"></span> Change image</button>
                    <button class="uk-button uk-button-secondary uk-width-expand uk-margin-small pb-open-hotspot-marker-modal" type="button" uk-toggle="target: #hotspot-manager-modal" style="border-radius: 0px"><i class="fas fa-map-pin uk-margin-small-right uk-margin-small-left"></i> Hotspot Manager</button>
                </div>
                <div class="uk-margin-small pb-dark">
                    <label class="uk-form-label" for="form-stacked-text">Border margin (<span class="current-margin-value"></span>px)</label>
                    <div class="slidecontainer">
                        <input type="range" class="left-position uk-width-1-1 input-margin-value" min="0" max="50" value="5">
                    </div>
                </div>
            </div>
            <div class="pb-widget-setting customButton-setting uk-padding-small pb-settings">
                <div>
                    <div class="uk-margin-small pb-dark">
                        <label class="uk-form-label">Link</label>
                        <input class="uk-input uk-form-small custom-button-link-input" type="text">
                    </div>
                    <div class="uk-margin-small pb-dark">
                        <label class="uk-form-label">Title</label>
                        <input class="uk-input uk-form-small custom-button-title-input" type="text">
                    </div>
                    <div class="uk-margin-small pb-dark">
                        <label class="uk-form-label">Color</label>
                        <select class="uk-select uk-form-small custom-button-color-input">
                            <option value="uk-button-default">Default</option>
                            <option value="uk-button-primary">Primary</option>
                            <option value="uk-button-danger">Danger</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="uk-padding-small">
                <span class="uk-button uk-button-danger uk-width-expand pb-remove-widget"><span uk-icon="icon: trash"></span> Delete widget</span>
            </div>
        </div>
        <!--Page Settings-->
        <div uk-sticky class="pb-page-wrapper" style="display: none">
            <div class="uk-padding-small">
                <div>
                    <!-- This is a button toggling the modal -->
                    PAGE SETTINGS
                </div>
            </div>
        </div>
        <!--Page content item setting-->
        <div uk-sticky class="pb-content-item-settings-wrapper pb-settings" style="display: none">
            <div class="uk-padding-small pb-dark">
                <div class="uk-margin-small">
                    <label class="uk-form-label" for="form-stacked-select">Transparent background</label>
                    <div class="uk-form-controls ">
                        <label><input class="uk-radio" type="radio" name="radio2" checked> Yes</label>
                        <label><input class="uk-radio" type="radio" name="radio2"> No</label>
                    </div>
                </div>
                <div class="uk-margin-small">
                    <label class="uk-form-label" for="form-stacked-select">Background color</label>
                    <div class="uk-form-controls ">
                        <input type="color" value="#FFFFFF" class="uk-width-expand" style="border-radius: 2px">
                    </div>
                </div>
                <div class="uk-margin-small pb-dark">
                    <label class="uk-form-label" for="form-stacked-text">Border padding (<span class="current-padding-value"></span>px)</label>
                    <div class="slidecontainer">
                        <input type="range" class="left-position uk-width-1-1 input-padding-value" min="0" max="50" value="5">
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-padding-small" style="position: fixed; bottom: 0; width: 18%"><button class="uk-button uk-button-primary uk-width-expand submit-content-form">Update</button></div>
        {!! Form::open(['url' => $updateRoute,'method' => 'PUT', 'id' => 'contentForm','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
        <input type="hidden" name="content">
        {!! Form::close() !!}

    </div>
</div>

{{--Modals--}}

<!-- This is the modal -->
<div id="vue-app">
    <div id="media-library-modal" class="uk-modal-container" uk-modal>
        <div class="uk-modal-dialog">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Media Library</h2>
            </div>
            <file-manager v-bind:insertmode="true"></file-manager>
        </div>
    </div>
</div>
<div id="hotspot-manager-modal" class="uk-modal-container" uk-modal>
    <div class="uk-modal-dialog uk-margin-auto-vertical uk-padding-small">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Hotspot map manger</h2>
        </div>
        <div class="uk-modal-body uk-padding-remove">
            <div class="uk-grid-collapse uk-grid-match" uk-grid>
                <div class="uk-width-1-2@m">
                    <div class="pb-widget-wrapper uk-inline-clip uk-inline-clip-show-overflow uk-transition-toggle" tabindex="0">
                        <div id="pb-hotspot-markers-map" class="uk-inline uk-dark">
                        </div>
                    </div>
                </div>
                <div class="uk-width-1-2@m" style="padding: 0 10px; ">
                    <div class="marker-adding-mode uk-padding-large uk-text-center">
                        <div class="uk-margin-small">
                            <div style="position: relative">
                                <img data-src="{{asset_image('assets/blank_image.png')}}" width="150" alt="" uk-img>
                                <i class="uk-text-primary fas fa-mouse-pointer fa-3x" style="position: absolute; bottom: -10px; right: 170px"></i>
                            </div>
                        </div>
                        Click on hotspot to add hotspot
                    </div>
                    <div class="marker-message uk-padding-large uk-text-center">
                        <div class="uk-margin-small">
                            <i  class="fas fa-map-pin fa-3x uk-text-primary"></i>
                        </div>
                        Click on the image to add
                    </div>
                    <div class="marker-editor" style="display: none">
{{--                        <div class="uk-margin-small">--}}
{{--                            <label class="uk-form-label" for="form-stacked-text">Title</label>--}}
{{--                            <div class="uk-form-controls">--}}
{{--                                <input class="uk-input mama"type="text" placeholder="Some text...">--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="uk-margin-small">
                            <label class="uk-form-label" for="form-stacked-text">Description</label>
                            <div class="uk-form-controls">
                                <textarea class="uk-textarea pb-marker-description-content-editor" rows="10"></textarea>
                                <input type="hidden" class="uk-input hidden-textarea-input">
                            </div>
                        </div>
                        <div class="uk-margin-small">
                            <label class="uk-form-label" for="form-stacked-text">Vertical position <span uk-icon="icon: arrow-down"></span></label>
                            <div class="slidecontainer">
                                <input type="range" class="top-position uk-width-1-1 input-top-value" min="1" max="100" value="50">
                            </div>
                        </div>
                        <div class="uk-margin-small">
                            <label class="uk-form-label" for="form-stacked-text">Horizontal position <span uk-icon="icon: arrow-right"></span></label>
                            <div class="slidecontainer">
                                <input type="range" class="left-position uk-width-1-1 input-left-value" min="1" max="100" value="50">
                            </div>
                        </div>
                        <div class="uk-margin-small">
                            <label class="uk-form-label" for="form-stacked-text">Hotspot color</label>
                            {{-- <div class="uk-form-controls">
                                <label><input class="uk-radio hotspot-color hotspot-color-dark" type="radio" name="hotspot-color" value="uk-dark"> Dark</label>
                                <label><input class="uk-radio hotspot-color hotspot-color-light" type="radio" name="hotspot-color" value="uk-light"> light</label>
                            </div> --}}

                            <div class="col-lg-9" style="padding: 10px 0 10px 10px; margin: 0px">
                                <input type="text" id="wheel-color_picker" name="hotspot-color" class="form-control color_picker hotspot-color" data-control="wheel" value="#000">
                            </div>
                           
                        </div>
                        <div class="uk-margin-small uk-text-right">
{{--                            <span class="uk-button uk-button-primary save-changes-hotspot-marker uk-button-small" style="padding: 5px 15px">Save changes</span>--}}
                            <span class="uk-button uk-button-danger delete-hotspot-marker uk-button-small" style="padding: 5px 15px"><span uk-icon="icon: trash"></span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-modal-footer uk-text-right" style="padding: 10px">
{{--            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>--}}
            <button class="uk-button uk-button-default pb-add-hotspot">Add hotspot</button>
            <button class="uk-button uk-button-primary save-hotspot-changes" type="button">Done</button>
        </div>
    </div>
</div>
