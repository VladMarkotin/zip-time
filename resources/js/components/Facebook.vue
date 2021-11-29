<template>
  <!--<v-facebook-login app-id="263292435338035"></v-facebook-login>-->
  <a href="/login/facebook " class="btn btn-facebook"> Facebook</a>
</template>

<script>
  import VFacebookLogin from 'vue-facebook-login-component'

  window.fbAsyncInit = function() {
      FB.init({
        appId      : '263292435338035',
        cookie     : true,
        xfbml      : true,
        version    : 'v10.0'
      });

      FB.AppEvents.logPageView();

    };

    (function(d, s, id){
       var js, fjs = d.getElementsByTagName(s)[0];
       if (d.getElementById(id)) {return;}
       js = d.createElement(s); js.id = id;
       js.src = "https://connect.facebook.net/en_US/sdk.js";
       fjs.parentNode.insertBefore(js, fjs);
     }(document, 'script', 'facebook-jssdk'));

  export default {
    components: {
      VFacebookLogin,
    },
  }
</script>