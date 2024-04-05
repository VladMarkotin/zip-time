<template>
	<v-dialog max-width="650px" persistent v-model="isShow">
		<v-card>
			<v-card-title class="font-weight-bold v-card-title">Emergency call</v-card-title>
			<v-card-text>
				<v-container>
					<v-row>
						<v-col cols="12" sm="7">
							<v-date-picker color="#A10000" range v-model="dates"></v-date-picker>
						</v-col>
						<v-col cols="12" sm="5">
							<v-text-field label="Date period" prepend-icon="mdi-calendar" readonly v-model="dateRangeText"></v-text-field>
						</v-col>
					</v-row>
					<v-row>
						<v-col cols="12">
							<v-textarea counter="256" label="Comment" rows="2" outlined shaped v-model="comment" style="margin-top : -25px"></v-textarea>
						</v-col>
					</v-row>
				</v-container>
			</v-card-text>
			<v-divider></v-divider>
			<v-card-actions class="justify-space-between v-card-actions">
				<v-tooltip right>
					<template v-slot:activator="{on}">
						<v-btn icon v-on="on" v-on:click="callEmergency">
							<v-icon color="#D71700" large>{{icons.mdiCarEmergency}}</v-icon>
						</v-btn>
					</template>
					<span>Emergency call</span>
				</v-tooltip>
				<v-tooltip right>
					<template v-slot:activator="{on}">
						<v-btn icon v-on="on" v-on:click="toggle">
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
	import {mdiCarEmergency,mdiCancel} from '@mdi/js'
	export default
		{
			data()
			{
				const currDate = new Date()
				return {dates : [currDate.toEnStr(),currDate.addDays(2).toEnStr()],comment : '',icons : {mdiCarEmergency,mdiCancel}, isShow : true}
			},
			computed :
			{
				dateRangeText()
				{
					return this.dates.join(' - ')
				}
			},
			methods :
			{
				callEmergency()
				{
					axios.post('/emergency',{from : this.dates[0],to : this.dates[1],comment : this.comment})
					this.toggle()
				},
				toggle()
				{
					this.$emit('toggleEmergencyCallDialog')
				}
			}
		}
		
</script>