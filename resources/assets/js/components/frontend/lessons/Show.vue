<template>
  <div>
    <memorize v-bind:lesson-slug="lessonSlug"></memorize>


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
  ],
  data(){
    return{
      name: 'mehmet',
    }
  },
  components: {
    memorize
  },
}
</script>

