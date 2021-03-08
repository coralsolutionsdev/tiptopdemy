<!-- Modal -->
<input type="hidden" name="owner_id" value="{{!empty($ownerId)? $ownerId : ''}}">
<input type="hidden" name="owner_type" value="{{!empty($ownerType)? $ownerType : ''}}">
<!-- This is the form setting -->
<div class="uk-card uk-card-default uk-card-body uk-padding-small">
    <div uk-grid>
        <div class="uk-width-auto@m">
            <ul class="uk-tab-left" uk-tab="connect: #component-tab-left; animation: uk-animation-fade">
                <li><a href="#">General info</a></li>
                <li><a href="#">Scoping</a></li>
                <li><a href="#">Properties</a></li>
                {{--                                                        <li><a href="#">Question list</a></li>--}}
                <li><a href="#">Others</a></li>
            </ul>
        </div>
        <div class="uk-width-expand@m">
            <ul id="component-tab-left" class="uk-switcher">
                <li>
                    <div class="h-header">Quiz information</div>
                    <div class="row uk-margin-small">
                        <div class="col-1 uk-flex uk-flex-middle">
                            {{__('main.Title')}}:
                        </div>
                        <div class="col-11">
                            <input class="uk-input uk-form-small" name="title" type="text" value="{{!empty($form->title) ? $form->title : 'untitled quiz'}}">
                        </div>
                    </div>
                    <div class="row uk-margin-small" uk-grid>
                        <div class="col-1 uk-flex uk-flex-middle">
                            {{__('main.Description')}}:
                        </div>
                        <div class="col-11">
                            <textarea class="uk-textarea content-editor" name="description"  rows="25" placeholder="Add quiz description here">{!! !empty($form->description) ? $form->description : '' !!}</textarea>
                        </div>
                    </div>
                    @if(!empty($categories))
                        <div class="row uk-margin-small" uk-grid>
                            <div class="col-1 uk-flex uk-flex-middle">
                                {{__('main.categories')}}:
                            </div>
                            <div class="col-11">
                                <span class="btn btn-primary" data-toggle="collapse" data-target="#demo">{{__('main.Show list of categories')}}</span>
                                <div id="demo" class="collapse">
                                    {{drawInputTreeListItems($categories, 'categories[]',!empty($selectedCategories) ? $selectedCategories : array(), 'checktree')}}
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row uk-margin-small" uk-grid>
                        <div class="col-1 uk-flex uk-flex-middle">
                            {{__('main.Category')}}:
                        </div>
                        <div class="col-3">
                            {{ Form::select('status', \App\Modules\Form\Form::STATUS_ARRAY, !empty($form) ? $form->status : 1, [ 'class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="row uk-margin-small" uk-grid>
                        <div class="col-1 uk-flex uk-flex-middle">
                            {{__('main.Position')}}:
                        </div>
                        <div class="col-3">
                            <input class="uk-input uk-form-small" name="position" type="number" value="{{!empty($form) ? $form->position : 0}}">
                        </div>
                    </div>
                </li>
                <li>
                    <div>
                        <div class="h-header">Passing requirements</div>
                        <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-5@s uk-flex uk-flex-middle">
                                Scoping:
                            </div>
                            <div class="uk-width-2-5@s">
                                <select class="uk-select uk-form-small" name="score_type">
                                    <option value="1" {{!empty($formProperties) && $formProperties['score_type'] == 1 ? 'selected' : ''}}>Percentage</option>
                                    <option value="2" {{!empty($formProperties) && $formProperties['score_type'] == 2 ? 'selected' : ''}}>Score</option>
                                    <option value="0" {{!empty($formProperties) && $formProperties['score_type'] == 0 ? 'selected' : ''}}>None</option>
                                </select>
                            </div>
                        </div>
                        <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-5@s uk-flex uk-flex-middle">
                                Passing score:
                            </div>
                            <div class="uk-width-1-5@s">
                                <input class="uk-input uk-form-small" type="number" name="passing_score" placeholder="" value="{{!empty($formProperties)? $formProperties['passing_score'] : 50}}">
                            </div>
                        </div>
                        <br>
                        <div class="h-header">Time limit</div>
                        <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-5-5@s uk-flex uk-flex-middle">
                                <label><input class="uk-checkbox" type="checkbox" name="has_time_limit" value="1" {{!empty($formProperties) && $formProperties['has_time_limit'] == 1 ? 'checked' : ''}}> <span style="margin: 0 0.5em">Time to complete the quiz </span></label>
                                <input class="uk-input uk-form-small uk-form-width-small" type="number" name="time_limit" placeholder="" step="1" value="{{!empty($formProperties)? $formProperties['time_limit'] : ''}}" style="margin: 0 0.5em"><span class="uk-text-meta">In minutes</span>
                            </div>
                        </div>
                    </div>
                </li>
                <li> {{--Main properties--}}
                    <div>
                        <div class="h-header">Restriction</div>
                        <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-5@s uk-flex uk-flex-middle">
                                Number of attempts
                            </div>
                            <div class="uk-width-2-5@s">
                                <input class="uk-input uk-form-small" type="number" name="attempts_number" placeholder="Example: 10" value="{{!empty($formProperties)? $formProperties['attempts_number'] : 50}}">
                            </div>
                            <div class="uk-width-5-5@s">
                                <label><input class="uk-checkbox" type="checkbox" name="shuffle_questions" {{!empty($formProperties) && $formProperties['shuffle_questions'] == 1 ? 'checked' : ''}}> <span style="margin: 0 0.5em">Shuffle questions</span></label>
                            </div>
                            <div class="uk-width-5-5@s">
                                <label><input class="uk-checkbox" type="checkbox" name="shuffle_groups" {{!empty($formProperties) && $formProperties['shuffle_questions'] == 1 ? 'checked' : ''}}> <span style="margin: 0 0.5em">Shuffle groups</span></label>
                            </div>
                        </div>
                        <br>
                        <label class="uk-form-label h-header" for="">Display type</label>
                        <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                            <label><input class="uk-radio" type="radio" name="display_type" value="1" {{empty($form) || ($form['properties']['display_type']) == 1 ? 'checked' : ''}}> Modern</label>
                            <label><input class="uk-radio" type="radio" name="display_type" value="0" {{!empty($form) && $form['properties']['display_type'] == 0 ? 'checked' : ''}}> Classic</label>
                        </div>
                        <br>
                        <label class="uk-form-label h-header" for="">Quiz text direction</label>
                        <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                            <label><input class="uk-radio" type="radio" name="direction" value="0" checked {{ empty($form) || $form['properties']['direction'] == 0 ? 'checked' : ''}}> Auto</label>
                            <label><input class="uk-radio" type="radio" name="direction" value="1" {{!empty($form['properties']) && $form['properties']['direction'] == 1 ? 'checked' : ''}}> LTR</label>
                            <label><input class="uk-radio" type="radio" name="direction" value="2" {{!empty($form['properties']) && $form['properties']['direction'] == 2 ? 'checked' : ''}}> RTL</label>
                        </div>
                        <br>
                        <div class="h-header">Feedback</div>
                        <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-5@s uk-flex uk-flex-middle">
                                Correct
                            </div>
                            <div class="uk-width-4-5@s">
                                <input class="uk-input uk-form-small" type="text" name="feedback_correct" value="{{!empty($formProperties)? $formProperties['feedback_correct'] : 'Put your correct message'}}">
                            </div>
                        </div>
                        <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-5@s uk-flex uk-flex-middle">
                                Incorrect
                            </div>
                            <div class="uk-width-4-5@s">
                                <input class="uk-input uk-form-small" type="text" name="feedback_incorrect" value="{{!empty($formProperties)? $formProperties['feedback_incorrect'] : 'Put your incorrect message'}}">
                            </div>
                        </div>
                        <div class="uk-grid-small" uk-grid>
                            <div class="uk-width-1-5@s uk-flex uk-flex-middle">
                                Try again
                            </div>
                            <div class="uk-width-4-5@s">
                                <input class="uk-input uk-form-small" type="text" name="feedback_retry" value="{{!empty($formProperties)? $formProperties['feedback_retry'] : 'Put your try again message'}}">
                            </div>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="h-header">Quiz submission</div>
                    <div class="uk-grid-small" uk-grid>
                        <div class="uk-width-1-5@s uk-flex uk-flex-middle">
                            <label><input class="uk-checkbox" type="checkbox"> <span style="margin: 0 0.5em">Send quiz results to</span></label>
                        </div>
                        <div class="uk-width-2-5@s">
                            <input class="uk-input uk-form-small" type="text" placeholder="email@example.com">
                        </div>
                    </div>
                    <div class="uk-grid-small" uk-grid>
                        <div class="uk-width-1-5@s uk-flex uk-flex-middle">
                            Submission button title
                        </div>
                        <div class="uk-width-2-5@s">
                            <input class="uk-input uk-form-small" type="text" name="submission_title" value="{{!empty($formProperties)? $formProperties['submission_title'] : __('main.submit')}}">
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>