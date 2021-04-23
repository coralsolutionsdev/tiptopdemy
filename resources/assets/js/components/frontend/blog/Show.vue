<template>
  <div>
    <div class="uk-grid-small uk-child-width-1-1" uk-grid>
      <div>
        <div class="uk-card uk-card-default uk-card-body uk-padding-remove" style="overflow: hidden">
          <div class="uk-card-body post-content uk-padding-small">
            <h3 v-html="post.title"></h3>
            <div class="uk-grid-column-small uk-grid-row-large" uk-grid>
              <div class="uk-width-expand">
                <ul class="uk-iconnav uk-text-muted uk-flex uk-flex-middle">
                  <li class="uk-flex uk-flex-middle"><span  uk-icon="icon: user; ratio: 0.8"></span><span style="margin: 0 2px" v-html="post.user_name"></span></li>
                  <li class="uk-flex uk-flex-middle"><span  uk-icon="icon: calendar; ratio: 0.8"></span><span style="margin: 0 2px" v-html="post.created_at"></span></li>
                  <li v-if="post.categories" class="uk-flex uk-flex-middle"><span style="margin: 0 2px"  uk-icon="icon: folder; ratio: 0.8"></span>
                    <span v-for="category in post.categories">
                      <span v-html="category.name"></span>
                    </span>
                  </li>
                </ul>
              </div>
              <div class="uk-width-auto">
                <ul class="uk-iconnav uk-text-muted uk-flex uk-flex-middle">
                  <li v-if="userId" class="uk-flex uk-flex-middle">
                    <a @click="reactPost()" class="uk-button uk-button-default post-reaction uk-text-danger" style="font-size: 14px">
                      <span class="post-reaction-icon" :class="post.is_liked ? 'fas fa-heart' : 'far fa-heart'"></span>
                      <span class="post-reaction-count" v-html="post.likes"></span>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
            <div class="uk-margin-small">
              <p v-html="post.content"></p>
            </div>
          </div>
        </div>
      </div>
      <div v-if="post.attachments && post.attachments.length > 0">
        <div class="uk-card uk-card-default uk-card-body uk-padding-small">
          <h5 class="text-highlighted uk-text-bold" v-html="$t('main.Attachments')"> (<span class="comment-count" v-html="post.attachments.length"></span>)</h5>
          <table class="uk-table uk-table-divider">
            <thead>
            <tr>
              <th class="uk-width-small" v-html="$t('main.File name')"></th>
              <th class="uk-table-expand" v-html="$t('main.File Type')"></th>
              <th class="uk-width-small" v-html="$t('main.Download link')"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="attachment in post.attachments">
              <td v-html="attachment.title"></td>
              <td v-html="attachment.type"></td>
              <td><a target="_blank" class="uk-button uk-button-default uk-text-primary" :href="attachment.download_url"><span uk-icon="icon: cloud-download"></span> <span v-html="$t('main.Download')"></span></a></td>
            </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div>
        <comments
            :commentable-id="commentableId"
            :slug="slug"
            :class-name="className"
            :user-id="userId"
            :user-name="userName"
            :user-profile-pic="userProfilePic"
        ></comments>
      </div>
    </div>
  </div>

</template>

<script>
import helperMixin from '../../../mixins/helpers';

export default {
  name: "Show",
  mixins: [helperMixin],
  props: [
    'slug',
    'commentableId',
    'className',
    'userId',
    'userName',
    'userProfilePic',
  ],
  data(){
    return{
      post: [],
      postUrl:'',
    }
  },
  created(){
    this.fetchItem();
  },
  methods:{
    fetchItem(){
      axios.get('/blog/post/'+this.slug+'/get/post', {
        params: {
        }
      }).then(res => {
        this.post = res.data;
        this.postUrl = this.post.post_url;
      });
    },
    reactPost(){
      if(this.post.is_liked === false){
        this.post.likes++;
      } else {
        if (parseInt(this.post.likes ) !== 0){
          this.post.likes--;
        }
      }
      this.post.is_liked = !this.post.is_liked ;
      axios.post('/blog/post/'+this.slug+'/react/like/toggle', {})
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
  }
}
</script>

<style scoped>

</style>