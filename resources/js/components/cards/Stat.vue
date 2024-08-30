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
		<v-card-text class="stat_main-data-wrapper">
			<v-list class="stat-main-data-list">
				<v-list-item class="stat-main-data-li">
					<v-list-item-content class="stat-main-data-li-item">
						<span>Completed days: </span>
						<span>{{mainStat.completedDays}} days</span>
					</v-list-item-content>
				</v-list-item>
				<v-list-item class="stat-main-data-li">
					<v-list-item-content class="stat-main-data-li-item">
						<span>Failed days:</span>
						<span>{{mainStat.failedDays}} days</span>
					</v-list-item-content>
				</v-list-item>
				<v-list-item class="stat-main-data-li">
					<v-list-item-content class="stat-main-data-li-item">
						<span>Emergency mode:</span>
						<span>{{mainStat.emergencyModes}} times</span>
					</v-list-item-content>
				</v-list-item>
				<v-list-item class="stat-main-data-li">
					<v-list-item-content class="stat-main-data-li-item">
						<span>Weekends:</span>
						<span>{{mainStat.weekends}} days</span>
					</v-list-item-content>
				</v-list-item>
				<v-list-item class="stat-main-data-li">
					<v-list-item-content class="stat-main-data-li-item">
						<span>Total time:</span>
						<span>{{mainStat.totalTime}} hours</span>
					</v-list-item-content>
				</v-list-item>
				<v-list-item class="stat-main-data-li">
					<v-list-item-content class="stat-main-data-li-item">
						<span>Average mark:</span>
						<span>{{mainStat.avgMark}}%</span>
					</v-list-item-content>
				</v-list-item>
				<v-list-item class="stat-main-data-li"> 
					<v-list-item-content class="stat-main-data-li-item">
						<span>Average own mark:</span>
						<span>{{mainStat.ownAvgMark}}%</span>
					</v-list-item-content>
				</v-list-item>
				<v-list-item class="stat-main-data-li">
					<v-list-item-content class="stat-main-data-li-item">
						<span>Max mark:</span>
						<span>{{mainStat.maxMark}}%</span>
					</v-list-item-content>
				</v-list-item>
				<v-list-item class="stat-main-data-li">
					<v-list-item-content class="stat-main-data-li-item">
						<span>Min mark:</span>
						<span>{{mainStat.minMark}}%</span>
					</v-list-item-content>
				</v-list-item>
			</v-list>
		</v-card-text>
		<v-card-text class="stat_chart-wrapper">
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
				const currDate    = new Date();
				const weekAgoDate = new Date(currDate);
				weekAgoDate.setDate(currDate.getDate() - 6);

				return {
					dates: {
						from: {modal: false, val: weekAgoDate.toEnStr()}, 
						to:   {modal: false, val: currDate.toEnStr()}
					}, 
					mainStat: {}, 
					marks: [],
					screenWidth: window.innerWidth,
				};
			},
			methods:
				{
					async loadMarks()
					{
						const data = (await axios.post('/get-stat-data', {from: this.dates.from.val, to: this.dates.to.val})).data;
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

	.stat-main-data-list .stat-main-data-li .stat-main-data-li-item {
		display: grid;
		grid-template-columns: 180px 120px;
		grid-column-gap: 15px;
		justify-content: center;
	}

	.stat-main-data-list .stat-main-data-li span {
		margin-bottom: 0;
	}

	@import url('/css/Stat/StatMedia.css');
</style>