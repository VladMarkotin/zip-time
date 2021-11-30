<template>
	<v-dialog max-width="650px" v-model="dialog">
		<v-card>
			<v-card-title class="font-weight-bold v-card-title">Close day</v-card-title>
			<v-card-text>
				<v-container>
					<v-row class="justify-center">
						<v-col cols="3">
							<v-text-field label="Own Mark" v-model="ownMark">
								<v-icon slot="append">mdi-percent</v-icon>
							</v-text-field>
						</v-col>
					</v-row>
					<v-row>
						<v-col>
							<v-textarea counter="256" label="Comment" rows="2" outlined shaped v-model="comment"></v-textarea>
						</v-col>
					</v-row>
				</v-container>
			</v-card-text>
			<v-divider></v-divider>
			<v-card-actions class="justify-space-between v-card-actions">
				<v-tooltip right>
					<template v-slot:activator="{on}">
						<v-btn icon v-on="on" v-on:click="closeDay()">
							<v-icon color="#D71700" large>{{icons.mdiSendClock}}</v-icon>
						</v-btn>
					</template>
					<span>Close day</span>
				</v-tooltip>
				<v-tooltip right>
					<template v-slot:activator="{on}">
						<v-btn icon v-on="on" v-on:click="hide()">
							<v-icon color="#D71700" large>{{icons.mdiCancel}}</v-icon>
						</v-btn>
					</template>
					<span>Cancel</span>
				</v-tooltip>
			</v-card-actions>
		</v-card>
	</v-dialog>
</template>
<script>
	import {mdiCancel,mdiSendClock} from '@mdi/js'
	export default
		{
			data()
			{
				return {dialog : true,ownMark : '',comment : '',icons : {mdiCancel,mdiSendClock}}
			},
			methods :
			{
				async closeDay()
				{
					const response = await axios.post('/closeDay',{ownMark : this.ownMark,comment : this.comment})
					this.hide()
				},
				hide()
				{
					this.$emit('hideCloseDayDialog')
				}
			}
		}
</script>