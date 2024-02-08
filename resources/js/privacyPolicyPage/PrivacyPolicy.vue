<template>
    <div class="inner-block">
        <div class="privacy-policy-container">
            <v-navigation-drawer 
            width="330"
            >
                <v-list>
                    <v-list-item v-for="(text, index) in text" :key="index" @click="scrollToSection(item)">
                        <v-list-item-title>{{`${index + 1}. ${text.title}`}}</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>
            <div>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
                <p>112</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                text: [
                    {title: 'Introduction'},
                    {title: 'Interpretation and Definitions'},
                    {title: 'Collecting and Using Your Personal Data'},
                    {title: 'Children\'s Privacy'},
                    {title: 'Links to Other Websites'},
                    {title: 'Changes to this Privacy Policy'},
                    {title: 'Contact Us'},
                ]
            }
        }
    }
</script>

<style scoped>
      @import url('/css/privacyPolicyPage/privacyPolicyPage.css');
</style>