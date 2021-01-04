@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)
@section('page-header-button')
<a href="{{Route('form.memorize.create')}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
@endsection
@section('head')
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<style>
		html,body{
			height: 100%;
		}
	</style>
@endsection
@section('content')

<section>
	{{--Page header--}}
	@include('manage.partials._page-header')
	{{--List of items--}}
	<div id="vue-app">
		<memorize-index></memorize-index>
		@if(true)
		<div class="card border-light table-card">
			<div class="card-body pt-0 p-3">
				<table class="uk-table uk-table-justify uk-table-divider">
					<thead>
					<tr>
						<th>Memorize info</th>
						<th class="uk-width-small">number of items</th>
						<th class="uk-width-small text-right"></th>
					</tr>
					</thead>
					<tbody>
					@forelse($memorizes as $item)
					<tr>
						<td  class="align-middle">
							<p>{{ucfirst($item->title)}}</p>
							<p class="text-muted"><small>{{ucfirst($item->creator->name)}} | {{$item->created_at->toFormattedDateString()}}</small></p>
							<p>{{substr(strip_tags($item->description),0,50)}} {{strlen($item->description) > 50 ? "...": "" }}</p>
						</td>
						<td class="align-middle uk-text-center">{{sizeof($item->options)}}</td>
						<td class="text-right pt-4">
{{--							<a href="{{route('form.templates.show', $item->slug)}}" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-success" uk-tooltip="{{__('main.view')}}"><i class="fas fa-eye" aria-hidden="true"></i></a>--}}
							<a href="{{route('form.memorize.edit', $item->hash_id)}}" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-primary" uk-tooltip="{{__('main.edit')}}"><span uk-icon="icon: pencil"></span></a>
							<span id="{{$item->id}}" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-danger btn-delete" uk-tooltip="{{__('main.delete')}}"><span uk-icon="icon: trash"></span></span>
							<form id="delete-form" method="post" action="{{route('form.memorize.destroy', $item->hash_id)}}">
								{{csrf_field()}}
								{{method_field('DELETE')}}
							</form>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="3" class="uk-text-center">{{__('main.There is no form items yet.')}}</td>
					</tr>
					@endforelse
					</tbody>
				</table>
			</div>
		</div>
		@endif
	</div>
	<div>
{{--		{{$templates->links()}}--}}
	</div>
</section>
{{--<script src="{{asset('/js/app.js')}}"></script>--}}

@endsection
@section('script')
@endsection
