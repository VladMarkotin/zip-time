<template>
    <v-dialog
		v-model="isShowNotesDialog"
		scrollable
		width="auto"
		>
		<template v-slot:activator="{ props }">
			<div class="d-flex justify-space-between align-center">
				<v-btn
				icon
				v-bind="props"
				@click="showAddNotesDialog"
				:id="!num ? 'card-notes' : false"
				>
				<v-icon color="#D71700">{{icons.mdiNotebookEditOutline}}</v-icon>
				</v-btn>
				<span>
					{{ notesTodayAmount }}
				</span>
			</div>
		</template>
		<v-card
		width="400"
        >
				<v-card-title>Notes list</v-card-title>
				<!-- <v-divider></v-divider>
				<v-card-text style="height: 300px;">
					<template>
						<div class="d-flex align-center flex-column">
								<v-card
								width="800"
								title="This is a title"
								subtitle="This is a subtitle"
								text="This is content"
								v-model="notesList"
								v-for="(item, i) in notesList"
      							:key="i"
								>
								<v-card-title >
         								Note from {{ item.created_at }}
											</v-card-title>
								<v-card-text class="bg-white text--primary">
									<b>
										{{ item.note }}
									</b>
									<v-checkbox
										v-model="ex4[i]"
										label="red"
										color="red"
										value="red"
										hide-details
									></v-checkbox>
								</v-card-text>
								<v-divider v-if="item.created_at == new Date('d.m.Y')"></v-divider>

							</v-card>
							<span v-if="noteInfo.todayAmount == 0">
								There are no any notes
							</span>
						</div>
					</template>
				</v-card-text>
				<v-divider></v-divider>
				<v-card-actions>
				<v-btn
					color="blue-darken-1"
					variant="text"
					@click="dialogNotes = false"
				>
					Close
				</v-btn>
				<v-btn
					color="blue-darken-1"
					variant="text"
					@click="dialogNotes = false"
				>
					Save
				</v-btn>
				</v-card-actions> -->
			</v-card>
			</v-dialog> 
</template>

<script>
import { mdiNotebookEditOutline }  from '@mdi/js'
    export default {
        props: {
            num:  {},
            notesTodayAmount: {
                type: Number,
            },
            item: {
                type: Object,
                required: true,
            },
        },
        data() {
            return {
                isShowNotesDialog: false,
                icons: { mdiNotebookEditOutline},
            }
        },
        methods: {

            showAddNotesDialog() {
                this.isShowNotesDialog = true;
                this.getAllNotesForTask();
            },

            getAllNotesForTask() {
				/**query for getting all notes */
				axios.post('/get-saved-notes',{
                    task_id : this.item.taskId, 
                    hash:     this.item.hash
                })
				.then((response) => {
					this.updateNotesList(response.data); 
				})
			},

            getTodayNoteAmount(){
				
				axios.post('/get-today-note-amount',{
                    task_id : this.item.taskId,
                    details : this.item.details,
				    note :    this.item.notes,
                    type :    this.item.type})
				.then((response) => {
					this.updateNotesTodayAmount(response.data.amount); 
				  })

			},

            updateNotesTodayAmount(todayAmount) {
                this.$emit('updateNotesTodayAmount', todayAmount);
            },

            updateNotesList(notesList) {
                this.$emit('updateNotesList', notesList);
            }
        },

        created() {
            this.getTodayNoteAmount();
        }
    }
</script>