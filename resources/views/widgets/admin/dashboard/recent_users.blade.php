<div class="widget uk-padding-small uk-box-shadow-hover-small p-tag-m-0" style="background-color: #EEE5FF">
    <div>
        <h4 class="" style="color: #8950FC">{{__('main.latest users')}}</h4>
        <span class="uk-text-meta" style="color: #8950FC">{{__('main.view the recently registered products')}}. </span>
        <table class="uk-table uk-table-justify uk-table-divider">
            <thead>
            <tr>
                <th class="" width="60">{{trans('main._avatar')}}</th>
                <th>{{trans('main._name')}}</th>
                <th>{{__('main.Actions')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($items as $user)
                <tr>
                    <td>
                        <img src="{{$user->getProfilePicURL()}}" class="profile-picture-w-50">
                    </td>
                    <td>
                        <p><a target="_blank" href="">{{ucfirst($user->name)}}</a></p>
                        <p class="uk-text-meta"><small>{{$user->email}}</p>
                        <p>{{$user->getRole()->display_name}}</p>
                    </td>
                    <td class="align-middle">
                        <a href="{{route('users.edit', $user->id)}}"  class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-primary" uk-tooltip="{{__('main.edit')}}"><span uk-icon="icon: pencil"></span></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="text-right" style="padding: 10px">
            <a href="{{Route('users.index')}}" class="uk-button uk-button-small uk-action-btn uk-button-default">{{__('main.view all')}}</a>
        </div>
    </div>
</div>