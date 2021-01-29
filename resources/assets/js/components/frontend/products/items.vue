<template>
    <div>
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
                <button @click="addToCart(product)" v-else class="uk-button uk-button-primary uk-width-1-1 cart-action" :class="{'in_cart':product.in_cart}">
                  <span v-if="inAddingProductId == product.id">
                    <span uk-spinner="ratio: 0.5"></span> <span v-html="$t('main.Adding')"></span>
                  </span>
                  <span v-else>
                    <span v-if="!product.in_cart">
                      <span uk-icon="icon: cart" style="margin: 0 3px"></span> <span v-html="$t('main.Add to cart')"></span>
                    </span>
                    <span v-else>
                      <span uk-icon="icon: check" style="margin: 0 3px"></span> <span v-html="$t('main.Added to cart')"></span>
                    </span>
                  </span>
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
                <div class="uk-margin-small">
                  <p>{{$t('main.Loading')}}</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import Vue from "vue";

const messages = {
  en: {
    message: {
      added_successfully: 'Added successfully',
      the_product_added: 'The product has been added to your shopping cart successfully.',
      already_in_cart: 'Am error accrued!',
      product_already_in_cart: 'This product was already added to your shopping cart',
    }
  },
  ar: {
    message: {
      added_successfully: 'تمت الإضافة بنجاح',
      the_product_added: 'لقد تمت إضافة المنتج الى سلة التسوق الخاصة بك بنجاح.',
      already_in_cart: 'لقد تم اضافة المنتج سابقاً',
      product_already_in_cart: 'هذا المنتج قد تمت اضافته مسبقاً لسلة التسوق الخاصة بك.',
    }
  }
}

export default {
  name: "items",
  props: [
    'search',
    'categoryId',
    'minPrice',
    'maxPrice',
    'perPage',
  ],
  data(){
    return{
      products: [],
      loadingMode:true,
      lang:null,
      productToCart:null,
      inAddingProductId:null,
    }
  },
  created() {
    this.lang = document.documentElement.lang.substr(0, 2);
    this.fetchItems();
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
        $('.full-screen-spinner').fadeOut();
        this.loadingMode = false,
        this.products = res.data.data;
        this.links = res.data.links;
        this.meta = res.data.meta;
        this.$emit('updateMiniLoadingMode', false);
      });
    },
    addToCart(product){
      if (this.inAddingProductId == null && product.in_cart == false) {
        this.inAddingProductId = product.id;
        const data = {
          id:product.id,
          name:product.name,
          qty:1,
          price:product.price,
          image:product.primary_image,
          sku:product.sku,
        };
        axios.post('/cart/add', data)
            .then(res => {
              product.in_cart = true;
              // this.$Notify({
              //   title: messages[this.lang].message.added_successfully,
              //   message: messages[this.lang].message.the_product_added,
              //   type: 'success',
              //   duration: 4000
              // });
              UIkit.notification("<span uk-icon='icon: check'></span> "+messages[this.lang].message.added_successfully, {pos: 'top-center', status:'success'})

              this.inAddingProductId = null;
              $('.navbar-cart-count').html(res.data.item_count);
            })
            .catch(error => {
              // console.log(error);
              // this.hideLoading();
              // this.$Notify({
              //   title: 'Oops! something going wrong',
              //   message: 'Please contact us for more information',
              //   type: 'error',
              //   duration: 4000
              // });
              UIkit.notification("<span uk-icon='icon: ban'></span> Oops! something going wrong", {pos: 'top-center', status:'danger'})

            });
      }else {
        // this.$Notify({
        //   title: messages[this.lang].message.already_in_cart,
        //   message: messages[this.lang].message.product_already_in_cart,
        //   type: 'warning',
        //   duration: 4000
        // });
        UIkit.notification("<span uk-icon='icon: warning'></span> "+messages[this.lang].message.already_in_cart, {pos: 'top-center', status:'warning'})

      }

    },
  },
}
</script>

<style scoped>
.no-products-box{
  opacity: 0.2;
}
a{
  color: #3F536E;
}
a:hover{
  color: var(--theme-primary-color);
}
a.uk-button, a.uk-button:hover{
  color: white;
}
</style>