<template>  
	<v-card :id="!cardIdx ? 'card-wrapper' : false" :class="`${isCurrentTaskReady} card-wrapper`">
		<div class="card-demo">
			<AddHashCode 
			v-if="isShowAddHashCodeDialog"
			:width  		= "450"
			:hashCodeVal    = "hash"
			:isShowDialog   = "isShowAddHashCodeDialog"
			:taskName       = "taskName"
			:time           = "time"
			:type           = "transformedType"
			:priority       = "priority"
			:taskId 		= "taskId"
			@close          = "isShowAddHashCodeDialog = false"
			@addHashCode    = "renameHashCode"
			/>
			<div class="card-demo"></div>
		<v-card-title class="font-weight-bold justify-space-between v-card-title">
			<v-row class="m-0 p-0">
				<v-col 
				class="m-0 p-0 d-flex justify-content-start align-items-start"
				cols="auto"
				style="min-width: 88px;"
				>
					<v-row 
					class="m-0 p-0"
					v-if="hash == '#'"
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
						<span style="line-height: 1.5rem;" class="p-0">{{ hash }}</span>
					</v-row>
				</v-col>
				<v-col class="m-0 p-0 d-flex justify-content-center align-items-start task-name-wrapper">
					<span v-if="!isTaskNameLong" class="task-name">{{ taskName }}</span>
					<span 
					v-else
					:class="maxTaskNameLen.forRender === 255 ? 'task-name trancated-task-name-full' : 'task-name pointer'"
					@click="maxTaskNameLen.forRender = 255"
					@mouseleave="maxTaskNameLen.forRender = maxTaskNameLen.default"
					>
						{{truncatedTaskName}}
					</span>
				</v-col>
				<v-col 
				class="m-0 p-0 d-flex justify-content-end align-items-start"
				cols="auto"
				style="min-width: 22px;"
				>
					<span v-if="priority == 1"> </span>
					<span v-else-if="priority == 2">!</span>
					<span v-else-if="priority == 3">!!!</span>
					<span v-else>  </span>
				</v-col>
			</v-row>
		</v-card-title>
		</div>
		<v-list>
			<v-list-item>
				<v-row class="p-0 m-0">
					<v-col 
					class="p-0 m-0"
					:cols="4"
					>
						<v-list-item-content
							v-if="type == 4 || type == 3"
							>
							Job`s duration:
						</v-list-item-content>
						<v-list-item-content v-else>
						Task`s duration:
						</v-list-item-content>
					</v-col>
					<v-col 
					class="p-0 m-0"
					:cols="6"
					>
						<v-list-item-content class="justify-content-center" v-if="time.includes('00:')">{{time}}
							 minutes
						</v-list-item-content>
						<v-list-item-content class="justify-content-center" v-else-if="time.includes('01:00')">{{time}}
							 hour
						</v-list-item-content>
						<v-list-item-content class="justify-content-center" v-else>{{time}}
							 hours
						</v-list-item-content>
					</v-col>
					<v-col 
					class="p-0 m-0 "
					:cols="2"
					>
						<v-row 
						class="p-0 m-0"
						style="height: 100%"
						>
							<v-col 
							style="height: 100%"
							class="p-0 m-0 d-flex justify-content-end align-items-center"
							:cols="9"
							>
								<EditCardData 
								:currentTaskType     = "transformedType"
								:currentTaskPriority = "priority"
								:currentTaskTime     = "time"
								@saveChanges         = "saveChanges"
								/>
							</v-col>
						</v-row>
					</v-col>
					
				</v-row>
			</v-list-item>

			<v-list-item  >
				<v-row class="p-0 m-0">
					<v-col 
					class="p-0 m-0" 
					:cols="4">
						<v-list-item-content>Details:</v-list-item-content>
					</v-col>
					<v-col 
					class="p-0 m-0"
					:cols="6"
					>
					</v-col>
					<v-col 
					class="p-0 m-0 "
					:cols="2"
					>
						<v-row 
						class="p-0 m-0"
						>
							<v-col 
							class="p-0 m-0 d-flex flex-column justify-content-start align-items-end"
							:cols="9"
							>
								<template>
									<AddDetails 
									:cardIdx = "cardIdx"
									:taskId  = "taskId"
									@resetDayMarkToDefVal  = "resetDayMarkToDefVal"
									/>
								</template>
							</v-col>
							<v-col
							class="p-0 m-0 d-flex justify-content-end align-center"
							:cols=3
							>
								<span>
									{{ actualDetailsCounter }}
								</span>
							</v-col>
						</v-row>
					</v-col>
				</v-row>
			</v-list-item>

			<v-list-item >
				<v-row class="p-0 m-0">
					<v-col 
					class="p-0 m-0" 
					:cols="4">
					</v-col>
					<v-col 
					class="p-0 m-0"
					:cols="6"
					>
					</v-col>
					<v-col 
					class="p-0 m-0 "
					:cols="2"
					>
						<v-row 
						class="p-0 m-0"
						style="height: 100%"
						>
							<v-col 
							style="height: 100%; gap: 5px"
							class="p-0 m-0 d-flex flex-column justify-content-start align-items-end"
							:cols="9"
							>
								<template>
									<CreateSubplanGPT 
									:requestData="{
										label: 'Request: create subplan for',
										taskName: taskName,
										taskHash: hash,
										taskId:   taskId,
									}"
									/>
								</template>
							</v-col>
						</v-row>
					</v-col>
				</v-row>
			</v-list-item>

			<v-list-item>
				<v-row class="p-0 m-0" style="min-height: 140px">
					<v-col 
					class="p-0 m-0"
					:cols="4"
					>
						<v-list-item-content>Note:</v-list-item-content>
					</v-col>
					<v-col 
					class="p-0 m-0"
					:cols="6"
					>
					</v-col>
					<v-col 
					class="p-0 m-0"
					:cols="2"
					>
						<template
						>
							<AddNotes 
							:cardIdx = "cardIdx"
							:taskId  = "taskId"
							/>
						</template>
					</v-col>
				</v-row>	
			</v-list-item>
		</v-list>
		<v-divider class="m-2"></v-divider>
		<div style="min-height: 60px;">
			<transition
			enter-active-class="card-alert_appearance"
            leave-active-class="card-alert_leave"
			>
				<v-alert color="#404040" text class="elevation-1" v-bind:type="alert.type" v-if="isShowAlert">{{alert.text}}</v-alert>  
			</transition>
		</div>
		<v-card-title class="font-weight-bold pt-0">
			<v-row class="p-0 m-0">
				<v-col class="p-0 m-0" cols="auto">
					<form 
					class="d-flex align-center gap-1" 
					:id="!cardIdx ? 'card-mark' : false"
					>
						<template v-if="[4,3].includes(type)">
							<div>Mark</div>
							<v-text-field 
							class="ml-1" 
							style="width : 54px" 
							v-model="jobMarkInputValue" 
							v-on:keypress.enter.prevent="debounceSendMark(taskId)" 
							@input    = "debounceSendMark(taskId)"
							@keypress = "filterJobMarkInputValue($event, taskId)"
							@focus    = "focusedInput=!focusedInput" 
							@blur     = "focusedInput=!focusedInput"
							>
								<v-icon slot="append">mdi-percent</v-icon>
							</v-text-field>
						</template>
						
						<template v-else-if="[2,1].includes(type)">
							<div>Ready?</div>
							<div @click="debounceUpdateIsReadyState(taskId)">
								<v-checkbox color="#D71700"
								readonly
								v-model="isTaskReady"
								:true-value="isTaskReadyCheckboxTrueVal"
								:false-value="isTaskReadyCheckboxFalseVal"
								>
								</v-checkbox>
							</div>
						</template>
					</form>
				</v-col>
				<v-col class="p-0 m-0 d-flex align-center" style="width: 100%;">
					<transition
					enter-active-class="notification_appearance"
					leave-active-class="notification_leave"
					mode="out-in"
					>
						<span 
						v-if="focusedInput"
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
	import { debounce } from 'lodash';
	import store from '../../store';
	import { mapActions, mapGetters, mapMutations } from 'vuex/dist/vuex.common.js';
	import {mdiUpdate, mdiPencil,
		mdiMarkerCheck, mdiCircle, mdiMusicAccidentalSharp }  from '@mdi/js'  //mdiContentSaveCheckOutline
	import Alert from '../dialogs/Alert.vue'
	import AddHashCode from '../dialogs/AddHashCode.vue'
	import AddHashCodeButton from '../UI/AddHashCodeButton.vue';
	import CreateSubplanGPT from '../dialogs/CreateSubplanGPT.vue'
	import AddDetails from '../dialogs/AddDetails/AddDetails.vue';
	import AddNotes from '../dialogs/AddNotes/AddNotes.vue';
	import EditCardData from '../dialogs/EditCardData.vue';
	export default
	{
		props : {
			taskId: {
				type: Number,
				required: true,
			},
			cardIdx: {
				type: Number,
				required: true,
			}
		},
		data()
		{
			return {
					icons      : {mdiMarkerCheck, mdiUpdate,mdiPencil,
						mdiCircle, mdiMusicAccidentalSharp  },
					isShowAlert: false ,
					alert      : {type: 'success', text: 'success'},
					focusedInput: false,
					isShowAddHashCodeDialog : false,
					defaultConfigs: {},
					isTaskReady: '', //присваивается в created
					jobMarkInputValue: '', //присваивается в created
					isTaskReadyCheckboxTrueVal: 99,
					isTaskReadyCheckboxFalseVal: '',
					//Тут менять от скольки символов название таски обрезается,з начения полей объекта должны совпадать.
					maxTaskNameLen: { 
						default: 50,
						forRender: 50,
					},
					DEBOUNCE_DELAY: {
						tasks: {
							default: 900,
							mobile:  2000,
						},
						jobs: {
							default: 450,
							mobile: 450,
						}
					}
				}
			},
		store,
		components : {
			Alert, 
			AddHashCode, 
			AddHashCodeButton, 
			CreateSubplanGPT, 
			AddDetails,
			AddNotes, 
			EditCardData,
		},
		computed: {
			...mapGetters(['getDetailsData', 'getWindowScreendWidth', 'getTaskData', 'getFullTaskData', 'checkIsCurrentTaskReady']),
			hash() {
				return this.getTaskData(this.taskId, 'hash');
			},
			mark() {
				return this.getTaskData(this.taskId, 'mark');
			},
			priority() {
				return this.getTaskData(this.taskId, 'priority');
			},
			taskName() {
				return this.getTaskData(this.taskId, 'taskName');
			},
			time() {
				return this.getTaskData(this.taskId, 'time');
			},
			type() {
				return this.getTaskData(this.taskId, 'type');
			},
			transformedType() {
				return this.getTaskData(this.taskId, 'transformedType');
			},
			actualDetailsCounter() {
				const detailsData = this.getDetailsData(this.taskId);
				if (detailsData) {
					return detailsData.details.filter(detail =>!detail.is_old_compleated && !detail.is_ready).length;
				}
				return 0;
			},
			isCurrentTaskReady() {
				return this.checkIsCurrentTaskReady({
						taskId:         this.taskId,
						defaultConfigs: this.defaultConfigs.cardRules
					});
			},

			truncatedTaskName() {
				const taskName = this.taskName;

				if (taskName.length > this.maxTaskNameLen.forRender) {
					return taskName.slice(0, this.maxTaskNameLen.forRender) + '...';
				}

				return taskName;
			},

			isTaskNameLong() {
				return this.taskName.length > this.maxTaskNameLen.default;
			},

			debouncedSendMark() {
				const key = this.isMobile ? 'mobile' : 'default';
				const delay = this.DEBOUNCE_DELAY.tasks[key];

				return debounce(function(item) {
					this.sendMark(item);
				}, delay)
			},

			debouncedUpdateIsReadyState() {
				const key = this.isMobile ? 'mobile' : 'default';
				const delay = this.DEBOUNCE_DELAY.jobs[key];

				return debounce(function(item) {
					this.updateIsReadyState(item);
				}, delay)
			},

			isMobile() {
				return this.getWindowScreendWidth < 770;
			},
		}, 
		methods :
		{
			...mapActions(['fetchPersonalResults', 'editCardData', 'estimateJob']),
			...mapMutations(['UPDATE_TASK_DATA']),

			resetDayMarkToDefVal() {
				const currentTaskType = this.type;
				
				if ([1,2].includes(currentTaskType)) {
					this.isTaskReady = this.isTaskReadyCheckboxFalseVal;
				}

				if ([3,4].includes(currentTaskType)) {
					this.jobMarkInputValue = '';
				}

				this.UPDATE_TASK_DATA({updatedTaskData: {taskId: this.taskId, mark: ''}});
			},
			
			updateIsReadyState(item)
			{
				const getNewCheckboxVal = (oldVal) => {
					switch (oldVal) {
						case this.isTaskReadyCheckboxTrueVal:
							return {forCheckbox: this.isTaskReadyCheckboxFalseVal, forRequest: -1};
						case this.isTaskReadyCheckboxFalseVal:
							return {forCheckbox: this.isTaskReadyCheckboxTrueVal, forRequest: this.isTaskReadyCheckboxTrueVal};
					}
				}
				axios.post('/estimate',{
					task_id : item.taskId, 
					is_ready : getNewCheckboxVal(this.isTaskReady).forRequest,type : this.type
				})
				.then((response) => {
					if (response.data.status === 'success') {
						this.isTaskReady = getNewCheckboxVal(this.isTaskReady).forCheckbox;
						
						this.UPDATE_TASK_DATA({
							updatedTaskData: {
								taskId: this.taskId, 
								mark: this.isTaskReady,
							},
						});
					}
					
					this.fetchPersonalResults();

					this.showAlert({status: response.data.status, message: response.data.message});
				  })
			},

			debounceSendMark(taskId) {
				this.debouncedSendMark(this.getFullTaskData(taskId));
			},	

			debounceUpdateIsReadyState(taskId) {
				this.debouncedUpdateIsReadyState(this.getFullTaskData(taskId));
			},
			
			async sendMark()
			{	
				try {
					const response = await this.estimateJob({
						payload: {
							task_id : this.taskId,
							mark    : this.jobMarkInputValue,
							type    : this.type
				 		}
					})

					const {data} = response;

					if(data.status === 'error') {
						const {current_task_mark} = response.data;
						
						this.jobMarkInputValue = current_task_mark !== -1 
							? String(current_task_mark) 
							: '';
					}
					
					this.fetchPersonalResults();

					this.showAlert({status: response.data.status, message: response.data.message});

				} catch(error) {
					this.jobMarkInputValue = '';
					this.showAlert({status: 'error', message: 'Error! Something has happened!'})
					console.error(error);
				}
			},
			
			setAlertData(type, text)
			{	
				this.alert.type = type
				this.alert.text = text
			},

			async saveChanges(newData)
			{
				const response = await this.editCardData({editedCardData: {...newData, taskId: this.taskId}});

				if (response) {
					const {updated_data} = response.data;
					if (Object.keys(updated_data).includes('type')) {
						this.resetDayMarkToDefVal();
					};

					this.showAlert({status: response.data.status, message: response.data.message});
				}
			},

			renameHashCode(newHash) {
				this.UPDATE_TASK_DATA({
					updatedTaskData: {hash: newHash, taskId: this.taskId},
				});
			},

			getConfigs(data=null) {
				axios.post('/get-default-configs')
					.then((response) => {
						this.defaultConfigs = response.data
						this.defaultConfigs = JSON.parse(this.defaultConfigs[0].config_data)
					  })
			},

			filterJobMarkInputValue(e, taskId) {
				const keysAllowed = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '.'];
				const keyPressed  = e.key;

				 if (!keysAllowed.includes(keyPressed)) {
					e.preventDefault();
					return;
				}

			},

			showAlert({status, message}) {
				this.isShowAlert = true;
				this.setAlertData(status, message)
				setTimeout( () => {
					this.isShowAlert = false;
				},3000)
			}

		},
		
		created() {
			this.getConfigs(); 
			
			this.jobMarkInputValue = String(this.mark);
			this.isTaskReady       = this.mark;
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
		min-height: 48px;
		word-break: break-word;
		text-align: center;
	}

	.task-name {
		line-height: 1.5rem;
	}
	.pointer {
		cursor: pointer;
	}

	.trancated-task-name-full {
		animation: taskNameAppearance  0.3s ease-in-out;
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

	.card-alert_appearance {
      animation: .3s card_alert_appearance ease;
   	}

   .card-alert_leave {
      animation: .3s card_alert_leave ease;
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

	.update-card-notifiactiob-br {
		display: none;
	}

	@keyframes show {
		from { opacity: 0; top: -10px;}
		to { opacity: 1; top: 0;}
	}

	@keyframes leave {
		from { opacity: 1; top: 0;}
		to { opacity: 0; top: 10px;}
	}

	@keyframes taskNameAppearance {
		from {opacity: 0;}
		to {opacity: 1;}
	}

	@keyframes card_alert_appearance {
		from { opacity: 0; left: -10px;}
		to { opacity: 1; left: 0;}
	}

	@keyframes card_alert_leave {
		from { opacity: 1; left: 0;}
		to { opacity: 0; left: 10px;}
	}

	
	@import url('/css/Card/CardMedia.css');
</style>