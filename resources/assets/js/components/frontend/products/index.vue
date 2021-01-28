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
        <div class="uk-grid-small" uk-grid uk-height-match="target: > div > .grid-side">
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
                    <a v-for="tag in tags" class="uk-button uk-button-default uk-background-default" href="#" v-html="printTagName(tag.name)"></a>
<!--                    @endforeach-->
                  </div>
                </div>
              </div>



            </div>
          </div>
          <div class="uk-width-expand">
            <div v-if="products.length > 0" class="grid-side uk-grid-small uk-child-width-1-3@m" uk-grid="masonry: true">
              <div v-for="product in products">
                <div :id="product.id" class="product uk-card uk-card-default uk-card-body uk-padding-remove uk-box-shadow-hover-large" style="overflow: hidden">
                  <a :href="product.link">
                    <div style="max-height: 200px; overflow: hidden">
                      <div class="uk-text-center">
                        <div class="uk-inline-clip uk-transition-toggle" tabindex="0">
                          <img class="product-primary-image" :data-src="product.primary_image" sizes="(min-width: 500px) 500px, 100vw" width="500" alt="" uk-img>
                          <img class="uk-transition-scale-up uk-position-cover" :src="product.alternative_image" alt="">
                        </div>
                      </div>
                    </div>
                  </a>
                  <div style="padding:20px 15px">
                    <a :href="product.link">
                      <div class="uk-grid-collapse uk-text-center" style="position: absolute; width: 90%; margin-top: -50px;" uk-grid>
                        <div class="uk-width-expand">
                        </div>
                        <div class="uk-width-auto">
                          <div class="uk-card uk-card-body bg-white" style="padding:3px 10px; color: black; font-weight: 700; font-size: 24px; border-radius: 10px 10px 0 0">
                            <span class="uk-text-primary">$</span> <span class="product-price" v-html="product.price"></span>
                          </div>
                        </div>
                      </div>
                      <div style="font-weight: 700; color: black" class="product-name" v-html="product.name"></div>
                      <div style="" class="product-sku" v-html="product.sku"></div>
                      <div style="height: 50px" v-html="product.sub_description"></div>
                      <div style="margin-bottom: 10px">
                        <span><img class="uk-border-circle" :src="product.user_profile_pic" style="width: 20px; height: 20px; object-fit: cover"></span> <span v-html="$t('main.By')+': '+product.user_name"></span>
                      </div>
                    </a>
                    <div>
                      <a v-if="product.has_purchased" class="uk-button uk-button-primary uk-width-1-1" :href="product.link"><span uk-icon="icon:  play-circle" style="margin: 0 3px"></span> <span v-html="$t('main.View lesson')"></span></a>
                      <button v-else class="uk-button uk-button-primary uk-width-1-1 cart-action" :class="{'in_cart':product.in_cart}">
                        <span @click="addToCart(product)" v-if="!product.in_cart"><span uk-icon="icon: cart" style="margin: 0 3px"></span> <span v-html="$t('main.Add to cart')"></span></span>
                        <span v-else><span uk-icon="icon: check" style="margin: 0 3px"></span> <span v-html="$t('main.Added to cart')"></span></span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div v-else class="uk-text-center" >
              <div>
                <div class="uk-card uk-card-default uk-card-body">
                  <div v-if="!loadingMode">
                    <div>
                      <img class="no-products-box" data-src="/storage/assets/box.png" width="80" alt="" uk-img>
                    </div>
                    <p class="uk-margin-small" v-html="$t('main.There is no products yet')"></p>
                  </div>
                  <div v-else>
                    <div class="uk-text-primary">
                      <span uk-spinner="ratio: 2.5"></span>
                      <div class="uk-margin-small">
                        <p>{{$t('main.Loading')}}</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
name: "index",
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
      categoryId:0,
      minPrice:null,
      maxPrice:null,
      floatEnd:null,
      perPage:10,
      active:0,
    }
  },
  created() {
    this.lang = document.documentElement.lang.substr(0, 2);
    this.fetchItems();
    this.fetchStoreInfo();
  },
  methods:{
    fetchItems(){
      axios.get('/store/products/items', {
        params: {
          search: this.search,
          category: this.categoryId,
          min: this.minPrice,
          max: this.maxPrice,
          per_page: this.perPage,
        }
      }).then(res => {
        this.loadingMode = false,
        this.minLoadingMode = false,
        this.products = res.data.data;
        this.links = res.data.links;
        this.meta = res.data.meta;
      });
    },
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
      this.minLoadingMode = true,
      this.fetchItems();
    },
    addToCart(product){
      this.$Notify({
        title: 'Function under development',
        message: 'Dear user adding items to shopping cart is still under developments please try again later.',
        type: 'warning',
        duration: 0
      });

    }
  },
}
</script>

<style scoped>
  .no-products-box{
    opacity: 0.2;
  }
</style>