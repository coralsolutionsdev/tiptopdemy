@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', Auth::user()->name)
@section('content')
    <section id="profile">
        <div class="uk-container">
            <div class="uk-grid-small uk-margin-medium-top uk-margin-small-bottom" uk-grid>
                <div class="uk-width-1-5">
                    <div class="uk-grid-small uk-child-width-1-1" uk-grid>
                        <div class="uk-card uk-card-default uk-card-body uk-text-center">
                            <div class="uk-padding-small ">
                                <div class="uk-text-center">
                                    <img class="uk-border-circle" src="{{Auth::user()->getProfilePicURL()}}" width="125" alt="Border circle">
                                </div>
                                <div class="uk-text-center" style="margin-top: -15px">
                                    <button class="uk-button uk-button-default uk-button-small" type="button" uk-toggle="target: #avatarsModal" style="background-color: white; padding: 0 8px 2px 8px"><span uk-icon="icon: camera"></span></button>
                                </div>
                            </div>
                            <div class="">
                                <span class="uk-text-bold uk-text-capitalize ">{{$user->first_name}} {{$user->surname}}</span><br>
                                <span class="uk-text-muted uk-text-capitalize uk-text-success">{{$user->getRole()->name}}</span>
                            </div>
                        </div>
                        <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-text-right">
                            <h5 class="uk-text-bold text-highlighted">My Profile</h5>
                            <ul class="uk-list uk-list-divider">
                                <li style="padding: 5px 5px 0px 5px"><span><a href="">My Profile</a></span></li>
                                <li style="padding: 5px 5px 0px 5px"><span><a href="">My Observer</a></span><span class="uk-align-left"><span class="uk-badge">0</span></span></li>
                                <li style="padding: 5px 5px 0px 5px"><span><a href="">My Coerces</a></span><span class="uk-align-left"><span class="uk-badge">0</span></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="uk-width-4-5">
                    <div class="uk-card uk-card-default uk-card-body">
                        <div class="uk-padding-large uk-text-center">
                            <img src="{{asset_image('/assets/reading_01.png')}}" width="300">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <!-- This is the modal -->
        <div id="avatarsModal" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <h3 class="text-highlighted">{{__('main.Avatar groups')}}</h3>
                {!! Form::open(['url' => route('profile.update'),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
                <div>
                    @foreach($user->getAvatarGroups() as $groupName => $groupAvatars)
                    <h5 class="text-highlighted">{{__($groupName)}}</h5>
                        <div class="uk-grid-small uk-child-width-1-4@m uk-child-width-1-2@s " uk-grid>
                            @foreach($groupAvatars as $avatarUrl)
                            <label class=""><input type="radio" name="avatar" value="{{$avatarUrl}}" {{$user->avatar == $avatarUrl ? 'checked' : ''}}> <img src="{{asset_image($avatarUrl)}}" class="uk-box-shadow-hover-large" width="100" alt="" style="border-radius: 5px"></label>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <p class="uk-text-right">
                    <button class="uk-button uk-button-primary">Save</button>
{{--                    <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>--}}
                </p>
                {!! Form::close() !!}

            </div>
        </div>
    </section>
@endsection

