<template>
	<v-card>
		<v-card-title class="font-weight-bold justify-space-between v-card-title">
			<span>Set Timeframe:</span>
			<table>
				<tr>
					<td>From:</td>
					<td>
						<v-text-field/>
					</td>
				</tr>
				<tr>
					<td>To:</td>
					<td>
						<v-text-field/>
					</td>
				</tr>
			</table>
			<v-btn>Apply</v-btn>
		</v-card-title>
		<v-card-text>
			<v-list>
				<v-list-item>
					<v-list-item-content>Completed days:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.completedDays}}</v-list-item-content>
				</v-list-item>
				<v-list-item>
					<v-list-item-content>Failed days:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.failedDays}}</v-list-item-content>
				</v-list-item>
				<v-list-item>
					<v-list-item-content>Emergency calls:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.emergencyModes}}</v-list-item-content>
				</v-list-item>
				<v-list-item>
					<v-list-item-content>Weekends:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.weekends}}</v-list-item-content>
				</v-list-item>
				<v-list-item>
					<v-list-item-content>Total time:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.totalTime}}</v-list-item-content>
				</v-list-item>
				<v-list-item>
					<v-list-item-content>Average mark:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.avgMark}}</v-list-item-content>
				</v-list-item>
				<v-list-item>
					<v-list-item-content>Average own mark:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.ownAvgMark}}</v-list-item-content>
				</v-list-item>
				<v-list-item>
					<v-list-item-content>Max mark:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.maxMark}}</v-list-item-content>
				</v-list-item>
				<v-list-item>
					<v-list-item-content>Min mark:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.minMark}}</v-list-item-content>
				</v-list-item>
			</v-list>
		</v-card-text>
		<v-card-text>
			<Chart v-bind:finalMarks="finalMarks" v-bind:ownMarks="ownMarks"/>
		</v-card-text>
	</v-card>
</template>
<script>
	import Chart from '../Chart.vue';
	export default
		{
			components: {Chart},
			data()
			{
				return {mainStat: null, finalMarks: null, ownMarks: null};
			},
			methods:
				{
					async loadMarks()
					{
						const data = (await axios.get('/stat')).data;
						this.mainStat = data.mainStat;
						this.finalMarks = data.marks.finalMarks;
						this.ownMarks = data.marks.ownMarks;
					}
				},
			beforeMount()
			{
				this.loadMarks();
			}
		};
</script>
<style scoped>
	.v-card-title
	{
		background-color: #A10000;
		color: white;
	}
	td
	{
		background-color: #A10000;
		color: white;
		font-weight: bold;
	}
</style>