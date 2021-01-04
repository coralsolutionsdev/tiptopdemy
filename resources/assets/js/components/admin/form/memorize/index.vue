<template>
  <div class="bg-white uk-padding-small">
    <table class="uk-table uk-table-middle uk-table-divider">
      <thead>
      <tr>
        <th class="uk-width-small">Memorize</th>
        <th>Answers Count</th>
        <th class="uk-text-right"></th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="item in items">
        <td>{{ item.title }}</td>
        <td>{{ item.option_count }}</td>
        <td class="uk-text-right">
          <a v-bind:href="item.edit_link">
            <span class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-primary"><span uk-icon="icon: pencil"></span></span>
          </a>
          <span @click="deleteItem()" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-danger"><span uk-icon="icon: trash"></span></span>
        </td>
      </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "index",
  data(){
    return {
      items: [],
    }
  },
  created() {
    this.fetchItems();
  },
  methods: {
    fetchItems(){
      fetch('/api/memorize')
      .then(res => res.json())
      .then(res => {
        console.log(res.data);
        this.items = res.data;
      })
    },
    deleteItem(){
      UIkit.modal.confirm('<h3 class="uk-text-warning uk-margin-remove">Alert!</h3>Are you sure that you want to delete this media item?').then(function() {
        alert('confirmed')
      }, function () {
        console.log('Rejected.')
      });
    }
  }
}
</script>

<style scoped>

</style>