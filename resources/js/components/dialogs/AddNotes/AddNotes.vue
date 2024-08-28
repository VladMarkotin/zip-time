<template>
    <v-dialog
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
                    <v-btn
                    icon
                    v-bind="props"
                    @click="showAddNotesDialog"
                    :id="!num ? 'card-notes' : false"
                    >
                    <v-icon color="#D71700">{{icons.mdiNotebookEditOutline}}</v-icon>
                    </v-btn>
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
            :isLoading   = "isLoading"
            :taskId      = "item.taskId"
            :item        = "item"
            :screenWidth = "screenWidth"
            @closeAddNotesDialog = "closeAddNotesDialog"
            />
        </template>
	</v-dialog> 
</template>

<script>
import { mapActions, mapGetters } from 'vuex/dist/vuex.common.js';
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
            screenWidth: {
                type: Number,
            }
        },
        data() {
            return {
                isShowNotesDialog: false,
                icons: { mdiNotebookEditOutline},
                isLoading: false,
                minPreloaderDispTime: 500,
            }
        },
        store,
        components: {
            AddNotesCard,
        },
        computed: {
            ...mapGetters(['getNotesData']),
            notesTodayAmount() {
                const notesData = this.getNotesData(this.item.taskId);
                if (!notesData) {
                    return 0;
                }

                return notesData.length;
            }
        },
        methods: {
            ...mapActions(['fetchNotes']),
            showAddNotesDialog() {
                this.isShowNotesDialog = true;
                this.getAllNotesForTask();
            },

            async getAllNotesForTask() {
                const controllLoadingTime = (time, callback) => {
                    if (time > this.minPreloaderDispTime) callback();
				    else setTimeout(callback, this.minPreloaderDispTime - time);
			    }
                
                this.isLoading = true
                const loadingStart = Date.now();
                try {
                    const requestData = {
                        task_id : this.item.taskId, 
                        hash:     this.item.hash
                    };
                    await this.fetchNotes({requestData});

                    const loadingEnd = Date.now();

                    controllLoadingTime(loadingEnd - loadingStart, () => {
                        this.isLoading = false;
                    })
                } catch(error) {
                    console.error(error);
                }
			},

            closeAddNotesDialog() {
                this.isShowNotesDialog = false;
                // this.getTodayNoteAmount()
            }
        },
    }
</script>

<style>
    @import url('/css/AddNotes/AddNotesMedia.css');
</style>