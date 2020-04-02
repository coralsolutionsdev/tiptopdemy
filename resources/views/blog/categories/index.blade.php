@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)
@section('page-header-button')
    <a href="{{Route('blog.categories.create')}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
@endsection
@section('head')
    <link href="{{asset('plugins/file_tree/css/file-explore.css')}}" rel="stylesheet">
    <script src="{{asset('plugins/file_tree/js/file-explore.js')}}"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>

        .file-tree .cat-item{
            margin: 5px 10px;
            border: 1px solid gray;
            border-radius: 2px;
            padding: 1px 5px;
        }
        .file-tree .icon{
            background-color: #F3F5F9;
            border: 1px solid gray;
            border-radius: 2px;
            padding: 3px 5px;
            font-size: 12px;
        }

    </style>
@endsection
@section('content')

    <section>
        {{--Page header--}}
        @include('manage.partials._page-header')
{{--        style="background-color: var(--main-theme-color)"--}}
        {{--List of items--}}
        <div>
            <div class="card border-light table-card">
                <div class="card-body">
                    {{drawCategoryTreeList($categoriesCollection, \App\Category::TYPE_POST, 'file-tree')}}
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).ready(function() {
            $(".file-tree").filetree({
            });
        });
    </script>

@endsection

