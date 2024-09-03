<template>
    <div class="login-page-container ">
    <div class="inner-block">
        <section class="login-section white-background">
            <div class="login-icons-wrapper login-icons-top">
                <LoginBorderIcon v-for="n in 4" :key="n" :isReversed="n % 2 === 0"/>
            </div>
            <div class="login-info">
                <h1 class="title-login-page main-title">Quipl.сo</h1>
                <h2 class="subtitle-login-page">The empire of efficiency is nearby. Final step left</h2>
            </div>
            <div class="login-links-wrapper">
                <div class="login-links-inner-block">
                    <div class="facebook-link-wrapper">
                        <LoginButton
                        loginUrl="/login/facebook"
                        buttonName="facebook-button"
                        >
                            <template #login-button-icon>
                                <svg class="login-button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M12 2.04C6.5 2.04 2 6.53 2 12.06C2 17.06 5.66 21.21 10.44 21.96V14.96H7.9V12.06H10.44V9.85C10.44 7.34 11.93 5.96 14.22 5.96C15.31 5.96 16.45 6.15 16.45 6.15V8.62H15.19C13.95 8.62 13.56 9.39 13.56 10.18V12.06H16.34L15.89 14.96H13.56V21.96A10 10 0 0 0 22 12.06C22 6.53 17.5 2.04 12 2.04Z" /></svg>
                            </template>
                            <template #login-button-text>
                                <span class="login-button__text"><span class="bold">Continue with</span> Facebook</span>
                                <span class="login-button__text secure-login-text">secured log in</span>
                            </template>
                        </LoginButton>
                        <LoginButton 
                        loginUrl="/login/google"
                        buttonName="google-button"
                        >
                            <template #login-button-icon>
                                <svg class="login-button-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <g id="sharp">
                                    <path d="M12.545,10.239v3.821h5.445c-0.712,2.315-2.647,3.972-5.445,3.972c-3.332,0-6.033-2.701-6.033-6.032s2.701-6.032,6.033-6.032c1.498,0,2.866,0.549,3.921,1.453l2.814-2.814C17.503,2.988,15.139,2,12.545,2C7.021,2,2.543,6.477,2.543,12s4.478,10,10.002,10c8.396,0,10.249-7.85,9.426-11.748L12.545,10.239z" fill="#FFFFFF"/>
                                </g>
                                </svg>
                            </template>
                            <template #login-button-text>
                                <span class="login-button__text"><span class="bold">Continue with</span> Google</span>
                                <span class="login-button__text secure-login-text">secured log in</span>
                            </template>
                        </LoginButton>
                    </div>
                    <div style="background: #000;">
                    <!-- <a
                       href="login/google"
                       class="text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#4285F4]/55 me-2 mb-2">
                        <svg class="w-1 h-1 me-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 19">
                        <path fill-rule="evenodd" d="M8.842 18.083a8.8 8.8 0 0 1-8.65-8.948 8.841 8.841 0 0 1 8.8-8.652h.153a8.464 8.464 0 0 1 5.7 2.257l-2.193 2.038A5.27 5.27 0 0 0 9.09 3.4a5.882 5.882 0 0 0-.2 11.76h.124a5.091 5.091 0 0 0 5.248-4.057L14.3 11H9V8h8.34c.066.543.095 1.09.088 1.636-.086 5.053-3.463 8.449-8.4 8.449l-.186-.002Z" clip-rule="evenodd"/>
                        </svg>
                        Sign in with Google
                    </a> -->
                    </div>  
                    <div class="privacy-policy-wrapper">
                        <div class="privacy-policy-text-wrapper">
                            <p class="privacy-policy-text">By using Quipl you accept</p>
                            <p class="privacy-policy-text">our <a href="/privacy" class="privacy-policy-link">Privacy Policy</a></p>
                        </div>
                    </div> 
                </div>
            </div>
            <div class="login-icons-wrapper login-icons-bottom">
                <LoginBorderIcon v-for="n in 4" :key="n" :isReversed="n % 2 !== 0"/>
            </div>
        </section>
    </div>                         
</div>
</template>

<script>
import LoginBorderIcon from './LoginBorderIcon.vue';
import Facebook from '../Facebook.vue';
import LoginButton from './LoginButton.vue';
    export default {
        components: {LoginButton, LoginBorderIcon},
    }
</script>

<style scoped>
    @import url('/css/loginPage/loginPage.css');
    @import url('/css/loginPage/loginPageMedia.css');
</style>