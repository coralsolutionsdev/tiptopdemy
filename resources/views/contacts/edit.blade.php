@extends('themes.'.getAdminThemeName().'.layout')
@section('title',trans('main._contact_info'))
@section('content')

<form method="POST" action="{{route('contacts.update', $contact->id)}}}" enctype="multipart/form-data" data-parsley-validate>
    {{csrf_field()}} {{method_field('PUT')}}

<section class="page-header">
    <div class="row">
        <div class="col-md-6">
          <h2>@yield('title')</h2>
            <small><p class="text-muted">{{trans('main._home')}} / {{trans('main._contact')}} / {{trans('main._update')}}</p></small>
        </div>
        <div class="col-md-6 d-flex justify-content-end">
      <div class="col-5">
      <button type="submit" name="submit" class="btn btn-success btn-lg col-12" >{{trans('main._update')}}</button>  
      </div>        
    </div>
    </div>
</section>
<section id="panel-form">
    <div class="row card border-light">
        <div class="col-md-8">
            <div class="">
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._title')}}:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="text" name="title" class="form-control" value="{{$contact->title}}" required>
                    </div>
                </div>
                <!--form item-->
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._contact')}}:</label>
                    </div>
                    <div class="col-md-6">
                        <select name="type" class="form-control" required>
                        <option disabled value> -- {{trans('main._select')}} {{trans('main._contact')}} -- </option>
                        <option value="contact-body" {{($contact->type == 'contact-body') ? 'selected' : ''}}>Contact desicreption</option>
                        <option value="location" {{($contact->type == 'location') ? 'selected' : ''}}>location</option>
                        <option value="email" {{($contact->type == 'email') ? 'selected' : ''}}>Email</option>
                        <option value="phone" {{($contact->type == 'phone') ? 'selected' : ''}}>Phone</option>
                        <option value="facebook" {{($contact->type == 'facebook') ? 'selected' : ''}}>Facebook</option>
                        <option value="twitter" {{($contact->type == 'twitter') ? 'selected' : ''}}>Twitter</option>
                        <option value="instagram" {{($contact->type == 'instagram') ? 'selected' : ''}}>Instagram</option>
                        <option value="youtube" {{($contact->type == 'youtube') ? 'selected' : ''}}>youtube</option>
                        <option value="linkedin" {{($contact->type == 'linkedin') ? 'selected' : ''}}>linkedin</option>
                        </select>
                    </div>
                </div>
                <!--form item-->
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._link')}}:</label>
                    </div>
                    <div class="col-md-6">
                        <input type="text" name="link" class="form-control" value="{{$contact->link}}">
                    </div>
                </div>
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._status')}}:</label>
                    </div>
                    <div class="col-md-10">
                        <input type="checkbox" name="status" class="toogle-switch" value="1" {{($contact->status == '1') ? 'checked' : ''}}>
                    </div>
                </div>  
                <!--form item-->
                <!--form item-->
                <div class="form-group d-flex align-items-center">
                    <div class="col-md-2">
                        <label>{{trans('main._body')}}:</label>
                    </div>
                    <div class="col-md-10">
                        <textarea name="body" rows="5" class="form-control" placeholder="Post desicription ....">{{$contact->body}}</textarea>

                    </div>
                </div>
                
                <!--form item-->
            </div>
        </div>      
              
    </div>
</section>
</form>
@endsection
