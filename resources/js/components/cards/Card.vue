<template>  
	<v-card>
		<v-card-title class="font-weight-bold justify-space-between v-card-title">
			<span>{{item.hash}}</span>
			<span>{{item.taskName}}</span>
			<span v-if="item.priority == 1"> </span>
			<span v-else-if="item.priority == 2">!</span>
			<span v-else-if="item.priority == 3">!!!</span>
			<span v-else>  </span>
		</v-card-title>
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
							>
							<v-icon color="#D71700">{{icons.mdiChartGantt}}</v-icon>
							</v-btn>
						</template>
						<v-card
									width="800"
									title="This is a title"
									subtitle="This is a subtitle"
									text="This is content">
								<v-card-title>Plan`s details</v-card-title>
								<v-divider></v-divider>
								<v-card-text style="height: 300px;">
									<template>
										<v-row>
											<v-col>

												<v-text-field
												width="20px"
												v-model="subTasks.title"
												:counter="10"
												label="Subtask title"
												required
												></v-text-field>
											</v-col>
											<v-col>

											<v-text-field
											width="20px"
											v-model="subTasks.text"
											:counter="256"
											label="Subtask details"
											required
											></v-text-field>
											</v-col>
											<v-col>

												<v-text-field
												width="20px"
												v-model="subTasks.position"
												hide-details
												single-line
												type="number"
												/>
											</v-col>
											<v-col>
												<v-text-field
												width="20px"
												v-model="subTasks.weight"
												hide-details
												single-line
												type="number"
												/>
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
												<v-expansion-panels>
													<v-expansion-panel
													v-for="(v, i) in details"
													:key="i"
													>
													<v-expansion-panel-header>
														{{v.title}}
														
														<v-btn icon v-on:click="deleteSubTask"> 
															<v-icon md="1"
																color="#D71700">
																{{icons.mdiDelete}}
															</v-icon>
														</v-btn>
													</v-expansion-panel-header>
													<v-expansion-panel-content>
														{{ v.text }}
														
													</v-expansion-panel-content>
													</v-expansion-panel>
												</v-expansion-panels>
												<v-btn icon
												v-on:click="createSubPlan"
												v-if="details.length > 0">
													<v-icon md="1"
													color="#D71700"
													> {{icons.mdiPlex}}
												</v-icon>
												</v-btn>
											</template>
										</v-row>
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
							<v-btn
							icon
							v-bind="props"
							@click="getAllNotesForTask(item)"
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
											</v-card>
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
			<form class="d-flex align-center">
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
	</v-card>
</template>
<script>
	import {mdiUpdate, mdiPencil, mdiNotebookEditOutline, mdiChartGantt, mdiPlex, mdiDelete } from '@mdi/js'  //mdiContentSaveCheckOutline
	import Alert from '../dialogs/Alert.vue'
	export default
	{
		props : ['item', 'num'],
		data()
		{
			return {
					icons      : {mdiUpdate,mdiPencil, mdiNotebookEditOutline, mdiChartGantt, mdiPlex, mdiDelete }, //mdiContentSaveCheckOutline
			        isShowAlert: false ,
					alert      : {type: 'success', text: 'success'},
					isReady    : true,
					dialog     : false,   
					dialogNotes: false,
					dialogDetails: false,
					checked: true,
					time       : this.item.time,
					priority   : this.item.priority,
					priorities : [1,2,3], //['normal', 'important', 'super important']
					notesList  : null,
					id: this.item.id,
					subTasks: {
						title: '',
						text: '',
						position:1,
						weight: 100,
						checkpoint: false,
						is_ready: false,
					},
					details: [],
					ex4: []
				}
			},
		components : {Alert},
		methods :
		{
			getAllDetailsForTask(item) {
				this.dialogDetails = true
			},

			addDetail(item){
				console.log(this.item.taskId)
				this.subTasks.task_id = this.item.taskId
				this.details.push(this.subTasks) 
				if (this.subTasks.length > 0) {

				}
			},

			createSubPlan(item){
				console.log(item.taskId)
				axios.post('/add-sub-task',{task_id : item.taskId, hash: item.hash, sub_plan: this.details})
				.then((response) => {
					this.isShowAlert = true;
					this.setAlertData(response.data.status, response.data.message)
					setTimeout( () => {
						this.isShowAlert = false;
						//debugger;
					},3000)
				  })
			},

			deleteSubTask(item){
				var index = this.details.indexOf(item)
            	this.details.splice(index, 1);
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
					//this.isShowAlert = true;
					this.notesList = response.data
					console.log(this.notesList[0].created_at)
					
					//this.setAlertData(response.data.status, response.data.message)
					/*setTimeout( () => {
						this.isShowAlert = false;
						//debugger;
					},3000)*/
				  })
			},
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
				console.log(item.priority)
				console.log(this.time)
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
			}
		}
	}
</script>
<style scoped>
	.v-card-title
	{
		background-color : #A10000;
		color : white
	}
</style>