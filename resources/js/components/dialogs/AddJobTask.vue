<template>
	<v-dialog max-width="650px" v-model="dialog">
		<v-card>
			<v-card-title class="font-weight-bold v-card-title">Add job/task</v-card-title>
			<v-card-text>
				<v-text-field counter="25" label="Name" required v-model="task.name"></v-text-field>
				<v-select label="Type" v-bind:items="task.types" v-model="task.type"></v-select>
				<v-select label="Priority" v-bind:items="task.priorities" v-model="task.priority"></v-select>
				<v-menu ref="v-menu" v-bind:close-on-content-click="false" v-model="menu">
					<template v-slot:activator="{on}">
						<v-text-field label="Time" v-model="task.time" v-on="on"></v-text-field>
					</template>
					<v-time-picker color="#D71700" v-on:click:minute="$refs['v-menu'].save(task.time)" v-model="task.time"></v-time-picker>
				</v-menu>
			</v-card-text>
			<v-divider></v-divider>
			<v-card-actions class="justify-space-between v-card-actions">
				<v-tooltip right>
					<template v-slot:activator="{on}">
						<v-btn icon v-on="on" v-on:click="addJob()">
							<v-icon color="#D71700" large>{{icons.mdiPlusBox}}</v-icon>
						</v-btn>
					</template>
					<span>Add job/task</span>
				</v-tooltip>
				<v-tooltip right>
					<template v-slot:activator="{on}">
						<v-btn icon v-on="on" v-on:click="hide()">
							<v-icon color="#D71700" large>{{icons.mdiCancel}}</v-icon>
						</v-btn>
					</template>
					<span>Cancel</span>
				</v-tooltip>
			</v-card-actions>
		</v-card>
	</v-dialog>
</template>
<script>
	import {mdiPlusBox,mdiCancel} from '@mdi/js'
	export default
		{
			data()
			{
				return {
						dialog : true,
						task :
							{
								name : '',
								type : 'required job',
								priority : 1,
								time : '',

								types : ['required job','non required job','required task','task','reminder'],
								priorities : [1,2,3]
							},
						icons : {mdiPlusBox,mdiCancel},

						menu : false/*for task.time*/
					}
			},
			methods :
			{
				async addJob()
				{
					const response = await axios.post('/addJob',{name : this.task.name,type : this.task.type,priority : this.task.priority,time : this.task.time})
					this.hide()
				},
				hide()
				{
					this.$emit('hideAddJobTaskDialog')
				}
			}
		}
</script>