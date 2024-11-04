<template>  
	<v-card :id="!cardIdx ? 'card-wrapper' : false" :class="`${isCurrentTaskReady} card-wrapper`">
		<CardHeader 
		:hash            = "hash"
		:taskName        = "taskName"
		:time            = "time"
		:transformedType = "transformedType"
		:priority        = "priority"
		:taskId          = "taskId"
		/>
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
								:taskId              = "taskId"
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
				<v-col class="p-0 m-0" cols="12">
					<form 
					class="d-flex align-center gap-1" 
					:id="!cardIdx ? 'card-mark' : false"
					>
						<template v-if="[4,3].includes(type)">
							<SetJobMark 
							:taskId = "taskId"
							@sendMark  = "sendMark"
							@showAlert = "showAlert"
							/>
						</template>
						
						<template v-else-if="[2,1].includes(type)">
							<div>Ready?</div>
							<div @click="debounceUpdateIsReadyState(taskId)">
								<v-checkbox color="#D71700"
								readonly
								v-model="isTaskReady"
								:true-value="taskCheckboxTrueVal"
								:false-value="taskCheckboxFalseVal"
								>
								</v-checkbox>
							</div>
						</template>
					</form>
				</v-col>
			</v-row>
		</v-card-title>
	</div>
	</v-card>
</template>
<script>
	import CardHeader from './CardHeader.vue';
	import { debounce } from 'lodash';
	import store from '../../../store';
	import { mapActions, mapGetters, mapMutations } from 'vuex/dist/vuex.common.js';
	import {mdiUpdate, mdiPencil,
		mdiMarkerCheck, mdiCircle, mdiMusicAccidentalSharp }  from '@mdi/js'  //mdiContentSaveCheckOutline
	import Alert from '../../dialogs/Alert.vue';
	import CreateSubplanGPT from '../../dialogs/CreateSubplanGPT.vue'
	import AddDetails from '../../dialogs/AddDetails/AddDetails.vue';
	import AddNotes from '../../dialogs/AddNotes/AddNotes.vue';
	import EditCardData from '../../dialogs/EditCardData.vue';
	import EmojiPicker from '../../UI/EmojiPicker.vue';
	import SetJobMark from '../../dialogs/SetJobMark/SetJobMark.vue';
	
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
					isShowAddHashCodeDialog : false,
					defaultConfigs: {},
					isTaskReady: '', //присваивается в created
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
			CardHeader,
			Alert, 
			CreateSubplanGPT, 
			AddDetails,
			AddNotes, 
			EditCardData,
			EmojiPicker,
			SetJobMark,
		},
		computed: {
			...mapGetters([
				'getDetailsData', 
				'getWindowScreendWidth', 
				'getTaskData', 
				'getFullTaskData', 
				'checkIsCurrentTaskReady', 
				'getTaskCheckboxTrueVal',
				'getTaskCheckboxFalseVal'
			]),
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
			taskCheckboxTrueVal() {
				return this.getTaskCheckboxTrueVal();
			},
			taskCheckboxFalseVal() {
				return this.getTaskCheckboxFalseVal();
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
			...mapActions(['fetchPersonalResults', 'editCardData', 'estimateJob', 'estimateTask']),
			...mapMutations(['UPDATE_TASK_DATA']),

			resetDayMarkToDefVal() {
				const currentTaskType = this.type;
				
				if ([1,2].includes(currentTaskType)) {
					this.isTaskReady = this.taskCheckboxFalseVal;
				}

				this.UPDATE_TASK_DATA({updatedTaskData: {taskId: this.taskId, mark: 0}});
			},
			
			async updateIsReadyState(item)
			{
				try {
					const getNewCheckboxVal = (oldVal) => {
						switch (oldVal) {
							case this.taskCheckboxTrueVal:
								return this.taskCheckboxFalseVal;
							case this.taskCheckboxFalseVal:
								return this.taskCheckboxTrueVal;
						}
					}

					const payload = {
						task_id :  this.taskId,
						is_ready : getNewCheckboxVal(this.isTaskReady),
						type :     this.type
					};

					const response = await this.estimateTask({payload: payload});

					if (response.data.status === 'success') {
						this.isTaskReady = payload.is_ready;
					}

					this.fetchPersonalResults();

					this.showAlert({status: response.data.status, message: response.data.message});
				} catch(error) {
					this.showAlert({status: 'error', message: 'Error! Something has happened!'})
					console.error(error);
				}
			},

			debounceUpdateIsReadyState(taskId) {
				this.debouncedUpdateIsReadyState(this.getFullTaskData(taskId));
			},
			
			async sendMark(mark)
			{	
				try {
					const response = await this.estimateJob({
						payload: {
							task_id : this.taskId,
							mark    : mark,
							type    : this.type
				 		}
					})

					const {data} = response;

					if(data.status === 'error') {
						const {current_task_mark} = response.data;

						const mark = current_task_mark !== -1 
							? current_task_mark 
							: 0;

						this.UPDATE_TASK_DATA({updatedTaskData: {taskId: this.taskId, mark}});
					}
					
					this.fetchPersonalResults();
					this.showAlert({status: response.data.status, message: response.data.message});

				} catch(error) {
					this.UPDATE_TASK_DATA({updatedTaskData: {taskId: this.taskId, mark: 0}});
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

			getConfigs(data=null) {
				axios.post('/get-default-configs')
					.then((response) => {
						this.defaultConfigs = response.data
						this.defaultConfigs = JSON.parse(this.defaultConfigs[0].config_data)
					  })
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