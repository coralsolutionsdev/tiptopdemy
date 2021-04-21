<template>
  <div class="uk-grid-small" uk-grid>
    <div class="uk-width-auto uk-flex uk-flex-center">
      <img class="uk-border-circle" src="http://baseapp.local/storage//images/avatars/group_0/01.png" style="width: 50px; height: 50px; object-fit: cover;">
    </div>
    <div class="uk-width-expand">
      <!--Main comment-->
      <div class="uk-card bg-secondary comment-item">
        <div class="uk-grid-collapse" uk-grid>
          <div class="uk-width-expand">
            <div>
              <p class="uk-margin-remove uk-text-bold" v-html="comment.commenter_name"></p>
            </div>
            <span uk-icon="icon: clock; ratio: 0.5"></span>
            <span class="uk-text-muted uk-text-meta" v-html="comment.creation_date"></span>
          </div>
          <div v-if="userId" class="uk-width-auto" style="padding: 0 14px">
            <div style="position: absolute; margin-top: -10px">
              <at-dropdown>
                <span uk-icon="icon: more; ratio: 0.7"></span>
                <at-dropdown-menu slot="menu">
                  <at-dropdown-item v-if="parseInt(userId) === parseInt(comment.commenter_user_id)">
                    <span @click="openEditForm(comment)">
                      <span class="icon-container uk-text-center"><span uk-icon="icon: pencil"></span></span><span v-html="$t('main.Edit')"></span>
                    </span>
                  </at-dropdown-item>
                  <at-dropdown-item v-if="parseInt(userId) !== parseInt(comment.commenter_user_id)">
                    <span @click="reportComment(comment)">
                      <span class="icon-container uk-text-center"><span uk-icon="icon: warning"></span></span><span v-html="$t('main.Report')"></span>
                    </span>
                  </at-dropdown-item>
                  <at-dropdown-item v-if="parseInt(userId) === parseInt(comment.commenter_user_id)">
                    <span @click="deleteComment(comment)">
                      <span class="icon-container uk-text-center"><span uk-icon="icon: trash"></span></span><span v-html="$t('main.Delete')"></span>
                    </span>
                  </at-dropdown-item>
                </at-dropdown-menu>
              </at-dropdown>
            </div>
          </div>
          <div class="uk-width-1-1">
            <div v-if="editableCommentId != comment.id" class="comment-text" v-html="comment.comment"></div>
            <textarea @change="updateComment(comment)" v-on:keyup.enter="updateComment(comment)" v-else class="uk-textarea editable-textarea" :placeholder="'Type your comment here'" v-model="comment.comment"></textarea>
            <div v-if="userId" class="uk-text-muted comment-actions">
              <span v-if="comment.postingMode == true">
                <span class="uk-text-primary">
                  <span uk-spinner="ratio: 0.4"></span>
                  <span style="margin: 0 5px">Posting ...</span>
                </span>
              </span>
              <span v-else>
                <span>
                <span class="uk-text-danger comment-action" @click="toggleCommentReaction(comment)">
                  <i v-if="comment.is_liked" class="fas fa-heart"></i>
                  <i v-else class="far fa-heart"></i>
                  <span v-html="comment.likes"></span>
                </span>
              </span>
                <span class="uk-margin-small-left uk-margin-small-right comment-action" @click="openReplyForm(comment)">
                <i class="far fa-comment-dots"></i>
                <span v-html="$t('main.Replay')"></span>
              </span>
              </span>
            </div>
          </div>
        </div>
      </div>
      <!--Replay to comment-->
      <div v-if="comment.replayMode == true" class="">
        <textarea class="uk-textarea comment-textarea" rows="4" :placeholder="'Type your comment here'" v-model="newComment"></textarea>
        <div class="uk-margin-small">
          <button class="uk-button uk-button-primary add-comment" @click="addComment({newCommentText:newComment, id:comment.id , parentId: parseInt(comment.parent_id) !== 0 ? comment.parent_id : comment.id })"><span v-html="$t('main.Comment')"></span></button>
        </div>
      </div>
      <!--sub comments-->
      <div v-if="comment.sub_comments && comment.sub_comments.length > 0">
        <div class="sub-comment" v-for="comment in comment.sub_comments">
          <comment
              :comment="comment"
              :editableCommentId="editableCommentId"
              ref="comment"
              :userId="userId"
              @openReplyForm="openReplyForm($event)"
              @addComment="addComment($event)"
              @openEditForm="openEditForm($event)"
              @updateComment="updateComment($event)"
              @deleteComment="deleteComment($event)"
              @toggleCommentReaction="toggleCommentReaction($event)"
              @reportComment="reportComment($event)"
          ></comment>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Comment from './Comment';

export default {
  name: "comment",
  props: [
    'comment',
    'editableCommentId',
    'userId',
  ],
  components:{
    Comment,
  },
  data(){
    return {
      newComment: '',
    }
  },
  methods:{
    openReplyForm(comment){
      this.$emit('openReplyForm', comment);
    },
    addComment(data){
      this.$emit('addComment', data);
      this.newComment = '';
    },
    openEditForm(comment){
      this.$emit('openEditForm', comment);
    },
    updateComment(comment){
      this.$emit('updateComment', comment);
    },
    deleteComment(comment){
      this.$emit('deleteComment', comment);
    },
    toggleCommentReaction(comment){
      this.$emit('toggleCommentReaction', comment);
    },
    reportComment(comment){
      this.$emit('reportComment', comment);
    },
  }

}
</script>

<style scoped>
.comment-item{
  padding: 10px !important;
  margin-bottom: 10px;
}
.comment-text{
  padding: 5px 0px;
}
.comment-actions{
  font-size: 12px;
}
.comment-action:hover{
  cursor: pointer;
}
.comment-textarea{
  border-radius: 5px;
  height: 50px;
  padding: 5px 10px;
}
.icon-container{
  display: inline-flex;
  width: 25px;
}
.editable-textarea{
  background-color: transparent;
  border-radius: 5px;
}

</style>