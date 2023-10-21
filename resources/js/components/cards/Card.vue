<template>  
	<v-card :id="!num ? 'card-wrapper' : false">
		<div class="card-demo">

			<div class="card-demo"></div>
		<v-card-title class="font-weight-bold justify-space-between v-card-title">
			<span>{{item.hash}}</span>
			<span>{{item.taskName}}</span>
			<span v-if="item.priority == 1"> </span>
			<span v-else-if="item.priority == 2">!</span>
			<span v-else-if="item.priority == 3">!!!</span>
			<span v-else>  </span>
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
					<v-btn icon @click="dialog=true">
						<v-icon color="#D71700">{{icons.mdiPencil}}</v-icon>
					</v-btn>
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
				<v-dialog
						v-model="dialogDetails"
						scrollable
						width="auto"
						>
						<template v-slot:activator="{ props }">
							<v-btn
							icon
							v-bind="props"
							@click="getAllDetailsForTask(item)"
							:id="!num ? 'card-details' : false"
							>
							<v-icon color="#D71700">{{icons.mdiChartGantt}}</v-icon>
							</v-btn>
						</template>
						<v-card
									width="800"
									title="This is a title"
									subtitle="This is a subtitle"
									text="This is content">
								<v-card-title>
									<v-row>
										<v-col >
											<p class="text-xs-center">Plan`s details</p>
										</v-col>
										<v-col>
											<v-progress-circular
											:rotate="360"
											:size="100"
											:width="10"
											:model-value="completedPercent"
											color="red"
											:value="completedPercent"
											>
											{{ completedPercent }}
										</v-progress-circular>
										</v-col>
									</v-row>
								</v-card-title>
								<v-divider></v-divider>
								<v-card-text style="height: 300px;">
									<template>
										<v-row>
											<v-col>

												<v-text-field
												width="20px"
												v-model="subTasks.title"
												:counter="256"
												label="Subtask title"
												v-on:keyup.enter="addDetail"
												required
												></v-text-field>
											</v-col>
											<v-col>

											<v-text-field
											width="20px"
											v-model="subTasks.text"
											v-on:keyup.enter="addDetail"
											:counter="1000"
											label="Subtask details"
											required
											></v-text-field>
											</v-col>
											
											<v-col>
												<v-checkbox
												 label="is required subtask?"
												 v-model="subTasks.checkpoint">
												</v-checkbox>
											</v-col>
											<v-col>
												<v-btn icon>
													<v-icon md="1"
													color="#D71700"
													v-on:click="addDetail(item)"> {{icons.mdiPlex}}
												</v-icon>
											</v-btn>
											</v-col>
										
										</v-row>
										<v-divider></v-divider>
										<v-row>

											<template>
												<!--Display subTask-->
												<v-expansion-panels>
													<v-expansion-panel
													v-for="(v, i) in details"
													:key="i"
													>
													<v-expansion-panel-header
													>
													<p class="text-md-center">{{v.title}} </p> 
														<v-icon color="#D71700" v-if="v.checkpoint == 1">
															{{ icons.mdiExclamation }}
															
														</v-icon>	
														<v-btn icon @click="editTask(v)">
															<v-icon color="#D71700">{{icons.mdiPencil}}</v-icon>
														</v-btn>
														<v-icon color="#D71700" v-if="v.is_ready">
															{{icons.mdiMarkerCheck}}
														</v-icon>
													</v-expansion-panel-header>
													<v-expansion-panel-content v-bind:class="{ done: v.is_ready }">
														<v-divider></v-divider>
														{{ v.text }}
														<v-row>
															<v-col>

																<v-checkbox
																	v-model="v.is_ready"
																	label="Is Ready?"
																	color="red"
																	@change="completed(v)"
																	hide-details
																></v-checkbox>
															</v-col>
															<v-col>

																<v-btn icon v-on:click="deleteSubTask(v)"
																v-if="v.checkpoint != 1"> 
																	<v-icon md="1"
																		color="#D71700">
																		{{icons.mdiDelete}}
																	</v-icon>
																</v-btn>
															</v-col>
														</v-row>
													</v-expansion-panel-content>
													
												</v-expansion-panel>
												</v-expansion-panels>
											</template>
										</v-row>
									</template>
								</v-card-text>
								<v-alert color="#404040" text class="elevation-1" v-bind:type="alert.type" v-if="isShowAlertInDetails">{{alert.text}}</v-alert> 
								<v-divider></v-divider>
								<v-card-actions>
									<v-row>
										<v-col>

											<v-btn
											color="blue-darken-1"
											variant="text"
											@click="dialogDetails = false"
											>
											Close
											</v-btn>
										</v-col>
										
									</v-row>
								</v-card-actions>
						</v-card>
				</v-dialog> 
				<v-dialog
					v-model="dialogEditSubTask"
					persistent
					width="500"
					>
					
					<v-card>
						<v-card-title class="text-h5">
						Edit Subtask
						</v-card-title>
						<v-card-text>
							Edit Subtask`s title:
							<v-text-field class="ml-1"  v-model="subTasks.title">
								
							</v-text-field>
							Edit Subtask`s text:
							<v-text-field class="ml-1"  v-model="subTasks.text">
								
							</v-text-field>
							
						</v-card-text>
						<v-card-actions>
						<v-spacer></v-spacer>
						<v-btn
							color="green-darken-1"
							variant="text"
							@click="dialogEditSubTask = false"
						>
							Cancel
						</v-btn>
						<v-btn
							color="green-darken-1"
							variant="text"
							@click="saveChangesInSubtask({title: subTasks.title, text: subTasks.text})"
						>
							Save
						</v-btn>
						</v-card-actions>
					</v-card>
					</v-dialog>		
				
			</v-list-item>
			<v-list-item>
				<v-list-item-content>Note:</v-list-item-content>
				
				<v-list-item-content class="align-end">
					<v-textarea counter="256" rows="2" outlined shaped v-model="item.notes"></v-textarea>
				</v-list-item-content>
				
						<v-dialog
						v-model="dialogNotes"
						scrollable
						width="auto"
						>
						<template v-slot:activator="{ props }">
							<span>
								{{ getTodayNoteAmount(item) }}
								{{ noteInfo.todayAmount }}
							</span>
							<v-btn
							icon
							v-bind="props"
							@click="getAllNotesForTask(item)"
							:id="!num ? 'card-notes' : false"
							>
							<v-icon color="#D71700">{{icons.mdiNotebookEditOutline}}</v-icon>
							
						</v-btn>
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
					
			</v-list-item>
		</v-list>
		<v-divider></v-divider>
		<v-alert color="#404040" text class="elevation-1" v-bind:type="alert.type" v-if="isShowAlert">{{alert.text}}</v-alert>  
		<v-card-title class="font-weight-bold">
			<form class="d-flex align-center" :id="!num ? 'card-mark' : false">
				<template v-if="[4,3].includes(item.type)">
					<div>Mark</div>
					<v-text-field class="ml-1" style="width : 54px" v-model="item.mark" v-on:keypress.enter.prevent="sendMark(item)">
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
				</template>
				
				<template v-else-if="[2,1].includes(item.type)">
					<div>Ready?</div>
					<v-checkbox color="#D71700" 
					@change="updateIsReadyState(item)"
					v-model="item.is_ready"
					@input="checked = $event.target.checked"
					:true-value=99
					:false-value=-1
					>
					</v-checkbox>
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
	import {mdiUpdate, mdiPencil, mdiNotebookEditOutline, mdiChartGantt, mdiPlex, mdiDelete,
		mdiMarkerCheck, mdiExclamation, mdiCircle }  from '@mdi/js'  //mdiContentSaveCheckOutline
	import Alert from '../dialogs/Alert.vue'
	export default
	{
		props : ['item', 'num'],
		data()
		{
			return {
					icons      : {mdiMarkerCheck, mdiUpdate,mdiPencil, mdiNotebookEditOutline,
						 mdiChartGantt, mdiPlex, mdiDelete, mdiExclamation,mdiCircle  }, //mdiContentSaveCheckOutline
			        path: {mdiMarkerCheck},
					isShowAlert: false ,
					isShowAlertInDetails: false,
					alert      : {type: 'success', text: 'success'},
					isReady    : true,
					dialog     : false,  
					dialogEditSubTask : false, 
					subTaskTitle: false,
					dialogNotes: false,
					dialogDetails: false,
					checked: true,
					time       : this.item.time,
					priority   : this.item.priority,
					priorities : [1,2,3], //['normal', 'important', 'super important']
					notesList  : null,
					id: this.item.id,
					done: 'v-card-done',
					completedPercent : 0,
					completedProgressBar: 0,
					subTasks: {
						title: '',
						text: '',
						position:1,
						weight: 100,
						checkpoint: false,
						is_ready: false,
					},
					createdSubTasks: {
						title: '',
						text: '',
						position:1,
						weight: 100,
						checkpoint: false,
						is_ready: false,
					},
					details: [],
					ex4: [],
					noteInfo: {
						todayAmount: 0
					}
				}
			},
		components : {Alert},
		methods :
		{
			mounted ()
			{

			},
			testFunction(v, event){
				console.log(event)
			},

			getAllDetailsForTask(item) {
				this.dialogDetails = true
				axios.post('/get-sub-tasks',{task_id : item.taskId})
				.then((response) => {
					this.details = []
					response.data.data.forEach(element => {
						this.details.push({
							title: element.title,
							text:  element.text,
							taskId: element.id,
							is_ready: element.is_ready, 
							checkpoint: element.checkpoint
						}) 
					});
					this.completedPercent = response.data.completedPercent
					//console.log(this.details)
					this.setAlertData(response.data.status, response.data.message)
				  })
			},

			addDetail(item){
				//console.log(item.taskId)
				this.subTasks.task_id = this.item.taskId
				this.details.push(this.subTasks) 
				this.createSubPlan(this.subTasks)
				this.subTasks = {};
			},

			createSubPlan(item){
				axios.post('/add-sub-task',{task_id : item.taskId, hash: item.hash, sub_plan: item})
				.then((response) => {
					//console.log(response)
					this.isShowAlertInDetails = true;
					this.setAlertData(response.data.elements, response.data.message)
					this.completedPercent = response.data.completedPercent
					item.taskId = response.data.taskId
					setTimeout( () => {
						this.isShowAlertInDetails = false;
						//debugger;
					},3000)
				  })
				  .catch(function (error) {
					console.log(error)
				  })
			},

			deleteSubTask(item){
				var index = this.details.indexOf(item)
				console.log(item)
				axios.post('/del-sub-task',{task_id : item.taskId})
				.then((response) => {
					//this.isShowAlert = true;
					console.log(this.details)
					this.setAlertData(response.data.status, response.data.message)
					this.details.splice(index, 1);
					this.completedPercent = response.data.completedPercent
				})
			},

			completed(item){
				var index = this.details.indexOf(item)
				axios.post('/complete-sub-task',{task_id : item.taskId})
				.then((response) => {
					//this.isShowAlert = true;
					console.log(this.details)
					this.completedPercent = response.data.completedPercent
					this.setAlertData(response.data.status, response.data.message)
					//this.details.splice(index, 1);
				})
			},

			saveNotes(){
				axios.post('/add-sub-task',{task_id : item.taskId,details : item.details,note : item.notes,/*is_ready : 0,*/type : item.type})
				.then((response) => {
					this.isShowAlert = true;
					this.setAlertData(response.data.status, response.data.message)
					setTimeout( () => {
						this.isShowAlert = false;
						//debugger;
					},3000)
				  })
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
				
				axios.post('/get-today-note-amount',{task_id : item.taskId,details : item.details,note : item.notes,type : item.type})
				.then((response) => {
					console.log(response.data)
					this.noteInfo.todayAmount = response.data.amount //response.data.noteAmount
				  })

			},

			/**end */
			sendIsReadyState(item)
			{
				axios.post('/estimate',{task_id : item.taskId,details : item.details,note : item.notes,/*is_ready : 0,*/type : item.type})
				.then((response) => {
					this.isShowAlert = true;
					this.setAlertData(response.data.status, response.data.message)
					setTimeout( () => {
						this.isShowAlert = false;
						//debugger;
					},3000)
				  })
			},
			updateIsReadyState(item)
			{
				axios.post('/estimate',{task_id : item.taskId,details : item.details,note : item.notes,is_ready : item.is_ready,type : item.type})
				.then((response) => {
					this.isShowAlert = true;
					this.setAlertData(response.data.status, response.data.message)
					setTimeout( () => {
						this.isShowAlert = false;
						console.log(item.is_ready)
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
			toggleAlertDialog()
			{
				this.isShowAlert = !this.isShowAlert
			},
			
			setAlertData(type,text)
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
				}
			},
			
			editTask(item) {
				this.dialogEditSubTask = true
				this.subTasks.task_id = item.taskId
				this.subTasks.title = item.title
				this.subTasks.text = item.text
				console.log(item)
			},
			saveChangesInSubtask(item){
				//this.subTasks.task_id = item.taskId
				this.subTasks.title = item.title
				this.subTasks.text = item.text		
						
				axios.post('/edit-subtask',{id : this.subTasks.task_id , title : this.subTasks.title , text: this.subTasks.text }) // type : item.type
					.then((response) => {
						
						if (response.data.status == 'success') {
							item.title = this.subTasks.title
							item.text = this.subTasks.text
							this.dialogEditSubTask = false
							this.dialog = false
						}
						this.setAlertData(response.data.status, response.data.message)
						setTimeout( () => {
							this.isShowAlert = false;
						},3000)
				  })
				this.subTasks = {};
			},
		}
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
</style>