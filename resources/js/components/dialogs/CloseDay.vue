<template>
	<v-dialog max-width="650px" persistent v-model="isShow">
		<v-card>
			<v-card-title class="font-weight-bold v-card-title">Close day</v-card-title>
			<v-card-text>
				<v-container>
					<v-row class="justify-center">
						<v-col cols="3">
							<v-text-field label="Own Mark" required v-model="ownMark">
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
			<v-alert color="#404040" text class="elevation-1" v-bind:type="alert.type" v-if="isShowAlert">{{alert.text}}</v-alert>  
			<v-card-actions class="justify-space-between v-card-actions">
				<v-tooltip right>
					<template v-slot:activator="{on}">
						<v-btn icon v-on="on" v-on:click="closeDay">
							<v-icon color="#D71700" large>{{icons.mdiSendClock}}</v-icon>
						</v-btn>
					</template>
					<span>Close day</span>
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
	import {mdiCancel,mdiSendClock} from '@mdi/js'
	import Alert from '../dialogs/Alert.vue'
	export default
		{
			data()
			{
				return {ownMark : '',comment : '',
				  isShowAlert: false,
				  icons : {mdiCancel,mdiSendClock},
				  isShow : true,
				  alert      : {type: 'success', text: 'success'},}
			},
			components : {Alert},
			methods :
			{
				closeDay()
				{
					axios.post('/closeDay',{ownMark : this.ownMark,comment : this.comment})
					.then((response) => {
						this.isShowAlert = true;
						this.setAlertData(response.data.status, response.data.message)
						if(response.data.status){
							setTimeout( () => {
									this.isShowAlert = false;
									this.toggle()
							},5000)
					    }
				  })
				},
				toggle()
				{
					this.$emit('toggleCloseDayDialog')
				},
				setAlertData(type,text)
				{
					this.alert.type = type
					this.alert.text = text
				},
			}
		}
</script>