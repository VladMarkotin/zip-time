<template>
    <v-dialog
        :fullscreen = "isMobile"
		v-model="isShowNotesDialog"
		scrollable
        content-class="addNotes-addNotes-dialog"
		width="auto"
		>
		<template v-slot:activator="{ props }">
            <v-row class="p-0 m-0 mt-2">
                <v-col 
                class="p-0 m-0 d-flex justify-content-end align-center"
                :cols="9"
                >
                <v-tooltip right>
                    <template v-slot:activator="{ on: tooltip  }">
                        <v-btn
                        icon
                        v-on="tooltip"
                        v-bind="props"
                        @click="showAddNotesDialog"
                        :id="!num ? 'card-notes' : false"
                        >
                        <v-icon color="#D71700">{{icons.mdiNotebookEditOutline}}</v-icon>
                        </v-btn>
                    </template>
                    <span>Show notes</span>
                </v-tooltip>
                </v-col>
                <v-col
                class="p-0 m-0 d-flex justify-content-end align-center"
                :cols=3
                >
                    <span>
                        {{notesTodayAmount}}
                    </span>
                </v-col>
            </v-row>
		</template>
		<template v-if="isShowNotesDialog">
            <AddNotesCard 
            :taskId      = "item.taskId"
            :item        = "item"
            @closeAddNotesDialog = "closeAddNotesDialog"
            />
        </template>
	</v-dialog> 
</template>

<script>
import { mapGetters } from 'vuex/dist/vuex.common.js';
import store from '../../../store';
import AddNotesCard from './AddNotesCard.vue';
import { mdiNotebookEditOutline }  from '@mdi/js'
    export default {
        props: {
            num:  {},
            item: {
                type: Object,
                required: true,
            },
        },
        data() {
            return {
                isShowNotesDialog: false,
                icons: { mdiNotebookEditOutline},
                minPreloaderDispTime: 500,
            }
        },
        store,
        components: {
            AddNotesCard,
        },
        computed: {
            ...mapGetters(['getNotesData', 'getWindowScreendWidth']),
            notesTodayAmount() {
                const notesData = this.getNotesData(this.item.taskId);
                if (!notesData) {
                    return 0;
                }

                return notesData.length;
            },
            isMobile() {
                return this.getWindowScreendWidth < 768;
            }
        },
        methods: {
            showAddNotesDialog() {
                this.isShowNotesDialog = true;
            },

            closeAddNotesDialog() {
                this.isShowNotesDialog = false;
            }
        },
    }
    
</script>

<style>
    @import url('/css/AddNotes/AddNotesMedia.css');
   
</style>