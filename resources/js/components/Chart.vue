<template>
	<highcharts ref="highcharts" v-bind:options="options"></highcharts>
</template>
<script>
	import {Chart} from 'highcharts-vue';
	export default
	{
		components: {highcharts: Chart},
		props: ['marks', 'screenWidth'],
		computed: {
			options() {
				const yAxisTitle = this.screenWidth > 500 ? 'Mark' : '';

				return {
					series: [{name: 'Final marks', data: this.marks.final}, {name: 'Own marks', data: this.marks.own}],
					title: {text: null},
					xAxis: {title: {text: 'Day'}, type: 'datetime'},
					yAxis: {title: {text: yAxisTitle}}
				}
			}
		},
		methods:
			{
				redraw(marks)
				{
					this.$refs.highcharts.chart.series[0].setData(marks.final);
					this.$refs.highcharts.chart.series[1].setData(marks.own);
				}
			}
	}
</script>