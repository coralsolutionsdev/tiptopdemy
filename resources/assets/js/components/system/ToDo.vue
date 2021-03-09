<template>
  <div>
    <div class="uk-card uk-card-default uk-card-body uk-padding-small">
      <h4>To do list</h4>
      <div class="uk-margin-small">
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-expand"><input v-model="newItemTitle" class="uk-input" type="text" placeholder="Add your to do statement"></div>
          <div class="uk-width-auto">
            <button class="uk-button uk-button-primary uk-width-1-1" @click="addNewItem()">Add</button>
          </div>
        </div>
      </div>
      <div class="">
        <table class="uk-table uk-table-divider uk-table-middle">
          <thead>
          <tr>
            <th class="uk-table-shrink">Status</th>
            <th>To do statement</th>
            <th class="uk-table-shrink">Delete</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="(item, key) in items">
            <td>
              <label><input class="uk-checkbox" type="checkbox" @click="updateStatus(item)" :checked="item.completed"></label>
            </td>
            <td>
              <span v-html="item.title" :class="{ 'completed':item.completed }"></span>
            </td>
            <td>
              <span @click="deleteItemKey(item.id)" class="uk-button uk-button-small uk-action-btn uk-button-default ck-button-danger btn-delete" :uk-tooltip="$t('main.delete')"><span uk-icon="icon: trash"></span></span>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</template>

<script>
import 'vuesax/dist/vuesax.css' //Vuesax styles

export default {
name: "ToDo",
  data(){
    return{
    active:0,
    option1:true,
    newItemTitle:'',
    currentItem:null,
    items: [],
  }
  },
  created() {
    this.fetchItems();
  },
  methods:{
    fetchItems(){
      axios.get('/system/todo', {
        params: {
          // group: this.groupSlug,
        }
      })
      .then(res => {
        console.log(res.data.data);
        this.items = res.data.data;
      })
      .catch(error => {
        console.log(error);
        this.hideLoading();
      });
    },
    addNewItem(){
      const data = {  title: this.newItemTitle };
      axios.post('/system/todo', data)
          .then(res => {
            var createdItem = res.data;
            console.log(createdItem);
            var newItem = {
              id:createdItem.id,
              title: createdItem.title,
              status: false,
            };
            this.items.unshift(newItem);
            this.newItemTitle = '';

          })
          .catch(error => {
            console.log(error);
          });
      //



    },
    updateStatus(item){
      item.completed = !item.completed;
      var status = 0;
      if (item.completed === true){
        status = 1;
      }
      this.updateItem(item.id, null, status);
    },
    updateItem(id, title, status){
      const data = {  title: this.newItemTitle, status:status };
      axios.put('/system/todo/'+id, data)
          .then(res => {
          })
          .catch(error => {
            console.log(error);
          });
    },
    deleteItemKey(id){
      var arrayKey = 0
      $.each(this.items, function (index, item){
        if (item.id == id){
          arrayKey = index;
        }
      });

      this.items.splice(arrayKey, 1);
      const data = {  id: id };
      axios.delete('/system/todo/'+id, { data: data }).then(

      )
    },

  },
}
</script>

<style scoped>
.completed{
  text-decoration: line-through;
}
</style>