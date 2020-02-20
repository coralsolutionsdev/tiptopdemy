@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $page_title)
@section('content')
    <section>
        @include('partial.frontend._page-header')
        <div class="uk-background-default pt-25">
            <div class="uk-container">
                <div class="" uk-grid>
                    <div class="uk-width-2-3@m ">
                        {{-- Posts cards --}}
                        <div class="uk-child-width-1-1@m" uk-grid>
                            <div>
                                <div class="uk-card uk-card-clear">
                                    <div class="uk-inline-clip uk-transition-toggle" tabindex="0" style="width: 100%;max-height: 400px; overflow: hidden; object-fit: contain;">
                                        <img class="uk-transition-scale-up uk-transition-opaque" src="{{asset_image($post->image)}}" alt="" style="width: 100%">
                                    </div>
                                    <div class="uk-card-body" style="padding-left: 0px; padding-right: 0px">
                                        <h3><a href="{{route('blog.post.show',$post->slug)}}">{{$post->title}}</a></h3>
                                        <ul class="uk-iconnav uk-text-muted">
                                            <li class="uk-flex uk-flex-middle"><span  uk-icon="icon: user; ratio: 0.8"></span><span><a href="#"> {{ucfirst($post->user->name)}}</a> </span></li>
                                            <li class="uk-flex uk-flex-middle"><span  uk-icon="icon: calendar; ratio: 0.8"></span><span><a href="#"> {{$post->created_at->toFormattedDateString()}}</a></span></li>
                                            <li class="uk-flex uk-flex-middle"><span  uk-icon="icon: folder; ratio: 0.8"></span><span><a href="{{route('blog.category.show',$post->category->id)}}"> {{ucfirst($post->category->title)}}</a></span></li>
                                        </ul>
                                        <p>
                                            {!! $post->content !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-3@m blog-sidebar">
                        @widget('home.blog.side_bar_menu')
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@if(false)

    <meta name="csrf-token" content="{{ csrf_token() }}">


<!--================Home Banner Area =================-->
<section class="banner_area">
    <div class="banner_inner d-flex align-items-center">
        <div class="overlay bg-parallax" data-stellar-ratio="0.9" data-stellar-vertical-offset="0" data-background=""></div>
        <div class="container">
            <div class="banner_content text-center">
                <h2>BLOG DETAILS</h2>
                <div class="page_link">
                    <a href="index.html">Home</a>
                    <a href="single-blog.html">BLOG DETAILS</a>
                </div>

            </div>
        </div>
    </div>
</section>
<!--================End Home Banner Area =================-->
<!--================Blog Area =================-->
<section class="blog_area single-post-area p_120">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 posts-list">
                <div class="single-post row">
                    <div class="col-lg-12">
                        <div class="feature-img">
                            <img class="img-fluid" src="{{asset_image($post->image)}}" alt="">
                            <div class="blog-info" style="padding-top: 5px">
                                <ul class="list-inline">
                                    <li class="list-inline-item "><i class="lnr lnr-user"></i> {{$post->user->name}}</li>
                                    <li class="list-inline-item "><i class="lnr lnr-calendar-full"></i> {{$post->created_at->toFormattedDateString()}}</li>
                                    {{--<li class="list-inline-item ">1.2M Views<i class="lnr lnr-eye"></i></li>--}}
                                    <li class="list-inline-item "><i class="lnr lnr-bubble"></i> {{$post->getCommentsCount()}} Comments</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-md-9 blog_details">
                        <h2>Astronomy Binoculars A Great Alternative</h2>
                        <p class="excert">
                            {!! $post->content !!}
                        </p>
                    </div>

                </div>
                <div class="navigation-area">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-12 nav-left flex-row d-flex justify-content-start align-items-center">
                            <div class="thumb">
                                <a href="#"><img class="img-fluid" src="/themes/ronin/img/blog/prev.jpg" alt=""></a>
                            </div>
                            <div class="arrow">
                                <a href="#"><span class="lnr text-white lnr-arrow-left"></span></a>
                            </div>
                            <div class="detials">
                                <p>Prev Post</p>
                                <a href="#"><h4>Space The Final Frontier</h4></a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-12 nav-right flex-row d-flex justify-content-end align-items-center">
                            <div class="detials">
                                <p>Next Post</p>
                                <a href="#"><h4>Telescopes 101</h4></a>
                            </div>
                            <div class="arrow">
                                <a href="#"><span class="lnr text-white lnr-arrow-right"></span></a>
                            </div>
                            <div class="thumb">
                                <a href="#"><img class="img-fluid" src="/themes/ronin/img/blog/next.jpg" alt=""></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="comments-area">
                    <h4><span class="comment-number">{{$post->getCommentsCount()}}</span> Comments</h4>
                    <div class="comment-list">

                            {{--@if($post_comment->user_id == Auth()->user()->id)--}}
                            {{--<div class="">--}}
                            {{--<span id="{{$post_comment->id}}" class="fa fa-trash-o remove-comment" aria-hidden="true"></span>--}}
                            {{--</div>--}}
                            {{--@endif--}}

                        <div class="single-comment comment-template hidden">
                            <div class="row">
                                <div class="col-1 thumb">
                                    <img src="/themes/ronin/img/blog/c1.jpg" alt="">
                                </div>
                                <div class="col-7 desc" style="padding-top: 10px">
                                    <h5 class="comment_user"></h5>
                                    <p class="date">Just now </p>
                                </div>
                                <div class="col-3 reply-btn">
                                    <span class="btn-reply text-uppercase pull-right" style="display: inline-block">Replay</span>
                                    <span class="btn-reply text-uppercase pull-right" style="display: inline-block"><i class="far fa-trash-alt remove-comment"></i></span>
                                </div>
                            </div>
                            <div class="row col-12 comment-template-text" style="padding: 5px 0px 10px 95px">
                            </div>
                        </div>
                        @foreach($post->comments as $post_comment)
                        <div class="single-comment">
                            <div class="row">
                                <div class="col-1 thumb">
                                    <img src="/themes/ronin/img/blog/c1.jpg" alt="">
                                </div>
                                <div class="col-7 desc" style="padding-top: 10px">
                                    <h5 class="comment_user">{{$post_comment->user->name}}</h5>
                                    <p class="date">{{$post_comment->created_at->toFormattedDateString()}} </p>
                                </div>
                                <div class="col-3 reply-btn">
                                    <span class="btn-reply text-uppercase pull-right" style="display: inline-block">Replay</span>
                                    <span class="btn-reply text-uppercase pull-right" style="display: inline-block"><i class="far fa-trash-alt remove-comment"></i></span>
                                </div>
                            </div>
                            <div class="row col-12" style="padding: 5px 0px 10px 95px">
                                {{$post_comment->content}}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @if(false)
                    <div class="comment-list left-padding">
                        <div class="single-comment justify-content-between d-flex">
                            <div class="user justify-content-between d-flex">
                                <div class="thumb">
                                    <img src="img/blog/c2.jpg" alt="">
                                </div>
                                <div class="desc">
                                    <h5><a href="#">Elsie Cunningham</a></h5>
                                    <p class="date">December 4, 2017 at 3:12 pm </p>
                                    <p class="comment">
                                        Never say goodbye till the end comes!
                                    </p>
                                </div>
                            </div>
                            <div class="reply-btn">
                                <a href="" class="btn-reply text-uppercase">reply</a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="comment-form">
                    <h4>Leave a Reply</h4>
                    <form>
                        {{--<div class="form-group form-inline">--}}
                            {{--<div class="form-group col-lg-6 col-md-6 name">--}}
                                {{--<input type="text" class="form-control" id="name" placeholder="Enter Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Name'">--}}
                            {{--</div>--}}
                            {{--<div class="form-group col-lg-6 col-md-6 email">--}}
                                {{--<input type="email" class="form-control" id="email" placeholder="Enter email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'">--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="form-group">--}}
                            {{--<input type="text" class="form-control" id="subject" placeholder="Subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Subject'">--}}
                        {{--</div>--}}
                        <div class="form-group">
                            <textarea class="form-control mb-10 comment-field" rows="5" name="message" placeholder="Messege" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Messege'" required=""></textarea>
                        </div>
                        <span class="primary-btn submit_btn add-comment">Post Comment</span><br><span class="lds-ripple posting-comment" style="display: none"><div></div><div></div></span>
                    </form>
                </div>
            </div>
            @include('themes.ronin.blog._sidebar')
        </div>
    </div>
</section>
<!--================Blog Area =================-->

@section('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('.add-comment').click(function () {
            var user_name = '{{Auth()->user()->name}}';
            var user_id = '{{Auth()->user()->id}}';
            var post_id = '{{$post->id}}';
            var comment_template = $('.comment-template').clone();
            var comment_box = $('.comment-list');
            var comment_number = $('.comment-number');
            var comment_number_as_int = parseInt(comment_number.html());
            comment_number_as_int++;
            var comment = $('.comment-field').val();
            console.log(comment_number_as_int)
            if (comment.length < 1){
                alert('cannot');
                return false;
            }
            comment_template.removeClass('comment-template').removeClass('hidden');
            comment_template.find('.comment-template-text').html(comment);
            comment_template.find('.comment_user').html(user_name);
            $('.posting-comment').slideDown();
            var data = {
                'user_id':user_id,
                'post_id':post_id,
                'content':comment
            };
            $.post('/manage/blog/comments',data).done(function (response) {
                console.log(response)
                comment_template.find('.remove-comment').attr('id',response.id);
                comment_box.append(comment_template);
                $('.comment-field').val('');
                comment_number.html(comment_number_as_int);
                $('.posting-comment').slideUp();
                deleteBlogComment()
            });


        });
        function deleteBlogComment() {
            $('.remove-comment').click(function () {
                var comment_id = $(this).attr('id');
                var comment = $(this).parent().parent();
                var data = {
                    "_method": 'DELETE'
                };

                $.post('/manage/blog/comments/'+comment_id,data).done(function () {
                    comment.remove();
                });
            });
        }
        deleteBlogComment();

    </script>
@endsection
@endif