<div class="uk-card uk-card-default uk-card-body" style="padding: 10px">
    {{--user avatar--}}
    <div class="uk-padding-small">
        <div class="uk-flex uk-flex-center">
            <img class="uk-border-circle uk-image-glow-{{$user->gender == 1 ? 'success' : 'pink'}}"  src="{{Auth::user()->getProfilePicURL()}}" width="125" alt="Border circle">
        </div>
        <div  class="" style="margin-top: -30px; padding: 0 30px;">
            <button class="uk-button uk-button-primary uk-button-small" type="button" uk-toggle="target: #avatarsModal" style=" border-radius: 50%; border: 3px solid white; padding: 0px 8px"><i class="fas fa-camera"></i></button>
        </div>
    </div>
    <div class="uk-text-center">
        <span class="uk-text-bold uk-text-capitalize ">{{$user->first_name}} {{$user->surname}}</span><br>
        @if(!empty($user->username))
            <span class="uk-text-primary uk-text-capitalize"> {{$user->username}}</span><br>
        @endif
        <span class="uk-text-muted uk-text-capitalize">{{__('main.'.$user->getRole()->display_name)}}</span><br>

    </div>
    <div class="uk-margin-small uk-text-center">
        <a class="uk-button uk-button-default uk-button-gray" href="{{route('profile.edit', $user->id)}}">{{__('main.Edit Profile')}}</a>
    </div>

    <hr>
    {{--user menus--}}
    <div>
        <ul class="uk-list">
            <li>
                <a href="{{route('profile.index')}}">
                    <div class="uk-grid-collapse uk-flex-middle" uk-grid>
                        <div class="uk-width-auto"><span class="uk-icon-box" uk-icon="icon: user"></span></div>
                        <div class="uk-width-expand" style="padding: 0 5px">{{__('main.Profile')}}</div>
                        {{--                                        <div class="uk-width-auto"><span class="uk-badge uk-badge-mini uk-badge-success">0</span></div>--}}
                    </div>
                </a>
            </li>
            <li>
                <a href="{{route('profile.courses.index')}}">
                    <div class="uk-grid-collapse uk-flex uk-flex-middle" uk-grid>
                        <div class="uk-width-auto"><span class="uk-icon-box" uk-icon="icon: calendar"></span></div>
                        <div class="uk-width-expand" style="padding: 0 5px">{{__('main.My Courses')}}</div>
                        <div class="uk-width-auto"><span class="uk-badge uk-badge-mini uk-badge-success">{{$user->getCourses(\App\Product::TYPE_COURSES)->count()}}</span></div>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{route('profile.orders.index')}}">
                    <div class="uk-grid-collapse uk-flex uk-flex-middle" uk-grid>
                        <div class="uk-width-auto"><span class="uk-icon-box" uk-icon="icon: cart"></span></div>
                        <div class="uk-width-expand" style="padding: 0 5px">{{__('main.My Orders')}}</div>
                        <div class="uk-width-auto"><span class="uk-badge uk-badge-mini uk-badge-success">{{$user->orders->count()}}</span></div>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{route('profile.observers.index')}}">
                    <div class="uk-grid-collapse uk-flex uk-flex-middle" uk-grid>
                        <div class="uk-width-auto"><span class="uk-icon-box" uk-icon="icon: users"></span></div>
                        <div class="uk-width-expand" style="padding: 0 5px">{{__('main.Observers List')}}</div>
                        <div class="uk-width-auto"><span class="uk-badge uk-badge-mini uk-badge-success">0</span></div>
                    </div>
                </a>
            </li>

        </ul>
    </div>
</div>
<section>
    <!-- This is the modal -->
    <div id="avatarsModal" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <h3 class="text-highlighted">{{__('main.Avatar groups')}}</h3>
            {!! Form::open(['url' => route('profile.update', ['profile' => $user->id]),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
            <div>
                @foreach($user->getAvatarGroups() as $groupName => $groupAvatars)
                    <h5 class="text-highlighted">{{__($groupName)}}</h5>
                    <div class="uk-grid-small" uk-grid>
                        @foreach($groupAvatars as $avatarUrl)
                            <div class="uk-width-1-4@m uk-width-1-2">
                                <label class=""><input type="radio" name="avatar" value="{{$avatarUrl}}" {{$user->avatar == $avatarUrl ? 'checked' : ''}} style="position: absolute"> <img src="{{asset_image($avatarUrl)}}" class="uk-box-shadow-hover-large" alt="" style="border-radius: 5px; width: 100%"></label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="uk-text-right uk-margin-small">
                <button class="uk-button uk-button-primary uk-width-1-1">{{__('main.Save')}}</button>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</section>