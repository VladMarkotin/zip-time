<template>
	<div>
		<template v-if="isShowAddJobTaskDialog">
			<AddJobTask v-on:hideAddJobTaskDialog="hideAddJobTaskDialog()"/>
		</template>
		<template v-if="isShowCloseDayDialog">
			<CloseDay v-on:hideCloseDayDialog="hideCloseDayDialog()"/>
		</template>
		<template v-if="isShowEmergencyCallDialog">
			<EmergencyCall v-on:hideEmergencyCallDialog="hideEmergencyCallDialog()"/>
		</template>
		<v-data-iterator hide-default-footer v-bind:items="plan">
			<Cards title="Required tasks:" v-bind:items="plan.filter((item) => [4,2].includes(item.type))"/>
			<v-divider></v-divider>
			<Cards title="Non required tasks:" v-bind:items="plan.filter((item) => [3,1].includes(item.type))"/>
		</v-data-iterator>
		<div class="d-flex justify-space-between mt-3">
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="showAddJobTaskDialog()">
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
	import AddJobTask from './dialogs/AddJobTask.vue'
	import CloseDay from './dialogs/CloseDay.vue'
	import Cards from './cards/Cards.vue'
	import EmergencyCall from './dialogs/EmergencyCall.vue'
	import {mdiCarEmergency,mdiPlusBox,mdiSendClock} from '@mdi/js'
	export default
	{
		components : {AddJobTask,CloseDay,Cards,EmergencyCall},
		props : ['plan'],
		data()
		{
			return {isShowAddJobTaskDialog : false,isShowCloseDayDialog : false,isShowEmergencyCallDialog : false,icons : {mdiCarEmergency,mdiPlusBox,mdiSendClock}}
		},
		methods :
		{
			showAddJobTaskDialog()
			{
				this.isShowAddJobTaskDialog = true
			},
			hideAddJobTaskDialog()
			{
				this.isShowAddJobTaskDialog = false
			},
			showCloseDayDialog()
			{
				this.isShowCloseDayDialog = true
			},
			hideCloseDayDialog()
			{
				this.isShowCloseDayDialog = false
			},
			showEmergencyCallDialog()
			{
				this.isShowEmergencyCallDialog = true
			},
			hideEmergencyCallDialog()
			{
				this.isShowEmergencyCallDialog = false
			}
		}
	}
</script>
<style>
	.v-card-actions
	{
		margin-top : -20px
	}
	.v-card-title
	{
		background-color : #A10000;
		color : white
	}
</style>