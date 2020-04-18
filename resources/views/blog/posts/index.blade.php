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
						<th scope="col" width="30">{{__('Image')}}</th>
						<th scope="col" width="300">{{__('Post')}}</th>
{{--						<th scope="col" class="text-center" width="50">{{__('Category')}}</th>--}}
						<th scope="col" class="text-center">{{__('Likes')}}</th>
						<th scope="col" class="text-center">{{__('Status')}}</th>
						<th scope="col" class="text-center">{{__('Allow Com.')}}</th>
						<th scope="col" class="text-center" width="100">{{__('Comments')}}</th>
						<th scope="col" class="text-center" width="350">{{__('Actions')}}</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($posts as $post)
						<tr>
							<td style="width: 120px">
								<img src="{{$post->getMainImage()}}" style="width: 100%">
							</td>
							<td>
								<p><a target="_blank" href="{{route('blog.posts.show', $post->slug)}}">{{ucfirst($post->title)}}</a></p>
								<p class="text-muted"><small>{{ucfirst($post->user->name)}} | {{$post->created_at->toFormattedDateString()}}</small></p>
								<p>{{substr(strip_tags($post->content),0,50)}} {{strlen($post->content) > 50 ? "...": "" }}</p>
							</td>
{{--							<td class="text-center align-middle">{{ucfirst($post->category->title)}}</td>--}}
							<td class="text-center align-middle">{{$post->getReactCount('like')}}</td>
							<td class="text-center align-middle">{!! getStatusIcon($post->status) !!}</td>
							<td class="text-center align-middle">{!! getStatusIcon($post->allow_comments_status) !!}</td>
							<td class="text-center align-middle"><a href="{{route('blog.post.comments.show', $post->slug)}}" class="btn btn-light">View</a>({{$post->comments->count()}})</td>
							<td>
								<div class="action_btn text-right" style="padding-top: 10px">
										<ul>
											<li class="">
												<a target="_blank" href="{{route('blog.posts.show', $post->slug)}}" class="btn btn-light"><i class="fas fa-link" aria-hidden="true"></i></a>
											</li>
											<li class="">
												<a href="{{route('posts.edit', $post->slug)}}" class="btn btn-light"><i class="far fa-edit"></i></a>
											</li>
											<li class="">
												<span id="{{$post->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
												<form id="delete-form" method="post" action="{{route('posts.destroy', $post->slug)}}">
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
		{{$posts->links()}}
	</div>
</section>

@endsection
@section('script')
@endsection
