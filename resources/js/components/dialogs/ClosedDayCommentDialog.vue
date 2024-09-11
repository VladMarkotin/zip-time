<template>
    <div>
        <div 
        @click="dialog = true"
        :style="`height: ${commentFieldHeight}`"
        class="comment-text-field"
        :class="{ 'editable-comment': isHovered }"
        @mouseover  = "isHovered = true"
        @mouseleave = "isHovered = false"
        >
            {{commentText}}
        </div>
        <v-dialog 
        v-model="dialog" 
        max-width="560px"
        :persistent = "!isCommentTextValid"
        :content-class="isMobile ? 'm-2' : ''"
        >
            <v-card 
            class="p-2 closed-day-comment-card">
                <v-textarea 
                :clearable = "!isMobile"
                clear-icon="mdi-close-circle"
                :success="isCommentTextValid"
                ref="commentTextarea"
                auto-grow
                solo
                outlined 
                :rules="commentTextareaRules"
                label   = "Enter your comment for the day"
                hide-details
                :value  = "newCommentText" 
                @input  = "editComment"
                />
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import store from '../../store';
import { mapGetters } from 'vuex/dist/vuex.common.js';
    export default {
        props: ['commentText', 'newCommentText', 'commentFieldHeight'],
        data() {
            return {
                isHovered: false,
                dialog: false,
                isCommentTextValid: true,
                COMMENT_MAX_LEN_CHARACT: 1024,
                commentTextareaRules: [
                    (inputVal) => {
                        inputVal = inputVal ? inputVal.trim().length : 0;
                        const maxLength = this.COMMENT_MAX_LEN_CHARACT;
                        return inputVal <= maxLength || `Maximum length is ${maxLength} characters`;
                    }
                ],
            }
        },
        store,
        emits: ['editComment', 'saveComment'],
        computed: {
            ...mapGetters(['getWindowScreendWidth']),
            isMobile() {
                return this.getWindowScreendWidth < 425;
            }
        },
        watch: {
            dialog(value) {
                if (value) {
                    this.$nextTick(() => {
                        this.setTextareaHeight();
                    });
                } else {
                    this.$emit('saveComment');
                }
            },
            newCommentText(value) {
                this.isCommentTextValid = this.commentTextareaRules.map(item => item(value))
                                          .every(checkResult => checkResult === true)
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
            },
            saveCommentMobile() {
                this.$emit('saveComment');
                this.dialog = false;
            },
        }
    }
</script>

<style scoped>
    .test {
        box-shadow: 4px 4px 12px black;
        padding: 6px;
    }
    .comment-text-field {
        box-sizing: border-box;
        padding: 12px;
        transition: box-shadow 0.3s ease;
        overflow-y: scroll;
        border-radius: 10px;
        border:  1px solid #e0e0e0;
        word-break: break-word;
        line-height: 24px;
    }

    .comment-text-field::-webkit-scrollbar {
        width: 12px;
    }

    .closed-day-comment-card::-webkit-scrollbar {
        width: 15px;
    }

    .comment-text-field::-webkit-scrollbar-thumb,
    .closed-day-comment-card::-webkit-scrollbar-thumb {
        background: #b0b0b0;
        border: solid 3px #e6e6e6;
        border-radius: 7px;
    }

    .comment-text-field::-webkit-scrollbar-thumb:hover,
    .closed-day-comment-card::-webkit-scrollbar-thumb:hover {
        background: #a10000;
    }
    
    .editable-comment:hover {
        cursor: pointer;
        box-shadow: 3px 3px 9px #e0e0e0;
    }

    .closed-day-comment-card {
        max-height: 80vh;
        overflow-y: auto;
    }
</style>