@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)
@section('page-header-button')
    <a href="{{Route('store.sets.create')}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
@endsection
@section('content')

    <section>
        {{--Page header--}}
        @include('manage.partials._page-header')

        {{--List of items--}}
        <div>
            <div class="card border-light table-card">
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">{{__('Name')}}</th>
                            <th scope="col" class="text-center" width="200">{{__('Actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($attribute_sets as $item)
                            <tr>
                                <td>
                                    <p>{{ucfirst($item->name)}}</p>
                                    <p class="text-muted"><small> {{$item->created_at->toFormattedDateString()}}</small></p>
                                    <p>{{substr(strip_tags($item->description),0,50)}} {{strlen($item->description) > 50 ? "...": "" }}</p>
                                </td>
                                <td>
                                    <div class="action_btn text-right" style="padding-top: 10px">
                                        <ul>
                                            <li class="">
                                                <a href="{{route('store.sets.edit', $item->slug)}}" class="btn btn-light"><i class="far fa-edit"></i></a>
                                            </li>
                                            <li class="">
                                                <span id="{{$item->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
                                                <form id="delete-form" method="post" action="{{route('store.sets.destroy', $item->slug)}}">
                                                    {{csrf_field()}}
                                                    {{method_field('DELETE')}}
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div>
            {{$attribute_sets->links()}}
        </div>
    </section>

@endsection
@section('script')
@endsection
