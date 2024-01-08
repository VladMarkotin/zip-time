<template>  
	<v-card :id="!num ? 'card-wrapper' : false">
		<div class="card-demo">
			<template v-if="isShowAddHashCodeDialog">
				<AddHashCode 
				:width  		= "450"
				:hashCodeVal    = "newHashCodeData.newHashCode"
				:isShowDialog   = "isShowAddHashCodeDialog"
				:taskName       = "newHashCodeData.taskName"
				:time           = "newHashCodeData.time"
				:type           = "newHashCodeData.type"
				:priority       = "newHashCodeData.priority"
				:details        = "newHashCodeData.details"
				:notes          = "newHashCodeData.notes"
				:taskId 		=  "item.taskId"
				@close          = "closeHashCodeDialog"
				@addHashCode    = "renameHashCode"
				/>
			</template>
			<template v-if="isShowPreloader">
				<Preloader :showPreloader="isShowPreloader"/>
			</template>
			<div class="card-demo"></div>
		<v-card-title class="font-weight-bold justify-space-between v-card-title">
			<v-row class="m-0 p-0">
				<v-col 
				class="m-0 p-0 d-flex justify-content-start align-items-center"
				cols="auto"
				style="min-width: 88px;"
				>
					<v-row 
					class="m-0 p-0"
					v-if="hashCode == '#'"
					>
						<AddHashCodeButton 
						:buttonColor = "'white'"
						:buttonSize  = "26"
						@addHashCodeButtonClick="isShowAddHashCodeDialog = true"
						/>	
					</v-row>
					<v-row 
					class="m-0 p-0"
					v-else
					>
						<span class="p-0">{{ hashCode }}</span>
					</v-row>
				</v-col>
				<v-col class="m-0 p-0 d-flex justify-content-center align-items-center">
					<span>{{item.taskName}}</span>
				</v-col>
				<v-col 
				class="m-0 p-0 d-flex justify-content-end align-items-center"
				cols="auto"
				style="min-width: 22px;"
				>
					<span v-if="item.priority == 1"> </span>
					<span v-else-if="item.priority == 2">!</span>
					<span v-else-if="item.priority == 3">!!!</span>
					<span v-else>  </span>
				</v-col>
			</v-row>
		</v-card-title>
		</div>
		
		<v-list>
			<v-list-item>
				<v-list-item-content>Time:</v-list-item-content>
				<v-list-item-content class="align-end" v-if="item.time.includes('00:')">{{item.time}}
					 minutes
				</v-list-item-content>
                <v-list-item-content class="align-end" v-else-if="item.time.includes('01:00')">{{item.time}}
					 hour
				</v-list-item-content>
				<v-list-item-content class="align-end" v-else>{{item.time}}
					 hours
				</v-list-item-content>
				<v-dialog
					v-model="dialog"
					persistent
					width="500"
					>
					<template v-slot:activator="{ props }">
						<template>
							<EditButton 
							@click="dialog=true"
							/>
						</template>
					<!-- <v-btn icon @click="dialog=true"> тут пока не удалять
						<v-icon color="#D71700">{{icons.mdiPencil}}</v-icon>
					</v-btn> --> 
				</template>
					<v-card>
						<v-card-title class="text-h5">
						Edit card
						</v-card-title>
						<v-card-text>
							Edit task`s priority:
							
							<v-select
								:items="priorities"
								v-model= priority
								label="Set Priority"
								solo
							></v-select>
							 Edit task`s time: 
							 <v-time-picker
							   v-model="time"
							   color="red">
							</v-time-picker>
						</v-card-text>
						<v-card-actions>
						<v-spacer></v-spacer>
						<v-btn
							color="green-darken-1"
							variant="text"
							@click="dialog = false"
						>
							Cancel
						</v-btn>
						<v-btn
							color="green-darken-1"
							variant="text"
							@click="changeTime(item)"
						>
							Save
						</v-btn>
						</v-card-actions>
					</v-card>
					</v-dialog>
			</v-list-item>

			<v-list-item>
				<v-list-item-content>Details:</v-list-item-content>
				<v-list-item-content class="align-end">
					<v-textarea counter="256" rows="2" outlined shaped v-model="item.details"></v-textarea>
				</v-list-item-content>
				<template>
					<AddDetails 
					:num                = "num"
					:item               = "item"
					:details            = "details"
					:completedPercent   = "completedPercent"
					:detailsSortingCrit = "detailsSortingCrit"
					@updateDetails            = "updateDetails"
					@updateCompletedPercent   = "updateCompletedPercent"
					@updateDetailsSortingCrit = "updateDetailsSortingCrit"
					@resetSortingToDefVal     = "resetSortingToDefVal"
					/>
				</template>
				<template>
					<CreateSubplanGPT 
					:requestData="{
						label: 'Request: create subplan for',
						taskName: item.taskName,
						taskHash: item.hash,
						taskId: item.taskId,
					}"
					/>
				</template>
			</v-list-item>
			<v-list-item>
				<v-row class="p-0 m-0">
					<v-col class="p-0">
						<v-row class="p-0 m-0">
							<v-col class="p-0 d-flex">
								<v-list-item-content>Note:</v-list-item-content>
							</v-col>
							<v-col class="p-0">
								<v-list-item-content class="align-end">
									<v-textarea counter="256" rows="2" outlined shaped v-model="item.notes"></v-textarea>
								</v-list-item-content>	
							</v-col>
						</v-row>
					</v-col>
					<v-col class="p-0 d-flex flex-column justify-center" cols="auto" style="min-width: 53px;">
						<v-dialog
						v-model="dialogNotes"
						scrollable
						width="auto"
						>
						<template v-slot:activator="{ props }">
							<div class="d-flex justify-space-between align-center">
								<v-btn
								icon
								v-bind="props"
								@click="getAllNotesForTask(item)"
								:id="!num ? 'card-notes' : false"
								>
								<v-icon color="#D71700">{{icons.mdiNotebookEditOutline}}</v-icon>
								</v-btn>
								<span>
									{{ getTodayNoteAmount(item) }}
									{{ noteInfo.todayAmount }}
								</span>
							</div>
						</template>
						<v-card
									width="400"
									title="This is a title"
									subtitle="This is a subtitle"
									text="This is content">
								<v-card-title>Notes list</v-card-title>
								<v-divider></v-divider>
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
													  <v-divider v-if="item.created_at == new Date('d.m.Y').toString()"></v-divider>
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
								</v-card-actions>
							</v-card>
							</v-dialog> 
					</v-col>
				</v-row>	
			</v-list-item>
		</v-list>
		<v-divider></v-divider>
		<v-alert color="#404040" text class="elevation-1" v-bind:type="alert.type" v-if="isShowAlert">{{alert.text}}</v-alert>  
		<v-card-title class="font-weight-bold">
			<form class="d-flex align-center" :id="!num ? 'card-mark' : false">
				<template v-if="[4,3].includes(item.type)">
					<div>Mark</div>
					<v-text-field class="ml-1" style="width : 54px" v-model="item.mark" v-on:keypress.enter.prevent="sendMark(item)" 
					@focus="focusedInput=!focusedInput" @blur="focusedInput=!focusedInput">
						<v-icon slot="append">mdi-percent</v-icon>
					</v-text-field>
					
					<v-tooltip right>
						<template v-slot:activator="{on}">
							<v-btn icon v-on="on" v-on:click="sendMark(item)">
								<v-icon color="#D71700">{{icons.mdiUpdate}}</v-icon>
							</v-btn>
						</template>
						<span>Update</span>
					</v-tooltip>
					<span class="mark-info" v-if="focusedInput">Ratings` range 
						from {{ defaultConfigs.cardRules[0].minMark }}
					    to {{ defaultConfigs.cardRules[0].maxMark }}</span>
				</template>
				
				<template v-else-if="[2,1].includes(item.type)">
					<div>Ready?</div>
					<div @click="updateIsReadyState(item)">
						<v-checkbox color="#D71700"
						readonly
						v-model="isTaskReady"
						:true-value="isTaskReadyCheckboxTrueVal"
						:false-value="isTaskReadyCheckboxFalseVal"
						>
						</v-checkbox>
					</div>
					<v-tooltip right>
						<template v-slot:activator="{on}">
							<v-btn icon v-on="on" v-on:click="sendIsReadyState(item)">
								<v-icon color="#D71700">{{icons.mdiUpdate}}</v-icon>
							</v-btn>
						</template>
						<span>Update</span>
					</v-tooltip>
				</template>
			</form>
		</v-card-title>
	</div>
	</v-card>
</template>
<script>
	import {mdiUpdate, mdiPencil, mdiNotebookEditOutline,
		mdiMarkerCheck, mdiCircle, mdiMusicAccidentalSharp }  from '@mdi/js'  //mdiContentSaveCheckOutline
	import Alert from '../dialogs/Alert.vue'
	import AddHashCode from '../dialogs/AddHashCode.vue'
	import AddHashCodeButton from '../UI/AddHashCodeButton.vue';
	import Preloader from '../UI/Preloader.vue';
	import CreateSubplanGPT from '../dialogs/CreateSubplanGPT.vue'
	import AddDetails from '../dialogs/AddDetails/AddDetails.vue';
	import EditButton from '../UI/EditButton.vue';
	export default
	{
		props : ['item', 'num'],
		data()
		{
			return {
					icons      : {mdiMarkerCheck, mdiUpdate,mdiPencil, mdiNotebookEditOutline,
						mdiCircle, mdiMusicAccidentalSharp  }, //mdiContentSaveCheckOutline
			        path: {mdiMarkerCheck},
					isShowAlert: false ,
					alert      : {type: 'success', text: 'success'},
					isReady    : true,
					dialog     : false,  
					dialogEditSubTask : false, 
					subTaskTitle: false,
					dialogNotes: false,
					checked: true,
					time       : this.item.time,
					priority   : this.item.priority,
					priorities : [1,2,3], //['normal', 'important', 'super important']
					notesList  : null,
					id: this.item.id,
					done: 'v-card-done',
					completedPercent : 0,
					completedProgressBar: 0,
					focusedInput: false,
					details: [],
					detailsSortingDefaultVal: 'created-at-asc',
					detailsSortingCrit: 'created-at-asc',
					ex4: [],
					noteInfo: {
						todayAmount: 0
					},
					isShow : true,
					isShowAddHashCodeDialog : false,
					newHashCodeData: {
						newHashCode: '#',
						taskName: 	this.item.taskName,
						time: 		this.item.time,
						type: 		this.item.type,
						priority: 	this.item.priority,
						details: 	this.item.details,
						notes: 		this.item.notes,
					},
					hashCode: this.item.hash,
					isShowPreloader: false,
					defaultConfigs: {},
					isTaskReady: -1,
					isTaskReadyCheckboxTrueVal: 99,
					isTaskReadyCheckboxFalseVal: -1,
				}
			},
		components : {Alert, AddHashCode, AddHashCodeButton, Preloader, CreateSubplanGPT, AddDetails, EditButton},
		methods :
		{
			closeHashCodeDialog() {
      	   		this.isShowAddHashCodeDialog = false;
      		},
				
			updateDetails(details) {
				this.details = details;
				this.sortDetails();
			},

			updateCompletedPercent(compPercent) {
				this.completedPercent = compPercent;
			},

			updateDetailsSortingCrit(sortCritVal) {
				this.detailsSortingCrit = sortCritVal;
				this.sortDetails();
			},

			resetSortingToDefVal() {
				this.detailsSortingCrit = this.detailsSortingDefaultVal;
			},

			sortDetails() {
				if (this.details.length < 2) return;

				const formatDate = (date) => Date.parse(date.created_at_date);

				const sortByCreatedAt = (detailA, detailB, direction = 'asc') => {
						const detailADate = formatDate(detailA);
						const detailBDate = formatDate(detailB);

						switch (direction) {
							case 'asc':
								return detailADate - detailBDate 
							case 'desc':
								return detailBDate - detailADate;
							default:
								return detailADate - detailBDate 
						}
				}

				switch (this.detailsSortingCrit) {
					case 'created-at-asc':
						this.details.sort((detailA, detailB) => {
							return sortByCreatedAt(detailA, detailB, 'asc');
						});
					break;
					case 'created-at-desc':
						this.details.sort((detailA, detailB) => {
							return sortByCreatedAt(detailA, detailB, 'desc');
						});
					break;
					case 'is_ready-asc':
						this.details.sort((detailA, detailB) => {

							if (detailA.is_ready || detailB.is_ready) {
								if (detailA.is_ready && !detailB.is_ready) return -1;
								if (!detailA.is_ready && detailB.is_ready) return 1;

								return sortByCreatedAt(detailA, detailB, 'asc');
							} else {
								return sortByCreatedAt(detailA, detailB, 'asc');
							}
						});
					break;
					case 'unready-asc':
						this.details.sort((detailA, detailB) => {

						if (!detailA.is_ready || !detailB.is_ready) {
							if (!detailA.is_ready && detailB.is_ready) return -1;
							if (detailA.is_ready && !detailB.is_ready) return 1;

							return sortByCreatedAt(detailA, detailB, 'asc');
						} else {
							return sortByCreatedAt(detailA, detailB, 'asc');
						}
					});
					break;
					default:
						this.details.sort((detailA, detailB) => {
							return sortByCreatedAt(detailA, detailB, 'asc');
						});
					break;
				}
			},

			/*Notes*/

			getAllNotesForTask(item) {
				this.dialogNotes = true
				/**query for getting all notes */
				axios.post('/get-saved-notes',{task_id : item.taskId, hash: item.hash})
				.then((response) => {
					
					this.notesList = response.data
					console.log(this.notesList[0].created_at)
					
				  })
			},

			getTodayNoteAmount(item){
				
				axios.post('/get-today-note-amount',{task_id : item.taskId,details : item.details,
				            note : item.notes,type : item.type})
				.then((response) => {
					// console.log(response.data)
					this.noteInfo.todayAmount = response.data.amount //response.data.noteAmount
				  })

			},

			/**end */
			sendIsReadyState(item)
			{
				axios.post('/estimate',{task_id : item.taskId,details : item.details,note : item.notes, type : item.type})
				.then((response) => {
					if (response.data.status === 'success' && this.item.hash !== '#' && this.item.notes) {
						this.item.notes = '';
					}
					this.isShowAlert = true;
					this.setAlertData(response.data.status, response.data.message);
					setTimeout( () => {
						this.isShowAlert = false;
					},3000)
				  })
			},
			
			updateIsReadyState(item)
			{
				const getNewCheckboxVal = (oldVal) => {
					switch (oldVal) {
						case this.isTaskReadyCheckboxTrueVal:
							return this.isTaskReadyCheckboxFalseVal;
						break;
						case this.isTaskReadyCheckboxFalseVal:
							return this.isTaskReadyCheckboxTrueVal;
						break;
					}
				}
				axios.post('/estimate',{task_id : item.taskId,details : item.details,note : item.notes,
					is_ready : getNewCheckboxVal(this.isTaskReady),type : item.type})
				.then((response) => {
					if (response.data.status === 'success') {
						this.isTaskReady = getNewCheckboxVal(this.isTaskReady);
					}
					
					this.isShowAlert = true;
					this.setAlertData(response.data.status, response.data.message)
					setTimeout( () => {
						this.isShowAlert = false;
						console.log(this.isTaskReady);
					},3000)
				  })
			},
			
			sendMark(item)
			{	
				axios.post('/estimate',{task_id : item.taskId,details : item.details,note : item.notes,mark : item.mark,type : item.type})
				.then((response) => {
					this.isShowAlert = true;
					this.setAlertData(response.data.status, response.data.message)
					item.notes = ""
					this.noteInfo.todayAmount = response.data.noteAmount
					setTimeout( () => {
						this.isShowAlert = false;
					},3000)
				  })
			},
			
			setAlertData(type, text)
			{	
				this.alert.type = type
				this.alert.text = text
			},

			changeTime(item)
			{
				if ( (item.time != this.time ) || (item.priority != this.priority) ) {
					axios.post('/edit-card',{task_id : item.taskId, time : this.time, priority: this.priority}) // type : item.type
					.then((response) => {
						this.isShowAlert = true;
						
						if (response.data.status == 'success') {
							item.time = this.time
							item.priority = this.priority
							this.dialog = false
						}
						this.setAlertData(response.data.status, response.data.message)
						setTimeout( () => {
							this.isShowAlert = false;
						},3000)
				  })

				  	this.newHashCodeData = {...this.newHashCodeData, time: this.time, priority: this.priority.toString()};
				}
			},

			editHashCodeData() {
				if (typeof this.newHashCodeData.priority === 'number' ) {
					this.newHashCodeData.priority = this.newHashCodeData.priority.toString();
				}

				if (typeof this.newHashCodeData.type === 'number') {
					const checkType = (type) => {
						switch (type) {
							case 0:
								return 'reminder';
							case 1:
								return 'task';
							case 2:
								return 'required task';
							case 3:
								return 'non required job'
							case 4:
								return 'required job';
						}
					}

					this.newHashCodeData.type = checkType(this.newHashCodeData.type);
				}
			},

			renameHashCode(newHashCode) {
				this.hashCode = newHashCode;
			},
			getConfigs(data=null) {
				axios.post('/get-default-configs')
					.then((response) => {
						
						this.defaultConfigs = response.data
						this.defaultConfigs = JSON.parse(this.defaultConfigs[0].config_data)
						//console.log(this.defaultConfigs.cardRules[0].maxMark )
						
					  })
			},
		},

		created() {
			this.editHashCodeData();
			this.getConfigs(); 
		},
	}
	
</script>
<style scoped>
	.v-card-title
	{
		background-color : #A10000;
		color : white
	}
	
	.v-card-done {
		background-color: #ededed;
	}
	.v-progress-circular {
  		margin: 1rem;
	}
	.mark-info{
		font-size: 10px;
		font-family: Sans-serif;
	}
</style>