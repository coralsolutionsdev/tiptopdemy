<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">

                      <p>Welcome: {{name ? name : 'User'}}</p>
                      <p v-if="name">{{name}}</p>
                      <p v-else> No name set</p>


                      <p v-if="age > 50">old</p>
                      <p v-else-if="age < 20">young</p>
                      <p v-else>validated</p>


<!--                      <p>{{calcAge()}}</p>-->
                      <p>{{ reversedMessage }}</p>
                      <p>{{ calcMyAge }}</p>
                      <p>{{ fullName }}</p>
                      <hr>
                      <label>Search for lang</label>
                      <input type="text" class="uk-input" v-model="findLanguage">
                      <ul>
                        <li v-for="lang in filterLanguages">{{ lang }}</li>
                      </ul>
                      <hr>
                      <label> add your user name</label>
                      <input type="text" class="uk-input" v-model="username">
                      <p>{{ validateUserName }}</p>
                      <label> Dollar </label>
                      <input type="text" class="uk-input" v-model="dollar">
                      <label> To dinnar</label>
                      <input type="text" class="uk-input" v-model="dinnar">

                      <hr>
                      <p>post_id is : {{post_id}}</p>
                    </div>

                    <div class="panel-body" v-html="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'post_id'
        ],

        data(){
          return {
            message: 'Hello Vue!',
            todos: [
              { text: 'Learn JavaScript' },
              { text: 'Learn Vue' },
              { text: 'Build something awesome' }
            ],
            answers: [
              { text: 'Learn JavaScript' },
              { text: 'Learn Vue' },
              { text: 'Build something awesome' }
            ],
            languages: [
                'HTML',
                'CSS',
                'PHP',
                'C++',
            ],
            name: 'Mehmet',
            firstName: 'Mehmet',
            lastName: 'Munaf',
            username: '',
            age: 100,
            findLanguage: '',
            dollar: 0,
            dinnar: 0,
          }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
          // calcAge: function (){
          //   return this.age * 2;
          // }
        },
      computed: {
        // a computed getter
        reversedMessage: function () {
          // `this` points to the vm instance
          return this.message.split('').reverse().join('')
        },
        calcMyAge: function (){
          return this.age * 2;
        },
        fullName: function (){
          // return this.firstName + ' ' + this.lastName;
          return `${this.firstName} ${this.lastName}`;
        },
        filterLanguages: function (){
          var filtering = new RegExp(this.findLanguage, 'i');
          return this.languages.filter(function (lang){
            return lang.match(filtering);
          });
        },
        validateUserName: function (){
          if(!this.username){
            return 'user name is empty'
          } else if (this.username.length < 8){
            return 'username is short'
          } else if (! isNaN(this.username)){
            return 'username is cannot be numbers only'
          }else{
            return 'Ok ' + this.username;
          }
        },
      },
      watch: {
        dollar: function (price){
          this.dinnar = price * 1400;
        },
        dinnar: function (price){
          this.dollar = price / 1400;
        }
      }
    }
</script>
