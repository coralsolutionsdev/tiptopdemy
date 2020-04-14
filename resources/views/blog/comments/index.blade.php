@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)
@section('page-header-button')
<a href="{{Route('posts.create')}}" class="btn btn-primary btn-lg w-75"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
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
						<th scope="col">{{__('Comment')}}</th>
						<th scope="col" width="30">{{__('Status')}}</th>
						<th scope="col" class="text-center" width="30">{{__('Actions')}}</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($comments as $item)
						<tr>
							<td>{{$item->content}}</td>
							<td class="" style="padding-top: 20px">
								<input type="checkbox" name="status" class="toogle-switch" value="1" >
							</td>
							<td>
								<div class="action_btn text-right" >
										<ul>
											<li class="">
												<span id="{{$item->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
												<form id="delete-form" method="post" action="{{route('posts.destroy', $item->id)}}">
													{{csrf_field()}}
													{{method_field('DELETE')}}
												</form>
											</li>
										</ul>
								</div>
							</td>
						</tr>
						@if(!empty($item->comments))
							@foreach ($item->comments as $item)
								<tr>
									<td style="padding-left: 50px"><i class="fas fa-angle-right"></i> {{$item->content}}</td>
									<td class="" style="padding-top: 20px">
										<input type="checkbox" name="status" class="toogle-switch" value="1" >
									</td>
									<td>
										<div class="action_btn text-right" >
											<ul>
												<li class="">
													<span id="{{$item->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
													<form id="delete-form" method="post" action="{{route('posts.destroy', $item->id)}}">
														{{csrf_field()}}
														{{method_field('DELETE')}}
													</form>
												</li>
											</ul>
										</div>
									</td>
								</tr>
							@endforeach
						@endif
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section>

@endsection
@section('script')
@endsection
