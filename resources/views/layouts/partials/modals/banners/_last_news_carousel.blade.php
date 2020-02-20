<div id="mylastnewscarousel" class="carousel slide" data-ride="carousel">
  <div class="carousel-inner">
@foreach($posts as $carousel)
<!--pic-->
    <div class="carousel-item {{($carousel->id == $lastnewscarousel_active->id) ? 'active' : ''}}">
      @if($carousel->image != null)
        <img class="d-block w-100" src="{{asset('/uploads/blog/images/'.$carousel->image)}}" alt="First slide">
      @endif 
      <div class="carousel-caption d-flex align-items-center justify-content-center">
        <div class="section post-caption col-lg-8 col-md-12 mr-auto  text-justify">
          <h3>{{$carousel->title}}</h3>
          <p>{!!substr($carousel->body,0,300)!!} {{strlen($carousel->body) > 300 ? "...": "" }}</p>
              <div class="section-md text-center">
               <a href="{{route('post.show', $carousel->id)}}" class="btn btn-primary">{{trans('main._read_more')}}</a>
              </div>
        </div>
      </div>
    </div>
@endforeach    
  </div>
  <a class="carousel-control-prev" href="#mylastnewscarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#mylastnewscarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

