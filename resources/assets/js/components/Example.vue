<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ message }}</div>

                    <div class="panel-body" v-html="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
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
            ]
          }
        },
        mounted() {
            console.log('Component mounted.')
        },
    }
</script>
