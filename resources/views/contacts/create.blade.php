@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._new_post'))
@section('page-header-button')
	<button class="btn btn-primary btn-lg w-75"><span>{{__('Submit')}}</span></button>
@endsection
@section('content')

@section('head')
	<style>
		.layout-items{
			list-style: none;
		}
		.layout-items li{
			display: block;
			margin-bottom: 10px;
			padding-top: 10px;
			padding-bottom: 10px;
			/*border-left: 2px solid #3399FF;*/
			border: 1px solid #2196F3;
			margin-left: -50px;
		}

		.add-item{
			margin-left: 10px;
			margin-right: 10px;
		}
		.layout .btn{
			min-width: 80px;
		}
	</style>
@endsection
<section>
	@if(!empty($contact))
		{!! Form::open(['url' => route('contacts.update', $contact->id),'method' => 'PUT','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
	@else
		{!! Form::open(['url' => route('contacts.store'),'method' => 'POST','enctype' => 'multipart/form-data','data-parsley-validate' => true]) !!}
	@endif

	@include('manage.partials._page-header')
	<div class="form-panel row">
		<div class="col-lg-12">
			<div class="card border-light">
				<div class="card-body">
					<p>{{__('Basic input')}}</p>
					<hr>
					<div class="form-group row col-lg-12">
						<div class="col-lg-2 d-flex align-items-center">{{__('Title')}}</div>
						<div class="col-lg-10 padding-0 margin-0">
							{!! Form::text('title',!empty($contact) ? $contact->title : null,['class' => 'form-control title','required' => true,'placeholder' => 'Title']) !!}
						</div>
					</div>
					<div class="form-group row col-lg-12">
						<div class="col-lg-2 d-flex align-items-center">{{__('Description')}}</div>
						<div class="col-lg-10 padding-0 margin-0">
							{!! Form::textarea('content',!empty($contact->content) ? $contact->content : null,['class' => 'form-control content-editor']) !!}
						</div>
					</div>
					<div class="form-group row col-lg-12">
						<div class="col-lg-2 d-flex align-items-center">{{__('Status')}}</div>
						<div class="col-lg-10 padding-0 margin-0">
							<input type="checkbox" name="status" class="toogle-switch" value="1" {{empty($contact) || !empty($contact->status) ? 'checked' : null}}>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="card border-light">
				<div class="card-body">
					<p>{{__('Contact items')}}</p>
					<hr>
					<div class="form-group row col-lg-12 d-flex justify-content-end margin-0" style="padding:10px 5px"><span class="btn btn-outline-secondary add-item" style=""><i class="fas fa-plus-circle"></i> {{__('Add Item')}}</span></div>
					<div class="form-group row col-lg-12">
						<div class="col-lg-2">{{__('Contact items')}}</div>
						<div class="col-lg-10 padding-0 margin-0">
							<ul id="sortable" class="layout-items">

							</ul>
							<script src="{{url('https://code.jquery.com/ui/1.12.1/jquery-ui.js')}}"></script>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-12">
			<div class="card border-light">
				<div class="card-body">
					<p>{{__('Map')}}</p>
					<hr>
					<div class="form-group row col-lg-12">
						<div class="col-lg-2">{{__('Coordinates')}}</div>
						<div class="col-lg-10 padding-0 margin-0">
							{!! Form::textarea('map_coordinates',!empty($contact->map_coordinates) ? $contact->map_coordinates : null,['class' => 'form-control map_coordinates','rows' => '4']) !!}
						</div>
						<div class="col-lg-2"></div>
						<div class="col-lg-10 padding-0 margin-0">
							<br>
							<div id="map_coordinates">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{!! Form::close() !!}

</section>
<section style="display: none">
	{{--template--}}
	<li class="item-template" style="display: none; background-color: white">
		<div class="row col-lg-12">
			<div class="col-lg-2 d-flex align-items-center">
				<input type="text" name="item-icon[]" class="form-control item-icon" placeholder="icon">
			</div>
			<div class="col-lg-3 d-flex align-items-center">
				<input type="text" name="item-title[]" class="form-control item-title" placeholder="Item title">
			</div>
			<div class="col-lg-6 d-flex align-items-center">
				<input type="text" name="item-text[]" class="form-control item-text" placeholder="Item text">
			</div>
			<div class="col-lg-1 text-right">
				<span class="btn btn-light delete-layout-item"><i class="far fa-trash-alt"></i></span>
			</div>
		</div>
	</li>
</section>
@endsection
@section('script')
	<script>
		$( ".layout-items" ).sortable();
		$( document ).ready(function() {
			function deleteLayoutItem() {
				$('.delete-layout-item').click(function () {
					$(this).parent().parent().parent().remove();
				});
			}
			$('.add-item').click(function () {
				console.log('clicked');
				// $('.no-items-yet').slideUp();
				var item = $('.item-template').clone().removeClass('item-template').show();
				// item.find('.bg-dark-input').attr('id','bg-dark-color-item-'+count);
				$('.layout-items').append(item);
				// count++;
				deleteLayoutItem();
			});
			var count = 1;
			function drawMenuItems(structure) {
				structure.map(function (item) {
					var new_item = $('.item-template').clone().removeClass('item-template').show();
					new_item.find('.item-icon').val(item.icon);
					new_item.find('.item-title').val(item.title);
					new_item.find('.item-text').val(item.text);
					$('.layout-items').append(new_item);
					count++;
				});
				deleteLayoutItem();
			}
			@if (!empty($contact))
			// $('.no-items-yet').slideUp();
			$.get('{{ route('contacts.get.items', $contact->id) }}')
					.done(function (response) {
						drawMenuItems(response.structure);
					});
			@endif
		});
		function drawGoogleMap(coordinates, width, height){
			$('#map_coordinates').html('');
			if (coordinates){
				$('#map_coordinates').append('<iframe src="https://www.google.com/maps/embed?pb='+coordinates+'" width="'+width+'" height="'+height+'" frameborder="0" style="border:0" allowfullscreen></iframe>\n');
			}
		}

		// update map
		$('.map_coordinates').change(function () {
			var input = $(this);
			var coordinates = input.val();
			drawGoogleMap(coordinates, 850, 400);
		});
		@if (!empty($contact) && !empty($contact->map_coordinates))
			var coordinates = '{{$contact->map_coordinates}}';
			drawGoogleMap(coordinates, 850, 400);
		@endif



	</script>
@endsection
