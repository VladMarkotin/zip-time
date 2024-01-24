<template>
  <!--<v-facebook-login app-id="263292435338035"></v-facebook-login>-->
  <a href="/login/facebook " class="btn-facebook">
    <button class="login-facebook-button"><span>Continue with</span></button>
  </a>
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

<style scoped>
  .login-facebook-button {
    font-family: 'Inter', sans-serif;
    font-weight: 400;
    line-height: 20px;
    padding: 0.55rem 1.55rem;
    border-radius: 10rem;
    color: #fff;
    text-transform: uppercase;
    font-size: 1rem;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
    z-index: 1;
    text-shadow: 1px 1px 1px black;
  }

  .login-facebook-button:after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    /* background-color: #ff2b2b; было */
    background-color: #de0000;
    border-radius: 10rem;
    z-index: -2;
  }

  .login-facebook-button:before {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0%;
    height: 100%;
    /* background-color: #de0000; было */
    background-color: #ff2b2b;
    transition: all 0.3s;
    border-radius: 10rem;
    z-index: -1;
  }

  .login-facebook-button:hover {
    color: #fff;
  }

  .login-facebook-button:hover:before {
    width: 100%;
  }
</style>
