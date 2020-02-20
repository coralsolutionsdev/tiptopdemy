@extends('themes.'.getAdminThemeName().'.layout')
@section('title', $pageTitle)
@section('page-header-button')
    <button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
@endsection
@section('content')

<section>
    <form method="POST" action="{{route('module.setting.update', getSite()->id)}}" enctype="multipart/form-data">
    {{csrf_field()}}
    {{method_field('PUT')}}
    {{--Page header--}}
    @include('manage.partials._page-header')
    {{--List of items--}}
        <div>
            <div class="card border-light table-card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">{{__('Module')}}</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                            <th scope="col" class="text-center" width="30">{{__('Actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($modules as $item)
                            <tr>
                                <td style="text-transform: capitalize">{{$item->display_name}}</td>
                                <td></td>
                                <td></td>
                                <td class="text-center"><input type="checkbox" name="modules[{{$item->id}}]" class="toogle-switch" value="1" {{(isModuleEnabled($item->name))?'checked':''}}>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form>
</section>

@endsection
