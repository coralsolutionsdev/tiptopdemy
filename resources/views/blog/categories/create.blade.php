@extends('themes.'.getAdminThemeName().'.layout')
@section('title','Create Category')
@section('dir')
<p><i class="fa fa-home" aria-hidden="true"></i>
 <a href="">Dashboard</a> > <a href="">Blog Category</a> > Create</p>
@endsection

@section('content')
<div class="container-fluid">  
	<div class="row">
		<form method="POST" action="{{route('blog.categories.store')}}" enctype="multipart/form-data" data-parsley-validate>
	        {{csrf_field()}}
	        	
				<div class="col-md-9 form-group">
					<div class="panel panel-body">
						<div class="form-group">
		                <label name="title">Title:</label>                
		                <input type="text" name="title" class="form-control" value="" placeholder="Category Title" required>
		                </div>
		                <div class="form-group">
		                <label name="body">Description:</label>
		                <textarea name="description" class="form-control" rows="7" placeholder="Categpry Description ...."></textarea>
		                </div>
					</div>
                </div>
			
				<div class="col-md-3 form-group">
					<div class="panel panel-body">
					
                        <div class="form-group">
                        <br>
                        	<button type="submit" name="submit" class="btn btn-success col-md-12" >Submit</button>
                        </div>
	                </div>
                </div>
			
		</form>
	</div>       
</div>
@endsection
