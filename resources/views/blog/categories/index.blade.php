@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._categories'))
@section('page-header-button')
	@Include('layouts.partials.modals._add_new_category')
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
						<th>{{__('Category')}}</th>
						<th scope="col" class="text-center" width="200">{{__('Actions')}}</th>
					</tr>
					</thead>
					<tbody>
					@foreach ($categories as $category)
						<tr>
							<td>
								<p><a target="_blank" href="{{route('blog.category.show', $category->slug)}}">{{ucfirst($category->title)}}</a></p>
								<p class="text-muted"><small>{{$category->created_at->toFormattedDateString()}}</small></p>
								<p>{{substr(strip_tags($category->description),0,50)}} {{strlen($category->description) > 50 ? "...": "" }}</p>
							</td>
							<td>
								<div class="action_btn text-right" style="padding-top: 10px">
									<ul>
										<li class="">
											<a target="_blank" href="{{route('blog.category.show', $category->slug)}}" class="btn btn-light"><i class="fas fa-link" aria-hidden="true"></i></a>
										</li>
										<li class="">
											<span id="{{$category->id}}" class="btn btn-light edit-category" data-toggle="modal" data-target="#editcategorymodal"><i class="far fa-edit"></i></span>
										</li>
										<li class="">
											<span id="{{$category->id}}" class="btn btn-light btn-delete"><i class="far fa-trash-alt"></i></span>
											<form id="delete-form" method="post" action="{{route('categories.destroy', $category->id)}}">
												{{csrf_field()}}
												{{method_field('DELETE')}}
											</form>
										</li>
									</ul>
								</div>
							</td>
						</tr>
						<div style="display: none">
							<span class="category-{{$category->id}}-title">{{$category->title}}</span>
							<span class="category-{{$category->id}}-description">{{$category->description}}</span>
						</div>
					@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div>
		{{$categories->links()}}
	</div>
</section>
{{--Edit category--}}
<section>
	<!-- Modal -->
	<form id="edit_category_form" method="POST" action="" enctype="multipart/form-data" data-parsley-validate>
		{{csrf_field()}} {{method_field('PUT')}}
		<div class="modal fade" id="editcategorymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header text-white bg-primary">
						<h5 class="modal-title" id="exampleModalLabel">{{__('Edit Category')}}</h5>
						<button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">

						<div class="form-group">
							<input type="text" name="title" class="category_title form-control" value="" placeholder="{{trans('main._title')}}" required>
						</div>
						<div class="form-group">
							<textarea name="description" class="category_description form-control" placeholder="{{trans('main._description')}}  ...."></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<div class="form-group col-12">
							<button type="submit" name="submit" class="btn btn-light btn-lg col-12" >{{__('Update')}}</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>
@endsection
@section('script')
	<script>
		// update category
		var form = $('#edit_category_form');
		var url = '{{url('')}}';
		$('.edit-category').click(function () {
			var item_id = $(this).attr('id');
			var item_title = $('.category-'+item_id+'-title').html();
			var item_description = $('.category-'+item_id+'-description').html();
			var action = url+'/manage/blog/categories/'+item_id;

			form.attr('action',action);
			// var item_status = $('.category-'+item_id+'-status').html();
			$('.category_title').val(item_title);
			$('.category_description').html(item_description);
			// if (item_status === 1){
			// 	$('.category_status').prop('checked', true);
			// }
		});
	</script>
@endsection
