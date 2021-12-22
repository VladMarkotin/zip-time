<template>
	<v-card>
		<v-card-title class="font-weight-bold justify-space-between v-card-title">
			<span>Date: |Date|</span>
			<span>Finished</span>
			<span>Status: |Status|</span>
		</v-card-title>
		<v-list>
			<v-list-item>
				<v-list-item-content class="key">Final mark:</v-list-item-content>
				<v-list-item-content class="align-end">|Final mark|</v-list-item-content>
			</v-list-item>
			<v-list-item>
				<v-list-item-content class="key">Own mark:</v-list-item-content>
				<v-list-item-content class="align-end">|Own mark|</v-list-item-content>
			</v-list-item>
			<v-list-item>
				<v-list-item-content class="key">Comment:</v-list-item-content>
				<v-list-item-content class="align-end">|Comment|</v-list-item-content>
			</v-list-item>
		</v-list>
		<v-card-actions class="d-flex justify-space-between">
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on">
						<v-icon color="#D71700" large>{{icons.mdiArrowLeft}}</v-icon>
					</v-btn>
				</template>
				<span>Prev day</span>
			</v-tooltip>
			<v-btn>Today</v-btn>
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on">
						<v-icon color="#D71700" large>{{icons.mdiArrowRight}}</v-icon>
					</v-btn>
				</template>
				<span>Next day</span>
			</v-tooltip>
		</v-card-actions>
	</v-card>
</template>
<script>
	import {mdiArrowLeft,mdiArrowRight} from '@mdi/js'
	export default
	{
		data()
		{
			return {icons : {mdiArrowLeft,mdiArrowRight}}
		}
	}
</script>
<style scoped>
	.key
	{
		font-weight : bold
	}
</style>