<div id="mycarousel" class="carousel slide" data-ride="carousel">
<!--
  <ol class="carousel-indicators">
    <li data-target="#mycarousel" data-slide-to="0" class="active"></li>
    <li data-target="#mycarousel" data-slide-to="1"></li>
    <li data-target="#mycarousel" data-slide-to="2"></li>
  </ol>
-->
  <div class="carousel-inner">
@foreach($carousels as $carousel)
    <!--pic-->
        <div class="carousel-item {{($carousel->id == $carousel_active->id) ? 'active' : ''}} ">
        <img class="d-block w-100" src="{{asset('/uploads/banner/images/'.$carousel->image)}}" alt="First slide">
      <div class="carousel-caption d-flex align-items-center justify-content-center">
          <div class="section {{($carousel->content_alignment == 'right') ? 'ml-auto  text-justify col-lg-7 col-md-12' : ''}} {{($carousel->content_alignment == 'left') ? 'mr-auto  text-justify col-lg-7 col-md-12' : ''}} {{($carousel->content_alignment == 'center') ? 'text-justify col-lg-10 col-md-12' : ''}}">
              <div class="{{($carousel->font_color ==  'light') ? 'text-white' : 'text-dark'}}">
                {!!$carousel->content!!}
              </div>
              @if($carousel->link != null)
              <div class="section-md text-center">
               <a href="{{$carousel->link}}" class="btn {{($carousel->font_color ==  'light') ? 'btn-outline-light' : 'btn-primary'}}">{{trans('main._read_more')}}</a>
              </div>
              @endif  
          </div>
      </div>
      
    </div>
@endforeach    
  </div>
  <a class="carousel-control-prev" href="#mycarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#mycarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

