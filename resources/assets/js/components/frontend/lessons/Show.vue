<template>
  <div>
    <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-small uk-padding-small" style="overflow: hidden">
      <h5 class="text-highlighted uk-text-bold">Memorize</h5>
<!--      <p>{{ $t('main.Dear', {name: 'visitor'}) }}</p>-->
      <p class="_memorize dear student">{{ $t('main._memorize dear student', {name: 'student'}) }}</p>
      <div>
        <ul class="uk-list uk-list-decimal">
          <li v-for="(item, key) in items" v-if="item.properties.level == 1">{{itemCount=+1}}- {{item.title}}</li>
        </ul>
      </div>
      <div class="uk-child-width-expand@s uk-text-center uk-margin-remove" uk-grid>
        <div>
          <a class="uk-button uk-button-primary open-" href="#modal-sections" uk-toggle>Start the memorize test</a>
          <div id="modal-sections" uk-modal>
            <div class="uk-modal-dialog uk-margin-auto-vertical">
              <div class="uk-modal-header">
                <h2 class="uk-modal-title">Modal Title</h2>
              </div>
              <div class="uk-modal-body">


              </div>
<!--              <div class="uk-modal-footer uk-text-right">-->
<!--                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>-->
<!--                <button class="uk-button uk-button-primary" type="button">Save</button>-->
<!--              </div>-->
            </div>
          </div>
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
  ],
  data(){
    return{
      name: 'mehmet',
      items: [],
      itemCount:0,

    }
  },
  created() {
    this.fetchItems();
  },
  methods:{
    fetchItems(){
      // fetch('/api/memorize')
      // // .then(res => res.json())
      // .then(res => {
      //   console.log(res);
      // });
      axios.get('/api/product/lesson/'+this.lessonSlug+'/memorize/items', {
        params: {
          id: 12345
        }
      }).then(res => {
        console.log(res.data);
        this.items = res.data;
      });
    }
  },
  components: {
    memorize
  },
}
</script>

<style scoped>

</style>