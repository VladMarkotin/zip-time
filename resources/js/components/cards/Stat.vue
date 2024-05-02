<template>
	<v-card>
		<v-card-title class="font-weight-bold justify-space-between v-card-title">
			<span>Set Timeframe:</span>
			<table>
				<tr>
					<td>
						<v-dialog ref="v-dialog-dates-from-val" width="290px" persistent v-bind:return-value.sync="dates.from.val" v-model="dates.from.modal">
							<template v-slot:activator="{on}">
								<v-text-field label="From" prepend-icon="mdi-calendar" dark readonly v-model="dates.from.val" v-on="on"></v-text-field>
							</template>
							<v-date-picker color="#D71700" v-model="dates.from.val">
								<v-spacer></v-spacer>
								<v-btn color="#D71700" text v-on:click="$refs['v-dialog-dates-from-val'].save(dates.from.val)">OK</v-btn>
								<v-btn color="#D71700" text v-on:click="dates.from.modal = false">Cancel</v-btn>
							</v-date-picker>
						</v-dialog>
					</td>
				</tr>
				<tr>
					<td>
						<v-dialog ref="v-dialog-dates-to-val" width="290px" persistent v-bind:return-value.sync="dates.to.val" v-model="dates.to.modal">
							<template v-slot:activator="{on}">
								<v-text-field label="To" prepend-icon="mdi-calendar" dark readonly v-model="dates.to.val" v-on="on"></v-text-field>
							</template>
							<v-date-picker color="#D71700" v-model="dates.to.val">
								<v-spacer></v-spacer>
								<v-btn color="#D71700" text v-on:click="$refs['v-dialog-dates-to-val'].save(dates.to.val)">OK</v-btn>
								<v-btn color="#D71700" text v-on:click="dates.to.modal = false">Cancel</v-btn>
							</v-date-picker>
						</v-dialog>
					</td>
				</tr>
			</table>
			<v-btn v-on:click="loadMarksFromPeriod(dates.from.val, dates.to.val)">Apply</v-btn>
		</v-card-title>
		<v-card-text>
			<v-list>
				<v-list-item>
					<v-list-item-content>Completed days:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.completedDays}} days</v-list-item-content>
				</v-list-item>
				<v-list-item>
					<v-list-item-content>Failed days:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.failedDays}} days</v-list-item-content>
				</v-list-item>
				<v-list-item>
					<v-list-item-content>Emergency mode:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.emergencyModes}} times</v-list-item-content>
				</v-list-item>
				<v-list-item>
					<v-list-item-content>Weekends:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.weekends}}</v-list-item-content>
				</v-list-item>
				<v-list-item>
					<v-list-item-content>Total time:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.totalTime}} hours</v-list-item-content>
				</v-list-item>
				<v-list-item>
					<v-list-item-content>Average mark:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.avgMark}}%</v-list-item-content>
				</v-list-item>
				<v-list-item>
					<v-list-item-content>Average own mark:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.ownAvgMark}}%</v-list-item-content>
				</v-list-item>
				<v-list-item>
					<v-list-item-content>Max mark:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.maxMark}}%</v-list-item-content>
				</v-list-item>
				<v-list-item>
					<v-list-item-content>Min mark:</v-list-item-content>
					<v-list-item-content class="align-end">{{mainStat.minMark}}%</v-list-item-content>
				</v-list-item>
			</v-list>
		</v-card-text>
		<v-card-text>
			<Chart 
			ref="chart" 
			v-bind:marks="marks"
			:screenWidth = "screenWidth"
			/>
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
				const currDate = new Date().toEnStr();
				return {
					dates: {from: {modal: false, val: currDate}, 
					to: {modal: false, val: currDate}}, 
					mainStat: {}, 
					marks: [],
					screenWidth: window.innerWidth,
				};
			},
			methods:
				{
					async loadMarks()
					{
						const data = (await axios.get('get-stat-data')).data;
						this.mainStat = data.mainStat;
						this.marks = {...{final: data.marks.finalMarks, own: data.marks.ownMarks}};
					},
					async loadMarksFromPeriod(from, to)
					{
						const data = (await axios.post('/stat', {from, to})).data;
						this.mainStat = data.mainStat;
						this.marks = {...{final: data.marks.finalMarks, own: data.marks.ownMarks}};
						this.$refs.chart.redraw(this.marks);
					},

					updateScreenWidth() {
            			this.screenWidth = window.innerWidth;
        			}	
				},
			
			beforeMount()
			{
				this.loadMarks();
			},

			mounted() {
				window.addEventListener('resize', this.updateScreenWidth);
			},

			beforeDestroy() {
				window.removeEventListener('resize', this.updateScreenWidth);
			}
		};
</script>
<style scoped>
	.v-card-title
	{
		background-color: #A10000;
		color: white;
	}
	.v-label
	{
		color: white !important;
	}
	td
	{
		font-weight: bold;
	}
</style>