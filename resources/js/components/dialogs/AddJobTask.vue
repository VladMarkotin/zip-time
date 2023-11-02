<template>
	<div>
		<template v-if="isShowAddHashCodeDialog">
			<AddHashCode v-on:addHashCode="addHashCode" v-on:toggleAddHashCodeDialog="toggleAddHashCodeDialog"/>
		</template>
		<v-dialog max-width="650px" persistent v-model="isShow">
			<v-card>
				<v-card-title class="font-weight-bold v-card-title">Add job/task</v-card-title>
				<v-card-text>
					<v-container>
						<v-row align="center">
							<v-col cols="1">
								<template v-if="task.name.length >= 4 && task.hashCode == ''">
									<AddHashCodeButton />
								</template>
								<!-- <v-tooltip right>
									<template v-slot:activator="{on}">
										<v-btn icon v-on="on" v-on:click="toggleAddHashCodeDialog">
											<v-icon color="#D71700">{{icons.mdiPlusBox}}</v-icon>
										</v-btn>
									</template>
									<span>Add #code to task for quick access</span>
								</v-tooltip> -->
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
						<v-text-field counter="25" label="Name" required v-model="task.name"></v-text-field>
						<v-select label="Type" v-bind:items="types" v-model="task.type"></v-select>
						<v-select label="Priority" v-bind:items="priorities" v-model="task.priority"></v-select>
						<v-menu ref="v-menu" v-bind:close-on-content-click="false" v-model="menu">
							<template v-slot:activator="{on}">
								<v-text-field label="Time" prepend-icon="mdi-clock-time-four-outline" readonly v-model="task.time" v-on="on"></v-text-field>
							</template>
							<v-time-picker color="#D71700" v-on:click:minute="$refs['v-menu'].save(task.time)" v-model="task.time"></v-time-picker>
						</v-menu>
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
					<v-tooltip right>
						<template v-slot:activator="{on}">
							<v-btn icon v-on="on" v-on:click="toggle">
								<v-icon color="#D71700" large>{{icons.mdiCancel}}</v-icon>
							</v-btn>
						</template>
						<span>Cancel</span>
					</v-tooltip>
				</v-card-actions>
			</v-card>
		</v-dialog>
	</div>
</template>
<script>
	import AddHashCode from './AddHashCode.vue';
	import AddHashCodeButton from '../UI/addHashCodeButton.vue';
	import CleanHashCodeButton from '../UI/CleanHashCodeButton.vue';
	import {mdiPlusBox,mdiCancel,} from '@mdi/js';

	export default
		{
			components : {AddHashCode, AddHashCodeButton, CleanHashCodeButton},
			data()
			{
				return {
						task :
							{
								hashCode : '',
								name : '',
								type : 'required job',
								priority : 1,
								time : '01:00'
							},
						hashCodes : [],
						types : ['required job','non required job','required task','task','reminder'],
						priorities : [1,2,3],
						menu : false/*for task.time*/,
						icons : {mdiPlusBox,mdiCancel,},

						isShow : true,
						isShowAddHashCodeDialog : false
					}
			},
			methods :
			{

				clearCurrentHashCode(hashCode){
					this.task.hashCode = ''
					this.task.name = ''
					this.task.type = ''
					this.task.priority = ''
					this.task.time = ''
				},

				async hashCodeChangeHandler(hashCode)
				{
					const data = (await axios.post('/getSavedTask',{hash_code : hashCode})).data
					this.task.name = data[1]
					const types = this.types.slice()
					this.task.type = data[2] //types.reverse()[data[2]]
					this.task.priority = data[3]
					this.task.time = data[5]
				},
				async loadHashCodes()
				{
					this.hashCodes = (await axios.post('/getSavedTasks')).data.hash_codes.map((item) => item.hash_code)
					let {defaultSavedTasks} = (await axios.post('/getDefaultSavedTasks')).data;
					defaultSavedTasks = defaultSavedTasks.map((item) => item.hash_code);
					this.hashCodes = [...this.hashCodes, ...defaultSavedTasks];
				},
				addHashCode(hashCode)
				{
					axios.
					post
						(
							'/addHashCode',
							{
								hash : hashCode,
								name : this.task.name,
								type : this.task.type,
								priority : this.task.priority,
								time : this.task.time,
								details : '',
								notes : ''
							}
						)
					this.hashCodes.unshift(hashCode)
					this.task.hashCode = hashCode
				},
				toggleAddHashCodeDialog()
				{
					this.isShowAddHashCodeDialog = !this.isShowAddHashCodeDialog
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
				}
			},
			async created()
			{
				this.loadHashCodes()
			}
		}
</script>