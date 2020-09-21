@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $user->name)
@section('content')
    <section>
        <div class="uk-container">
            <div class="uk-grid-small uk-margin-medium-top uk-margin-small-bottom" uk-grid>
                <div class="uk-width-1-5@m uk-width-1-1">
                    <div class="uk-grid-small uk-child-width-1-1" uk-grid>
                        <div>
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
                        </div>
                       <div>
                           <div class="uk-card uk-card-default uk-card-body uk-padding-small uk-text-right">
                               <h5 class="uk-text-bold text-highlighted">My Profile</h5>
                               <ul class="uk-list uk-list-divider">
                                   <li style="padding: 5px 5px 0px 5px"><span><a href="">My Profile</a></span></li>
                                   <li style="padding: 5px 5px 0px 5px"><span><a href="{{route('profile.courses.index')}}">{{__('main.My Courses')}}</a></span><span class="uk-align-left"><span class="uk-badge">0</span></span></li>
                                   <li style="padding: 5px 5px 0px 5px"><span><a href="">My Observer</a></span><span class="uk-align-left"><span class="uk-badge">0</span></span></li>
                               </ul>
                           </div>
                       </div>
                    </div>
                </div>
                <div class="uk-width-4-5@m uk-width-1-1">
                    <div class="uk-card uk-card-default uk-card-body uk-padding-small">
                        <h4 class="uk-text-bold text-highlighted">{{__('main.My Courses')}} ({{$products->count()}})</h4>
                        <table id="cart-table" class="uk-table uk-table-divider uk-table-justify uk-table-middle uk-margin-remove ">
                            <thead>
                            <tr>
                                <th width="150" class="">{{__('main.Product image')}}</th>
                                <th class="uk-table-expand">{{__('main.Product info')}}</th>
                                <th class="uk-table-small"></th>
                            </tr>
                            </thead>
                            <tbody class="card-items">
                            @forelse($products as $product)
                                <tr class="cart-item">
                                    <td>
                                        <img data-src="{{$product->getProductPrimaryImage()}}" width="150" height="" alt="" uk-img>
                                    </td>
                                    <td>
                                        <p class="uk-margin-remove"><a target="_blank" href="{{route('store.product.show', $product->slug)}}">{{ucfirst($product->name)}}</a></p>
                                        <p class="uk-margin-remove" class="text-muted"><small>{{ucfirst($product->user->name)}} | {{$product->created_at->toFormattedDateString()}}</small></p>
                                        <p class="uk-margin-remove">{{substr(strip_tags($product->description),0,50)}} {{strlen($product->description) > 50 ? "...": "" }}</p>
                                    </td>
                                    <td class="uk-text-{{getFloatKey((getLanguage() == 'ar')? 'end' : 'start')}}">
                                        <a class="uk-button uk-button-primary" href="{{route('store.product.show', $product->slug)}}"><span uk-icon="icon:  play-circle"></span> {{__('main.View lesson')}}</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>{{__('main.There is no form items yet.')}}</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <!-- This is the modal -->
        <div id="avatarsModal" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <h3 class="text-highlighted">{{__('main.Avatar groups')}}</h3>
                {!! Form::open(['url' => route('profile.update'),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
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
                <p class="uk-text-right">
                    <button class="uk-button uk-button-primary uk-width-1-1">{{__('main.Save')}}</button>
{{--                    <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>--}}
                </p>
                {!! Form::close() !!}

            </div>
        </div>
    </section>
@endsection

