<template>
  <div>
    <div class="uk-grid-small uk-child-width-1-1" uk-grid>
      <div>
        <memorize v-bind:lesson-slug="lessonSlug" @updateViewContent="updateViewContentStatus($event)"></memorize>
      </div>
      <div v-if="viewContentStatus">
        <div class="uk-card uk-card-default uk-card-body uk-padding-remove">
          <ul id="pb-content" class="pb-content-list-items uk-grid-collapse uk-child-width-1-1" uk-grid v-html="content">
          </ul>
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
  props: [
      'postTitle',
      'lessonSlug',
      'content',
  ],
  data(){
    return{
      name: 'mehmet',
      viewContentStatus: false,
    }
  },
  methods:{
    updateViewContentStatus(status){
      this.viewContentStatus = status;
    }
  },
  components: {
    memorize
  },
}
</script>

