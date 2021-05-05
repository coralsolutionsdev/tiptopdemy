<template>
  <div>
    <h1>Pusher Test</h1>
    <p>
      Publish an event to channel <code>my-channel</code>
      with event name <code>my-event</code>; it will appear below:
    </p>
    <div>
      <ul>
        <li v-for="message in messages">
          {{message.message}}
        </li>
      </ul>
    </div>
  </div>
</template>

<script>
export default {
  name: "notifications",
  data(){
    return{
      messages: [],
    }
  },
  created() {
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('6e0c4a037bdbc70bb1ee', {
      cluster: 'ap2'
    });
    var app = this;
    var channel = pusher.subscribe('my-channel');
    channel.bind('my-event', function(data) {
      // console.log(data.message);
      app.messages.push(data);
    });
  }
}
</script>

<style scoped>

</style>