@extends('themes.'.getAdminThemeName().'.layout')
@section('title',$page_title)
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
						<th scope="col">{{__('main.Comment')}}</th>
						<th scope="col" width="100">{{__('main.Status')}}</th>
						<th scope="col" class="text-center" width="30">{{__('main.Actions')}}</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($comments as $item)
						@if($item->parent_id == 0)
						<tr>
							<td>{!! nl2br($item->comment) !!}</td>
							<td class="" style="padding-top: 20px">
								{!! Form::open(['url' => route('comment.update', $item->id),'method' => 'PUT', 'enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
								<input type="checkbox" name="status" onchange="this.form.submit()" class="toogle-switch"  value="1"  {{empty($item) || !empty($item->status) ? 'checked' : null}}>
								{!! Form::close() !!}
							</td>
							<div>
							</div>
							<td>
								<div class="action_btn text-right" >
										<ul>
											<li class="">
												<span id="{{$item->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
												<form id="delete-form" method="post" action="{{route('comment.destroy', $item->id)}}">
													{{csrf_field()}}
													{{method_field('DELETE')}}
												</form>
											</li>
										</ul>
								</div>
							</td>
						</tr>
						@endif
						@if(!empty($item->children))
							@foreach ($item->children as $item)
								<tr>
									<td style="padding-left: 50px"><i class="fas fa-angle-right"></i> {{$item->comment}}</td>
									<td class="" style="padding-top: 20px">
										{!! Form::open(['url' => route('comment.update', $item->id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
										<input type="checkbox" name="status" onchange="this.form.submit()" class="toogle-switch"  value="1"  {{empty($item) || !empty($item->status) ? 'checked' : null}}>
										{!! Form::close() !!}
									</td>

									<td>
										<div class="action_btn text-right" >
											<ul>
												<li class="">
													<span id="{{$item->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
													<form id="delete-form" method="post" action="{{route('comment.destroy', $item->id)}}">
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
