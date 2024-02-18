<template>  

	<v-card :id="!num ? 'card-wrapper' : false" :class="`${isCurrentTaskReady} card-wrapper`">
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
				:taskId 		=  "item.taskId"
				@close          = "closeHashCodeDialog"
				@addHashCode    = "createUnsavedTaskSaved"
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
				<v-col class="m-0 p-0 d-flex justify-content-center align-items-center task-name-wrapper">
					<span v-if="!isTaskNameLong" class="task-name">{{ item.taskName }}</span>
					<span 
					v-else
					class="task-name task-name-truncated"
					@mouseenter="maxTaskNameLen.forRender = 255"
					@mouseleave="maxTaskNameLen.forRender = maxTaskNameLen.default"
					>
						{{truncatedTaskName}}
					</span>
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
				<EditCardData 
				:currentTaskPriority = "item.priority"
				:currentTaskTime     = "item.time"
				@saveChanges = "changeTime"
				/>
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
					@resetDayMarkToDefVal     = "resetDayMarkToDefVal"
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
						<template
						v-if="item.hash !== '#'"
						>
							<AddNotes 
							:num              = "num"
							:item             = "item"
							:notesTodayAmount = "noteInfo.todayAmount"
							:notesList        = "noteInfo.notesList"  
							@updateNotesInfo  = "setNotesInfo"
							/>
						</template>
					</v-col>
				</v-row>	
			</v-list-item>
		</v-list>
		<v-divider class="m-2"></v-divider>
		<div style="min-height: 60px;">
			<v-alert color="#404040" text class="elevation-1" v-bind:type="alert.type" v-if="isShowAlert">{{alert.text}}</v-alert>  
		</div>
		<v-card-title class="font-weight-bold pt-0">
			<v-row class="p-0 m-0">
				<v-col class="p-0 m-0" cols="auto">
					<form 
					class="d-flex align-center gap-1" 
					:id="!num ? 'card-mark' : false"
					>
						<template v-if="[4,3].includes(item.type)">
							<div>Mark</div>
							<v-text-field 
							class="ml-1" 
							style="width : 54px" 
							v-model="jobMarkInputValue" 
							v-on:keypress.enter.prevent="sendMark(item)" 
							@keypress = "filterJobMarkInputValue($event, item.taskId)"
							@focus    = "focusedInput=!focusedInput" 
							@blur     = "focusedInput=!focusedInput"
							>
								<v-icon slot="append">mdi-percent</v-icon>
							</v-text-field>
							
							<v-tooltip right>
								<template v-slot:activator="{on}">
									<v-btn 
									:class="{'button-attention' : isShowUpdateCardNotification}"
									icon
									v-on="on" 
									v-on:click="sendMark(item)"
									>
										<v-icon color="#D71700">{{icons.mdiUpdate}}</v-icon>
									</v-btn>
								</template>
								<span>Update</span>
							</v-tooltip>
							
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
				</v-col>
				<v-col class="p-0 m-0 d-flex align-center" style="width: 100%;">
					<transition
					enter-active-class="notification_appearance"
					leave-active-class="notification_leave"
					mode="out-in"
					>
						<div
						v-if="isShowUpdateCardNotification"
						style="width: inherit;"
						class="d-flex justify-content-center"
						key="updante-card-not"
						>
							<span 
							class="update-card-notification" 
							>
								Don't forget to save your mark!
							</span>
						</div>
						<span 
						v-if="focusedInput && !isShowUpdateCardNotification"
						class="mark-info" 
						key="rating-range"
						>Ratings` range 
							from {{ defaultConfigs.cardRules[0].minMark }}
							to {{ defaultConfigs.cardRules[0].maxMark }}
						</span>
					</transition>
				</v-col>
			</v-row>
		</v-card-title>
	</div>
	</v-card>
</template>
<script>
	import {mdiUpdate, mdiPencil,
		mdiMarkerCheck, mdiCircle, mdiMusicAccidentalSharp }  from '@mdi/js'  //mdiContentSaveCheckOutline
	import Alert from '../dialogs/Alert.vue'
	import AddHashCode from '../dialogs/AddHashCode.vue'
	import AddHashCodeButton from '../UI/AddHashCodeButton.vue';
	import Preloader from '../UI/Preloader.vue';
	import CreateSubplanGPT from '../dialogs/CreateSubplanGPT.vue'
	import AddDetails from '../dialogs/AddDetails/AddDetails.vue';
	import AddNotes from '../dialogs/AddNotes/AddNotes.vue';
	import EditCardData from '../dialogs/EditCardData.vue';
	export default
	{
		props : ['item', 'num'],
		data()
		{
			return {
					icons      : {mdiMarkerCheck, mdiUpdate,mdiPencil,
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
					// priorities : [1,2,3], //['normal', 'important', 'super important']
					id: this.item.id,
					done: 'v-card-done',
					completedPercent : 0,
					completedProgressBar: 0,
					focusedInput: false,
					isShowUpdateCardNotification: false,
					details: [],
					detailsSortingDefaultVal: 'created-at-asc',
					detailsSortingCrit: 'created-at-asc',
					ex4: [],
					noteInfo: {
						todayAmount: 0,
						notesList:   new Array,
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
					},
					hashCode: this.item.hash,
					isShowPreloader: false,
					defaultConfigs: {},
					isTaskReady: this.item.is_ready,
					jobMarkInputValue: String(this.item.mark),
					isTaskReadyCheckboxTrueVal: 99,
					isTaskReadyCheckboxFalseVal: -1,
					maxTaskNameLen: {
						default: 50,
						forRender: 50,
					},
				}
			},
		components : {
			Alert, 
			AddHashCode, 
			AddHashCodeButton, 
			Preloader, 
			CreateSubplanGPT, 
			AddDetails,
			AddNotes, 
			EditCardData,
		},
		computed: {
			isCurrentTaskReady() {
				const {type} = this.item;

				const checkTask = (data) => {
					const {type, mark} = data;
					const cardRules = this.defaultConfigs.cardRules;

					if (cardRules) {
						const maxMark = +cardRules[0].maxMark;
						const minMark = +cardRules[0].minMark;
						switch (type) {
							case 'task':
								return mark === 99 //хардкод
									? 'card-wrapper_ready'
									: 'card-wrapper_unready';
							case 'job':
								return mark >= minMark && mark <= maxMark
									? 'card-wrapper_ready'
									: 'card-wrapper_unready';
							default:
								return 'card-wrapper_unready';
						}
					}

				}
				
				switch(type) {
					case 1:
					case 2:
						return checkTask({type: 'task', mark: this.isTaskReady});
					break;
					case 3:
					case 4:
						return checkTask({type: 'job', mark: this.item.mark});
					break;
					default:
						return 'card-wrapper_unready';
				}

				
			},

			truncatedTaskName() {
				const {taskName} = this.item;

				if (taskName.length > this.maxTaskNameLen.forRender) {
					return taskName.slice(0, this.maxTaskNameLen.forRender) + '...';
				}

				return taskName;
			},

			isTaskNameLong() {
				return this.item.taskName.length > this.maxTaskNameLen.default;
			}
		}, 
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

			resetDayMarkToDefVal() {
				const currentTaskType = this.item.type;
				
				if ([1,2].includes(currentTaskType)) {
					this.isTaskReady = this.isTaskReadyCheckboxFalseVal;
				}

				if ([3,4].includes(currentTaskType)) {
					this.jobMarkInputValue = '';
				}
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

			setNotesInfo(data) {
				Object.assign(this.noteInfo, data);
			},
			
			sendIsReadyState(item)
			{
				axios.post('/estimate',{task_id : item.taskId,details : item.details,note : item.notes, type : item.type})
				.then((response) => {
					this.isItNessesaryToCleanNoteInput(response);
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
					this.isItNessesaryToCleanNoteInput(response);
					if (response.data.status === 'success') {
						this.isTaskReady = getNewCheckboxVal(this.isTaskReady);
					}
					
					this.isShowAlert = true;
					this.setAlertData(response.data.status, response.data.message)
					setTimeout( () => {
						this.isShowAlert = false;
					},3000)
				  })
			},
			
			sendMark(item)
			{	
				axios.post('/estimate',{
					task_id : item.taskId,
					details : item.details,
					note    : item.notes,
					mark    : this.jobMarkInputValue,
					type    : item.type
				})
				.then((response) => {
					this.isItNessesaryToCleanNoteInput(response);
					this.isShowAlert = true;
					this.setAlertData(response.data.status, response.data.message)
					this.noteInfo.todayAmount = response.data.noteAmount
					this.checkIsSavedMark(item.taskId);

					const {data} = response;
					if (data.status === 'success') {
						this.item.mark = +this.jobMarkInputValue;
					}

					setTimeout( () => {
						this.isShowAlert = false;
					},3000)
				  })
			},

			isItNessesaryToCleanNoteInput(response) {
				//поле noteWasAddedSuccessfully прийдет с бэкенда только если была обязательная невыполненная задача
				// и удалось успешно добавить заметку
				if (this.item.hash !== '#' && this.item.notes) {
					if (
						response.data.status === 'success' 
						|| (response.data.status === 'error' && response.data.noteWasAddedSuccessfully) 
					) {
						this.cleanNotesInput();
					}
				}
			},

			cleanNotesInput() {
				this.item.notes = '';
			},
			
			setAlertData(type, text)
			{	
				this.alert.type = type
				this.alert.text = text
			},

			changeTime(newData)
			{
				const {priority: newPriority, time: newTime} = newData;

				if ((this.item.time != newTime ) || (this.item.priority != newPriority) ) {
					axios.post('/edit-card',{
						task_id : this.item.taskId, 
						time : newTime, 
						priority: newPriority}) 
					.then((response) => {
						this.isShowAlert = true;
						
						if (response.data.status == 'success') {
							this.item.time = newTime;
							this.item.priority = newPriority;
						}

						this.setAlertData(response.data.status, response.data.message)
						setTimeout( () => {
							this.isShowAlert = false;
						},3000)
				  })

				  	this.newHashCodeData = {...this.newHashCodeData, time: newTime, priority: newPriority.toString()};
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

			createUnsavedTaskSaved(newHashCode) {
				this.renameHashCode(newHashCode);
				this.cleanNotesInput();
			},

			renameHashCode(newHashCode) {
				this.item.hash = newHashCode;
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

			filterJobMarkInputValue(e, taskId) {
				const keysAllowed = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.'];
				const keyPressed  = e.key;

				 if (!keysAllowed.includes(keyPressed)) {
					e.preventDefault();
					return;
				}

				this.checkIsSavedMark(taskId);
			},

			checkIsSavedMark(taskId) {
				const isShowUpdateCardNotification = (markInInput, savedMark) => {
					if (markInInput === '' && savedMark === -1) return false;
					return +markInInput !== savedMark;
				};

				axios.post('/get-task-mark',{task_id : taskId})
				.then((response) => {
					const {data} = response;
					const savedMark = data.mark;
					const markInInput = this.jobMarkInputValue.trim();
					
					if (data.status === 'success') {
						this.isShowUpdateCardNotification = isShowUpdateCardNotification(
							markInInput,
							savedMark
						);
					}
				})
			}
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

	.task-name-wrapper {
		padding: 0 10px !important;
	}

	.task-name {
		line-height: 1.5rem;
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

	.update-card-notification {
		color: rgba(0,0,0,.87);
		font-size: 12px;
		font-weight: 700;
		text-transform: uppercase;
		font-family: Sans-serif;
		/* color: #A10000; */
	}

	.button-attention{
		background-color: #DCDCDC;
		box-shadow: rgba(0,0,0,.87) 0px 0px 8px;
	}

	.notification_appearance {
		position: relative;
		animation: .3s show ease;
	}

	.notification_leave {
		position: relative;
		animation: .3s leave ease;
	}

	@keyframes show {
		from { opacity: 0; top: -10px;}
		to { opacity: 1; top: 0;}
	}

	@keyframes leave {
		from { opacity: 1; top: 0;}
		to { opacity: 0; top: 10px;}
	}
	/* стили для вдавливания карточки */
	.v-sheet.v-card:not(.v-sheet--outlined).card-wrapper {
		transition:  all .3s ease;
		position: relative;
	}
	.v-sheet.v-card:not(.v-sheet--outlined).card-wrapper_unready {
		box-shadow: 5px 5px 10px rgba(0, 0, 0, 0.3);
		top: 0;
		left: 0;
	}

	.v-sheet.v-card:not(.v-sheet--outlined).card-wrapper_ready {
		box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.3);
		top: 5px;
    	left: 3px;
	}
	/* ============================================ */
	/* тут эффекты затемнения готовой карточки и иконка */
	/* .v-sheet.v-card:not(.v-sheet--outlined).card-wrapper_ready::before {
		content: "";
		display: block;
		position: absolute;
		top: 0;
		left: 50%;
  		transform: translateX(-50%);
		height: 100%;
		width: 100%;
		background-color: rgba(0,0,0, 0.035);
		z-index: 1;
		transition: all .3s ease;
		background-image: url('/images/task_ready_icon.svg');
		background-position: top right;
		background-repeat: no-repeat;
		background-size: 150px 150px; 
	}

	.v-sheet.v-card:not(.v-sheet--outlined).card-wrapper_ready:hover::before {
		width: 0;
	} */
	/* ============================================ */
</style>