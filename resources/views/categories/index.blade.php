@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)
@section('page-header-button')
    <a href="{{Route('category.create.type', $modelType)}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
@endsection
@section('head')
    <link href="{{asset('plugins/file_tree/css/file-explore.css')}}" rel="stylesheet">
    <script src="{{asset('plugins/file_tree/js/file-explore.js')}}"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .cat-li{
            display: block;
        }
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
        html, body{
            height: 100%;
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
                    @if(!empty($categoriesCollection) && sizeof($categoriesCollection) > 0)
                    {{drawCategoryTreeList($categoriesCollection, $categoryType, 'file-tree')}}
                    @else
                        <div class="uk-text-center">
                            <p>{{__('main.There is no form items yet.')}}</p>
                        </div>
                    @endif
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

