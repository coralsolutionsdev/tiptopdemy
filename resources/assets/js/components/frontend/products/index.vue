<template>
  <div>
    <div class="uk-grid-small uk-child-width-1-1" uk-grid>
      <div class="uk-visible@m">
        <div class="filter-section uk-card uk-card-default uk-card-body" style="padding: 25px">
            <div class="uk-grid-small" uk-grid>
              <div class="input-group uk-width-expand">
                <div class="item-title">
                  <span class="title" v-html="$t('main.Search in store')"></span>
                </div>
                <input @keyup.enter="filterItem()" class="uk-input" name="search" type="text" placeholder="" v-model="search">
              </div>
              <div class="uk-width-auto">
                <span @click="filterItem()" class="uk-button uk-button-primary" style="width: 55px;padding:0px 15px">
                  <span v-if="minLoadingMode" uk-spinner="ratio: 0.5"></span>
                  <span v-else><span uk-icon="icon: search"></span></span>
                </span>
              </div>

              <div class="input-group uk-width-expand">
                <div class="item-title">
                  <span class="title" v-html="$t('main.Filter by Category')"></span>
                </div>
                <select name="category" class="uk-select" v-model="categoryId">
                  <option value="0">أختر التصنيف</option>
                  <option v-for="category in categories" :value="category.id" v-html="category.name"></option>
                </select>
              </div>
              <div class="input-group uk-width-expand">
                <div class="item-title">
                  <span class="title" v-html="$t('main.Sort by')"></span>
                </div>
                <select name="sort" class="uk-select">
                  <option v-html="$t('main.Default Sort')"></option>
                  <option v-html="$t('main.Sort by name')"></option>
<!--                  <option v-html="$t('main.Sort by position')"></option>-->
                  <option v-html="$t('main.Price low to high')"></option>
                  <option v-html="$t('main.Price high to low')"></option>
                </select>
              </div>
              <div class="input-group uk-width-expand">
                <div class="item-title">
                  <span class="title" v-html="$t('main.Number of displayed products')"></span>
                </div>
                <select name="per_page" class="uk-select" v-model="perPage">
                  <option :value="10">10</option>
                  <option :value="15">15</option>
                  <option :value="20">20</option>
                  <option :value="50">50</option>
                </select>
              </div>
              <div class="uk-width-auto">
                <span @click="filterItem()" class="uk-button uk-button-primary" style="min-width: 155px;padding:0px 25px">
                  <span v-html="$t('main.Apply Filter')"></span>
                  <span v-if="minLoadingMode" uk-spinner="ratio: 0.5"></span>
                </span>
              </div>
            </div>
        </div>
      </div>
      <div>
        <div class="uk-grid-small" uk-grid>
          <div class="uk-width-1-4 uk-visible@m">
            <div class="grid-side uk-card uk-card-default uk-card-body" style="padding: 10px">

              <!--Categories-->
              <div class="uk-margin-small" style="padding: 20px; border-bottom: 1px solid #e5e5e5">
                <h5 class="text-highlighted" v-html="$t('main._categories')" style="padding: 0px; font-weight: 700" ></h5>
                <div class="uk-margin-small">
                  <ul class="uk-list uk-list-divider">
                    <li v-for="category in categories" style="padding: 5px 5px 0px 5px"><span><a :href="category.link">{{category.name}}</a></span><span :class="lang == 'ar' ? 'uk-align-left' : 'uk-align-right'" class=""><span class="uk-badge uk-badge-mini uk-badge-success" v-html="category.items_count"></span></span></li>
                  </ul>
                </div>
              </div>
              <div class="uk-margin-small" style="padding: 20px; border-bottom: 1px solid #e5e5e5">
                  <h5 class="text-highlighted" v-html="$t('main.Price range')" style="padding: 0px; font-weight: 700"></h5>
                  <div class="uk-margin-small uk-grid-small uk-child-width-1-2" uk-grid>
                    <div class="input-group">
                      <div class="item-title">
                        <span class="title" v-html="$t('main.From')"></span>
                      </div>
                      <input class="uk-input" name="min" type="text" placeholder="$" min="0" v-model="minPrice">
                    </div>
                    <div class="input-group">
                      <div class="item-title">
                        <span class="title" v-html="$t('main.To')"></span>
                      </div>
                      <input class="uk-input" name="max" type="text" placeholder="$" v-model="maxPrice">
                    </div>
                  </div>
                  <div style="padding-top: 5px">
                    <span @click="filterItem()" class="uk-button uk-button-primary uk-width-1-1 uk-margin-small-bottom">
                      <span v-html="$t('main.Filter prices')"></span>
                      <span v-if="minLoadingMode" uk-spinner="ratio: 0.5"></span>
                    </span>
                  </div>
              </div>
              <!--Tags-->
              <div class="uuk-margin-small" style="padding: 20px">
                <h5 class="text-highlighted" v-html="$t('main._tags')" style="padding: 0px; font-weight: 700"></h5>
                <div class="uk-margin-small">
                  <div class="blog-tags">
<!--                    @foreach($tags as $tag)-->
                    <a v-for="tag in tags" class="tag-item uk-button uk-button-default uk-background-default" href="#" v-html="printTagName(tag.name)"></a>
<!--                    @endforeach-->
                  </div>
                </div>
              </div>

            </div>
          </div>
          <div class="uk-width-expand">
            <product-items
                ref="productItems"
                :search="search"
                :categoryId="categoryId"
                :minPrice="minPrice"
                :maxPrice="maxPrice"
                :perPage="perPage"
                @updateMiniLoadingMode="updateLoadingMode($event)"
            ></product-items>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
name: "index",
  props: [
    'categoryId',
  ],
  data(){
    return{
      products: [],
      loadingMode:true,
      minLoadingMode:false,
      links:null,
      meta:null,
      categories:[],
      tags:[],
      lang:null,
      search:null,
      minPrice:null,
      maxPrice:null,
      floatEnd:null,
      perPage:10,
      active:0,
      productToCart:null,
      inAddingProductId:null,
    }
  },
  beforeCreate() {
  },
  created() {
    this.lang = document.documentElement.lang.substr(0, 2);
    this.fetchStoreInfo();
  },
  methods:{
    fetchStoreInfo(){
      axios.get('/store/sidebar/info', {
        params: {
          // id: 12345
        }
      }).then(res => {
        this.categories = res.data.categories;
        this.tags = res.data.tags;
      });
    },
    printTagName(tagArray){
      if (this.lang == 'ar'){
        if (tagArray['ar'] && tagArray['ar'].length > 0){
          return tagArray['ar'];
        } else if (tagArray['en'] && tagArray['en'].length > 0){
          return tagArray['en'];
        }
      }else {
        if (tagArray['en'] && tagArray['en'].length > 0){
          return tagArray['en'];
        } else if (tagArray['ar'] && tagArray['ar'].length > 0){
          return tagArray['ar'];
        }
      }
      return '';

    },
    filterItem(){
      this.minLoadingMode = true;
      this.$refs.productItems.fetchItems();
    },
    updateLoadingMode(status){
      this.minLoadingMode = status;

    }
  },
}
</script>

<style scoped>
  .no-products-box{
    opacity: 0.2;
  }
  a:hover{
    color: var(--theme-primary-color);
  }
  a.uk-button, a.uk-button:hover{
    color: white;
  }
  a, a.tag-item, a.tag-item:hover{
    color: #3F536E;
  }
</style>