<template>
  <div class="form uk-card uk-card-default uk-card-body uk-width-3-5@m">
    <div class="uk-grid-small" uk-grid>
      <div class="uk-width-auto"><span class="uk-icon-button uk-text-primary" uk-icon="user"></span></div>
      <div class="uk-width-expand"><h3 class="uk-card-title" v-html="$t('main.Create new account')"></h3></div>
    </div>
    <div class="uk-padding-small">

    </div>
    <div>
        <div class="uk-grid-small uk-child-width-1-2@m" uk-grid>
        <div class="uk-width-1-4@m uk-width-1-2">
          <label class="uk-form-label" v-html="$t('main.First name')">First name</label>
          <input class="uk-input" max="20" name="first_name" type="text" required :class="{'uk-form-danger': errors.first_name }" v-model="inputArray.first_name">
          <span class="uk-text-danger uk-text-meta" v-if="errors.first_name" v-html="errors.first_name[0]"></span>
        </div>
        <div class="uk-width-1-4@m uk-width-1-2">
          <label class="uk-form-label" v-html="$t('main.Father_name')"></label>
          <input class="uk-input" max="20" name="middle_name" type="text" required v-model="inputArray.middle_name">
        </div>
        <div class="uk-width-1-4@m uk-width-1-2">
          <label class="uk-form-label" v-html="$t('main.Grandpa_name')"></label>
          <input class="uk-input" max="20" name="last_name" type="text" required v-model="inputArray.last_name">
        </div>
        <div class="uk-width-1-4@m uk-width-1-2">
          <label class="uk-form-label"v-html="$t('main.Surname')"></label>
          <input class="uk-input" max="20" name="surname" type="text" required :class="{'uk-form-danger': errors.surname }" v-model="inputArray.surname">
          <span class="uk-text-danger uk-text-meta" v-if="errors.surname" v-html="errors.surname[0]"></span>
        </div>
        <div class="uk-width-1-1">
          <label class="uk-form-label" v-html="$t('main.Email')"></label>
          <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: mail"></span>
            <input class="uk-input" name="email" type="text" placeholder="" required :class="{'uk-form-danger': errors.email }" v-model="inputArray.email">
          </div>
          <span class="uk-text-danger uk-text-meta" v-if="errors.email" v-html="errors.email[0]"></span>
        </div>
        <div>
          <label class="uk-form-label" v-html="$t('main.Password')"></label>
          <vs-input
              name="password"
              type="password"
              v-model="inputArray.password"
              :progress="getPasswordProgress"
              :visiblePassword="hasVisiblePassword"
              icon-after
              @click-icon="hasVisiblePassword = !hasVisiblePassword">
              :class="{'uk-form-danger': errors.password }" v-model="inputArray.password"
            <template #icon>
              <i v-if="!hasVisiblePassword" class='far fa-eye'></i>
              <i v-else class='far fa-eye-slash'></i>
            </template>

            <template v-if="getPasswordProgress >= 100" #message-success>
              Secure password
            </template>

          </vs-input>
          <span class="uk-text-danger uk-text-meta" v-if="errors.password" v-html="errors.password[0]"></span>
        </div>
        <div>
          <label class="uk-form-label" v-html="$t('main.Password Confirm')"></label>
          <vs-input
              name="password_confirmation"
              type="password"
              v-model="inputArray.password_confirmation"
              :progress="getPasswordConfirmationProgress"
              :visiblePassword="hasVisiblePassword"
              icon-after
              @click-icon="hasVisiblePassword = !hasVisiblePassword">
            <template #icon>
              <i v-if="!hasVisiblePassword" class='far fa-eye'></i>
              <i v-else class='far fa-eye-slash'></i>
            </template>

            <template v-if="getPasswordConfirmationProgress >= 100" #message-success>
              Secure password
            </template>

          </vs-input>
        </div>
        <div :class="{'uk-width-1-3@m uk-width-1-1':subDirectorates.length > 0}">
          <label class="uk-form-label" v-html="$t('main.Country')"></label>
          <select class="uk-select countries-items" name="country_id" required v-model="inputArray.country_id">
            <option selected="true" disabled="disabled" v-html="$t('main.Select Country')"></option>
            <option v-for="country in countries" v-html="country.name" :value="country.id"></option>
          </select>
        </div>
        <div :class="{'uk-width-1-3@m uk-width-1-1':subDirectorates.length > 0}">
          <label class="uk-form-label" v-html="$t('main.Directorate')"></label>
          <select @change="updateSubdirectories(inputArray.directorate_id)" class="uk-select countries-items" name="directorate_id" required v-model="inputArray.directorate_id">
            <option selected="true" disabled="disabled" v-html="$t('main.Select directorate')"></option>
            <option v-for="directorate in directorates" v-html="directorate.title" :value="directorate.id"></option>
          </select>
        </div>
        <div v-if="subDirectorates.length > 0" class="uk-width-1-3@m uk-width-1-1">
          <label class="uk-form-label" v-html="$t('main.Schools out of country')"></label>
          <select class="uk-select countries-items" name="sub_directorate_id" required v-model="inputArray.sub_directorate_id">
            <option selected="true" disabled="disabled" v-html="$t('main.Select school')"></option>
            <option v-for="subDirectorate in subDirectorates" v-html="subDirectorate.title" :value="subDirectorate.id"></option>
          </select>
        </div>
        <div class="uk-width-1-4@m uk-width-1-2">
          <label class="uk-form-label" v-html="$t('main.Scope')"></label>
          <select class="uk-select" name="scope_id" v-model="inputArray.scope_id" @change="fetchScopes()">
            <option selected="true" disabled="disabled" v-html="$t('main.Study scope')"></option>
            <option v-for="scope in scopes" v-html="scope.title" :value="scope.id"></option>
          </select>
        </div>
        <div class="uk-width-1-4@m uk-width-1-2">
          <label class="uk-form-label" v-html="$t('main.Field')"></label>
          <select class="uk-select" name="field_id" v-model="inputArray.field_id" @change="fetchItem()">
            <option selected="true" disabled="disabled" v-html="$t('main.Study field')"></option>
            <option v-for="field in fields" v-html="field.title" :value="field.id"></option>
          </select>
        </div>
        <div class="uk-width-1-4@m uk-width-1-2">
          <label class="uk-form-label" v-html="$t('main.Level')"></label>
          <select class="uk-select" name="level" v-model="inputArray.level_id">
            <option selected="true" disabled="disabled" v-html="$t('main.Study Level')"></option>
            <option v-for="(level, key) in levels" v-html="level.title" :value="key" v-if="parseInt(level.status) === 1"></option>
          </select>
        </div>
        <div class="uk-width-1-4@m uk-width-1-2">
          <label class="uk-form-label" v-html="$t('main.Study type')"></label>
          <select class="uk-select" name="field_option_id" v-model="inputArray.field_option_id">
            <option selected="true" disabled="disabled" v-html="$t('main.Select study type')"></option>
            <option v-for="option in fieldOptions" v-html="option.title" :value="option.id"></option>
          </select>
        </div>
        <div class="uk-width-1-3@m uk-width-1-2 select-birthday">
          <label class="uk-form-label" v-html="$t('main.Birthday')"></label>
          <date-picker v-model="inputArray.date" valueType="format"
          ></date-picker>
        </div>
        <div class="uk-width-1-3@m uk-width-1-2">
          <label class="uk-form-label" v-html="$t('main.Phone number')"></label>
          <div class="uk-inline uk-width-1-1">
            <span class="uk-form-icon uk-form-icon-flip" uk-icon="icon: phone"></span>
            <input class="uk-input" name="phone_number" type="text" required @keypress="onlyNumber" :class="{'uk-form-danger': errors.phone_number }" v-model="inputArray.phone_number">
          </div>
          <span class="uk-text-danger uk-text-meta" v-if="errors.phone_number" v-html="errors.phone_number[0]"></span>
        </div>
        <div class="uk-width-1-3@m uk-width-1-1">
          <div class="uk-grid-small uk-text-center uk-child-width-1-2" uk-grid>
            <div style="padding-top: 10px">
              <vs-radio name="gender" v-model="inputArray.gender" color="#0099FF" val="1">
                <span v-html="$t('main.Male')"></span>
                <template #icon>
                  <i class="fas fa-mars uk-text-muted"></i>
                </template>
              </vs-radio>
            </div>
            <div style="padding-top: 10px">
              <vs-radio name="gender" v-model="inputArray.gender" color="#d234eb" val="0">
                <span v-html="$t('main.Female')"></span>
                <template #icon>
                  <i class="fas fa-venus uk-text-muted"></i>
                </template>
              </vs-radio>
            </div>
          </div>
          <span class="uk-text-danger uk-text-meta" v-if="errors.gender" v-html="errors.gender[0]"></span>
        </div>
        <div class="uk-width-1-1">
<!--          @click="submitForm()"-->
          <button @click="submitForm()" class="uk-button uk-button-primary uk-width-1-1 recaptcha-validation-required" :disabled="postingMode || inputArray.recaptcha === ''">
            <span v-if="!postingMode" v-html="$t('main.Register')"></span>
            <span v-else><span uk-spinner="ratio: 0.7"></span> <span v-html="$t('main.Creation in process')"></span></span>
          </button>
        </div>
      </div>
<!--      </form>-->
    </div>
  </div>
</template>

<script>
import DatePicker from 'vue2-datepicker';
import 'vue2-datepicker/index.css';

export default {
  name: "RegisterForm",
  components: { DatePicker },
  data(){
    return{
      value:'',
      postingMode:'',
      hasVisiblePassword: false,
      countries:[],
      directorates:[],
      subDirectorates:[],
      scopes:[],
      fields:[],
      fieldOptions:[],
      levels:[],
      errors:[],
      recaptchaSiteKey : '6LeQDcIaAAAAAFLK1sXS-x6mdmeLgIl1Ba8CDR39', // tiptop key
      // recaptchaSiteKey : '6LfQPBYaAAAAABksKwr8bePl5S4Jxq_P4tqLwOOG', // dev key
      inputArray: {
        first_name:'',
        middle_name:'',
        last_name:'',
        surname:'',
        email:'',
        password:'',
        password_confirmation:'',
        country_id:368, // iraq
        directorate_id: null,
        sub_directorate_id: null,
        scope_id: null,
        field_id: null,
        field_option_id: null,
        level_id: null,
        date: null,
        phone_number: null,
        gender:null,
        token: 'null',
        recaptcha: '',
      },
    }
  },
  created() {
    this.fetchItem();
    this.refreshReCaptchaToken();
  },
  methods:{
    onlyNumber ($event) {
      //console.log($event.keyCode); //keyCodes value
      let keyCode = ($event.keyCode ? $event.keyCode : $event.which);
      if ((keyCode < 48 || keyCode > 57) && keyCode !== 46) { // 46 is dot
        $event.preventDefault();
      }
    },
    //
    fetchItem(){
      $('.full-screen-spinner').fadeIn();
      axios.get('/get/registration/info', {
        params: {
          country_id: this.inputArray.country_id,
          scope_id: this.inputArray.scope_id,
          field_id: this.inputArray.field_id,
          directorate_id: this.inputArray.directorate_id,
        }
      }).then(res => {
        $('.full-screen-spinner').fadeOut();
        var data = res.data;
        this.countries = data.countries;
        this.directorates = data.directorates;
        this.inputArray.country_id = data.country_id;
        this.inputArray.directorate_id = data.directorate_id;
        this.inputArray.scope_id = data.scope_id;
        this.scopes = data.scopes;
        this.fields = data.fields;
        this.inputArray.field_id = data.field_id;
        this.fieldOptions = data.field_options;
        this.inputArray.field_option_id = data.field_option_id;
        this.levels = data.levels;
        this.inputArray.level_id = data.level_id;
        this.inputArray.token = data._token;
        // this.recaptchaSiteKey = data.recaptcha_site_key;
        this.updateSubdirectories(this.inputArray.directorate_id);
      });

    },
    fetchScopes(){
      this.inputArray.field_id = null;
      this.inputArray.field_option_id = null;
      this.inputArray.level_id = null;
      this.fetchItem();
    },
    updateSubdirectories(directorateId){
        this.directorates.forEach((value, index) => {
          if(parseInt(value.id) === parseInt(directorateId)){
            this.subDirectorates = value.items;
          }
        });
      // console.log(this.subDirectorates);
    },
    refreshReCaptchaToken(){
      var vue = this;
      grecaptcha.ready(function() {
        grecaptcha.execute(vue.recaptchaSiteKey, {action: 'submit'}).then(token => {
          // Add your logic to submit to your backend server here.
          if (vue.inputArray.recaptcha != token){
            vue.inputArray.recaptcha = token;
          } else {
            this.refreshReCaptchaToken();
          }
        });
      });
    },
    submitForm() {
      // console.log(this.inputArray.recaptcha);
      this.postingMode = !this.postingMode;
      this.refreshReCaptchaToken();
      this.errors = {};
      axios.post('/register', this.inputArray).then(res => {
        location.replace("/suspended");
      }).catch(error => {
        this.postingMode = !this.postingMode;
        if (error.response.status === 422) {
          this.errors = error.response.data.errors || {};
          this.$Notify({
            title: 'Oops! something going wrong',
            message: error.response.data.message,
            type: 'error',
            duration: 4000
          });
          console.log(error.response.data);
        }
      });
    },
  },
  computed: {
    getPasswordProgress() {
      let progress = 0

      // at least one number

      if (/\d/.test(this.inputArray.password)) {
        progress += 20
      }

      // at least one capital letter

      if (/(.*[A-Z].*)/.test(this.inputArray.password)) {
        progress += 20
      }

      // at menons a lowercase

      if (/(.*[a-z].*)/.test(this.inputArray.password)) {
        progress += 20
      }

      // more than 5 digits

      if (this.inputArray.password.length >= 6) {
        progress += 20
      }

      // at least one special character

      if (/[^A-Za-z0-9]/.test(this.inputArray.password)) {
        progress += 20
      }

      return progress
    },
    getPasswordConfirmationProgress() {
      let progress = 0

      // at least one number

      if (/\d/.test(this.inputArray.password_confirmation)) {
        progress += 20
      }

      // at least one capital letter

      if (/(.*[A-Z].*)/.test(this.inputArray.password_confirmation)) {
        progress += 20
      }

      // at menons a lowercase

      if (/(.*[a-z].*)/.test(this.inputArray.password_confirmation)) {
        progress += 20
      }

      // more than 5 digits

      if (this.inputArray.password_confirmation.length >= 6) {
        progress += 20
      }

      // at least one special character

      if (/[^A-Za-z0-9]/.test(this.inputArray.password_confirmation)) {
        progress += 20
      }

      return progress
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
.vs-input {
  background-color: transparent !important;
}
.select-birthday:hover {
  /*cursor: pointer;*/
}

</style>