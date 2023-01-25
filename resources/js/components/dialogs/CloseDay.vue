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
					<v-row justify="space-around">
						<v-col
						cols="12"
						sm="10"
						md="8"
						>
						<v-sheet
							elevation="20"
							class="py-4 px-1"
						>
							<v-chip-group
							multiple
							active-class="primary--text"
							v-model="chosenChips"
							>
							<v-chip
								v-for="tag in tags"
								:key="tag"
							>
								{{ tag }}
							</v-chip>
							</v-chip-group>
						</v-sheet>
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
				<v-progress-circular
					:rotate="90"
					:size="100"
					:width="5"
					:value="value"
					color="red"
					class="v-progress-circular"
					v-if="isShowProgress"
				>
					{{ value }}
				</v-progress-circular>
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
			data: () => ({
				ownMark : '',comment : '',
				isShowAlert: false,
				icons : {mdiCancel,mdiSendClock},
				isShow : true,
				alert      : {type: 'success', text: 'success'},
				interval: {},
				value: 0,
				isShowProgress: false,
				tags: [],
				chosenChips: []
				
			}),
			components : {Alert},
			methods :
			{
				closeDay()
				{
					let chosenChipValues = [];
					for(let i = 0; i < this.chosenChips.length; i++){
                        chosenChipValues.push(this.tags[this.chosenChips[i] ])
					}
					axios.post('/closeDay',{ownMark : this.ownMark,comment : this.comment, tomorow: chosenChipValues})
					.then((response) => {
						this.isShowAlert = true;
						this.setAlertData(response.data.status, response.data.message)
						if(response.data.status != "error"){
							this.isShowProgress = true;
							this.interval = setInterval(() => {
							if (this.value === 100) {
								clearInterval(this.interval)
								return (this.value = 100)
							}
								this.value += 20
							}, 500)
							setTimeout( () => {
									this.isShowAlert    = false;
									this.isShowProgress = false;
									this.toggle()
									document.location.reload();
							},5000)
					    }else{
							setTimeout( () => {
									this.isShowAlert    = false;
									this.isShowProgress = false;
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

				async loadHashCodes()
				{
					const response = (await axios.post('/getSavedTasks')).data; //.map((item) => item.hash_code)
					debugger;
/*
: 
Array(13)
0
: 
{hash_code: '#exc'}
1
: 
{hash_code: '#sys'}
*/

					//this.tags = [response[0].hash_code,2,3]
					//this.hashCodes = response.data.hash_codes;
					let length = response.data.hash_codes.length;
					debugger	
					for (let i = 0; i < length; i++) {
							this.tags[i] = response.data.hash_codes[i].hash_code; //this.hashCodes[i].hash_code
							;
							//console.log(currentObj.tags.value)
					}
				} 
			},
			async mounted() {
				this.loadHashCodes()
				//let currentObj = this;
				/*axios.post('/getSavedTasks')
				.then((response) => {
					
				})*/
			}
		}
</script>
<style scoped>
	.v-progress-circular{
		width: 50px;
		margin: auto;
	}
</style>