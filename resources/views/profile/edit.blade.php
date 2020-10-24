@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $user->name)
@section('content')
    <div class="profile uk-container uk-margin-medium-bottom" style="background-color: transparent">
        {{--header--}}
        @include('partial.frontend._page-header')
        {{--body--}}
        <div class="uk-grid-small" uk-grid>
            <div class="uk-width-1-5 uk-visible@m">
                @include('profile.partials._sidebar')
            </div>
            {{--content--}}
            <div class="uk-width-expand">
                <ul class="uk-tab-label" uk-tab style="margin: 0px; padding: 0px">
                    <li class="tab-item tab-0 account-inf0"><a href="#">{{__('main.Account info')}}</a></li>
                    <li class="tab-item tab-1 password-tab"><a href="#">{{__('main.Password')}}</a></li>
                    <li class="tab-item tab-2 images"><a href="#">{{__('main.Images')}}</a></li>
                </ul>

                <ul class="uk-switcher" style="padding: 0px">
                    <li>
                        <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-text-center" style="border-radius: 5px 0 5px 5px">

                            {!! Form::model($user, ['url' => route('profile.update', ['id' => $user->id]), 'method' => 'PATCH', 'class' => '']) !!}

                            {{-- Form item--}}
                            <div class="uk-margin">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-6@m uk-flex uk-flex-middle">
                                        <label class="uk-form-label" for="">{{__('Full name')}}:</label>
                                    </div>
                                    <div class="uk-width-5-6@m">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-width-1-4@m">
                                                {!! Form::text('first_name', null, ['class' => $errors->has('first_name') ? 'uk-input uk-form-danger' : 'uk-input', 'placeholder' => __('First name'), 'required' =>true]) !!}
                                                {!! $errors->first('first_name', '<span class="uk-form-danger">:message</span>') !!}
                                            </div>
                                            <div class="uk-width-1-4@m">
                                                {!! Form::text('middle_name', null, ['class' => $errors->has('middle_name') ? 'uk-input uk-form-danger' : 'uk-input', 'placeholder' => __('Father\'s name'), 'required' =>false]) !!}
                                                {!! $errors->first('middle_name', '<span class="uk-form-danger">:message</span>') !!}
                                            </div>
                                            <div class="uk-width-1-4@m">
                                                {!! Form::text('last_name', null, ['class' => $errors->has('last_name') ? 'uk-input uk-form-danger' : 'uk-input', 'placeholder' => __('Grandpa\'s name'), 'required' =>false]) !!}
                                                {!! $errors->first('last_name', '<span class="uk-form-danger">:message</span>') !!}
                                            </div>
                                            <div class="uk-width-1-4@m">
                                                {!! Form::text('surname', null, ['class' => $errors->has('surname') ? 'uk-input uk-form-danger' : 'uk-input', 'placeholder' => __('Surname'), 'required' =>false]) !!}
                                                {!! $errors->first('surname', '<span class="uk-form-danger">:message</span>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Form item--}}
                            <div class="uk-margin">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-6@m uk-flex uk-flex-middle">
                                        <label class="uk-form-label" for="">{{__('Email')}}:</label>
                                    </div>
                                    <div class="uk-width-5-6@m">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-inline uk-width-1-1">
                                                {!! Form::text('email', null, ['class' => $errors->has('email') ? 'uk-input uk-form-danger' : 'uk-input', 'placeholder' => __('your_email@example.com'), 'required' =>false]) !!}
                                                {!! $errors->first('email', '<span class="uk-form-danger">:message</span>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Form item--}}
                            <div class="uk-margin">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-6@m uk-flex uk-flex-middle">
                                        <label class="uk-form-label" for="">{{__('country')}}:</label>
                                    </div>
                                    <div class="uk-width-5-6@m">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-width-1-2@m">
                                                {!! Form::select('country_id', $countries, null, ['class' => $errors->has('country_id') ? 'uk-select countries-items uk-form-danger' : 'uk-select ', 'required'=> true]) !!}
                                                {!! $errors->first('country_id', '<span class="uk-form-danger">:message</span>') !!}
                                            </div>
                                            <div class="uk-width-1-2@m">
                                                <div class="uk-form-controls directorates-section">
                                                    {!! Form::select('directorate_id', $directorates, null, ['class' => $errors->has('directorate_id') ? 'uk-select uk-form-danger' : 'uk-select ', 'required'=> true]) !!}
                                                    {!! $errors->first('directorate_id', '<span class="uk-form-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Form item--}}
                            <div class="uk-margin">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-6@m uk-flex uk-flex-middle">
                                        <label class="uk-form-label" for="">{{__('Study kind')}}:</label>
                                    </div>
                                    <div class="uk-width-5-6@m">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-width-1-4@m">
                                                {!! Form::select('scope_id', $scopes, null, ['class' => $errors->has('scope_id') ? 'uk-select scope uk-form-danger' : 'uk-select scope ', 'required'=> true]) !!}
                                                {!! $errors->first('scope_id', '<span class="uk-form-danger">:message</span>') !!}
                                            </div>
                                            <div class="uk-width-1-4@m">
                                                <div class="uk-form-controls fields-section">
                                                    <select class="uk-select fields-items fields" name="field_id">
                                                        <option selected="true" disabled="disabled">Study field</option>
                                                    </select>
                                                    {!! $errors->first('field_id', '<span class="uk-form-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="uk-width-1-4@m">
                                                <div class="uk-form-controls">
                                                    <select class="uk-select field-level-options" name="level">
                                                        <option selected="true" disabled="disabled">Study level</option>
                                                    </select>
                                                    {!! $errors->first('level', '<span class="uk-form-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                            <div class="uk-width-1-4@m">
                                                <div class="uk-form-controls fields-items-section">
                                                    <select class="uk-select field-item-options" name="field_option_id">
                                                        <option selected="true" disabled="disabled">Study type</option>
                                                    </select>
                                                    {!! $errors->first('field_option_id', '<span class="uk-form-danger">:message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Form item--}}
                            <div class="uk-margin">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-6@m uk-flex uk-flex-middle">
                                        <label class="uk-form-label" for="">{{__('Birthday')}}:</label>
                                    </div>
                                    <div class="uk-width-5-6@m">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-inline uk-width-2-3@m">
                                                <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: calendar"></span>
                                                {!! Form::text('birth_date', null, ['class' => $errors->has('birth_date') ? 'uk-input birthday uk-form-danger' : 'uk-input birthday', 'placeholder' => __('Tap to select'), 'required' => true]) !!}
                                                {!! $errors->first('birth_date', '<span class="uk-form-danger">:message</span>') !!}
                                            </div>
                                            <div class="uk-width-1-3@m">
                                                <div class="uk-form-controls">
                                                    <div class="uk-grid-small" uk-grid style="padding-top: 10px">
                                                        <div class="uk-width-1-2@s">
                                                            <label><input class="uk-radio" type="radio" name="gender" value="1" {{$user->gender == 1 ? 'checked' : ''}}> {{__('Male')}}</label>
                                                        </div>
                                                        <div class="uk-width-1-2@s">
                                                            <label><input class="uk-radio" type="radio" name="gender" value="0" {{$user->gender == 0 ? 'checked' : ''}}> {{__('Female')}}</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Form item--}}
                            <div class="uk-margin">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-6@m uk-flex uk-flex-middle">
                                        <label class="uk-form-label" for="">{{__('Phone number')}}:</label>
                                    </div>
                                    <div class="uk-width-5-6@m">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-inline uk-width-1-1">
                                                <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: phone"></span>
                                                {!! Form::text('phone_number', null, ['class' => $errors->has('phone_number') ? 'uk-input uk-form-danger' : 'uk-input', 'placeholder' => __('Add your phone number'), 'required' => false]) !!}
                                                {!! $errors->first('phone_number', '<span class="uk-form-danger">:message</span>') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(false)
                                <div class="uk-margin-small">
                                    <label class="uk-form-label" for="">{{__('Mother name')}}:</label>
                                    <div class="uk-form-controls">
                                        <input class="uk-input {{ $errors->has('mother_name') ? ' uk-form-danger' : '' }}" name="mother_name" type="text" value="{{ old('mother_name') }}">
                                    </div>
                                </div>
                            @endif
                            <div class="uk-margin uk-text-center">
                                <button class="uk-button uk-button-primary uk-width-1-3">{{__('main.Save')}}</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </li>
                    <li>
                        <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-text-center" style="border-radius: 5px 0 5px 5px">

                            {!! Form::model($user, ['url' => route('profile.update', ['id' => $user->id]), 'method' => 'PATCH', 'class' => '', 'autocomplete' => 'off']) !!}

                            <div class="uk-margin">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-6@m uk-flex uk-flex-middle">
                                        <label class="uk-form-label" for="">{{__('main.Current Current password')}}:</label>
                                    </div>
                                    <div class="uk-width-5-6@m">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-inline uk-width-1-2">
                                                <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                                                <input class="uk-input {{ $errors->has('password') ? ' uk-form-danger' : '' }}" type="password" name="current_password" placeholder="" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-margin">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-6@m uk-flex uk-flex-middle">
                                        <label class="uk-form-label" for="">{{__('main.New password')}}:</label>
                                    </div>
                                    <div class="uk-width-5-6@m">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-inline uk-width-1-2">
                                                <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                                                <input class="uk-input {{ $errors->has('password') ? ' uk-form-danger' : '' }}" type="password" name="new_password" placeholder="" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-margin">
                                <div class="uk-grid-small" uk-grid>
                                    <div class="uk-width-1-6@m uk-flex uk-flex-middle">
                                        <label class="uk-form-label" for="">{{__('main.Confirm new password')}}:</label>
                                    </div>
                                    <div class="uk-width-5-6@m">
                                        <div class="uk-grid-small" uk-grid>
                                            <div class="uk-inline uk-width-1-2">
                                                <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: lock"></span>
                                                <input class="uk-input {{ $errors->has('password') ? ' uk-form-danger' : '' }}" type="password" name="confirm_new_password" placeholder="" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-margin uk-text-center">
                                <button class="uk-button uk-button-primary uk-width-1-3">{{__('main.Save')}}</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </li>
                    <li>
                        <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-text-center" style="border-radius: 5px 0 5px 5px">

                            {!! Form::model($user, ['url' => route('profile.update', ['id' => $user->id]), 'method' => 'PATCH', 'class' => '', 'enctype' => 'multipart/form-data', 'autocomplete' => 'off']) !!}

                            <div class="uk-margin">
                                <input type="hidden" name="updated_tab" value="2">
                                <p>{{__('main.Dear student, you can add your personal picture to be used for documents and certificates issuing.')}}</p>
                                <div>
                                    @include('manage.partials._media_uploader')
                                </div>
                                <div>
                                    <ul class="uk-grid-small uk-child-width-1-2 uk-child-width-1-2@s uk-child-width-1-3@m media-items-list" uk-sortable="handle: .uk-sortable-handle" uk-grid="masonry: true">
                                        @if(!empty($user) && $userMedia = $user->getMedia(\App\Modules\Media\Media::getGroup(\App\Modules\Media\Media::TYPE_PROFILE_IMAGE)))
                                            @foreach($userMedia as $image)
                                                <li id="media_item-{{$image->id}}">
                                                    <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
                                                        <div class="bg-white uk-box-shadow-hover-medium resource-item-control"><span class="uk-sortable-handle uk-margin-small-right hover-primary" uk-icon="icon: table"></span> <span uk-tooltip="{{__('main.delete')}}" class="hover-danger media-delete" uk-icon="icon: trash"></span></div>
                                                        <div>
                                                            <input type="hidden" name="media_id[]" value="{{$image->id}}">
                                                            <input type="hidden" name="media_position[]" value="0">
                                                            <input type="hidden" name="media_new_file_order[]" value="">
                                                            <img data-src="{{$image->getFullUrl('card')}}" sizes="(min-width: 650px) 650px, 100vw" width="650" height="433" alt="" uk-img>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </div>
                            </div>

                            <div class="uk-margin uk-text-center">
                                <button class="uk-button uk-button-primary uk-width-1-3">{{__('main.Save')}}</button>
                            </div>
                            <div class="deleted-images">

                            </div>
                            {!! Form::close() !!}
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </div>
    @include('manage.partials._media_uploader_scripts')
    <script>
    $('.delete-profile-pic').click(function (){
        if (!confirm('Are you sure that you want to delete this item ?')){
            return false;
        }
        var btn = $(this);
        var imageItem = btn.closest('.profile-picture');
        var imageKey = imageItem.attr('id');
        $('.deleted-images').append('<input type="hidden" name="deleted_images[]" value="'+imageKey+'">');
        imageItem.remove();
    });

    </script>
    @include('auth._scripts')
@endsection

