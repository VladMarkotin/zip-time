<template>
  <!--<v-facebook-login app-id="263292435338035"></v-facebook-login>-->
  <a href="/login/facebook " class="btn-facebook">
    <button class="login-facebook-button">
      <div class="login-facebook-button__icon-wrapper">
        <svg class="login-facebook-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2.04C6.5 2.04 2 6.53 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.85C10.44 7.34 11.93 5.96 14.22 5.96C15.31 5.96 16.45 6.15 16.45 6.15V8.62H15.19C13.95 8.62 13.56 9.39 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96A10 10 0 0 0 22 12.06C22 6.53 17.5 2.04 12 2.04Z" /></svg>
      </div>
      <div class="login-facebook-button__text-wrapper">
        <span class="login-facebook-button__text"><span class="bold">Continue with</span> Facebook</span>
        <span class="login-facebook-button__text secure-login-text">secured log in</span>
      </div>
    </button>
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
  .bold {
    font-weight: 700;
  }
  .btn-facebook {
    text-decoration: none;
  }

  .login-facebook-icon {
    height: 35px;
    width: 35px;
    fill: #FFFFFF;
  }
  .login-facebook-button {
    font-family: 'Roboto', sans-serif;
    padding: 7px 17px;
    border-radius: 10rem;
    color: #fff;
    text-transform: uppercase;
    font-size: 1rem;
    transition: all 0.3s;
    position: relative;
    overflow: hidden;
    z-index: 1;
    display: flex;
    align-items: center;
  }

  .login-facebook-button__text {
    font-size: 13px;
    margin: 0 7px;
    font-weight: 400;
    -webkit-text-shadow: -1px 0px 1px rgba(0, 0, 0, 0.39);
    -moz-text-shadow: -1px 0px 1px rgba(0, 0, 0, 0.39);
    text-shadow: -1px 0px 1px rgba(0, 0, 0, 0.39);
    line-height: 15px;
  }

  .login-facebook-button:after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: #0074e0;
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
    background-color: #00693E;
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

  .login-facebook-button__text-wrapper {
    display: flex;
    flex-direction: column;
  }

  .secure-login-text {
    font-family: 'Inter', sans-serif;
    font-weight: 300;
    font-size: 10px;
    line-height: 11px;
  }

  @media screen and (max-width: 480px) {
    .login-facebook-button__text {
      font-size: 11px;
    }

    .secure-login-text {
      font-size: 9px;
    }

    .login-facebook-button {
      padding: 7px 12px;
    }

    .login-facebook-icon {
      height: 30px;
      width: 30px;
    }
  }
</style>
