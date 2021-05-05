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
<script>
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  var postAllowedToComment = '{{$post->allow_comments_status}}';

  var count = 0;
  var bgClass = '';

  function openCommentEditorForm() {
    $('.edit-comment-item').off('click');
    $('.edit-comment-item').click(function () {
      var item = $(this);
      var itemId = item.attr('id').split('-')[1];
      var itemContent = $('.comment-'+itemId+'-content').html();
      $('.comment-editor-input').html(itemContent);
      $('.comment-editor-id').val(itemId);
      UIkit.modal('#comment-editor').show();
    });
  }
  function getEditedComment() {
    return $('.comment-editor-input').val();
  }
  function updateComment() {
    $('.update-comment').off('click');
    $('.update-comment').click(function () {
      var commentId = $('.comment-editor-id').val();
      var comment = getEditedComment();
      var data = {
        'comment':comment,
      };
      $('.update-comment').html('<span uk-spinner="ratio: 0.5"></span>'+'{{__('main.Updating')}}')
      $.post('/comment/'+commentId+'/ajax/update',data).done(function (comment) {
        $('.comment-editor-input').html('');
        $('.comment-editor-id').val('');
        $('.comment-'+commentId+'-content').html(comment)
        UIkit.modal('#comment-editor').hide();
        $('.update-comment').html('{{__('main.Save changes')}}');

      });
    });
  }

  function toggleCommentReaction(){
    $('.comment-reaction').off('click');
    $('.comment-reaction').click(function () {
      var item = $(this);
      var itemId = $(this).attr('id').split('-')[1];
      var itemIcon = item.find('.reaction-icon');
      var itemReactionCount = item.find('.comment-reaction-count').html();
      var newCount = 0;
      if(item.hasClass('reacted')){ // remove
        item.removeClass('reacted');
        item.addClass('not-reacted');
        itemIcon.removeClass('fas');
        itemIcon.addClass('far');
        newCount = parseInt(itemReactionCount) - 1;
        item.find('.comment-reaction-count').html(newCount)
      }else{ // add
        item.removeClass('not-reacted');
        item.addClass('reacted');
        item.find('.reaction-icon');
        itemIcon.removeClass('far');
        itemIcon.addClass('fas');
        newCount = parseInt(itemReactionCount) + 1;
        item.find('.comment-reaction-count').html(newCount)
      }
      $.post('/comment/'+itemId+'/react/like/toggle').done(function (count) {
      });
      // TODO: add field notification
    });
  }

  $('.post-reaction').click(function () {
    var item = $(this);
    var icon =  item.find('.reaction-icon');
    var postId = '{{$post->slug}}';
    var itemIcon = item.find('.post-reaction-icon');
    var itemReactionCount = item.find('.post-reaction-count').html();
    var newCount = 0;
    if(item.hasClass('reacted')){ // remove
      item.removeClass('reacted');
      itemIcon.removeClass('fas');
      itemIcon.addClass('far');
      newCount = parseInt(itemReactionCount) - 1;
      item.find('.post-reaction-count').html(newCount)
    }else{ // add
      item.addClass('reacted');
      item.find('.reaction-icon');
      itemIcon.removeClass('far');
      itemIcon.addClass('fas');
      newCount = parseInt(itemReactionCount) + 1;
      item.find('.post-reaction-count').html(newCount)
    }
    $.post('/blog/post/'+postId+'/react/like/toggle').done(function (count) {
    });
    // TODO: notification if failed
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
      var item = $(this);
      var itemId = item.attr('id').split('-')[1];
      if (!confirm('Are you sure you want to remove your comment?')){
        return false;
      }
      $.post('/comment/'+itemId+'/ajax/delete').done(function (response) {
        $('#comment-'+itemId).remove();
        updateCommentCount(false);
        var deleteMsg = '<span class="uk-text-success"><span uk-icon=\'icon: trash\'></span> '+'{{__('main.Comment removed successfully')}}'+'</span>';
        UIkit.notification({message: deleteMsg, pos: 'bottom-right'})
      });
    });
  }

  function opedSubCommentForm() {
    $('.open-comment-form').off('click');
    $('.open-comment-form').click(function () {
      var item = $(this);
      var listId = item.attr('id').split('-')[1];
      var listItem = $('#comment-'+listId);
      var form = $('.main-comments-list').find('.sub-comment-form');
      var replyedTo = listItem.find('.user-name').html();
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

  function drawCommentItem(item) {
    var bgClass = 'bg-secondary';
    var replayBtn = '';
    var actionsBtn = '';
    var reactionBtn = '';
    var editBtn = '';
    var deleteBtn = '';
    var reportBtn = '';
    var commenterRingColor = 'success';
    var reactionStatus = 'not-reacted';
    if(item.is_liked == true){
      reactionStatus = 'reacted';
    }
    if(item.commenter_gender == 0){
      commenterRingColor = 'pink';
    }
    var comment = item.comment.replace(/\n/g,"<br>");
    var likeClass = 'far';
    if(item.is_liked == true){
      likeClass = 'fas'
    }
    @if(isLoginIn())
    var currentUserId = parseInt('{{getAuthUser()->id}}');
    if(currentUserId == item.commenter_id){
      editBtn = '<li><a id="edit_comment-'+item.id+'" class="edit-comment-item" style="display: block"><span uk-icon="icon: file-edit"></span> {{__('main.Edit')}}</a></a></li>\n';
      deleteBtn = '<li><a id="delete_comment-'+item.id+'" class="delete-comment-item" style="display: block"><span uk-icon="icon: trash"></span> {{__('main.Remove')}}</a></a></li>\n';
    }else{
      reportBtn ='<li><a href="#"><span uk-icon="icon: warning"></span> {{__('main.Report')}}</a></a></li>\n';
    }
    replayBtn = '<li><button id="reply_to-'+item.id+'" class="uk-button uk-button-default open-comment-form uk-text-primary">{{__('main.Replay')}}</button></li>';
    actionsBtn = '<li>\n' +
            '<button class="uk-button uk-button-text" type="button" style="padding: 0 10px"><span uk-icon="icon:  more-vertical; ratio: 0.8"></span></button>\n' +
            '<div uk-dropdown="pos: bottom-right">\n' +
            '<ul class="uk-list" style="padding: 0px; margin: 0px">\n' +
            reportBtn+
            editBtn+
            deleteBtn+
            '</ul>\n' +
            '</div>\n' +
            '</li>';
    reactionBtn = '<li><button id="react_to_comment-'+item.id+'" class="uk-button uk-button-default uk-text-danger comment-reaction '+reactionStatus+'" style="padding: 0 10px"><span class="comment-reaction-count">'+item.likes+'</span> <span class="'+likeClass+' fa-heart reaction-icon"></span></button></li>';
    @else
            reactionBtn = '<li><span id="react_to_comment-'+item.id+'" class="uk-text-danger '+reactionStatus+'" style="padding: 0 10px"><span class="comment-reaction-count">'+item.likes+'</span> <span class="'+likeClass+' fa-heart reaction-icon"></span></span></li>';
    @endif


    $('.comments-list-'+item.parent_id).append(
            '<li id="comment-'+item.id+'" class="comment comment-parent-'+item.parent_id+'">\n' +
            '    <article class="uk-comment bg-secondary uk-padding-small uk-visible-toggle" tabindex="-1">\n' +
            '        <header class="uk-comment-header uk-position-relative">\n' +
            '            <div class="uk-grid-medium" uk-grid>\n' +
            '                <div class="uk-width-auto">\n' +
            '                    <img class="uk-comment-avatar uk-border-circle uk-image-glow-'+commenterRingColor+'-small" src="'+item.commenter_profile_pic+'" width="60" height="60" alt="">\n' +
            '                </div>\n' +
            '                <div class="uk-width-expand">\n' +
            '                    <div class="uk-grid-medium" uk-grid>\n' +
            '                        <div class="uk-width-expand">\n' +
            '                            <h4 class="uk-comment-title uk-margin-remove"><a class="uk-link-reset">'+item.commenter_name+'</a></h4>\n' +
            '                            <p class="uk-comment-meta uk-margin-remove-top"><a class="uk-link-reset">'+item.creation_date+'</a></p>\n' +
            '                        </div>\n' +
            '                        <div class="uk-width-auto">\n' +
            '                            <ul class="uk-list comment-actions">\n' +
            '                                '+reactionBtn+'\n' +
            '                                '+replayBtn+'\n' +
            '                                '+actionsBtn+'\n' +
            '                            </ul>\n' +
            '                        </div>\n' +
            '                    </div>\n' +
            '                    <div class="uk-comment-body">\n' +
            '                        <p class="comment-'+item.id+'-content">'+comment+'</p>\n' +
            '                    </div>\n' +
            '                </div>\n' +
            '            </div>\n' +
            '        </header>\n' +
            '    </article>\n' +
            '    <ul id="list-'+item.id+'" class="uk-comment-list comments-list-'+item.id+'">\n' +
            '    </ul>\n' +
            '</li>'
    );
    opedSubCommentForm();
    deleteComment();
    toggleCommentReaction();
    openCommentEditorForm();
    updateComment();
  }
  function reDrawComments() {
    var id = '{{$post->slug}}';
    $.get('/blog/post/'+id+'/get/comments').done(function (comments) {
      $('.comment-loading-spinner').remove();
      $.each(comments, function (id, comment) {
        if(comment.status == 1){
          drawCommentItem(comment);
          count++;
          opedSubCommentForm();
        }
      })
    }).fail(function () {
      $('.comment-loading-spinner').html(
              '<div class="uk-margin">\n' +
              '<div class="uk-text-center uk-text-warning">\n' +
              '<div>\n' +
              '<span uk-icon="icon: warning; ratio: 2"></span>\n' +
              '</div>\n' +
              '<div class="uk-padding-small">\n' +
              '{{__('main.An error appended during loading, please refresh the page.')}} ...\n' +
              '</div>\n' +
              '</div>\n' +
              '</div>'
      );
    });
  }


  function addComment(){
    $('.add-comment').off('click');
    $('.add-comment').click(function () {
      var item = $(this);
      var itemList = item.parent().parent();
      var listId = itemList.attr('id').split('-')[1];
      var commentForm = item.parent();
      var comment = commentForm.find('.comment-text').val();
      if (comment == ''){
        alert('Comment is empty!');
        return false;
      }
      toggleScreenSpinner(true);
      var postId = '{{$post->id}}';
      var data = {
        'commentable_id':postId,
        'commentable_type': '{!! addslashes($post->getClassName()) !!}',
        'comment':comment,
        'parent_id': listId,
        'status': '{{$post->default_comment_status == 1 ? 1 : 0}}',
      };
      $.post('/comment',data).done(function (item) {
        drawCommentItem(item);
        $('body, html').animate({ scrollTop: $("#comment-"+item.id).offset().top - 200 }, 1000);
        updateCommentCount(true);
        if(item.status == 0){
          UIkit.modal($('#comment-submitted')).show();
        }else{
          var deleteMsg = '<span class="uk-text-success"><span uk-icon=\'icon: check\'></span> '+'{{__('main.Comment added successfully')}}'+'</span>';
          UIkit.notification({message: deleteMsg, pos: 'bottom-right'})
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

@if(true)
  <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-small uk-padding-small uk-margin-small">
    <h5 class="text-highlighted uk-text-bold">{{__('main.Comments')}} (<span class="comment-count">{{$post->comments->where('status', 1)->count()}}</span>)</h5>
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
      <li class="comment-loading-spinner">
        <div class="uk-margin">
          <div class="uk-text-center uk-text-primary">
            <div>
              <span uk-spinner="ratio: 2"></span>
            </div>
            <div class="uk-padding-small">
              {{__('main.Loading')}} ...
            </div>
          </div>
        </div>
      </li>
      @if(false)
        <li>
          <article class="uk-comment bg-secondary uk-padding-small uk-visible-toggle" tabindex="-1">
            <header class="uk-comment-header uk-position-relative">
              <div class="uk-grid-medium" uk-grid>
                <div class="uk-width-auto">
                  <img class="uk-comment-avatar uk-border-circle" src="https://getuikit.com/docs/images/avatar.jpg" width="80" height="80" alt="">
                </div>
                <div class="uk-width-expand">
                  <div class="uk-grid-medium" uk-grid>
                    <div class="uk-width-expand">
                      <h4 class="uk-comment-title uk-margin-remove"><a class="uk-link-reset" href="#">Author</a></h4>
                      <p class="uk-comment-meta uk-margin-remove-top"><a class="uk-link-reset" href="#">12 days ago</a></p>
                    </div>
                    <div class="uk-width-auto">
                      <ul class="uk-list comment-actions">
                        <li><button class="uk-button uk-button-default uk-text-danger" style="padding: 0 10px"><span>1</span> <span class="fas fa-heart"></span></button></li>
                        <li><button class="uk-button uk-button-default uk-text-primary">Replay</button></li>
                        <li>
                          <button class="uk-button uk-button-text" type="button" style="padding: 0 10px"><span uk-icon="icon:  more-vertical; ratio: 0.8"></span></button>
                          <div uk-dropdown="pos: bottom-right">
                            <ul class="uk-list" style="padding: 0px; margin: 0px">
                              <li><a href="#">Report</a></li>
                              <li><a href="#">Edit</a></li>
                              <li><a href="#">Reply</a></li>
                            </ul>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div class="uk-comment-body">
                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.</p>
                  </div>
                </div>
              </div>
            </header>
          </article>
          <ul>
          </ul>
        </li>
      @endif

    </ul>
  </div>
@endif


<script>




  addSubComment(comment){
    var data = {
      id: comment.id,
      parent_id:comment.parent_id !== 0 ? comment.parent_id : comment.id,
      comment: this.newComment
    };
    this.$emit('addSubComment', data);
    this.newComment = '';
  },
  openEditForm(comment){
    this.editableCommentId = comment.id;
  },
  changeComment(comment){
    var data = {
      id: comment.id,
      comment: comment.comment,
    }

  }
  fetchItems(){
    axios.get('/comments/get/items', {
      params: {
        slug: this.slug,
        class_name: this.className,
        page: this.currentPage,
      }
    }).then(res => {
      // console.log(res.data.data);
      this.comments = res.data.data;
    });
  },
  addComment(){
    var data = {
      id: null,
      parent_id: null,
      comment: this.newComment
    };
    this.postComment(data);
    this.newComment = '';

  },
  resetCommentReplyForms(e){
    this.comments.forEach((comment, index) => {
      comment.replayMode =  false;
      if (comment.sub_comments){
        comment.sub_comments.forEach((subComment, index) => {
          subComment.replayMode =  false;
        });
      }
    });
  },
  openReplyForm(comment){
    // close all previous comments
    this.$emit('resetReplyForms', true);
    // open comments
    comment.replayMode = true;
  },
  addSubComment(comment){
    var data = {
      id: comment.id,
      parent_id:comment.parent_id !== 0 ? comment.parent_id : comment.id,
      comment: this.newComment
    };
    this.$emit('addSubComment', data);
    this.newComment = '';
  },
  openEditForm(comment){
    this.editableCommentId = comment.id;
  },
  changeComment(comment){
    var data = {
      id: comment.id,
      comment: comment.comment,
    }

  }


  if (postedCommentParentId === 0){ // posted as main comment
    this.comments.forEach((comment, index) => {
      if (parseInt(comment.id) === parseInt(postedComment.posted_id)){
        comment.id = postedComment.id;
        comment.postingMode = false;
        comment.sub_comments = [];
      }
    });
  } else {
    subComment.id = postedComment.id;
    subComment.postingMode = false;
    comment.sub_comments = [];
    console.log(comment.sub_comments)
    if (comment.sub_comments){

    }



  }
</script>