<template>
    <div>
        <div>{{title}}</div>
        <v-row>
            <v-col cols="6" v-for="item of items" v-bind:key="item.taskId">
                <CardComponent v-bind:item="item"></CardComponent>
            </v-col>
        </v-row>
    </div>
</template>
<script>
    import CardComponent from './CardComponent.vue'
    export default {components : {CardComponent},props : ['title','items']}
</script>