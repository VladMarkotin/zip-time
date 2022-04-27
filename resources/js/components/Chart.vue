<template>
	<highcharts v-bind:options="options"></highcharts>
</template>
<script>
	import {Chart} from 'highcharts-vue';
	export default
	{
		components: {highcharts: Chart},
		props: ['finalMarks', 'ownMarks'],
		data()
		{
			return {
				options:
					{
						series: [{name: 'Final marks', data: this.finalMarks}, {name: 'Own marks', data: this.ownMarks}],
						title: {text: null},
						xAxis: {title: {text: 'Day'}, type: 'datetime'},
						yAxis: {title: {text: 'Mark'}}
					}
			};
		}
	}
</script>