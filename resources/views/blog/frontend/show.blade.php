@extends('themes.'.getFrontendThemeName().'.layout')
@section('title', $page_title)
@section('head')
    <script>
        $(function() {
            var ifr = $("iframe");
            ifr.attr("scrolling", "no");
            ifr.attr("src", ifr.attr("src"));
            var newItemWidth = parseInt($('.post-content').width());
            var itemHeight = ifr.attr("height");
            var itemWidth = ifr.attr("width");
            var r = (itemWidth / newItemWidth) * 100;
            var newItemHeight = (itemHeight * 100) / r;
            ifr.attr("width",newItemWidth);
            ifr.attr("height",newItemHeight);
        });
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

@endsection
@section('content')
    <section>
        @include('partial.frontend._page-header')
        <div class="uk-background-default pt-25">
            <div class="uk-container">
                <div class="" uk-grid>
                    <div class="uk-width-1-4@m blog-sidebar">
                        @widget('home.blog.side_bar_menu', ['search_key' => $search_key])
                    </div>
                    <div class="uk-width-3-4@m ">
                        {{-- Posts cards --}}
                        <div class="uk-child-width-1-1@m" uk-grid>
                            <div>
                                <div class="uk-card uk-card-clear">
                                    <div class="uk-inline-clip uk-transition-toggle" tabindex="0" style="width: 100%;max-height: 400px; overflow: hidden; object-fit: contain; margin-bottom: 10px">
                                        <img class="uk-transition-scale-up uk-transition-opaque" src="{{asset_image($post->image)}}" alt="" style="width: 100%">
                                    </div>
                                    <div class="uk-card-body post-content" style="padding-left: 0px; padding-right: 0px; padding-top: 0px">
                                        <h3><a href="{{route('blog.posts.show',$post->slug)}}">{{$post->title}}</a></h3>
                                        <div class="uk-grid-column-small uk-grid-row-large uk-child-width-1-2@s" uk-grid>
                                            <div class="uk-flex uk-flex-middle">
                                                <ul class="uk-iconnav uk-text-muted">
                                                    <li class="uk-flex uk-flex-middle"><span  uk-icon="icon: user; ratio: 0.8"></span><span><a href="#"> {{ucfirst($post->user->name)}}</a> </span></li>
                                                    <li class="uk-flex uk-flex-middle"><span  uk-icon="icon: calendar; ratio: 0.8"></span><span><a href="#"> {{$post->created_at->toFormattedDateString()}}</a></span></li>
                                                    @if(!empty($post->categories()))
                                                        <li class="uk-flex uk-flex-middle"><span  uk-icon="icon: folder; ratio: 0.8"></span>
                                                            @foreach($post->categories as $category)
                                                                <span><a href=""> {{ucfirst($category->name)}}</a></span>@if($post->categories->count() > 1) <span> | </span> @endif
                                                            @endforeach
                                                        </li>
                                                    @endif
                                                    <li><span uk-icon="icon: heart; ratio: 0.8"></span>  <span class="reaction-count">{{$post->getReactCount('like')}}</span>  </li>
                                                </ul>
                                            </div>
                                            <div class="uk-text-{{getFloatKey('end')}} blog-post-actions">
                                                @if(getAuthUser())
                                                <a class="uk-button uk-button-default post-reaction reaction-off"><span class=" reaction-icon {{$post->isReacted('like')? 'uk-text-danger' : ''}}" uk-icon="icon: heart"></span></a>
                                                @endif
                                                <a href="" class="uk-button uk-button-default"><span uk-icon="icon: twitter" style="color: #29A4DA"></span></a>
                                                <a href="" class="uk-button uk-button-default"><span uk-icon="icon: facebook" style="color: #0074EF"></span></a>
                                            </div>
                                        </div>
                                        <p>
                                            {!! $post->content !!}
                                        </p>
                                    </div>
                                </div>
                                {{--comments--}}
                                <div>
                                    <h4>{{__('main.Comments')}} (<span class="comment-count">{{$post->comments->where('status', 1)->count()}}</span>)</h4>
                                    <ul id="list-0" class="main-comments-list uk-comment-list comments-list-0">
                                        @if($post->allow_comments_status == 1)
                                            @if(isLoginIn())
                                                <li class="uk-fieldset main-comment-form">
                                                    <div class="uk-margin">
                                                        <textarea class="uk-textarea comment-text" rows="4" placeholder="{{__('main.Type your comment here ..')}}"></textarea>
                                                    </div>
                                                    <button class="uk-button uk-button-default add-comment">{{__('main.Comment')}}</button>
                                                </li>
                                            @else
                                                <div>
                                                    <div class="uk-card uk-card-body uk-text-center" style="border: 2px solid var(--theme-secondary-bg-color)">
                                                        <p>{{__('main.To add comments you are required to login with your account.')}}</p>
                                                        <a class="uk-button uk-button-primary" href="{{route('login')}}">{{__('main.Login now')}}</a>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                        @if(false)
                                        <li id="comment-1" class="comment">
                                            <article class="uk-comment uk-comment-primary bg-secondary uk-visible-toggle" tabindex="-1">
                                                <header class="uk-comment-header uk-flex-middle" uk-grid>
                                                    <div class="uk-width-auto">
                                                        <div class="uk-width-auto">
                                                            <img class="uk-comment-avatar uk-border-circle" src="" width="60" height="60" alt="">
                                                        </div>
                                                    </div>
                                                    <div class="uk-width-expand">
                                                        <h4 class="uk-comment-title uk-margin-remove"><a class="uk-link-reset" href="#"></a></h4>
                                                        <p class="uk-comment-meta uk-margin-remove-top"><a class="uk-link-reset" href="#"></a></p>
                                                    </div>
                                                    <div class="uk-width-auto">
                                                        <a uk-icon="icon: heart"> <span class="uk-badge">0</span> </a>
                                                        <a class="uk-link-muted uk-button uk-button-default open-comment-form" style="margin: 0px 5px">Reply</a>
                                                    </div>
                                                </header>
                                                <div class="uk-comment-body">
                                                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                                                </div>
                                            </article>
                                            <ul id="list-1" class="uk-comment-list comments-list-1">

                                            </ul>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div id="comment-submitted" class="uk-flex-top" uk-modal>
            <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

                <button class="uk-modal-close-default" type="button" uk-close></button>
                <div class="uk-modal-body">
                    <div class="uk-padding-small uk-text-center uk-text-success"><span uk-icon="icon: comment; ratio: 4.5"></span></div>
                    <div>
                        <p>{{__('your comment has been added but it is required for admin approving, thank you for sharing your feedback.')}}
                        <br> {{__('stay tuned.')}}</p>
                    </div>
                </div>

                <div class=" uk-text-center">
                    <button class="uk-button uk-button-primary uk-modal-close" type="button">Okey</button>
                </div>
            </div>
        </div>
    </section>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var postAllowedToComment = '{{$post->allow_comments_status}}';

        var count = 0;
        var bgClass = '';

        function toggleCommentReaction(){
            $('.comment-reaction').off('click');
            $('.comment-reaction').click(function () {
                console.log('liked');
                var item = $(this);
                var icon =  item.find('.reaction-icon');
                var listIem = $(this).parent().parent().parent().parent();
                var itemId = listIem.attr('id').split('-')[1];
                $.post('/blog/post/comment/'+itemId+'/react/like/toggle').done(function (count) {
                    listIem.find('.comment-reaction-count').html(count);
                });
                icon.toggleClass('uk-text-danger');
            });
        }

        $('.post-reaction').click(function () {
            var item = $(this);
            var icon =  item.find('.reaction-icon');
            var postId = '{{$post->slug}}';
            $.post('/blog/post/'+postId+'/react/like/toggle').done(function (count) {
                $('.reaction-count').html(count);
            });
            icon.toggleClass('uk-text-danger');
        });

        function updateCommentCount($status = true) {
            var countCount =  parseInt($('.comment-count').html());
            if($status ==  true){
                countCount =  countCount +1;
            }else{
                countCount =  countCount -1;
            }
            $('.comment-count').html(countCount);
        }

        function deleteComment() {
            $('.delete-comment-item').off('click');
            $('.delete-comment-item').click(function () {
                var listIem = $(this).parent().parent().parent().parent();
                var itemId = listIem.attr('id').split('-')[1];
                if (!confirm('Are you sure you want to remove your comment?')){
                    return false;
                }
                $.post('/blog/post/comment/'+itemId+'/delete').done(function (response) {
                    listIem.remove();
                    updateCommentCount(false);
                    var deleteMsg = '<span class="uk-text-success"><span uk-icon=\'icon: trash\'></span> '+'{{__('main.Comment removed successfully')}}'+'</span>';
                    UIkit.notification({message: deleteMsg, pos: 'top-right'})
                });
            });
        }

        function opedSubCommentForm() {
            $('.open-comment-form').off('click');
            $('.open-comment-form').click(function () {
                var item = $(this);
                var listitem = item.parent().parent().parent().parent();
                var listId = item.parent().parent().parent().parent().attr('id').split('-')[1];
                var listItem = item.parent().parent().parent().parent();
                var form = $('.main-comments-list').find('.sub-comment-form');
                var replyedTo =listItem.find('.user-name').html();
                form.remove();
                if(listItem.hasClass('comment-parent-0')){
                    $('.comments-list-'+listId).append(
                    '<li class="uk-fieldset sub-comment-form">\n' +
                    '<div class="uk-margin">\n' +
                    '<textarea class="uk-textarea comment-text" rows="4" placeholder=""> </textarea>\n' +
                    '</div>\n' +
                    '<button class="uk-button uk-button-default add-comment">{{__('main.Comment')}}</button>\n' +
                    '</li>'
                    );
                }else{
                    listItem.parent().append(
                    '<li class="uk-fieldset sub-comment-form">\n' +
                    '<div class="uk-margin">\n' +
                    '<textarea class="uk-textarea comment-text" rows="4" placeholder=""></textarea>\n' +
                    '</div>\n' +
                    '<button class="uk-button uk-button-default add-comment">{{__('main.Comment')}}</button>\n' +
                    '</li>'
                    );
                }
                $('body, html').animate({ scrollTop: $(".sub-comment-form").offset().top - 200 }, 1000);

                addComment();
            });
        }

        function drawCommentItem(commentId, listId, profilePic, userName, date, comment, likes , commentParentId, userId , isLiked, status) {
            var bgClass = 'bg-secondary';
            var deleteBtn = '';
            var replyBtn = '';
            var likeBtn = '';
            var likedClass = '';
            var currentUserId = '{{\Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->id : 0}}';
            if(isLiked == 1){
                likedClass = 'uk-text-danger';
            }
            if (userId == currentUserId){
                deleteBtn = '<a class="uk-link-muted uk-button uk-button-default delete-comment-item" style="padding: 0px 10px"><span uk-icon="icon: trash"></span></a>\n';
            }
            @if(isLoginIn())
                if(postAllowedToComment == 1){
                    replyBtn = '<a class="uk-link-muted uk-button uk-button-default open-comment-form" style="margin: 0px 5px">{{__('main.Replay')}}</a>\n';
                }
                likeBtn = '<a class="uk-button uk-button-default comment-reaction" style="padding: 0px 10px"><span class=" reaction-icon '+likedClass+'" uk-icon="icon: heart"></span></a>\n';
            @endif


            comment = comment.replace(/\n/g,"<br>");

            $('.comments-list-'+listId).append(
                '<li id="comment-'+commentId+'" class="comment comment-parent-'+commentParentId+'">\n' +
                '<article class="uk-comment uk-comment-primary '+bgClass+' uk-visible-toggle" tabindex="-1">\n' +
                '<header class="uk-comment-header uk-flex-middle" uk-grid>\n' +
                '<div class="uk-width-auto">\n' +
                '<img class="uk-comment-avatar uk-border-circle" src="'+profilePic+'" width="60" height="60" alt="">\n' +
                '</div>\n' +
                '<div class="uk-width-expand">\n' +
                '<h4 class="uk-comment-title uk-margin-remove"><a class="uk-link-reset user-name" href="#">'+userName+'</a></h4>\n' +
                '<p class="uk-comment-meta uk-margin-remove-top"><a class="uk-link-reset" href="#">'+date+'</a>  <span style="padding: 0px 5px">|</span>  <span uk-icon="icon: heart; ratio: 0.8"></span>  <span class="comment-reaction-count">'+likes+'</span>  </p>\n' +
                '</div>\n' +
                '<div class="uk-width-auto">\n' +
                likeBtn +
                replyBtn +
                deleteBtn+
                '</div>\n' +
                '</header>\n' +
                '<div class="uk-comment-body">\n' +
                '<p>'+comment+'</p>\n' +
                '</div>\n' +
                '</article>\n' +
                '<ul id="list-'+commentId+'" class="uk-comment-list comments-list-'+commentId+'">\n' +
                '</ul>\n' +
                '</li>'
            );
            opedSubCommentForm();
            deleteComment();
            toggleCommentReaction();
        }

        function reDrawComments() {
            var id = '{{$post->slug}}';
            $.get('/blog/post/'+id+'/get/comments').done(function (items) {
                $.each(items, function (id, item) {
                    var commentId = item.id;
                    var commentParentId = item.parent_id;
                    var listId = 0;
                    var profilePic = item.user_profile_pic;
                    var userName = item.user_name;
                    var date = item.create_date;
                    var comment = item.content;
                    var likes = item.likes;
                    var userId = item.user_id;
                    var status = item.status;
                    var subItems = item.sub_items;
                    var isLiked = item.is_liked;
                    if(status == 1){
                        drawCommentItem(commentId, listId, profilePic, userName, date, comment, likes , commentParentId, userId,  isLiked, status);
                        if (subItems != null && subItems != undefined){
                            $.each(subItems, function (id, item) {
                                var subCommentId = item.id;
                                var commentParentId = item.parent_id;
                                var listId = commentId;
                                var profilePic = item.user_profile_pic;
                                var userName = item.user_name;
                                var date = item.create_date;
                                var comment = item.content;
                                var likes = item.likes;
                                var userId = item.user_id;
                                var subStatus = item.status;
                                var isLiked = item.is_liked;
                                if(subStatus == 1){
                                    drawCommentItem(subCommentId, listId, profilePic, userName, date, comment, likes , commentParentId, userId,  isLiked, subStatus);
                                    count++;
                                    opedSubCommentForm();
                                }
                            })
                        }
                        count++;
                        opedSubCommentForm();
                    }
                })
            });
        }

        function addComment(){
            $('.add-comment').off('click');
            $('.add-comment').click(function () {
                toggleScreenSpinner(true);
                var item = $(this);
                var itemList = item.parent().parent();
                var listId = itemList.attr('id').split('-')[1];
                var commentForm = item.parent();
                var comment = commentForm.find('.comment-text').val();
                if (comment == ''){
                    alert('Comment is empty!');
                    return false;
                }
                var userId = '{{\Illuminate\Support\Facades\Auth::check() ? \Illuminate\Support\Facades\Auth::user()->id : 0}}';
                var postId = '{{$post->id}}';
                var data = {
                    'user_id':userId,
                    'post_id':postId,
                    'content':comment,
                    'parent_id': listId,
                    'status': '{{$post->default_comment_status == 1 ? 1 : 0}}',
                };
                $.post('/manage/blog/comments',data).done(function (item) {
                    drawCommentItem(item.id, listId, item.user_profile_pic, item.user_name, item.create_date, item.content, item.likes, item.parent_id, item.user_id, item.is_liked, item.status);
                    $('body, html').animate({ scrollTop: $("#comment-"+item.id).offset().top - 200 }, 1000);
                    updateCommentCount(true);
                    if(item.status == 0){
                        UIkit.modal($('#comment-submitted')).show();
                    }else{
                        var deleteMsg = '<span class="uk-text-success"><span uk-icon=\'icon: check\'></span> '+'{{__('main.Comment added successfully')}}'+'</span>';
                        UIkit.notification({message: deleteMsg, pos: 'top-right'})
                    }
                });

                count++;
                $('.comment-text').val('');
                if (!commentForm.hasClass('main-comment-form') ){
                    commentForm.remove();
                }
            });
        }


        $(document).ready(function () {
            reDrawComments();
            addComment();
        });
        $( document ).ajaxComplete(function() {
            toggleScreenSpinner(false);
        });

    </script>
@endsection
@if(false)

@section('script')

    <script>

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