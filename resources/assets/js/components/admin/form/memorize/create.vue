<template>
  <div>
    <div class="card border-light">
        mehmet
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
