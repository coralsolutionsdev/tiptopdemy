<template>
    <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-small uk-padding-small uk-margin-small">
      <h5 class="text-highlighted uk-text-bold">{{$t('main.Comments')}}</h5>
      <!--Add Comments-->
      <div v-if="allowComment">
        <div v-if="userId" class="uk-grid-small" uk-grid>
          <div class="uk-width-auto uk-flex uk-flex-center">
            <img class="uk-border-circle" :src="userProfilePic" style="width: 50px; height: 50px; object-fit: cover;">
          </div>
          <div class="uk-width-expand">
            <textarea class="uk-textarea comment-textarea" rows="4" :placeholder="'Type your comment here'" v-model="newComment"></textarea>
            <div class="uk-margin-small">
              <button class="uk-button uk-button-primary add-comment" @click="addComment({newCommentText:newComment, id:null , parentId:0  })"><span v-html="$t('main.Comment')"></span></button>
            </div>
          </div>
        </div>
        <div v-else class="uk-placeholder uk-text-center">
          <p>To contribute in this discussion, you are required to login in with your account.</p>
          <a href="/login" class="uk-button uk-button-primary" v-html="$t('main.login')"></a>
        </div>
      </div>
      <!--All Comments-->
      <div class="uk-margin-small">
        <div v-for="comment in comments" ref="comments">
          <comment
              :comment="comment"
              :editableCommentId="editableCommentId"
              :userId="userId"
              ref="comment"
              @openReplyForm="openReplyForm($event)"
              @addComment="addComment($event)"
              @openEditForm="openEditForm($event)"
              @updateComment="updateComment($event)"
              @deleteComment="deleteComment($event)"
              @toggleCommentReaction="toggleCommentReaction($event)"
              @reportComment="reportComment($event)"
          ></comment>
        </div>
        <div v-if="!comments.length" class="uk-text-center uk-padding-small">
          <div class="uk-margin-small">
            <i class="far fa-comment-dots fa-5x no-comments"></i>
          </div>
          No comments yet
        </div>
      </div>
    </div>
</template>

<script>
import comment from './Comment.vue';
import helperMixin from '../../../mixins/helpers';
import items from "../products/items";

export default {
  name: "Comments",
  mixins: [helperMixin],
  components: {
    comment
  },
  props: [
    'slug',
    'className',
    'userName',
    'userId',
    'userProfilePic',
    'commentableId',
  ],
  data(){
    return {
      allowComment: true,
      comments:[],
      currentPage: 1,
      newComment: '',
      editableCommentId: 'A',
    }
  },
  created() {
    if (this.userName == null){
      this.allowComment = false;
    }
    this.fetchItems();
    console.log(this.userId);
  },
  methods:{
    // get model comments
    fetchItems(){
      axios.get('/comments/get/items', {
        params: {
          slug: this.slug,
          class_name: this.className,
          page: this.currentPage,
        }
      }).then(res => {
        this.comments = res.data.data;
        // console.log(this.comments);
      });
    },
    // post new comment
    addComment(data){
      var id = data.id;
      var parentId = data.parentId;
      var newCommentText =  data.newCommentText;
      var newId = this.generateRandomString(4);
      this.newComment = '';
      // if (false){
        if (newCommentText && newCommentText.length > 0){
          var newComment = {
            id: newId,
            comment: newCommentText,
            likes: 0,
            commenter_user_id: this.userId,
            commenter_name: this.userName,
            commenter_profile_pic: this.userProfilePic,
            commenter_gender: null,
            creation_date: 'Just now',
            is_liked: null,
            parent_id: parentId,
            replayMode: false,
            postingMode: true,
            commentable_id: this.commentableId,
            commentable_type: this.className,
            sub_comments: [],
            status: 1,
          };
          // post a main comment
          if (id == null){
            this.comments.push(newComment);
          } else {
            if (this.comments){
              this.comments.forEach((item, index) => {
                if (item.id === parentId){
                  item.sub_comments.push(newComment);
                }
              });
            }
          }
          // TODO: improve this
          var commentsElements = this.$refs.comments;
          if (commentsElements){
            var lastCommentsElement = commentsElements[commentsElements.length -1];
            this.scrollToElement(lastCommentsElement);
            this.resetCommentReplyForms();
          }
          // post comment > newComment
          // console.log(newComment);
          if (newComment){
            axios.post('/comment', newComment)
                .then(res => {
                  var postedComment = res.data;
                  var postedCommentParentId = parseInt(postedComment.parent_id);
                  this.comments.forEach((mainComment, index) => {
                    if(postedComment.posted_id == mainComment.id){
                      mainComment.id = postedComment.id;
                      mainComment.postingMode = false;
                    } else {
                      mainComment.sub_comments.forEach((subComment, index) => {
                        if (postedComment.posted_id == subComment.id){
                          subComment.id = postedComment.id;
                          subComment.postingMode = false;
                        }
                      });
                    }
                  });

                })
                .catch(error => {
                  console.log(error);
                  this.$Notify({
                    title: 'Oops! something going wrong',
                    message: 'Please contact us for more information',
                    type: 'error',
                    duration: 4000
                  });
                });
          }

        } else {
          this.$Notify({
            title: 'Comment is empty',
            message: 'You cannot post an empty comment.',
            type: 'warning',
            duration: 4000
          });
        }
      // }
    },
    // close all opened reply forms
    resetCommentReplyForms(){
      if (this.comments){
        this.comments.forEach((comment, index) => {
          comment.replayMode =  false;
          if (comment.sub_comments){
            comment.sub_comments.forEach((subComment, index) => {
              subComment.replayMode =  false;
            });
          }
        });
      }
    },
    // open comment replay form
    openReplyForm(comment){
      this.resetCommentReplyForms();
      // open comments
      comment.replayMode = true;
    },
    // open edit replay form
    openEditForm(comment){
      this.editableCommentId = comment.id;
    },
    // update comment
    updateComment(comment){
      var data = {
        comment: comment.comment,
      }
      this.editableCommentId = null;
      axios.post('/comment/'+comment.id+'/ajax/update', data)
          .then(res => {

          })
          .catch(error => {
            console.log(error);
            this.$Notify({
              title: 'Oops! something going wrong',
              message: 'Please contact us for more information',
              type: 'error',
              duration: 4000
            });
          });
    },
    // delete comment
    deleteComment(comment){
      if (!confirm('Are you sure that you want to delete this comment?')){
        return false;
      }
      var data = {}
      this.comments.forEach((item, index) => {
        if (item && item.id && item.id == comment.id){
          this.comments.splice(index, 1);
        } else {
          if (item.sub_comments){
              item.sub_comments.forEach((subComment, index) => {
              if (subComment && subComment.id && subComment.id == comment.id){
                item.sub_comments.splice(index, 1);
              }
            });
          }
        }
      });
      axios.post('/comment/'+comment.id+'/ajax/delete', data)
          .then(res => {

          })
          .catch(error => {
            console.log(error);
            this.$Notify({
              title: 'Oops! something going wrong',
              message: 'Please contact us for more information',
              type: 'error',
              duration: 4000
            });
          });
    },
    // react comment
    toggleCommentReaction(comment){
      if(comment.is_liked === false){
        comment.likes++;
      } else {
        if (parseInt(comment.likes ) !== 0){
          comment.likes--;
        }
      }
      comment.is_liked = !comment.is_liked ;
      axios.post('/comment/'+comment.id+'/react/like/toggle', {})
          .then(res => {
          })
          .catch(error => {
            console.log(error);
            this.$Notify({
              title: 'Oops! something going wrong',
              message: 'Please contact us for more information',
              type: 'error',
              duration: 4000
            });
          });
    },
    // report comment
    reportComment(comment){
      this.$Notify({
        title: 'Report posted successfully',
        message: 'We received your report, the required action will be taken as soon as possible.',
        type: 'success',
        duration: 4000
      });
    },
  },
}
</script>

<style scoped>
.comment-textarea{
  border-radius: 5px;
  height: 50px;
  padding: 5px 10px;
}
.no-comments{
  opacity: 0.2;
}
.uk-open>.uk-modal-dialog {
  border-radius: 5px;
  overflow: hidden;
}
</style>