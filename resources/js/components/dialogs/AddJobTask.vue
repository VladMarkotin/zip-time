<template>
	<div>
		<template v-if="isShowAddHashCodeDialog">
			<AddHashCode 
			:width  		= "450"
			:hashCodeVal    = "isChangedHashCodeTemplate ? '#' : task.hashCode"
			:isShowDialog   = "isShowAddHashCodeDialog"
			:taskName       = "task.name"
			:time           = "task.time"
			:type           = "task.type"
			:priority       = "task.priority"
			:details        = "isChangedHashCodeTemplate ? '' : task.details"
			:notes          = "isChangedHashCodeTemplate ? '' : task.notes"
			@close          = "closeHashCodeDialog"
			@changeHashCode = "changeHashCode"
			@addHashCode    = "addHashCode"
			/>
		</template>
		<v-dialog max-width="650px" persistent v-model="isShow">
			<v-card>
				<v-card-title class="font-weight-bold v-card-title">Add job/task</v-card-title>
				<v-card-text>
					<v-container>
						<v-row align="center">
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
								counter="25" 
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
								></v-select>
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
								></v-select>
							</v-col>
							<v-col
							cols="1"
							class="p-0 m-0"
							>	
							</v-col>
						</v-row>
						<template>
							<TimePickerMenu 
							:menuParent = "menu"
							:timeParent = "task.time"
							@changeMenuModel="changeMenuModel"
							@changeTimeModel="changeTimeModel"
							/>
						</template>
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
	import AddHashCodeButton from '../UI/addHashCodeButton.vue';
	import CleanHashCodeButton from '../UI/CleanHashCodeButton.vue';
	import CloseButton from '../UI/CloseButton.vue';
	import TimePickerMenu from '../TimePickerMenu.vue';
	import {mdiPlusBox, mdiClockTimeFourOutline} from '@mdi/js';

	export default
		{
			components : {AddHashCode, AddHashCodeButton, CleanHashCodeButton, CloseButton, TimePickerMenu},
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
						types : ['required job','non required job','required task','task','reminder'],
						priorities : [1,2,3],
						menu : false/*for task.time*/,
						icons : {mdiPlusBox,mdiClockTimeFourOutline},

						isShow : true,
						isShowAddHashCodeDialog : false,
						isChangedHashCodeTemplate: false,
					}
			},
			methods :
			{
				clearCurrentHashCode(){
					this.task = {
								hashCode : '#',
								name : '',
								type : 'required job',
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
					const data = (await axios.post('/getSavedTask',{hash_code : hashCode})).data
					this.savedTaskTemplate.hashCode = hashCode;
					this.savedTaskTemplate.name = this.task.name = data[1];
					const types = this.types.slice()
					this.savedTaskTemplate.type = this.task.type = data[2]; //types.reverse()[data[2]]
					this.savedTaskTemplate.priority = this.task.priority = data[3];
					this.savedTaskTemplate.time = this.task.time = data[5];

					this.isChangedHashCodeTemplate = false;
				},
				async loadHashCodes()
				{
					this.hashCodes = (await axios.post('/getSavedTasks')).data.hash_codes.map((item) => item.hash_code)
					let {defaultSavedTasks} = (await axios.post('/getDefaultSavedTasks')).data;
					defaultSavedTasks = defaultSavedTasks.map((item) => item.hash_code);
					this.hashCodes = [...this.hashCodes, ...defaultSavedTasks];
				},

				changeHashCode(hashCodeVal) {
         			this.task.hashCode = hashCodeVal;
      			},

				closeHashCodeDialog() {
					if (this.isChangedHashCodeTemplate && !this.hashCodes.includes(this.task.hashCode)) {
						this.task.hashCode = this.savedTaskTemplate.hashCode;
					}

      	   			this.isShowAddHashCodeDialog = false;
					this.isChangedHashCodeTemplate = false;
      			},
				addHashCode() {
					this.hashCodes.unshift(this.task.hashCode);
				},

				async addJob()
				{
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
						this.
						$root.
						currComponentProps.
						push
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

				changeMenuModel(menu) {
					this.menu = menu;
				},

				changeTimeModel(time) {
					this.task = {...this.task, time};
					this.compareWithTemplate();
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
			},
			async created()
			{
				this.loadHashCodes()
			}
		}
</script>

<style>
	.addJobTask-timePicker-wrapper .v-picker > .v-picker__body {
		width: 60%;
		margin: 0 auto;
	}
</style>