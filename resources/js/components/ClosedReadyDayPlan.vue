<template>
	<v-card>
		<v-card-title class="font-weight-bold justify-space-between v-card-title">
			<span>Date: {{date.toEnStr()}}</span>
			<span>Finished</span>
			<span>Status: {{getDayStatus(data.dayStatus)}}</span>
		</v-card-title>
		<v-list>
			<v-list-item>
				<v-list-item-content class="key">Final mark:</v-list-item-content>
				<v-list-item-content class="align-end">{{data.dayFinalMark}} %</v-list-item-content>
			</v-list-item>
			<v-list-item>
				<v-list-item-content class="key">Own mark:</v-list-item-content>
				<v-list-item-content class="align-end">{{data.dayOwnMark}} %</v-list-item-content>
			</v-list-item>
			<v-list-item>
				<v-list-item-content class="key">Comment:</v-list-item-content>
				<v-list-item-content class="align-end">{{data.comment}}</v-list-item-content>
			</v-list-item>
		</v-list>
		<v-card-actions class="d-flex justify-space-between">
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="setDataByDate(date = date.subtractDays(1))">
						<v-icon color="#D71700" large>{{icons.mdiArrowLeft}}</v-icon>
					</v-btn>
				</template>
				<span>Prev day</span>
			</v-tooltip>
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="setDataByDate(date = new Date())">
						<v-icon color="#D71700" large>{{icons.mdiCalendarToday}}</v-icon>
					</v-btn>
				</template>
				<span>Today</span>
			</v-tooltip>
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="setDataByDate(date = date.addDays(1))">
						<v-icon color="#D71700" large>{{icons.mdiArrowRight}}</v-icon>
					</v-btn>
				</template>
				<span>Next day</span>
			</v-tooltip>
		</v-card-actions>
	</v-card>
</template>
<script>
	import {mdiArrowLeft,mdiCalendarToday,mdiArrowRight} from '@mdi/js'
	export default
	{
		props : ['data'],
		data()
		{
			return {date : new Date(),icons : {mdiArrowLeft,mdiCalendarToday,mdiArrowRight}}
		},
		methods :
			{
				async setDataByDate(date)
				{
					const strDate = date.toEnStr()
					const response = await axios.get(`/hist/${strDate}`)
					this.data.dayStatus = response.data.plans[strDate].dayStatus
					this.data.dayFinalMark = response.data.plans[strDate].dayFinalMark
					this.data.dayOwnMark = response.data.plans[strDate].dayOwnMark
					this.data.comment = response.data.plans[strDate].comment
				},
				getDayStatus(status)
				{
					return {
							'-1' : 'Fine (Day was not completed)',
							'0' : 'Emergency mode',
							'1' : 'Weekend mode',
							'2' : 'In progress',
							'3' : 'Success'
						}[status]
				}
			}
	}
</script>
<style scoped>
	.key
	{
		font-weight : bold
	}
</style>