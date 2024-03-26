<template>
    <v-dialog
		v-model="isShowNotesDialog"
		scrollable
		width="auto"
		>
		<template v-slot:activator="{ props }">
            <v-row class="p-0 m-0">
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
                        {{ notesTodayAmount }}
                    </span>
                </v-col>
            </v-row>
		</template>
		<template v-if="isShowNotesDialog">
            <AddNotesCard 
            :isLoading   = "isLoading"
            :notesList   = "notesList"
            :item        = "item"
            :screenWidth = "screenWidth"
            @updateNotesInfo     = "updateNotesInfo"
            @closeAddNotesDialog = "closeAddNotesDialog"
            />
        </template>
	</v-dialog> 
</template>

<script>
import AddNotesCard from './AddNotesCard.vue';
import { mdiNotebookEditOutline }  from '@mdi/js'
    export default {
        props: {
            num:  {},
            notesList: {
                type: Array,
                required: true,
            },
            notesTodayAmount: {
                type: Number,
            },
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
        components: {
            AddNotesCard,
        },
        methods: {

            showAddNotesDialog() {
                this.isShowNotesDialog = true;
                this.getAllNotesForTask();
            },

            getAllNotesForTask() {
                const controllLoadingTime = (time, callback) => {
				    if (time > this.minPreloaderDispTime) callback();
				    else setTimeout(callback, this.minPreloaderDispTime - time);
			    }

                this.isLoading = true
                const loadingStart = Date.now();

				/**query for getting all notes */
				axios.post('/get-saved-notes',{
                    task_id : this.item.taskId, 
                    hash:     this.item.hash
                })
				.then((response) => {
                    const loadingEnd = Date.now();

                    controllLoadingTime(loadingEnd - loadingStart, () => {
                        this.isLoading = false;

                        const notesList = response.data;
                        this.updateNotesInfo({notesList}); 
                    })

				})
			},

            getTodayNoteAmount(){
				axios.post('/get-today-note-amount',{
                    task_id : this.item.taskId,
                    details : this.item.details,
				    note :    this.item.notes,
                    type :    this.item.type})
				.then((response) => {
                    const todayAmount = response.data.amount;
					this.updateNotesInfo({todayAmount}); 
				  })

			},

            updateNotesInfo(dataObj) {
                this.$emit('updateNotesInfo', dataObj);
            },

            closeAddNotesDialog() {
                this.isShowNotesDialog = false;
            }
        },

        created() {
            this.getTodayNoteAmount();
        },
    }
</script>