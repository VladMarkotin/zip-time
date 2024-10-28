<template>
    <v-dialog 
    v-model     = "isShowSetJobMark" 
    width="auto">
        <template #activator="{ on }">
            <v-tooltip top>
                <template v-slot:activator="{ on: tooltip  }">
                    <div class="selected_emoji_icon">
                        <v-img 
                        @click="toggleEmojiPicker"
                        v-on="tooltip"
                        :src="'/images/marks/normal_mark_icon.svg'"  
                        max-width="80px" 
                        max-height="80px" 
                        />
                    </div>
                </template>
                <span>Set mark</span>
            </v-tooltip>
        </template>
        <SetJobMarkCard v-if="isShowSetJobMark"/>
    </v-dialog>
</template>

<script>
    import SetJobMarkCard from './SetJobMarkCard.vue';
    export default {
        data() {
            return {
                isShowSetJobMark: false,
            };
        },
        components: {SetJobMarkCard},
        methods: {
            toggleEmojiPicker() {
                this.isShowSetJobMark = !this.isShowSetJobMark;
            }
        }
    }
</script>

<style scoped>
    .selected_emoji_icon {
        cursor: pointer;
        transition: all .3s ease;
        overflow: hidden;
    }

    .selected_emoji_icon:hover {
        transform: scale(1.05) rotate(5deg); 
    }
</style>