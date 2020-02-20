@if($news_tickers_count > 0)
<div class="container">
    <div id="marquee">
        
          <div class="row">
            <div class="col-lg-2 d-flex justify-content-center align-items-center title padding-0">
            <h5>{{trans('main._last_news')}}</h5>
            </div>
            <div class="col-lg-10 padding-0 bg-white">
              <div class="marquee">
                  <p>
                      @foreach($news_tickers as $news)
                          @if($news->link == null)
                          {{strip_tags($news->body)}} &nbsp; <span class="text-danger">&#9830;</span>   &nbsp;
                          @else
                          <a href="">{{strip_tags($news->body)}}</a> &nbsp; <span class="text-danger">&#9830;</span>   &nbsp;
                          @endif
                      @endforeach
                  </p>
                
              </div>
            </div>
          </div>
        
    </div>
</div>
@endif

