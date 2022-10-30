<template>  
	<v-card>
		<v-card-title class="font-weight-bold justify-space-between v-card-title">
			<span>{{item.hash}}</span>
			<span>{{item.taskName}}</span>
			<span v-if="item.priority == 1"> </span>
			<span v-else-if="item.priority == 2">!</span>
			<span v-else-if="item.priority == 3">!!</span>
			<span v-else>  </span>
		</v-card-title>
		<v-list>
			<v-list-item>
				<v-list-item-content>Time:</v-list-item-content>
				<v-list-item-content class="align-end" v-if="item.time.includes('00:')">{{item.time}}
					 minutes
				</v-list-item-content>
                <v-list-item-content class="align-end" v-else-if="item.time.includes('01:00')">{{item.time}}
					 hour
				</v-list-item-content>
				<v-list-item-content class="align-end" v-else>{{item.time}}
					 hours
				</v-list-item-content>
			</v-list-item>
			<v-list-item>
				<v-list-item-content>Details:</v-list-item-content>
				<v-list-item-content class="align-end">
					<v-textarea counter="256" rows="2" outlined shaped v-model="item.details"></v-textarea>
				</v-list-item-content>
			</v-list-item>
			<v-list-item>
				<v-list-item-content>Note:</v-list-item-content>
				<v-list-item-content class="align-end">
					<v-textarea counter="256" rows="2" outlined shaped v-model="item.notes"></v-textarea>
				</v-list-item-content>
			</v-list-item>
		</v-list>
		<v-divider></v-divider>
		<v-alert color="#404040" text class="elevation-1" v-bind:type="alert.type" v-if="isShowAlert">{{alert.text}}</v-alert>  
		<v-card-title class="font-weight-bold">
			<form class="d-flex align-center">
				<template v-if="[4,3].includes(item.type)">
					<div>Mark</div>
					<v-text-field class="ml-1" style="width : 54px" v-model="item.mark" v-on:keypress.enter.prevent="sendMark(item)">
						<v-icon slot="append">mdi-percent</v-icon>
					</v-text-field>
					<v-tooltip right>
						<template v-slot:activator="{on}">
							<v-btn icon v-on="on" v-on:click="sendMark(item)">
								<v-icon color="#D71700">{{icons.mdiUpdate}}</v-icon>
							</v-btn>
						</template>
						<span>Update</span>
					</v-tooltip>
				</template>
				
				<template v-else-if="[2,1].includes(item.type)">
					<div>Ready?</div>
					<v-checkbox color="#D71700" v-model="item.is_ready == 99 ? true : item.is_ready <= 50 ? false : true"></v-checkbox>
					<v-tooltip right>
						<template v-slot:activator="{on}">
							<v-btn icon v-on="on" v-on:click="sendIsReadyState(item)">
								<v-icon color="#D71700">{{icons.mdiUpdate}}</v-icon>
							</v-btn>
						</template>
						<span>Update</span>
					</v-tooltip>
				</template>
			</form>
		</v-card-title>
	</v-card>
</template>
<script>
	import {mdiUpdate} from '@mdi/js'
	import Alert from '../dialogs/Alert.vue'
	export default
	{
		props : ['item', 'num'],
		data()
		{
			return {icons      : {mdiUpdate},
			        isShowAlert: false ,
					alert      : {type: 'success', text: 'success'},
					//num        : 0
			}
		},
		components : {Alert},
		methods :
		{
			sendIsReadyState(item)
			{
				axios.post('/estimate',{task_id : item.taskId,details : item.details,note : item.notes,is_ready : item.is_ready,type : item.type})
				.then((response) => {
					this.isShowAlert = true;
					this.setAlertData(response.data.status, response.data.message)
					setTimeout( () => {
						this.isShowAlert = false;
						//debugger;
					},3000)
				  })
			},
			sendMark(item)
			{

				axios.post('/estimate',{task_id : item.taskId,details : item.details,note : item.notes,mark : item.mark,type : item.type})
				.then((response) => {
					this.isShowAlert = true;
					this.setAlertData(response.data.status, response.data.message)
					setTimeout( () => {
						this.isShowAlert = false;
					},3000)
				  })
			},
			toggleAlertDialog()
			{
				this.isShowAlert = !this.isShowAlert
			},
			
			setAlertData(type,text)
			{
				this.alert.type = type
				this.alert.text = text
			},
		}
	}
</script>
<style scoped>
	.v-card-title
	{
		background-color : #A10000;
		color : white
	}
</style>