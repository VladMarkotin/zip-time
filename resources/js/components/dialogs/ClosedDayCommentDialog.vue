<template>
    <div>
        <div 
        style="min-height: 70px;"
        @click="dialog = true"
        class="comment-text-field"
        :class="{ 'editable-comment': isHovered }"
        @mouseover  = "isHovered = true"
        @mouseleave = "isHovered = false"
        >
            {{commentText}}
        </div>
        <v-dialog v-model="dialog" max-width="500px">
            <v-card class="p-2 closed-day-comment-card">
                <v-textarea
                ref="commentTextarea"
                auto-grow
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
            if (value) {
                this.$nextTick(() => {
                    this.setTextareaHeight();
                });
            } else {
                this.$emit('saveComment');
            }
        }
    },
        methods: {
            editComment(value) {
                this.$emit('editComment', value);
            },
            setTextareaHeight() {
            const textarea = this.$refs.commentTextarea?.$el.querySelector('textarea');
            if (textarea) {
                textarea.style.height = 'auto';
                textarea.style.height = `${textarea.scrollHeight}px`;
            }
        }
        }
    }
</script>

<style scoped>
    .comment-text-field {
        box-sizing: border-box;
        padding: 4px;
        transition: box-shadow 0.3s ease;
        max-height: 150px;
        overflow-y: scroll;
    }

    .comment-text-field::-webkit-scrollbar {
        width: 12px;
    }

    .comment-text-field::-webkit-scrollbar-thumb {
        background: #b0b0b0;
        border: solid 3px #e6e6e6;
        border-radius: 7px;
    }

    .comment-text-field::-webkit-scrollbar-thumb:hover {
        background: #a10000;
    }
    
    .editable-comment:hover {
        cursor: pointer;
        box-shadow: 0 0 0 2px black;
    }

    .closed-day-comment-card {
        max-height: 80vh;
        overflow-y: auto;
    }
</style>