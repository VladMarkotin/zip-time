<template>
	<v-card>
		<v-card-title class="font-weight-bold justify-space-between v-card-title">
			<span>Set Timeframe:</span>
			<div>
				From:
				<v-text-field></v-text-field>
				To:
				<v-text-field></v-text-field>
			</div>
			<v-btn>Apply</v-btn>
		</v-card-title>
		<v-list>
			<v-list-item>
				<v-list-item-content>@Key:</v-list-item-content>
				<v-list-item-content class="align-end">@val</v-list-item-content>
			</v-list-item>
			<v-list-item>
				<v-list-item-content>@Key2:</v-list-item-content>
				<v-list-item-content class="align-end">@val2</v-list-item-content>
			</v-list-item>
		</v-list>
		<v-divider></v-divider>
		<v-card-title class="font-weight-bold">
		</v-card-title>
	</v-card>
</template>
<script>
	export default {}
</script>