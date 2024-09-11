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
        :fullscreen = "isShowFullScreen" 
        v-model="dialog" 
        max-width="560px"
        :persistent = "!isCommentTextValid"
        >
            <v-card 
            v-if="!isShowFullScreen"
            class="p-2 closed-day-comment-card">
                <v-textarea 
                clearable 
                clear-icon="mdi-close-circle"
                :success="isCommentTextValid"
                ref="commentTextarea"
                auto-grow
                solo
                outlined 
                :rules="commentTextareaRules"
                label   = "comment"
                hide-details
                :value  = "newCommentText" 
                @input  = "editComment"
                />
            </v-card>
            <v-card
            v-else
            class="closed-day-comment-card d-flex flex-column justify-content-center"
            >
                <v-card-text style="height: 500px;" class="closed-day-comment_textarea-wrapper p-0">
                    <v-textarea 
                    class="closed-day-comment_textarea"
                    height="450px"
                    :clearable = "!isMobile"
                    clear-icon="mdi-close-circle"
                    :success="isCommentTextValid"
                    ref="commentTextarea"
                    solo
                    outlined 
                    :rules="commentTextareaRules"
                    label   = "comment"
                    hide-details
                    :value  = "newCommentText" 
                    @input  = "editComment"
                    />
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions class="p-0 d-flex justify-content-between">
                    <v-btn 
                    min-width="94px"
                    @click="cancel"
                    >
                        Cancel
                    </v-btn>
                    <v-btn 
                    min-width="94px"
                    @click="saveCommentMobile"
                    >
                        Save
                    </v-btn>
                </v-card-actions>
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
                isSaveCommentFlag: true,
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
            isShowFullScreen() {
                return this.getWindowScreendWidth < 768;
            },
            isMobile() {
                return this.getWindowScreendWidth < 425;
            }
        },
        watch: {
            dialog(value) {
                if (value && !this.isShowFullScreen) {
                    this.$nextTick(() => {
                        this.setTextareaHeight();
                    });
                } else if(this.isSaveCommentFlag) {
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
                this.isSaveCommentFlag = true;
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
            cancel() {
                this.$emit('editComment', this.commentText);
                this.isSaveCommentFlag = false;
                this.dialog = false;
            }
        }
    }
</script>

<style scoped>
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
    /*------------*/
    @media screen and (max-width: 768px)  {

        .closed-day-comment-card {
            box-sizing: border-box;
            max-height: 100vh;
            padding: 18px !important;
        }
    }

    @media screen and (max-width: 350px)  {
        .closed-day-comment-card {
            padding: 6px !important;
        }
    }
</style>