<template>
    <div class="login-icon-wrapper">
        <svg class="login-icon" width="58" height="50" viewBox="0 0 58 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path v-if="isReversed" d="M29 0L57.5788 49.5H0.421162L29 0Z" fill="#E60000"/>
            <path v-else d="M29 50L0.421162 0.5L57.5788 0.5L29 50Z" fill="#E60000"/>
        </svg>
    </div>
</template>

<script>
    export default {
        props: ['isReversed'],
    }
</script>