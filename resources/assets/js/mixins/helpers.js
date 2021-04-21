export default {
    data(){
      return{
        lang: 'en',
      }
    },
    created() {
        this.lang = document.documentElement.lang.substr(0, 2);

    },
    methods: {
        // scroll to element position
        scrollToElement(e){
            $('body, html').animate({
                scrollTop: $(e).offset().top
            }, 300);
        },
        // generate random string
        generateRandomString(length) {
            var text = "";
            var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
            for (var i = 0; i < length; i++)
                text += possible.charAt(Math.floor(Math.random() * possible.length));
            return text;
        },
    }
};