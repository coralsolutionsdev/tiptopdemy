<li class="form-item uk-width-1-1 uk-margin-remove pr-1 pl-1 pb-2 section-template" style="display: none">
    <div>
        <div class="uk-card uk-card-default uk-secondary-bg uk-card-body uk-padding-small" style="border-color: #F3F5F9">
            <div class="item-header">
                <span class="uk-sortable-handle uk-margin-small-right" uk-icon="icon: table"></span> <span class="form-item-title"></span>
                <span class="uk-align-right">
                    <span style="margin: 0 10px" class="open-config hover-primary" uk-icon="icon: cog" href="" uk-tooltip="Settings"></span>
                    <span style="margin: 0 10px" class="hover-primary replicate-form-item" uk-icon="icon: copy" uk-tooltip="Duplicate"></span>
                    <span style="margin: 0 10px" class="hover-danger remove-form-item" uk-icon="icon: trash" uk-tooltip="Delete"></span>
                </span>
            </div>
            <div class="uk-margin-remove">
                <div class="uk-margin-small item-review">
                    review
                </div>
                <div class="uk-margin-small pb-0 item-config" style="display: none">
                    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                        <li><a href="#">{{__('main.General settings')}}</a></li>
                    </ul>
                    <ul class="uk-switcher">
                        <li class="uk-placeholder item-config-section bg-white">
                            <div>
                                <div>
                                    {{--hidden data--}}
                                    <input type="hidden" name="" class="input-id">
                                    <input type="hidden" name="" class="input-type">
                                    <input type="hidden" name="" class="input-width" value="1-1">
                                </div>
                                <div class="uk-margin-small">
                                    <label class="uk-form-label h-header" for="">Section title</label>
                                    <div class="uk-form-controls">
                                        <input type="text" class="uk-input uk-form-small input-title" placeholder="Section title">
                                    </div>
                                </div>
                                <div class="uk-margin-small">
                                    <label class="uk-form-label h-header" for="">Section description</label>
                                    <div class="uk-grid-collapse" uk-grid>
                                        <div class="uk-width-expand@m">
                                            <div class="fill-the-blank-section hidden-div">
                                                <div class="uk-grid-collapse" uk-grid>
                                                    <div class="uk-width-expand@m">
                                                        <span class="uk-button uk-button-default uk-button-small editor-align" data-value="left"><i class="fas fa-align-left"></i></span>
                                                        <span class="uk-button uk-button-default uk-button-small editor-align" data-value="center"><i class="fas fa-align-center"></i></span>
                                                        <span class="uk-button uk-button-default uk-button-small editor-align" data-value="right"><i class="fas fa-align-right"></i></span>
                                                        <span class="uk-button uk-button-default uk-button-small editor-format"><i class="fas fa-italic"></i></span>
                                                        <span class="uk-button uk-button-default uk-button-small editor-format"><i class="fas fa-underline"></i></span>
                                                        <span class="uk-button uk-button-default uk-button-small editor-format"><i class="fas fa-bold"></i></span>
                                                    </div>
                                                    <div class="uk-width-auto@m">
                                                        <span class="btn btn-default insert-blank"><span class="" uk-icon="icon: plus-circle"></span> {{__('main.Add blank')}}</span>
                                                        <span class="btn btn-default insert-drag-and-drop-blank"><span class="" uk-icon="icon: plus-circle"></span> {{__('main.Add Drag and drop blank')}}</span>
                                                    </div>
                                                </div>
                                                <!-- User interaction is required by the browser -->
                                                <div class="editable-div fill-the-blank-div cu-border-light p-2 mt-1" contenteditable="true" >
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut debitis dolore eum, ex harum maiores quibusdam. Blanditiis commodi culpa dolores ducimus enim explicabo iste itaque, nobis quos repudiandae soluta vitae.
                                                </div>
                                                <input type="hidden" name="" class="input-blanks" value="">
                                            </div>
                                            <div class="title-section hidden-div">
                                                <input type="hidden" class="hidden-input-title">
                                                <textarea class="uk-textarea input-description" placeholder="type your description here"></textarea>
                                            </div>
                                        </div>

                                        <div class="uk-width-auto@m uk-flex uk-flex-middle pl-2">
                                            <div class="">
                                                <div class="uk-margin-small">
                                                    <div class="js-upload hover-primary" uk-form-custom>
                                                        <input type="file" multiple>
                                                        <button class="uk-button uk-button-default pr-3 pl-3" type="button" tabindex="-1"><span uk-icon="icon: image"></span></button>
                                                    </div>
                                                </div>
                                                <div class="uk-margin-small">
                                                    <div class="js-upload" uk-form-custom>
                                                        <input type="file" multiple>
                                                        <button class="uk-button uk-button-default pr-3 pl-3" type="button" tabindex="-1"><span uk-icon="icon: video-camera"></span></button>
                                                    </div>
                                                </div>
                                                <div class="uk-margin-small">
                                                    <div class="js-upload" uk-form-custom>
                                                        <input type="file" multiple>
                                                        <button class="uk-button uk-button-default pr-3 pl-3" type="button" tabindex="-1"><span uk-icon="icon: microphone"></span></button>
                                                    </div>
                                                </div>
                                                <div class="uk-margin-small">
                                                    <span class="uk-button uk-button-default pr-3 pl-3 open-media-list" type="button" tabindex="-1" uk-tooltip="title: Media list"><span uk-icon="icon: thumbnails"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-margin-small media-list-section hidden-div">
                                    <label class="uk-form-label h-header" for="">Media list</label>
                                    <div class="">
                                        <div class="uk-text-center">No items yet</div>
                                    </div>
                                </div>
                                <br>
                                <label class="uk-form-label h-header" for="">Questions settings</label>
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-5-5@s uk-flex uk-flex-middle">
                                        <label><input class="uk-checkbox input-shuffle-questions" type="checkbox"> <span style="margin: 0 0.5em">Shuffle Questions</span></label>
                                    </div>
                                </div>
                                <div class="uk-margin uk-grid-small score-section" uk-grid>
                                    <div class="uk-width-1-5@m uk-flex uk-flex-middle">
                                        <label>Questions number allowed to answer:</label>
                                    </div>
                                    <div class="uk-width-expand@m ">
                                        <input type="number" class="uk-input uk-form-small input-section-allowed-number" placeholder="5">
                                    </div>
                                </div>
                                <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                    <label>Evaluation:</label>
                                    <label><input class="uk-radio input-evaluation-auto" type="radio" name="radio1" value="{{\App\Modules\Form\FormResponse::EVALUATION_TYPE_AUTO}}" checked>  تلقائي  </label>
                                    <label><input class="uk-radio input-evaluation-manual" type="radio" name="radio1" value="{{\App\Modules\Form\FormResponse::EVALUATION_TYPE_MANUAL}}">  يدوي  </label>
                                </div>
{{--                                <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">--}}
{{--                                    <label for="">Topic:</label> {!! Form::select('tags[]', [], null, ['class' => 'form-control select2 input-tags', 'multiple' => 'multiple', 'data-placeholder' => 'Create any tag', 'style' => 'width:100%;']) !!}--}}
{{--                                </div>--}}
                            </div>
                        </li>
                        <li class="uk-placeholder item-config-section">
                            <label class="uk-form-label h-header" for="">Answering settings</label>

                        </li>
                        <li class="uk-placeholder item-config-section">
                            <label class="uk-form-label h-header" for="">Display type</label>
                            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                <label><input class="uk-radio input-display-block" type="radio" name="radio2" value="1" checked> Block</label>
                                <label><input class="uk-radio input-display-inline" type="radio" name="radio2" value="2"> in line</label>
                            </div>
                            <br>
                            <label class="uk-form-label h-header" for="">{{__('main.Question Width')}}</label>
                            <div class="uk-grid-collapse uk-text-center" uk-grid>
                                <div class="uk-width-1-2@m p-1">
                                    <div id="itemWidth_1-2" class="uk-alert-primary clickable" uk-alert>
                                        1/2
                                    </div>
                                </div>
                                <div class="uk-width-1-2@m p-1">
                                    <div id="itemWidth_1-2" class="uk-alert-primary clickable" uk-alert>
                                        1/2
                                    </div>
                                </div>
                                <div class="uk-width-1-3@m p-1">
                                    <div id="itemWidth_1-3" class="uk-alert-primary clickable" uk-alert>
                                        1/3
                                    </div>
                                </div>
                                <div class="uk-width-2-3@m p-1">
                                    <div id="itemWidth_2-3" class="uk-alert-primary clickable" uk-alert>
                                        2/3
                                    </div>
                                </div>
                                <div class="uk-width-1-1@m p-1">
                                    <div id="itemWidth_1-1" class="uk-alert-primary clickable" uk-alert>
                                        100%
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</li>
<li class="form-item uk-width-1-1 uk-margin-remove pr-1 pl-1 pb-2 item-template" style="display: none">
    <div>
        <div class="uk-card uk-card-default uk-card-body uk-padding-small">
            <div class="item-header">
                <span class="uk-sortable-handle uk-margin-small-right" uk-icon="icon: table"></span> <span class="form-item-title"></span>
                <span class="uk-align-right">
                    <span style="margin: 0 10px" class="uk-text-primary pr-1"><span class="item-score-widget">0</span> {{trans_choice('main.Marks', 0)}}</span>
                    <span style="margin: 0 10px" class="open-config hover-primary" uk-icon="icon: cog" href="" uk-tooltip="Settings"></span>
                    <span style="margin: 0 10px" class="hover-primary replicate-form-item" uk-icon="icon: copy" uk-tooltip="Duplicate"></span>
                    <span style="margin: 0 10px" class="hover-danger remove-form-item" uk-icon="icon: trash" uk-tooltip="Delete"></span>
                </span>
            </div>
            <div class="uk-margin-remove">

                <div class="uk-margin-small item-review">
                    <div class="uk-margin-small item-pre-review" style="padding: 10px 0">
                    </div>
                    <div class="item-review-content">

                    </div>
                </div>
                <div class="uk-margin-small pb-0 item-config" style="display: none">
                    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                        <li><a href="#">{{__('main.General settings')}}</a></li>
                        <li><a href="#">{{__('main.Display settings')}}</a></li>
                    </ul>
                    <ul class="uk-switcher">
                        <li class="uk-placeholder item-config-section">
                            <div>
                                <div>
                                    {{--hidden data--}}
                                    <input type="hidden" name="" class="input-id">
                                    <input type="hidden" name="" class="input-type">
                                    <input type="hidden" name="" class="input-width" value="1-1">
                                    <input type="hidden" name="" class="input-score" value="0">
                                </div>
                                <div class="uk-margin-small">
                                    <label class="uk-form-label h-header" for="">Question statement</label>
                                    <div class="uk-grid-collapse" uk-grid>
                                        <div class="uk-width-expand@m">
                                            <div class="fill-the-blank-section hidden-div">
                                                <div class="cu-editor uk-grid-collapse" uk-grid>
                                                    <div class="uk-width-expand@m">
                                                        <strong></strong>
                                                        <span class="btn btn-default editor-item editor-align" data-value="left"><i class="fas fa-align-left"></i></span>
                                                        <span class="btn btn-default editor-item editor-align" data-value="center"><i class="fas fa-align-center"></i></span>
                                                        <span class="btn btn-default editor-item editor-align" data-value="right"><i class="fas fa-align-right"></i></span>
                                                        <span class="btn btn-default editor-item editor-action editor-format" data-value="Italic"><i class="fas fa-italic"></i></span>
                                                        <span class="btn btn-default editor-item editor-action editor-format" data-value="underline"><i class="fas fa-underline"></i></span>
                                                        <span class="btn btn-default editor-item editor-action editor-format" data-value="Bold"><i class="fas fa-bold"></i></span>
                                                        <div class="uk-inline">
                                                            <span class="btn btn-default editor-item editor-font-color" style="padding:6px 10px"><i style="border-bottom: 2px solid #000000; padding: 1px 3px" class="fas fa-font"></i></span>
                                                            <div uk-dropdown="mode: hover" class="uk-padding-remove font-color-pallet">
                                                                <div class="uk-grid-collapse uk-child-width-1-5 uk-text-center" uk-grid>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #BFEDD2" data-value="#BFEDD2"></span>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #FBEEB8" data-value="#FBEEB8"></span>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #F8CAC6" data-value="#F8CAC6"></span>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #ECCAFA" data-value="#ECCAFA"></span>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #C2E0F4" data-value="#C2E0F4"></span>

                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #2DC26B" data-value="#2DC26B"></span>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #F1C40F" data-value="#F1C40F"></span>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #E03E2D" data-value="#E03E2D"></span>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #B96AD9" data-value="#B96AD9"></span>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #3598DB" data-value="#3598DB"></span>

                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #169179" data-value="#169179"></span>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #E67E23" data-value="#E67E23"></span>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #BA372A" data-value="#BA372A"></span>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #843FA1" data-value="#843FA1"></span>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #236FA1" data-value="#ECF0F1"></span>

                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #ECF0F1" data-value="#ECF0F1"></span>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #CED4D9" data-value="#CED4D9"></span>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #7E8C8D" data-value="#7E8C8D"></span>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #34495E" data-value="#34495E"></span>
                                                                    <span class="btn btn-default editor-action color-item" style="background-color: #000000" data-value="#000000"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-auto@m">
                                                        <span class="btn btn-default insert-blank hidden"><span class="" uk-icon="icon: plus-circle"></span> {{__('main.Add blank')}}</span>
                                                        <span class="btn btn-default insert-drag-and-drop-blank hidden"><span class="" uk-icon="icon: plus-circle"></span> {{__('main.Add Drag and drop blank')}}</span>
                                                    </div>
                                                </div>
                                                <!-- User interaction is required by the browser -->
                                                <div class="editable-div fill-the-blank-div cu-border-light p-2 mt-1" contenteditable="true" >
                                                    {{__('main._fill blank default paragraph')}}
                                                </div>
                                                <div class="uk-margin-small">
                                                    <label class="uk-form-label h-header" for="">Extra word</label>
                                                    <input type="text" class="uk-input uk-form-small input-extra-blanks" placeholder="Ex: welcome">
                                                </div>
                                                <input type="hidden" name="" class="input-blanks" value="">
                                                <input type="hidden" name="" class="input-blanks-alignment" value="auto">
                                            </div>
                                            <div class="title-section hidden-div">
                                                <input type="hidden" class="hidden-input-title">
                                                <textarea class="uk-textarea input-title " placeholder="type your question here"></textarea>
                                            </div>
                                        </div>
                                        <div class="uk-width-auto@m uk-flex uk-flex-middle pl-2">
                                            <div class="">
                                                <div class="uk-margin-small">
                                                    <div class="js-upload hover-primary" uk-form-custom>
                                                        <input type="file" multiple>
                                                        <button class="uk-button uk-button-default pr-3 pl-3" type="button" tabindex="-1"><span uk-icon="icon: image"></span></button>
                                                    </div>
                                                </div>
                                                <div class="uk-margin-small">
                                                    <div class="js-upload" uk-form-custom>
                                                        <input type="file" multiple>
                                                        <button class="uk-button uk-button-default pr-3 pl-3" type="button" tabindex="-1"><span uk-icon="icon: video-camera"></span></button>
                                                    </div>
                                                </div>
                                                <div class="uk-margin-small">
                                                    <div class="js-upload" uk-form-custom>
                                                        <input type="file" multiple>
                                                        <button class="uk-button uk-button-default pr-3 pl-3" type="button" tabindex="-1"><span uk-icon="icon: microphone"></span></button>
                                                    </div>
                                                </div>
                                                <div class="uk-margin-small">
                                                    <span class="uk-button uk-button-default pr-3 pl-3 open-media-list" type="button" tabindex="-1" uk-tooltip="title: Media list"><span uk-icon="icon: thumbnails"></span></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="uk-margin-small media-list-section hidden-div">
                                    <label class="uk-form-label h-header" for="">Media list</label>
                                    <div class="">
                                        <div class="uk-text-center">No items yet</div>
                                    </div>
                                </div>
                                <div class="uk-margin-small">
                                    <label class="uk-form-label h-header" for="">Description</label>
                                    <div class="uk-form-controls">
                                        <textarea class="uk-textarea input-description" placeholder="type your question here"></textarea>
                                    </div>
                                </div>
                                <div class="uk-margin-small answers-list-section hidden-div">
                                    <label class="uk-form-label h-header" for="">List of answers</label>
                                    <ul class="uk-grid-collapse uk-child-width-1-1 item-options-list" uk-sortable="handle: .uk-sortable-handle" uk-grid>
                                    </ul>
                                    <div class="pt-2 uk-text-right">
                                        <span class="uk-button uk-button-default add-item-option"><span uk-icon="icon: plus-circle"></span> {{__('main.Add Option')}}</span>
                                    </div>
                                </div>
                            </div>
                            <label class="uk-form-label h-header" for="">Answering settings</label>
                            <div class="uk-grid-small" uk-grid>
                                <div class="uk-width-5-5@s uk-flex uk-flex-middle">
                                    <label><input class="uk-checkbox input-answer-time" name="" type="checkbox"> <span style="margin: 0 0.5em">Time to answer the question </span></label>
                                    <input class="uk-input uk-form-small uk-form-width-small input-answer-time-within" type="number" placeholder="" step="1" style="margin: 0 0.5em"><span class="uk-text-meta">In seconds</span>
                                </div>
                            </div>
                            <div class="uk-grid-small" uk-grid>
                                <div class="uk-width-5-5@s uk-flex uk-flex-middle">
                                    <label><input class="uk-checkbox input-shuffle-options" type="checkbox"> <span style="margin: 0 0.5em">Shuffle options</span></label>
                                </div>
                            </div>
                            <div class="uk-margin uk-grid-small score-section disabled-div" uk-grid>
                                <div class="uk-width-auto@m uk-flex uk-flex-middle">
                                    <label>Question mark:</label>
                                </div>
                                <div class="uk-width-expand@m ">
                                    <input type="number" class="uk-input uk-form-small input-score">
                                </div>
                            </div>
                            <br>
                            <label class="uk-form-label h-header" for="">References</label>
                            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                <label>Got from:</label>
                                <label><input class="uk-radio input-source-internal" type="radio" name="radio1" value="0"> Quoted </label>
                                <label><input class="uk-radio input-source-internal-modified" type="radio" name="radio1" value="1"> Modified</label>
                                <label><input class="uk-radio input-source-external" type="radio" name="radio1" value="2"> Out the box </label>
                            </div>
                            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                <label><input class="uk-checkbox input-uniform" type="checkbox" name=""> <span style="margin: 0 0.5em"> Matriculation Examination</span></label>
                            </div>
                            <br>
                            <label class="uk-form-label h-header" for="">Taxonomies</label>
                            <div class="uk-margin uk-grid-small" uk-grid>
                                <div class="uk-width-auto@m uk-flex uk-flex-middle">
                                    <label>Taxonomy 1</label>
                                </div>
                                <div class="uk-width-expand@m">

                                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                        @foreach(\App\Modules\Form\Form::TAXONOMY_TYPES_ARRAY as $key => $taxonomy)
                                        <label><input class="uk-checkbox input-taxonomy" name="" type="checkbox" value="{{$key}}"> {{$taxonomy}}</label>
                                        @endforeach
                                    </div>
{{--                                    {!! Form::select('tags[]', [], null, ['class' => 'form-control select2 input-tags', 'multiple' => 'multiple', 'data-placeholder' => 'Create any tag', 'style' => 'width:100%;']) !!}--}}
                                </div>
                            </div>
                            <div class="uk-margin uk-grid-small" uk-grid>
                                <div class="uk-width-auto@m uk-flex uk-flex-middle">
                                    <label>Taxonomy 2</label>
                                </div>
                                <div class="uk-width-expand@m">
                                    <select class="input-tags uk-select select2 input-taxonomy-b" name="" multiple="multiple" style="width: 100%">
                                        @foreach($tags as $tag)
                                        <option value="{{$tag}}">{{$tag}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </li>
                        <li class="uk-placeholder item-config-section">
                            <label class="uk-form-label h-header" for="">Display type</label>
                            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                <label><input class="uk-radio input-display-block" type="radio" name="radio2" value="1" checked> Block</label>
                                <label><input class="uk-radio input-display-inline" type="radio" name="radio2" value="0"> in line</label>
                            </div>
                            <br>
                            <label class="uk-form-label h-header" for="">{{__('main.Question Width')}}</label>
                            <div class="uk-grid-collapse uk-text-center" uk-grid>
                                <div class="uk-width-1-2@m p-1">
                                    <div id="itemWidth_1-2" class="uk-alert-primary clickable" uk-alert>
                                        1/2
                                    </div>
                                </div>
                                <div class="uk-width-1-2@m p-1">
                                    <div id="itemWidth_1-2" class="uk-alert-primary clickable" uk-alert>
                                        1/2
                                    </div>
                                </div>
                                <div class="uk-width-1-3@m p-1">
                                    <div id="itemWidth_1-3" class="uk-alert-primary clickable" uk-alert>
                                        1/3
                                    </div>
                                </div>
                                <div class="uk-width-2-3@m p-1">
                                    <div id="itemWidth_2-3" class="uk-alert-primary clickable" uk-alert>
                                        2/3
                                    </div>
                                </div>
                                <div class="uk-width-1-1@m p-1">
                                    <div id="itemWidth_1-1" class="uk-alert-primary clickable" uk-alert>
                                        100%
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</li>
