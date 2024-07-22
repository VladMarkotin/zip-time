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
								<v-select label="#code" v-bind:items="hashCodes" v-model="task.hashCode" v-on:change="hashCodeChangeHandler"></v-select>
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
								<v-select 
								label="Type" 
								v-bind:items="types" 
								v-model="task.type"
								@change="compareWithTemplate"
								>
								<template v-slot:item="{item}">
									<v-list-item >{{ item }}</v-list-item>
									<VSelectTooptip 
                          			:item        = "item"
									:tooltipData = "tooltipTypesData"
                           			/>
								</template>
							</v-select>
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
									<!-- open-on-hover -->
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
	import AddHashCode from './AddHashCode.vue';
	import AddHashCodeButton from '../UI/AddHashCodeButton.vue';
	import CleanHashCodeButton from '../UI/CleanHashCodeButton.vue';
	import CloseButton from '../UI/CloseButton.vue';
	import VSelectTooptip from '../UI/VSelectTooptip.vue';
	import {mdiPlusBox, mdiClockTimeFourOutline} from '@mdi/js';
	import CustomTimepicker from '../UI/CustomTimepicker.vue';

	import createWatcherForDefSavTaskMixin from '../../mixins';

	export default
		{
			components : {AddHashCode, AddHashCodeButton, CleanHashCodeButton, CloseButton, VSelectTooptip, CustomTimepicker},
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
					}
			},
			computed: {
				tooltipTypesData() {
					return {
						titles: {
							requiredJob: 'required job',
							nonRequiredJob: 'non required job',
							requiredTask: 'required task',
							task: 'task',
						},
						descriptions: {
							requiredJob: `<span style="text-indent: -1em; padding-left: 1em;">Main entity of your plan. By adding a required job, you kind of sign a commitment with yourself that you will at least start doing it today. After finishing working on a job, you should evaluate the effort you spent.</span><br><span style="text-indent: -1em; padding-left: 1em;">By 23:59 all (!) required jobs should be evaluated</span>`,
							nonRequiredJob: `<span style="text-indent: -1em; padding-left: 1em;">Some of your day\`s jobs could be not so important but, anyway, you want to evaluate your efforts. So, non required jobs are exactly what you need. Failure to comply has no consequences. Moreover, to complete all non required jobs is a perfect way to increase your final day grade</span>`,
							requiredTask: `<span style="text-indent: -1em; padding-left: 1em;">We often have a plenty of small (but important) tasks (e.g “call to the boss”). It would be difficult to evaluate the result of such task, but, anyway, you have to do it.</span>`,
							task: `<span style="text-indent: -1em; padding-left: 1em;">Anything that\`s not so important and hard to evaluate but necessary personally for you ( e.g. “night out with friends” )</span>`,
						},
					}
        		},

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
				clearCurrentHashCode(){
					const self = this;

					this.task = {
						hashCode : '#',
						name : '',
						type : self.isTodayAWeekend ? self.WEEKEND_DEFAULT_TASK_TYPE : self.WORKING_DAY_DEFAULT_TASK_TYPE,
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
					if (this.isDefaultSavedTaskSelected) {
						this.isShowAddHashCodeDialog          = true;
						//после успешного создание хешкода таска попадет сразу в план
						this.addTaskToPlanWithoutConfirmation = true;
						return;
					}

					const response =
						(
							await
								axios.
								post
									(
										'/addJob',
										{
											hash_code : this.task.hashCode,
											name : this.task.name,
											type : this.task.type,
											priority : this.task.priority,
											time : this.task.time
										}
									)
						).data
					if (response.status == 'success')
					{
						this.$root.currComponentProps.plan.push
							(
								{
									hash : this.task.hashCode,
									taskName : this.task.name,
									priority : this.task.priority,
									type : this.task.type,
									time : this.task.time,
									details : '',
									notes : '',
									mark : '',
									taskId : response.taskId
								}
							)
						this.$root.$forceUpdate()
						this.toggle()
						setTimeout(function (){
							location.reload()
						}, 3000);
					}
					this.$emit('setAlertData',response.status,response.message)
					this.$emit('toggleAlertDialog')
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
						console.log(this.isChangedHashCodeTemplate);
					}

				},

				setTime(time) {
					this.task = {...this.task, time};
					this.compareWithTemplate();
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