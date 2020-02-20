@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._carousels'))
@section('dir')
<p><i class="fa fa-home" aria-hidden="true"></i>
 <a href="">{{trans('main._dashboard')}} </a> > {{trans('main._carousels')}}</p>
@endsection

@section('content')
<section class="page-header">
    <div class="row">
        <div class="col-md-6">
        	<h2>@yield('title')</h2>
            <small><p class="text-muted">{{trans('main._home')}} / {{trans('main._carousels')}}</p></small>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
			<div class="col-5">
			<a href="{{Route('carousels.create')}}" class="btn btn-primary btn-lg col-lg"><span class="fa fa-plus-circle" aria-hidden="true"></span> <span>{{trans('main._add')}}</span></a>
	
			</div>        
		</div>
    </div>
</section>

<div class="row card border-light">
		
		<table class="table table-hover" id="blog-table">
			<thead>
				<th>#</th>
		     	<th>{{trans('main._image')}}</th>
		     	<th>{{trans('main._title')}}</th>
		     	<th>{{trans('main._order_id')}}</th>
		      	<th>{{trans('main._description')}}</th>
		      	<th class="text-center">status</th>
		      	<th class="text-center">{{trans('main._status')}}</th>
		      	<th class="text-center">{{trans('main._user')}}</th>
		      	<th class="text-center">{{trans('main._actions')}}</th>
			</thead>
			<tbody>

				@foreach ($banners as $banner)
				<tr>
					<td class="align-middle">{{$banner->id}}</td>
					<td>
						@if ( !empty ( $banner->image ) ) 
  						<img src="{{asset('/uploads/banner/images/'.$banner->image)}}" height="70">
  						@else 
  						<img src="{{asset('/uploads/temp/no_image_thumb.gif')}}" height="70"">
						@endif
					</td>
					<td class="align-middle">{{$banner->title}}</td>
					<td class="align-middle">{{$banner->order_id}}</td>
					<td class="align-middle">{{substr(strip_tags($banner->body),0,50)}} {{strlen($banner->body) > 50 ? "...": "" }}</td>
					<td class="align-middle text-center">{{$banner->type}}</td>
					<td id="status" class="text-center align-middle">
					@if($banner->status == "1")
						<span class="fa fa-check-circle-o text-success" aria-hidden="true"></span>
					@else
						<span class="fa fa-times-circle-o text-danger" aria-hidden="true"></span>
					@endif
					</td>
					<td class="align-middle">{{$banner->user->name}}</td>
					<td style="width: 100px;">
						<div id="action_btn">
							<nav class="navbar navbar-expand-lg">
								<ul class="navbar-nav">
									<li class="nav-item">
										<a href="{{route('banners.edit', $banner->id)}}" class="nav-link btn btn-light"><i class="fa fa-pencil" aria-hidden="true"></i></a>
									</li>
									<li id="delete_btn" class="nav-item">
										<form class="" method="post" action="{{route('banners.destroy', $banner->id)}}">
											{{csrf_field()}}
											{{method_field('DELETE')}}
											<button type="submit"><span class="fa fa-trash-o btn btn-light" aria-hidden="true"></span></button>
										</form>
									</li>
									
								</ul>
							</nav>
						</div>
					</td>
				</tr>
				@endforeach

			</tbody>
			
		</table>

</div>       
<div class="text-center">
	<div class="d-flex justify-content-center pagination">
		{!!$banners->render()!!}
	</div>
</div>
@endsection
