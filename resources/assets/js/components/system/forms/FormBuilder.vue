<template>
  <div>
    <div class="uk-grid-small form-title" uk-grid>
      <div class="uk-width-auto"><span class="uk-icon-button uk-text-primary" uk-icon="mail"></span></div>
      <div class="uk-width-expand"><h3 class="uk-card-title" v-html="$t('main._contact_us')"></h3></div>
    </div>
    <div class="uk-grid-small uk-child-width-1-2@m" uk-grid>
      <div v-for="item in items" class="uk-width-1-1">
        <label class="uk-form-label" v-html="item.label"></label>
        <input v-if="item.type === 'text'" class="uk-input" type="text" required v-model="item.value" :class="{'uk-form-danger': !item.ValidValue && item.value.length === 0}" @keypress="validateItem(item)">
        <div v-else-if="item.type === 'email'" class="uk-inline uk-width-1-1">
          <span v-if="item.ValidValue && item.value.length > 0" class="uk-form-icon uk-text-success" uk-icon="icon: check" :class="{'uk-form-icon-flip': lang === 'en'}"></span>
          <span v-if="!item.ValidValue && item.value.length > 0" class="uk-form-icon uk-text-danger" uk-icon="icon: close" :class="{'uk-form-icon-flip': lang === 'en'}"></span>
          <input class="uk-input" type="email" required v-model="item.value" :class="{'uk-form-danger': !item.ValidValue, 'uk-form-success': item.ValidValue && item.value.length > 0}" @blur="validateItem(item)">
        </div>
        <textarea v-if="item.type === 'textarea'" class="uk-textarea" rows="5" placeholder="" v-model="item.value" :class="{'uk-form-danger': !item.ValidValue && item.value.length === 0}" @keypress="validateItem(item)"></textarea>
        <span class="uk-text-muted uk-text-danger" v-if="!item.ValidValue"> {{item.label}} is required or invalid. </span>
      </div>
    </div>
    <div class="uk-grid-collapse uk-margin-small" uk-grid>
      <div class="uk-width-expand"></div>
      <div class="uk-width-expand@m uk-width-1-1">
      </div>
      <div class="uk-width-auto@m uk-width-1-2 uk-flex uk-flex-middle">
        <span v-html="postingMessage"></span>
      </div>
      <div class="uk-width-1-4@m uk-width-1-2">
        <button @click="submitForm()" class="uk-button uk-button-primary uk-width-1-1" :disabled="postingMode">
            <span v-if="!postingMode" v-html="$t('main.submit')"></span>
            <span v-else><span uk-spinner="ratio: 0.7"></span></span>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "FormBuilder",
  props: [
    'recaptchaSiteKey'
  ],
  data(){
    return{
      lang:'en',
      postingMode: false,
      postingMessage: '',
      recaptcha: '',
      items:[
        {
          label: 'الأسم',
          type: 'text',
          placeholder: '',
          value: '',
          ValidValue: true,
          required: true,
          senderTitle: true,
          senderEmail: false,
        },
        {
          label: 'البريد الإلكتروني',
          type: 'email',
          placeholder: '',
          value: '',
          ValidValue: true,
          required: true,
          senderTitle: false,
          senderEmail: true,
        },
        {
          label: 'الموضوع',
          type: 'text',
          placeholder: '',
          value: '',
          ValidValue: true,
          required: true,
          senderTitle: false,
          senderEmail: false,
        },
        {
          label: 'الرسالة',
          type: 'textarea',
          placeholder: '',
          value: '',
          ValidValue: true,
          required: true,
          senderTitle: false,
          senderEmail: false,
        },

      ],
    }
  },
  created() {
    this.lang = document.documentElement.lang.substr(0, 2);
    this.refreshReCaptchaToken();
  },
  methods: {
    validateItem(item) {
      if (item.type == 'email'){
        if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(item.value)) {
          item.ValidValue = true;
        } else {
          item.ValidValue = false;
        }
      } else {
        if (item.value.length > 0){
          item.ValidValue = true;
        }
      }
    },
    submitForm() {
      // console.log(this.inputArray.recaptcha);
      // console.log();
      if (this.isValidItems() === true){
        this.postingMode = !this.postingMode;
        this.refreshReCaptchaToken();
        // this.errors = {};
        var data = {
          items: this.items,
          recaptcha:this.recaptcha,
        };
        axios.post('/send/form/email', data).then(res => {
          this.postingMode = !this.postingMode;
          this.postingMessage = '<span class="uk-text-success uk-margin-small-right uk-margin-small-left"><i class="far fa-check-circle"></i> Successfully sent</span>';
          this.resetItems();
          this.$Notify({
            title: 'Message sent successfully',
            message: 'Your message has been sent successfully, we will get back to you soon.',
            type: 'success',
            duration: 4000
          });
        }).catch(error => {
          this.postingMode = !this.postingMode;
          this.postingMessage = '<span class="uk-text-danger uk-margin-small-right uk-margin-small-left"><i class="far fa-times-circle"></i> An error acquired</span>';
          this.$Notify({
            title: 'Oops! something going wrong',
            message: 'Seems that your email cannot be send please try again later or contact us by another contact option.',
            type: 'error',
            duration: 4000
          });
        });
      }

    },
    refreshReCaptchaToken(){
      var vue = this;
      grecaptcha.ready(function() {
        grecaptcha.execute(vue.recaptchaSiteKey, {action: 'submit'}).then(token => {
          // Add your logic to submit to your backend server here.
          if (vue.recaptcha != token){
            vue.recaptcha = token;
          } else {
            this.refreshReCaptchaToken();
          }
        });
      });
    },
    isValidItems(){
      var result =  true;
      this.items.forEach((item, index) => {
        if (item.required === true){
          if (item.value.length === 0){
            item.ValidValue = false;
            result = false;
          } else {
            if (item.type != 'email'){
              item.ValidValue = true;
            }
          }
        }
      });
      return result;
    },
    resetItems(){
      this.items.forEach((item, index) => {
        item.value = '';
      });
    },
  }
}
</script>

<style scoped>
.uk-form-label{
  position: absolute;
  z-index: 20;
  margin: -12px 10px 0 10px;
  background-color: #FFFFFF;
  padding: 0 5px;
}
.uk-textarea{
  border-radius: 5px;
}
.form-title{
  margin-bottom: 25px;
}
</style>