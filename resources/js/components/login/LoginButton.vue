<template>
    <a :href="loginUrl" class="login-btn-link">
      <button :class="['login-button', buttonName]">
        <div class="login-facebook-button__icon-wrapper">
            <slot name="login-button-icon" />
        </div>
        <div class="login-button__text-wrapper">
            <slot name="login-button-text"/>
        </div>
      </button>
    </a>
  </template>

<script>
    export default {
        props: {
            loginUrl: {
                type: String,
                required: true,
            },
            buttonName: {
                type: String,
                default: 'facebook-button',
            }
        }
    }
</script>

<style scoped>
  .bold {
    font-weight: 700;
  }
  .login-btn-link{
    text-decoration: none;
  }

  .login-button-icon {
    height: 35px;
    width: 35px;
    fill: #FFFFFF;
  }
  .login-button {
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
    width: 100%;
  }

  .login-button__text {
    font-size: 13px;
    margin: 0 7px;
    font-weight: 400;
    -webkit-text-shadow: -1px 0px 1px rgba(0, 0, 0, 0.39);
    -moz-text-shadow: -1px 0px 1px rgba(0, 0, 0, 0.39);
    text-shadow: -1px 0px 1px rgba(0, 0, 0, 0.39);
    line-height: 15px;
  }

  .login-button:after {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 10rem;
    z-index: -2;
  }

  .facebook-button:after {
    background-color: #0074e0;
  }

  .google-button::after {
    background-color: #DB4437;
  }

  .login-button:before {
    content: "";
    position: absolute;
    bottom: 0;
    left: 0;
    width: 0%;
    height: 100%;
    transition: all 0.3s;
    border-radius: 10rem;
    z-index: -1;
  }

  .facebook-button::before {
    background-color: #003399;
  }

  .google-button::before {
    background-color:  #C13528;;
  }

  .login-button:hover {
    color: #fff;
  }

  .login-button:hover:before {
    width: 100%;
  }

  .login-button__text-wrapper {
    display: flex;
    flex-direction: column;
  }

  .secure-login-text {
    font-family: 'Inter', sans-serif;
    font-weight: 300;
    font-size: 10px;
    line-height: 11px;
  }
</style>