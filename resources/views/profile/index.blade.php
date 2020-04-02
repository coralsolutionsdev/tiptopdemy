@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', Auth::user()->name)
@section('content')
    <section id="profile">
        <div class="uk-container">
            <div>
                <div class="uk-card uk-card-default uk-card-body uk-text-center" style="padding: 25px 40px">
                    <div class="uk-grid-divider uk-child-width-expand@s" uk-grid>
                        <div class="uk-width-1-4@m">
                            <div>
                                <div class="uk-card uk-width-1-1@m" style="border: 0.5px solid #E5E5E5;">
                                    <div class="uk-card-body uk-padding-remove">
                                        <div class="uk-padding-small">
                                            <img class="uk-border-circle" src="{{Auth::user()->getProfilePicURL()}}" width="125" alt="Border circle">
                                        </div>
                                        <div class="">
                                            <span class="uk-text-bold uk-text-capitalize ">{{$user->first_name}} {{$user->surname}}</span><br>
                                            <span class="uk-text-muted uk-text-capitalize uk-text-success">{{$user->getRole()->name}}</span>
                                        </div>
                                    </div>
                                    <br>
                                </div>
                                <br>
                                <div class="uk-card uk-width-1-1@m" style="border: 0.5px solid #E5E5E5;">
                                    <div class="uk-card-body uk-padding-remove">
                                        <div class="uk-padding-small uk-text-right">
                                            <h4 class="uk-text-bold">My Profile</h4>
                                            <ul class="uk-list uk-list-divider">
                                                <li style="padding: 5px 5px 0px 5px"><span><a href="">My Profile</a></span></li>
                                                <li style="padding: 5px 5px 0px 5px"><span><a href="">My Observer</a></span><span class="uk-align-left"><span class="uk-badge">0</span></span></li>
                                                <li style="padding: 5px 5px 0px 5px"><span><a href="">My Coerces</a></span><span class="uk-align-left"><span class="uk-badge">0</span></span></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-padding-large">
                            <img src="{{asset_image('/assets/reading_01.png')}}" width="300">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

