<template>
  <div>
    <div class="uk-grid-small uk-child-width-1-1" uk-grid>
      <div>
        <memorize v-bind:lesson-slug="lessonSlug" @updateViewContent="updateViewContentStatus($event)"></memorize>
      </div>
      <div v-if="description">
        <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-small uk-padding-small uk-margin-small">
          <h5 class="text-highlighted uk-text-bold" v-html="$t('main.Lesson description')"></h5>
          <div v-html="description"></div>
        </div>
      </div>
      <div v-if="viewContentStatus">
        <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
          <ul id="pb-content" class="pb-content-list-items uk-grid-collapse uk-child-width-1-1" uk-grid v-html="content">
          </ul>
        </div>
      </div>
      <div v-if="viewContentStatus" v-for="resource in resources">
        <div class="uk-card uk-card-default uk-card-body uk-padding-remove" style="overflow: hidden">
          <div v-if="resource.type == 10">
            <video :src="resource.url" playsinline controls disablepictureinpicture controlsList="nodownload"></video>
          </div>
          <div v-else-if="resource.type == 20">
            <iframe :src="resource.url" class="uk-responsive-width" width="1920" height="1080" controls controlsList="nodownload" frameborder="0" uk-responsive></iframe>
          </div>
        </div>
      </div>
      <div v-if="forms && forms.length > 0">
        <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-small uk-padding-small uk-margin-small">
          <h5 class="text-highlighted uk-text-bold" v-html="$t('main.Lesson quizzes')"></h5>
          <table class="uk-table uk-table-divider">
            <thead>
            <tr>
              <th class="uk-text-center" v-html="$t('main.Quiz name')"></th>
              <th class="uk-text-center" v-html="$t('main.Items num')"></th>
              <th class="uk-text-center" v-html="$t('main.Quiz period')"></th>
              <th class="uk-text-center" v-html="$t('main.Availability')"></th>
              <th class="uk-text-center" v-html="$t('main.Results')" v-if="viewContentStatus"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="form in forms">
              <td>
                <p class="uk-margin-remove text-highlighted" v-html="form.title"></p>
                <p class="uk-margin-remove" v-html="form.description"></p>
              </td>
              <td class="uk-text-center" v-html="form.items_count"></td>
              <td class="uk-text-center">
                <span v-if="form.has_time_limit == 1" class="uk-text-warning">{{form.has_time_limit}} {{form.time_limit}} </span>
                <span v-else class="uk-text-primary" v-html="$t('main.Unlimited time')"></span>
              </td>
              <td class="uk-text-center">
                <div v-if="form.evaluation_status == 1">
                    <p class="uk-margin-remove"><i class="far fa-check-circle uk-text-success"></i> <span v-html="form.evaluation_mark"></span></p>
                    <a :href="form.response_link" v-html="$t('main.View results')"></a>
                </div>
                <div v-else>
                  <p class="uk-text-muted" v-html="$t('main.No results')"></p>
                </div>
              </td>
              <td class="uk-text-center" v-if="viewContentStatus">
                <a class="uk-button uk-button-primary" :href="form.form_url" v-html="$t('main.Take the exam')"></a>
              </td>

            </tr>
            </tbody>
          </table>
        </div>
      </div>

    </div>
  </div>
</template>

<script>
import memorize from './Memorize.vue'

export default {
name: "Show",
  // props: [
  //   'lesson_slug'
  // ],
  props: {
    lessonSlug: {type:String},
  },
  data(){
    return{
      name: 'mehmet',
      viewContentStatus: false,
      item: null,
      content: null,
      description: null,
      resources: null,
      forms: null,
    }
  },
  created() {
    this.fetchItem();
  },
  methods:{
    fetchItem(){
      axios.get('/api/product/lesson/'+this.lessonSlug+'/items', {
        params: {
          // id: 12345
        }
      }).then(res => {
        this.item = res.data;
        this.content = this.item.content;
        this.description = this.item.description;
        this.resources = this.item.resources;
        this.forms = this.item.forms;
        console.log(this.item);
      });
    },
    updateViewContentStatus(status){
      this.viewContentStatus = status;
    }
  },
  components: {
    memorize
  },
}
</script>

