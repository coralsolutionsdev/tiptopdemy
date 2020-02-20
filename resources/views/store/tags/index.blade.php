@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)
@section('page-header-button')
    <a href="{{Route('store.products.create')}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
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
                            <th scope="col" width="30">{{__('Tag')}}</th>
                            <th scope="col" class="text-center">{{__('Type')}}</th>
                            <th scope="col" class="text-center" width="200">{{__('Actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tags as $tag)
                            <tr>
                                <td class="text-center align-middle">{{$tag->name}}</td>
                                <td class="text-center align-middle">{{$tag->type}}</td>
                                <td class="d-flex align-items-center">
                                    <div class="action_btn text-right" style="padding-top: 10px">
                                        <ul>
                                            <li class="">
                                                <a target="_blank" href="" class="btn btn-light disabled"><i class="fas fa-link" aria-hidden="true"></i></a>
                                            </li>
                                            <li class="">
                                                <a href="" class="btn btn-light disabled"><i class="far fa-edit"></i></a>
                                            </li>
                                            <li class="">
                                                <span id="{{$tag->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
                                                <form id="delete-form" method="post" action="{{route('store.tags.destroy', $tag->id)}}">
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
{{--            {{$products->links()}}--}}
        </div>
    </section>

@endsection
@section('script')
@endsection
