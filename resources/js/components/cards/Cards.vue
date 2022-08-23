<template>
    <div>
        <div>{{title}}</div>
        <v-row>
            <v-col cols="6" v-for="item, i of items" v-bind:key="item.taskId">
                <Card v-bind:item="item" v-bind:num="i" />
            </v-col>
        </v-row>
    </div>
</template>
<script>
    import Card from './Card.vue'
    export default {components : {Card},props : ['title','items']}
</script>