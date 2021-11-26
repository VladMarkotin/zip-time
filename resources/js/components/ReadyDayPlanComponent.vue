<template>
	<div>
		<v-dialog max-width="650px" v-model="addJobDialog">
			<v-card>
				<v-card-title class="font-weight-bold v-card-title">Add job/task</v-card-title>
				<v-card-text>
					<v-text-field counter="25" label="Name" required v-model="task.name"></v-text-field>
					<v-select label="Type" v-bind:items="task.types" v-model="task.type"></v-select>
					<v-select label="Priority" v-bind:items="task.priorities" v-model="task.priority"></v-select>
					<v-text-field label="Time" required v-model="task.time"></v-text-field>
				</v-card-text>
				<v-divider></v-divider>
				<v-card-actions class="justify-space-between" style="margin-top : -20px">
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
							<v-btn icon v-on="on" v-on:click="hideAddJobDialog()">
								<v-icon color="#D71700" large>{{icons.mdiCancel}}</v-icon>
							</v-btn>
						</template>
						<span>Cancel</span>
					</v-tooltip>
				</v-card-actions>
			</v-card>
		</v-dialog>
		<!------------------------------------------------------------------------------------------------------------------------------------------------------------->
		<v-dialog max-width="650px" v-model="closeDayDialog">
			<v-card>
				<v-card-title class="font-weight-bold v-card-title">Close day</v-card-title>
				<v-card-text>
					<v-container>
						<v-row class="justify-center">
							<v-col cols="3">
								<v-text-field label="Own Mark" v-model="ownMark">
									<v-icon slot="append">mdi-percent</v-icon>
								</v-text-field>
							</v-col>
						</v-row>
						<v-row>
							<v-col>
								<v-textarea counter="256" label="Comment" rows="2" outlined shaped v-model="closeDayComment"></v-textarea>
							</v-col>
						</v-row>
					</v-container>
				</v-card-text>
				<v-divider></v-divider>
				<v-card-actions class="justify-space-between" style="margin-top : -20px">
					<v-tooltip right>
						<template v-slot:activator="{on}">
							<v-btn icon v-on="on" v-on:click="closeDay()">
								<v-icon color="#D71700" large>{{icons.mdiSendClock}}</v-icon>
							</v-btn>
						</template>
						<span>Close day</span>
					</v-tooltip>
					<v-tooltip right>
						<template v-slot:activator="{on}">
							<v-btn icon v-on="on" v-on:click="hideCloseDayDialog()">
								<v-icon color="#D71700" large>{{icons.mdiCancel}}</v-icon>
							</v-btn>
						</template>
						<span>Cancel</span>
					</v-tooltip>
				</v-card-actions>
			</v-card>
		</v-dialog>
		<!------------------------------------------------------------------------------------------------------------------------------------------------------------->
		<v-dialog max-width="650px" v-model="emergencyCallDialog">
			<v-card>
				<v-card-title class="font-weight-bold v-card-title">Emergency call</v-card-title>
				<v-card-text>
					<v-container>
						<v-row>
							<v-col cols="12" sm="7">
								<v-date-picker color="#A10000" range id="v-date-picker" v-model="dates"></v-date-picker>
							</v-col>
							<v-col cols="12" sm="5">
								<v-text-field label="Date period" prepend-icon="mdi-calendar" readonly v-model="dateRangeText"></v-text-field>
							</v-col>
						</v-row>							
						<v-row>
							<v-col cols="12">
								<v-textarea counter="256" label="Comment" rows="2" outlined shaped v-model="emergencyCallComment"></v-textarea>
							</v-col>
						</v-row>
					</v-container>
				</v-card-text>
				<v-divider></v-divider>
				<v-card-actions class="justify-space-between" style="margin-top : -20px">
					<v-tooltip right>
						<template v-slot:activator="{on}">
							<v-btn icon v-on="on" v-on:click="callEmergency()">
								<v-icon color="#D71700" large>{{icons.mdiCarEmergency}}</v-icon>
							</v-btn>
						</template>
						<span>Emergency call</span>
					</v-tooltip>
					<v-tooltip right>
						<template v-slot:activator="{on}">
							<v-btn icon v-on="on" v-on:click="hideEmergencyCallDialog()">
								<v-icon color="#D71700" large>{{icons.mdiCancel}}</v-icon>
							</v-btn>
						</template>
						<span>Cancel</span>
					</v-tooltip>
				</v-card-actions>
			</v-card>
		</v-dialog>
		<v-data-iterator hide-default-footer v-bind:items="['temp']">
			<CardsComponent title="Required tasks:" v-bind:items="plan.filter((item) => [4,2].includes(item.type))"></CardsComponent>
			<v-divider></v-divider>
			<CardsComponent title="Non required tasks:" v-bind:items="plan.filter((item) => [3,1].includes(item.type))"></CardsComponent>
		</v-data-iterator>
		<div class="d-flex justify-space-between mt-3">
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="showAddJobDialog()">
						<v-icon color="#D71700" large>{{icons.mdiPlusBox}}</v-icon>
					</v-btn>
				</template>
				<span>Add job/task</span>
			</v-tooltip>
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="showCloseDayDialog()">
						<v-icon color="#D71700" large>{{icons.mdiSendClock}}</v-icon>
					</v-btn>
				</template>
				<span>Close day</span>
			</v-tooltip>
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="showEmergencyCallDialog()">
						<v-icon color="#D71700" large>{{icons.mdiCarEmergency}}</v-icon>
					</v-btn>
				</template>
				<span>Emergency call</span>
			</v-tooltip>
		</div>
	</div>
</template>
<script>
	import AddJobComponent from './AddJobComponent.vue'
	import CardsComponent from './CardsComponent.vue'
	import {mdiPlusBox,mdiSendClock,mdiCarEmergency,mdiCancel} from '@mdi/js'
	export default
	{
		components : {AddJobComponent,CardsComponent},
		props : ['plan'],
		data()
		{
			const currDate = new Date()
			return {
					task :
						{
							name : '',
							type : 'required job',
							priority : 1,
							time : '',

							types : ['required job','non required job','required task','task','reminder'],
							priorities : [1,2,3]
						},
					icons : {mdiPlusBox,mdiSendClock,mdiCarEmergency,mdiCancel},
					addJobDialog : false,
					closeDayDialog : false,
					emergencyCallDialog : false,
					dates : [currDate.toEnStr(),currDate.addDays(2).toEnStr()],
					ownMark : '',
					closeDayComment : '',
					emergencyCallComment : ''
				}
		},
		computed :
		{
			dateRangeText()
			{
				return this.dates.join(' - ')
			}
		},
		methods :
		{
			async addJob()
			{
				const response = await axios.post('/addJob',{ownMark : this.ownMark,comment : this.closeDayComment})
				this.hideAddJobDialog()
			},
			async closeDay()
			{
				const response = await axios.post('/closeDay',{ownMark : this.ownMark,comment : this.closeDayComment})
				this.hideCloseDayDialog()
			},
			async callEmergency()
			{
				const response = await axios.post('/emergency',{from : this.dates[0],to : this.dates[1],comment : this.emergencyCallComment})
				this.hideEmergencyCallDialog()
			},
			runExpression(expr)
			{
				new Function(expr).bind(this)()
			},

			showAddJobDialog()
			{
				this.addJobDialog = true
			},
			hideAddJobDialog()
			{
				this.addJobDialog = false
			},
			showCloseDayDialog()
			{
				this.closeDayDialog = true
			},
			hideCloseDayDialog()
			{
				this.closeDayDialog = false
			},
			showEmergencyCallDialog()
			{
				this.emergencyCallDialog = true
			},
			hideEmergencyCallDialog()
			{
				this.emergencyCallDialog = false
			}
		}
	}
</script>
<style scoped>
	#v-date-picker
	{
		height : 325px
	}
	.v-card-title
	{
		background-color : #A10000;
		color : white
	}
</style>