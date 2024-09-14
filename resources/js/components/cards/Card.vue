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
				class="m-0 p-0 d-flex justify-content-start align-items-start"
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
						<span style="line-height: 1.5rem;" class="p-0">{{ hashCode }}</span>
					</v-row>
				</v-col>
				<v-col class="m-0 p-0 d-flex justify-content-center align-items-start task-name-wrapper">
					<span v-if="!isTaskNameLong" class="task-name">{{ item.taskName }}</span>
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
				<v-row class="p-0 m-0">
					<v-col 
					class="p-0 m-0"
					:cols="4"
					>
						<v-list-item-content
							v-if="item.type == 4 || item.type == 3"
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
						<v-list-item-content class="justify-content-center" v-if="item.time.includes('00:')">{{item.time}}
							 minutes
						</v-list-item-content>
						<v-list-item-content class="justify-content-center" v-else-if="item.time.includes('01:00')">{{item.time}}
							 hour
						</v-list-item-content>
						<v-list-item-content class="justify-content-center" v-else>{{item.time}}
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
								:currentTaskPriority = "item.priority"
								:currentTaskTime     = "item.time"
								@saveChanges = "changeTime"
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
									:num                = "num"
									:item               = "item"
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
										taskName: item.taskName,
										taskHash: item.hash,
										taskId: item.taskId,
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
							:num  = "num"
							:item = "item"
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
					:id="!num ? 'card-mark' : false"
					>
						<template v-if="[4,3].includes(item.type)">
							<div>Mark</div>
							<v-text-field 
							class="ml-1" 
							style="width : 54px" 
							v-model="jobMarkInputValue" 
							v-on:keypress.enter.prevent="debounceSendMark(item)" 
							@input    = "debounceSendMark(item)"
							@keypress = "filterJobMarkInputValue($event, item.taskId)"
							@focus    = "focusedInput=!focusedInput" 
							@blur     = "focusedInput=!focusedInput"
							>
								<v-icon slot="append">mdi-percent</v-icon>
							</v-text-field>
						</template>
						
						<template v-else-if="[2,1].includes(item.type)">
							<div>Ready?</div>
							<div @click="debounceUpdateIsReadyState(item)">
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
	import { mapActions, mapGetters } from 'vuex/dist/vuex.common.js';
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
						mdiCircle, mdiMusicAccidentalSharp  },
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
					id: this.item.id,
					done: 'v-card-done',
					completedProgressBar: 0,
					focusedInput: false,
					details: [],
					ex4: [],
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
			Preloader, 
			CreateSubplanGPT, 
			AddDetails,
			AddNotes, 
			EditCardData,
		},
		computed: {
			...mapGetters(['getDetailsData', 'getWindowScreendWidth']),
			actualDetailsCounter() {
				const detailsData = this.getDetailsData(this.item.taskId);
				if (detailsData) {
					return detailsData.details.filter(detail =>!detail.is_old_compleated && !detail.is_ready).length;
				}
				return 0;
			},
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
			...mapActions(['fetchDetails', 'fetchNotes', 'fetchPersonalResults']),
			closeHashCodeDialog() {
      	   		this.isShowAddHashCodeDialog = false;
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

					this.fetchPersonalResults();

					setTimeout( () => {
						this.isShowAlert = false;
					},3000)
				  })
			},

			debounceSendMark(item) {
				this.debouncedSendMark(item);
			},	

			debounceUpdateIsReadyState(item) {
				this.debouncedUpdateIsReadyState(item);
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
					this.isShowAlert = true;
					this.setAlertData(response.data.status, response.data.message)

					const {data}              = response;
					const {current_task_mark} = data;
					if (data.status === 'success') {
						this.item.mark = +this.jobMarkInputValue;
					} 
					if((data.status === 'error') && current_task_mark !== undefined) {
						this.jobMarkInputValue = current_task_mark !== -1 
							? String(current_task_mark) 
							: '';
					}
					
					this.fetchPersonalResults();

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