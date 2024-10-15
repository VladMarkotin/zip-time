<template>
	<div>
		<template v-if="isShowAddHashCodeDialog">
			<AddHashCode 
			:width  		      = "450"
			:hashCodeVal          = "isChangedHashCodeTemplate ? '#' : newHashCode"
			:isShowDialog         = "isShowAddHashCodeDialog"
			:taskName             = "task.name"
			:time                 = "task.time"
			:type                 = "task.type"
			:priority             = "task.priority"
			:details              = "isChangedHashCodeTemplate ? '' : task.details"
			:notes                = "isChangedHashCodeTemplate ? '' : task.notes"
			:defaultSavedTaskData = "defaultSavedTaskData"
			@close          = "closeHashCodeDialog"
			@changeHashCode = "changeHashCode"
			@addHashCode    = "addHashCode"
			/>
		</template>
		<v-dialog 
		max-width="650px" 
		persistent 
		v-model="isShow"
		content-class="addJobTask-addJobTask-dialog"
		>
			<v-card class="addJobTask_card">
				<v-card-title class="font-weight-bold v-card-title">Add job/task</v-card-title>
				<v-card-text>
					<v-container class="addJobTask_container">
						<v-row align="center" class="addJobTask-add-hashCode-wrapper">
							<v-col cols="1">
								<template v-if="(task.name.length >= 4 && (task.hashCode == '#' || isChangedHashCodeTemplate)) ">
									<AddHashCodeButton @addHashCodeButtonClick="isShowAddHashCodeDialog = true"/>
								</template>
							</v-col>
							<v-col>
								<!-- <v-select 
								label="#code" 
								v-bind:items="hashCodes" 
								v-model="task.hashCode" 
								v-on:change="hashCodeChangeHandler"
								></v-select> -->
								<SelectHashCode 
								v-model         = "task.hashCode" 
								:hashCodes      = "hashCodes"
								searchItemWidth = '100%'
								@selectHashCode = "hashCodeChangeHandler"
								/>
							</v-col>
							<v-col cols="1">
								<template v-if="task.name.length  > 2">
									<CleanHashCodeButton @clearCurrentHashCode="clearCurrentHashCode"/>
								</template>
							</v-col>
						</v-row>
						<v-row class="p-0 m-0">
							<v-col 
							cols="1" 
							class="p-0 m-0"></v-col>
							<v-col class="p-0 m-0">
								<v-text-field 
								counter="50" 
								label="Name" 
								required 
								v-model="task.name"
								@input="compareWithTemplate"></v-text-field>
							</v-col>
							<v-col 
							cols="1" 
							class="p-0 m-0"></v-col>
						</v-row>
						<v-row class="p-0 m-0">
							<v-col 
							cols="1"
							class="p-0 m-0"
							></v-col>
							<v-col class="p-0 m-0">
								<SelectTaskType 
								label      = "Type" 
								v-model    = "task.type"
								:taskTypes = "types"
								@change = "compareWithTemplate"
								/>
							</v-col>
							<v-col
							cols="1"
							class="p-0 m-0"
							></v-col>
						</v-row>
						<v-row class="p-0 m-0">
							<v-col
							cols="1"
							class="p-0 m-0"
							></v-col>
							<v-col
							class="p-0 m-0"
							>
								<v-select 
								label="Priority" 
								v-bind:items="priorities" 
								v-model="task.priority"
								@change="compareWithTemplate"
								>
								<template v-slot:item="{item}" >
									<v-list-item >{{ item }}</v-list-item>
									<VSelectTooptip 
									:item              = "String(item)"
									:width             = "200"
									:tooltipData       = "tooltipPrioritiesData"
									:isShowDescription = "false"
									/>
								</template>
								</v-select>
							</v-col>
							<v-col
							cols="1"
							class="p-0 m-0"
							>	
							</v-col>
						</v-row>
						<v-row class="p-0 m-0">
							<v-col
							cols="1"
							class="p-0 m-0"
							></v-col>
							<v-col class="p-0 m-0">
								<CustomTimepicker 
								:time     = "task.time"
								:isIconInner = "true"
								@updateTime = "setTime"
								/>
							</v-col>
							<v-col
							cols="1"
							class="p-0 m-0"
							></v-col>
						</v-row>
					</v-container>
				</v-card-text>
				<v-divider></v-divider>
				<v-card-actions class="justify-space-between v-card-actions">
					<v-tooltip right>
						<template v-slot:activator="{on}">
							<v-btn icon v-on="on" v-on:click="addJob">
								<v-icon color="#D71700" large>{{icons.mdiPlusBox}}</v-icon>
							</v-btn>
						</template>
						<span>Add job/task</span>
					</v-tooltip>
					<CloseButton @close="toggle"/>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</div>
</template>
<script>
	import store from '../../store';
	import { mapMutations } from "vuex/dist/vuex.common.js";
	import AddHashCode from './AddHashCode.vue';
	import AddHashCodeButton from '../UI/AddHashCodeButton.vue';
	import CleanHashCodeButton from '../UI/CleanHashCodeButton.vue';
	import CloseButton from '../UI/CloseButton.vue';
	import VSelectTooptip from '../UI/VSelectTooptip.vue';
	import {mdiPlusBox, mdiClockTimeFourOutline} from '@mdi/js';
	import CustomTimepicker from '../UI/CustomTimepicker.vue';
	import SelectTaskType from '../UI/SelectTaskType.vue';
	import SelectHashCode from '../UI/SelectHashCode.vue';

	import createWatcherForDefSavTaskMixin from '../../mixins';

	export default
		{
			components : {
				AddHashCode, 
				AddHashCodeButton, 
				CleanHashCodeButton, 
				CloseButton, 
				VSelectTooptip, 
				CustomTimepicker, 
				SelectTaskType,
				SelectHashCode,
			},
			props: {
				dayStatus: {
					type: Number,
				},
			},
			mixins: [createWatcherForDefSavTaskMixin('task.hashCode')],
			data()
			{
				return {
						task : {
							hashCode : '#',
							name : '',
							type : 'required job',
							priority : 1,
							time : '01:00',
							details: '',
							notes: '',
						},
						savedTaskTemplate: {
							hashCode : '#',
							name : '',
							type : '',
							priority : null,
							time : '',
						},
						hashCodes : [],
						newHashCode: '#',
						priorities : [1,2,3],
						menu : false/*for task.time*/,
						icons : {mdiPlusBox,mdiClockTimeFourOutline},

						isShow : true,
						isShowAddHashCodeDialog : false,
						isChangedHashCodeTemplate: false,
						WEEKEND_DEFAULT_TASK_TYPE: 'task',
						WORKING_DAY_DEFAULT_TASK_TYPE: 'required job',
						defaultSavedTaskData: {
							isDefaultSAvedTaskSelected: false,
							defaultSavedTasks: [],
							selectedSavedTaskId: null,
         				},
						addTaskToPlanWithoutConfirmation: false,
						isLoading: false,
					}
			},
			store,
			computed: {
				tooltipPrioritiesData() {
					return {
						titles: {
							'1' : 'usual',
							'2' : 'important',
							'3' : 'extremly imortant',
						}
					}
        		},

				isTodayAWeekend() {
					return this.dayStatus === 1;
				},

				types() {
					return !this.isTodayAWeekend 
						? ['required job','non required job','required task','task']
						: [this.WEEKEND_DEFAULT_TASK_TYPE];
				},

				isDefaultSavedTaskSelected() {
            		return !!this.task.hashCode.match(/^#q-/);
         		}
			},
			methods :
			{
				...mapMutations(['INITIALIZE_TASK_DATA_STORE',]),
				clearCurrentHashCode(){
					this.task = {
						hashCode : '#',
						name : '',
						type : this.isTodayAWeekend ? this.WEEKEND_DEFAULT_TASK_TYPE : this.WORKING_DAY_DEFAULT_TASK_TYPE,
						priority : 1,
						time : '01:00',
						details: '',
						notes: '',
					};
					
					this.savedTaskTemplate = {
						hashCode : '#',
						name : '',
						type : '',
						priority : null,
						time : '',
					}
				},

				async hashCodeChangeHandler(hashCode)
				{	
					try {
						const getData = (response) => (key) => response.data[key];
						
						const response = (await axios.post('/getSavedTask',{hash_code : hashCode}));
						const getValue = getData(response);
						
						this.savedTaskTemplate.hashCode = hashCode;
						this.savedTaskTemplate.name = this.task.name = getValue('task_name');
						this.savedTaskTemplate.type = this.task.type = this.isTodayAWeekend 
																	 ? this.WEEKEND_DEFAULT_TASK_TYPE 
																	 : getValue('type');
						this.savedTaskTemplate.priority = this.task.priority = getValue('priority');
						this.savedTaskTemplate.time = this.task.time = getValue('time');
					} catch(error) {
						console.error(error);
					}

					this.isChangedHashCodeTemplate = false;
				},
				async loadHashCodes()
				{
					this.hashCodes = (await axios.post('/getSavedTasks')).data.hash_codes.map((item) => item.hash_code)
					let {defaultSavedTasks} = (await axios.post('/getDefaultSavedTasks')).data;
					
					this.defaultSavedTaskData.defaultSavedTasks = defaultSavedTasks;
					
					defaultSavedTasks = defaultSavedTasks.map((item) => item.hash_code);

					this.hashCodes = [...this.hashCodes, ...defaultSavedTasks];

				},

				changeHashCode(hashCodeVal) {
         			this.newHashCode = hashCodeVal;
      			},

				closeHashCodeDialog() {
					this.newHashCode = '#';
      	   			this.isShowAddHashCodeDialog = false;
					this.isChangedHashCodeTemplate = false;
      			},
				addHashCode() {
					this.hashCodes.unshift(this.newHashCode);
					this.task.hashCode = this.newHashCode;
					
					if (this.defaultSavedTaskData.isDefaultSAvedTaskSelected && this.addTaskToPlanWithoutConfirmation) {
						this.addJob();
					}
					this.addTaskToPlanWithoutConfirmation = false;
				},

				async addJob()
				{
					try {

						if (this.isDefaultSavedTaskSelected) {
							this.isShowAddHashCodeDialog          = true;
							//после успешного создание хешкода таска попадет сразу в план
							this.addTaskToPlanWithoutConfirmation = true;
							return;
						}

						if (this.isLoading) {
							return;
						}
						this.isLoading = true;
						
						const requestData = {
											hash_code : this.task.hashCode,
											name : this.task.name,
											type : this.task.type,
											priority : this.task.priority,
											time : this.task.time
										};
					
						const response = ( await axios.post('/addJob', requestData)).data;

						if (response.status == 'success') {
							this.INITIALIZE_TASK_DATA_STORE({taskData: response.updated_plan});
							this.clearCurrentHashCode();
						}
						
						this.showAlert({status: response.status, text: response.message});
					} catch(error) {
						this.showAlert({status: 'error', text: 'Error! Something has happened!'});
					} finally {
						this.isLoading = false;
					}
					
				},
				toggle()
				{
					this.$emit('toggleAddJobTaskDialog')
				},

				compareWithTemplate() {
					if (this.task.hashCode !== '#') {
						
						const convertToJSON = (targetObj) => {
							return JSON.stringify({...targetObj, name: targetObj.name.trim()});
						}

						const currentTask = {
							hashCode: this.task.hashCode,
							name: this.task.name,
							type: this.task.type,
							priority: this.task.priority,
							time: this.task.time,
						};

						this.isChangedHashCodeTemplate = !(convertToJSON(currentTask) === convertToJSON(this.savedTaskTemplate));
					}
				},

				setTime(time) {
					this.task = {...this.task, time};
					this.compareWithTemplate();
				},

				showAlert({status, text}) {
					this.$emit('setAlertData',status,text);
					this.$emit('toggleAlertDialog');
				}
			},
			async created()
			{
				this.loadHashCodes()
			},
		}
</script>

<style>
	.addJobTask-timePicker-wrapper .v-picker > .v-picker__body {
		width: 60%;
		margin: 0 auto;
	}

	@import url('/css/AddJobTask/AddJobTaskMedia.css');
</style>