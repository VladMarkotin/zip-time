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
			<Chart v-bind:finalMarks="finalMarks" v-bind:ownMarks="ownMarks"/>
		</v-card-text>
		<!-- Хз почему без этой строки не отображается график -->
		{{finalMarks.unknownVar}}
	</v-card>
</template>
<script>
	import Chart from '../Chart.vue';
	export default
		{
			components: {Chart},
			data()
			{
				return {finalMarks: null, ownMarks: null};
			},
			methods:
				{
					async loadMarks()
					{
						const data = (await axios.get('/stat')).data;
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