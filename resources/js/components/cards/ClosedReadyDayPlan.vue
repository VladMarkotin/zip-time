<template>
	<v-card>
		<Challenges />
		<v-card-title class="font-weight-bold justify-space-between v-card-title">
			<span>Date: {{date.toEnStr()}}</span>
			<span>Finished</span>
			<span>Status: {{getDayStatusName(data.dayStatus)}}</span>
		</v-card-title>
		<v-list>
			<v-list-item>
				<v-list-item-content class="key">Final mark:</v-list-item-content>
				<v-list-item-content class="align-end" v-if="data.dayFinalMark > 0 ">{{data.dayFinalMark}} %</v-list-item-content>
				<v-list-item-content class="align-end" v-else> - </v-list-item-content>
			</v-list-item>
			<v-list-item>
				<v-list-item-content class="key" >Own mark:</v-list-item-content>
                <v-list-item-content class="align-end" v-if="data.dayOwnMark > 0 ">{{data.dayOwnMark}} %</v-list-item-content>
				<v-list-item-content class="align-end" v-else> - </v-list-item-content>
			</v-list-item>
			<v-list-item class="comment-wrapper">
				<v-list-item-content class="key d-flex comment-key-wrapper">
					<span>Comment:</span>
					<div class="d-flex justify-content-center comment-buttons-wrapper">
						<v-tooltip left>
							<template v-slot:activator="{on}">
								<v-btn 
								icon 
								v-on="on" 
								v-on:click="editComment"
								:disabled="isCommentEdited"
								>
									<v-icon color="#D71700" large> {{icons.mdiPencil}} </v-icon>
								</v-btn>
							</template>
							<span>Edit comment</span>
						</v-tooltip>
						<v-tooltip right>
							<template v-slot:activator="{on}">
								<v-btn 
								icon 
								v-on="on" 
								v-on:click="saveComment"
								:disabled="!isCommentEdited"
								>
									<v-icon color="#D71700" large> {{icons.mdiContentSaveMoveOutline }} </v-icon>
								</v-btn>
							</template>
							<span>Save comment</span>
						</v-tooltip>
					</div>
				</v-list-item-content>
				<v-list-item-content class="align-end" v-if="!isCommentEdited">
					{{commentText}}
				</v-list-item-content>
				<v-list-item-content class="align-end" v-else>
					<v-textarea
					    solo
						clear-icon="mdi-close-circle"
						label="Describe your day"
						v-model="newComment"
						clearable
						@keydown.enter="saveComment"
					></v-textarea>
				</v-list-item-content>
			</v-list-item>
		</v-list>
		<v-card-actions class="d-flex justify-space-between">
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="setData(date = date.subtractDays(1),-1)" v-bind:disabled="disabled.prevButton">
						<v-icon color="#D71700" large>{{icons.mdiArrowLeft}}</v-icon>
					</v-btn>
				</template>
				<span>Prev day</span>
			</v-tooltip>
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="setData(date = new Date(),0)">
						<v-icon color="#D71700" large>{{icons.mdiCalendarToday}}</v-icon>
					</v-btn>
				</template>
				<span>Today</span>
			</v-tooltip>
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="setData(date = date.addDays(1),1)" v-bind:disabled="disabled.nextButton">
						<v-icon color="#D71700" large>{{icons.mdiArrowRight}}</v-icon>
					</v-btn>
				</template>
				<span>Next day</span>
			</v-tooltip>
		</v-card-actions>
	</v-card>
</template>
<script>
	import {mdiArrowLeft,mdiCalendarToday,mdiArrowRight, mdiPencil, mdiContentSaveMoveOutline } from '@mdi/js'
	import Challenges from "./../challenges/Challenges.vue";
import { data } from 'jquery';

	export default
	{
		props : ['data'],
		components: { Challenges },
		data()
		{
			const commentText = this.data.comment;

			return {date : new Date(),
				   icons : {mdiArrowLeft,mdiCalendarToday,mdiArrowRight, mdiPencil, mdiContentSaveMoveOutline },
			       disabled : {prevButton : false,nextButton : true},
				   commentText,
				   newComment: '',
				   isCommentEdited: false,
		   }
		},
		methods :
			{
				async setData(date,direction)
				{
					const strDate = date.toEnStr()
					const data = (await axios.get(`/hist/${strDate}`,{params : {direction}})).data
					this.data.dayStatus = data.plans[strDate].dayStatus
					this.data.dayFinalMark = data.plans[strDate].dayFinalMark
					this.data.dayOwnMark = data.plans[strDate].dayOwnMark
					this.data.comment = data.plans[strDate].comment
					this.disabled.prevButton = data.histLength == 0 
					this.disabled.nextButton = date.toEnStr() == new Date().toEnStr()
				},
				getDayStatusName(statusCode)
				{
					return {
							'-1' : 'Fine (Day was not completed)',
							'0' : 'Emergency mode',
							'1' : 'Weekend mode',
							'2' : 'In progress',
							'3' : 'Success'
						}[statusCode]
				},
				editComment () {
					this.isCommentEdited = true;
					this.newComment = this.commentText;
				},
				saveComment() {
					axios.post('/edit-comment',{	
						comment    : this.newComment,
						date       : this.date
					})
					.then((response) => {
						this.commentText     = this.newComment;
						this.isCommentEdited = false;
					})
				}
			}
	}
</script>
<style scoped>
	.key
	{
		font-weight : bold
	}

	.comment-wrapper {
		align-items: flex-start;
	}

	.comment-wrapper > .v-list-item__content {
		align-self: auto;
	}

	
	.comment-key-wrapper {
		display: grid !important;
		grid-template-columns: auto 1fr;
	}

	.comment-buttons-wrapper {
		gap: 15px;
	}
</style>