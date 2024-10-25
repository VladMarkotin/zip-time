<template>
    <v-menu v-model="emojiPickerMenu" offset-y>
        <template #activator="{ props }">
            <v-img 
            @click="emojiPickerMenu = true"
            src="/images/marks/sad_mark_icon.svg"  max-width="90px" max-height="90px"></v-img>
        </template>
        <v-card class="p-2 m-0">
            <v-btn-toggle color="white">
                <v-btn class="p-2">
                    <v-img src="/images/marks/sad_mark_icon.svg"  max-width="50px" max-height="50px"></v-img>
                </v-btn>
                <v-btn class="p-2">
                    <v-img src="/images/marks/sad_mark_icon.svg"  max-width="50px" max-height="50px"></v-img>
                </v-btn>
                <v-btn class="p-2">
                    <v-img src="/images/marks/sad_mark_icon.svg"  max-width="50px" max-height="50px"></v-img>
                </v-btn>
                <v-btn>
                    <v-img src="/images/marks/happy_mark_icon.svg"  max-width="50px" max-height="50px"></v-img>
                </v-btn>
            </v-btn-toggle>
        </v-card>
    </v-menu>
</template>

<script>
    export default {
        data() {
            return {
                emojiPickerMenu: false,
            }
        },
    }
</script>