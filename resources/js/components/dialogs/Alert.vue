<template>
	<v-dialog max-width="650px" persistent v-model="isShow">
		<v-card>
			<v-card-title class="font-weight-bold v-card-title">Message</v-card-title>
			<v-card-text>
				<v-container>
					<v-alert v-bind:type="type" color="#404040" text class="elevation-1" v-bind:value="true">{{text}}</v-alert>
				</v-container>
			</v-card-text>
			<v-divider></v-divider>
			<v-card-actions class="justify-end v-card-actions">
				<v-tooltip right>
					<template v-slot:activator="{on}">
						<v-btn icon v-on="on" v-on:click="toggle">
							<v-icon color="#D71700" large>{{mdiCancel}}</v-icon>
						</v-btn>
					</template>
					<span>Cancel</span>
				</v-tooltip>
			</v-card-actions>
		</v-card>
	</v-dialog>
</template>
<script>
	import {mdiCancel} from '@mdi/js'
	export default
		{
			props : ['type','text'],
			data()
			{
				return {mdiCancel, isShow : true}
			},
			methods :
			{
				toggle()
				{
					this.$emit('toggleAlertDialog')
				}
			},
			created()
			{
				setTimeout(this.toggle,this.$root.alertDelay)
			}
		}
</script>