<template>
    <div>
        <div 
        style="min-height: 70px;"
        @click="dialog = true"
        :class="{ 'editable-comment': isHovered }"
        @mouseover  = "isHovered = true"
        @mouseleave = "isHovered = false"
        >
            {{commentText}}
        </div>
        <v-dialog v-model="dialog" max-width="500px">
            <v-card class="p-2">
                <v-textarea
                solo
                outlined 
                label   = "comment"
                hide-details
                :value  = "commentText" 
                @input  = "editComment"
                />
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
    export default {
        props: ['commentText'],
        data() {
            return {
                isHovered: false,
                dialog: false,
            }
        },
        emits: ['editComment'],
        watch: {
            dialog(value) {
                if (!value) this.$emit('saveComment');
            }
        },
        methods: {
            editComment(value) {
                this.$emit('editComment', value);
            }
        }
    }
</script>

<style scoped>
    .editable-comment {
        cursor: pointer;
        transition: box-shadow 0.3s ease;
    }

    .editable-comment:hover {
        box-shadow: 0 0 0 2px black;
    }
</style>