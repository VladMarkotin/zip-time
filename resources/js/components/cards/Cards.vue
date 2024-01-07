<template>
    <div>
        <div>{{title}}</div>
        <v-row>
            <v-col cols="6" v-for="item, i of items" v-bind:key="item.taskId">
                <Card 
                v-bind:item="item" 
                v-bind:num="i" 
                @updateItem="updateItems"
                />
            </v-col>
        </v-row>
    </div>
</template>
<script>
    import Card from './Card.vue'
    export default {
    props : ['title','items'],
    components : {Card},
    methods: {
        updateItems(newItem) {
            const newItems = [...this.items.map(item => {
                if (item.taskId !== newItem.taskId) return item;
                return newItem;
            })];
            this.$emit('updateItems', newItems);
        }
    }
    }
</script>