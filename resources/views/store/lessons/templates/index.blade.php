@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)
@section('page-header-button')
    <span class="uk-button uk-button-primary" type="button" uk-toggle="target: #toggle-animation-multiple; animation:  uk-animation-slide-left, uk-animation-slide-bottom">Filters</span>

    {{--    <a href="{{Route('store.products.create')}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>--}}
@endsection
@section('head')
    <link rel="stylesheet" href="{{asset('/plugins/input_tree/css/styles.css')}}">
@endsection
@section('content')

    <section>
        {{--Page header--}}
        @include('manage.partials._page-header')

        {{--List of items--}}
        <div>
            <div class="">
                <div class="pt-5">
                    <div id="toggle-animation-multiple" class="hidden mb-4" areia-hidden="true" {{ empty($selectedCategories)? 'hidden': ''}}>
                        <form id="filter-form" action="{{route('store.get.form.templates', $lesson->slug)}}">
                            {{drawInputTreeListItems($categories, 'categories[]',$selectedCategories , 'checktree')}}
                        </form>
                    </div>
                    <script>
                        $('.tree-item').change(function () {
                            $('#filter-form').submit();
                        });
                    </script>

                    <div class="uk-child-width-1-6@xl uk-child-width-1-4@l uk-child-width-1-3@m uk-child-width-1-2@s uk-child-width-1-1 uk-text-center" uk-grid>
                        <div>
                            <a href="{{route('store.form.create', $lesson->slug)}}">
                                <div class=" uk-card uk-card-default uk-card-body uk-text-primary border-hover-primary uk-box-shadow-hover-large uk-flex uk-flex-middle uk-flex-center" style="min-height: 18em; width: 100%">
                                    <div class="uk-margin">
                                        <div class="uk-padding-small"><span uk-icon="icon: plus-circle; ratio: 4"></span></div>
                                        <label>Create new</label>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @forelse($templates as $template)
                            <div>
                                <div class=" uk-card uk-card-default uk-card-body border-hover-primary uk-box-shadow-hover-large p-0" style="min-height: 18em; width: 100%">
                                    <div class="uk-text-left uk-padding-small">
                                        <h4 class="uk-text-primary">{{$template->title}}</h4>
                                    </div>
                                    <div class="uk-position-bottom uk-padding-small">
                                        <spam id="{{$template->id}}" class="uk-button uk-button-primary uk-width-1-1 apply-template" onClick="applyTemplate($(this).attr('id'))">Apply</spam>
                                    </div>
                                </div>
                            </div>
                            @empty
                        @endforelse

                    </div>
                    {!! Form::open(['url' => route('form.template.clone'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true, 'id' => 'clone-form']) !!}
                    <input type="hidden" name="owner_id" value="{{!empty($lesson)? $lesson->id : ''}}">
                    <input type="hidden" name="owner_type" value="{{\App\Modules\Form\Form::OWNER_TYPE_LESSON}}">
                    <input type="hidden" name="form_template_id">
                    {!! Form::close() !!}

                </div>
            </div>
        </div>
        <script>
            function applyTemplate(id)
            {
                if(!confirm('Are you sure you want to apply this template?')){
                    return false;
                }
                $( "input[name='form_template_id']" ).val(id);
                $('#clone-form').submit();

            }
        </script>
    </section>

@endsection
@section('script')
@endsection
