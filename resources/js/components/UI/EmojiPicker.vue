<template>
    <v-menu 
    v-model="emojiPickerMenu" 
    offset-y transition="scale-transition">
        <template #activator="{ on }">
            <v-tooltip right>
                <template v-slot:activator="{ on: tooltip  }">
                    <div class="selected_emoji_icon">
                        <v-img 
                        @click="emojiPickerMenu = true"
                        :src="selectedEmoji"  
                        v-on="tooltip"
                        max-width="80px" 
                        max-height="80px" 
                        />
                    </div>
                </template>
                <span>Set mark</span>
            </v-tooltip>
        </template>
        <v-card 
        class="p-2 m-0 d-flex flex-column align-items-center" 
        >
        <v-tabs 
        :value="value"
        @change="updateValue" 
        >
            <v-tooltip 
            bottom 
            v-for="(data, idx) in emojiTabsData" 
            :key="idx"
            >
                <template v-slot:activator="{ on: tooltip  }">
                    <v-tab 
                    :tab-value = "data.mark"
                    v-on="tooltip"
                    >
                        <v-img 
                        :src="`/images/marks/${data.iconName}`"  
                        max-width="40px" 
                        max-height="40px" 
                        />
                    </v-tab>
                </template>
                <span>{{ data.toopltipText }}</span>
            </v-tooltip>
            <v-tabs-slider color="red"></v-tabs-slider>
        </v-tabs>
        </v-card>
    </v-menu>
</template>

<script>
    export default {
        props: {
            taskId: {
                type: Number,
                required: true,
            },
            value: {
                type: Number,
                required: true,
            },
        },
        data() {
            return {
                emojiPickerMenu: false,
                emojiTabsData: [
                    {iconName: 'bad_mark_icon.svg', mark: 0, toopltipText: 'bad'},
                    {iconName: 'normal_mark_icon.svg', mark: 50, toopltipText: 'normal'},
                    {iconName: 'good_mark_icon.svg', mark: 99, toopltipText: 'good'},
                ],
            }
        },
        emits: ['input', 'sendMark'],
        computed: {
            selectedEmoji() {
                const {iconName} = this.emojiTabsData.find(data => data.mark === this.value);
                
                return `/images/marks/${iconName}`;
            },
        },
        methods: {
            updateValue(mark) {
                this.$emit('input', mark);
                this.$emit('sendMark');
            },
        },
        
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