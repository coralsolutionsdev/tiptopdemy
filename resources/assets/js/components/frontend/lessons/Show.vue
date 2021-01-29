<template>
  <div>

    <div class="uk-grid-small" uk-grid>
      <div class="uk-width-1-4 uk-visible@m">
        <div v-if="(groups && groups.length != 0) || !product.has_purchased" class="uk-card uk-card-default uk-card-body uk-padding-remove">
          <div v-if="product && !product.has_purchased">
            <div class="uk-padding-small">
              <div class="price uk-heading-small uk-margin-remove"><span class="uk-text-primary">$</span><span v-html="product.price"></span></div>

              <div class="uk-margin-small">
                <h5 class="uk-text-primary uk-margin-small" v-html="$t('main.This course includes')"></h5>
                <ul class="uk-list">
                  <li><span uk-icon="icon: unlock"></span> <span v-html="$t('main.Full lifetime access')"></span></li>
                  <li><span uk-icon="icon: bookmark"></span> <span v-html="$t('main.Certificate of Completion')"></span></li>
                </ul>
              </div>

              <div>
                <button @click="addToCart(product)" class="uk-button uk-button-primary uk-width-1-1">
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
            <hr>
          </div>
          <div class="uk-padding-small">
            <ul uk-accordion="multiple: true">
              <li v-for="(group, key) in groups" :class=" { 'uk-open':lessonGroupId == group.id}" style="margin:0px 0px 10px 0px">
                <a class="uk-accordion-title text-highlighted uk-secondary-bg" style="padding: 10px 20px" href="#">{{key}} | {{group.title}}</a>
                <div class="uk-accordion-content">
                  <a v-if="lesson.link" v-for="(lesson, lessonKey) in group.items" :href="lesson.link">
                    <div class="uk-secondary-bg-hover">
                      <div style="padding: 5px">
                        <div class="uk-grid-small" uk-grid>
                          <div  class="uk-width-auto@s uk-text-center uk-flex uk-flex-middle">
                            <span v-if="lesson.id == lessonId" class="uk-icon-box uk-text-primary" style="height: 40px; width:40px;" uk-icon="icon: play-circle"></span>
                            <span v-else class="uk-icon-box" style="height: 40px; width:40px;" v-html="lessonKey"></span>
                          </div>
                          <div class="uk-width-expand@s uk-flex uk-flex-middle">
                            <div>
                              <p :class="{'uk-text-primary': lesson.id == lessonId}" style="padding: 0px; margin: 0px" v-html="lesson.title"></p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </a>
                  <div v-else class="uk-secondary-bg-hover please-purchase" @click="pleasePurchase()">
                    <div style="padding: 5px">
                      <div class="uk-grid-small" uk-grid>
                        <div  class="uk-width-auto@s uk-text-center uk-flex uk-flex-middle">
                          <span v-if="lesson.id == lessonId" class="uk-icon-box uk-text-primary" style="height: 40px; width:40px;" uk-icon="icon: play-circle"></span>
                          <span v-else class="uk-icon-box" style="height: 40px; width:40px;" v-html="lessonKey"></span>
                        </div>
                        <div class="uk-width-expand@s uk-flex uk-flex-middle">
                          <div>
                            <p :class="{'uk-text-primary': lesson.id == lessonId}" style="padding: 0px; margin: 0px" v-html="lesson.title"></p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </li>

            </ul>
          </div>
        </div>
      </div>
      <div class="uk-width-expand">
        <div class="uk-grid-small uk-child-width-1-1@m" uk-grid="masonry: true">
          <div class="uk-grid-small uk-child-width-1-1" uk-grid>
            <!-- Memorizes-->
            <div>
              <memorize v-bind:lesson-slug="lessonSlug" @updateViewContent="updateViewContentStatus($event)"></memorize>
            </div>
            <!-- Descriptions-->
            <div v-if="description">
              <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-small uk-padding-small uk-margin-small" style="overflow: hidden">
                <h5 class="text-highlighted uk-text-bold" v-html="$t('main.Lesson description')"></h5>
                <div v-html="description"></div>
              </div>
            </div>
            <!-- Content-->
            <div v-if="viewContentStatus">
              <div class="uk-card uk-card-default uk-card-body uk-padding-remove" style="overflow: hidden">
                <ul id="pb-content" class="pb-content-list-items uk-grid-collapse uk-child-width-1-1" uk-grid v-html="content">
                </ul>
              </div>
            </div>
            <!-- Sources-->
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
            <!-- Forms-->
            <div v-if="forms && forms.length > 0">
              <div  class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-small uk-padding-small uk-margin-small">
                <h5 class="text-highlighted uk-text-bold" v-html="$t('main.Lesson quizzes')"></h5>
                <div class="overflow-auto">
                  <table class="uk-table uk-table-divider">
                    <thead>
                    <tr>
                      <th class="uk-text-center uk-width-2-5" v-html="$t('main.Quiz name')"></th>
                      <th class="uk-text-center" v-html="$t('main.Items num')"></th>
                      <th class="uk-text-center" v-html="$t('main.Quiz period')"></th>
                      <th class="uk-text-center" v-html="$t('main.Availability')"></th>
                      <th class="uk-text-center" v-html="$t('main.Results')" v-if="viewContentStatus"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="form in forms">
                      <td class="uk-width-2-5">
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
            <!-- Attachments-->
            <div v-if="attachments && attachments.length > 0">
              <div class="uk-card uk-card-default uk-card-body uk-box-shadow-hover-small uk-padding-small uk-margin-small">
                <h5 class="text-highlighted uk-text-bold" v-html="$t('main.Attachments')"> (<span class="comment-count" v-html="attachments.length"></span>)</h5>
                <table class="uk-table uk-table-divider">
                  <thead>
                  <tr>
                    <th class="uk-text-center " v-html="$t('main.File name')"></th>
                    <th class="uk-text-center uk-table-expand" v-html="$t('main.File Type')"></th>
                    <th class="uk-text-center uk-width-small" v-html="$t('main.Download link')"> </th>
                  </tr>
                  </thead>
                  <tbody>
                  <tr v-for="attachment in attachments">
                    <td class="uk-width-auto" v-html="attachment.filename"></td>
                    <td class="uk-text-center" v-html="attachment.filetype"></td>
                    <td><a target="_blank" class="uk-button uk-button-primary" :href="attachment.link"><span uk-icon="icon: cloud-download"></span> <span v-html="$t('main.Download')"> </span></a></td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
const messages = {
  en: {
    message: {
      added_successfully: 'Added successfully',
      the_product_added: 'The product has been added to your shopping cart successfully.',
      already_in_cart: 'Am error accrued!',
      product_already_in_cart: 'This product was already added to your shopping cart',
      please_purchase: 'Please purchase the product first',
      please_purchase_message: 'To view this lesson you need to purchase the product first.',
    }
  },
  ar: {
    message: {
      added_successfully: 'تمت الإضافة بنجاح',
      the_product_added: 'لقد تمت إضافة المنتج الى سلة التسوق الخاصة بك بنجاح.',
      already_in_cart: 'لقد تم اضافة المنتج سابقاً',
      product_already_in_cart: 'هذا المنتج قد تمت اضافته مسبقاً لسلة التسوق الخاصة بك.',
      please_purchase: 'يرجى شراء الدورة',
      please_purchase_message: 'لعرض هذا الدرس يجب عليك شراء الدورة أولا.',
    }
  }
}
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
      product: null,
      lessonId: null,
      content: null,
      description: null,
      resources: null,
      forms: null,
      attachments: [],
      groups: [],
      lessonGroupId: null,
      productColor: null,
      loadingMode:true,
      lang:null,
      productToCart:null,
      inAddingProductId:null,
    }
  },
  created() {
    this.lang = document.documentElement.lang.substr(0, 2);
    this.fetchItem();
  },
  methods:{
    fetchItem(){
      axios.get('/store/product/lesson/'+this.lessonSlug+'/items', {
        params: {
          // id: 12345
        }
      }).then(res => {
        this.item = res.data;
        this.content = this.item.content;
        this.description = this.item.description;
        this.resources = this.item.resources;
        this.forms = this.item.forms;
        this.attachments = this.item.attachments;
        this.groups = this.item.groups;
        this.lessonGroupId = this.item.lesson_group_id;
        this.lessonId = this.item.lesson_id;
        this.product = this.item.product;
        console.log(this.product);
      });
    },
    updateViewContentStatus(status){
      this.viewContentStatus = status;
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
              console.log(error);
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
    pleasePurchase(){
      this.$Notify({
        title: messages[this.lang].message.please_purchase,
        message: messages[this.lang].message.please_purchase_message,
        type: 'warning',
        duration: 5000
      });
    }
  },
  components: {
    memorize
  },
}
</script>

<style scoped>

@media (max-width: 960px){
  .overflow-auto{
    overflow-y: hidden; overflow-x: scroll
  }
  /* width */
  ::-webkit-scrollbar {
    width: 5px;
    height: 5px;
  }

  /* Track */
  ::-webkit-scrollbar-track {
    background: #f1f1f1;
  }

  /* Handle */
  ::-webkit-scrollbar-thumb {
    background: #a8a8a8;
    border-radius: 10px;
  }

  /* Handle on hover */
  ::-webkit-scrollbar-thumb:hover {
    background: #888;
  }
  .please-purchase{
    opacity: 0.5;
  }
  .please-purchase:hover{
    cursor: pointer !important;
  }
}

</style>

