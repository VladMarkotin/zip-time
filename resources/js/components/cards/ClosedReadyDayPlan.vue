<template>
	<v-card>
		<Challenges />
		<v-card-title class="font-weight-bold justify-space-between v-card-title closedReadyDayPlan_day-info-header">
			<div class="closedReadyDayPlan_day-info-header-date">
				<p class="closedReadyDayPlan_header-text">
					<span>Date: </span> <span>{{shownDate}}</span>
				</p>
			</div>
			<div class="closedReadyDayPlan_header-finished">
				<p 
				v-if="wasADailyPlanCreated"
				class="closedReadyDayPlan_header-text"
				>
					<span>
						Finished
					</span>
				</p>
			</div>
			<div 
			class="closedReadyDayPlan_day-info-header-status"
			>
				<p 
				v-if="wasADailyPlanCreated"
				class="closedReadyDayPlan_header-text"
				>
					<span>Status: </span><span>{{ dayStatus }}</span>
				</p>
			</div>
		</v-card-title>
		<v-list v-if="wasADailyPlanCreated" class="day-info-list">
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
									<v-icon color="#D71700" size="29"> {{icons.mdiPencil}} </v-icon>
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
									<v-icon color="#D71700" size="29"> {{icons.mdiContentSaveMoveOutline }} </v-icon>
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
						class="newComment-input"
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
		<v-list v-else class="day-info-list d-flex justify-content-center">
			<v-list-item>
				<v-list-item-content class="key d-flex justify-content-center missed-day-text">
					In this day, a daily plan was not created.	
				</v-list-item-content>
			</v-list-item>
		</v-list>
		<v-card-actions class="d-flex justify-space-between">
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="setDate('prev')" :disabled="!isShowButton.prev || isCommentEdited">
						<v-icon color="#D71700" large>{{icons.mdiArrowLeft}}</v-icon>
					</v-btn>
				</template>
				<span>Prev day</span>
			</v-tooltip>
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="setDate('today')" :disabled="isCommentEdited">
						<v-icon color="#D71700" large>{{icons.mdiCalendarToday}}</v-icon>
					</v-btn>
				</template>
				<span>Today</span>
			</v-tooltip>
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="setDate('next')" :disabled="!isShowButton.next || isCommentEdited">
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
			const daystatusCodeInfo = new Map;

			daystatusCodeInfo.set(-1, 'Fine (Day was not completed)');
			daystatusCodeInfo.set(0, 'Emergency mode');
			daystatusCodeInfo.set(1, 'Weekend mode');
			daystatusCodeInfo.set(2, 'Failed');
			daystatusCodeInfo.set(3, 'Success');

			const currentDate = new Date;

			return {
				   currentDate,
				   shownDate: currentDate.toEnStr(),
				   icons : {mdiArrowLeft,mdiCalendarToday,mdiArrowRight, mdiPencil, mdiContentSaveMoveOutline },
			       disabled : {prevButton : false,nextButton : true},
				   commentText,
				   daystatusCodeInfo,
				   newComment: '',
				   isCommentEdited: false,
				   wasADailyPlanCreated: true,
				   isLoading: false,
				   isShowButton: {
					prev: true,
					next: false,
				   }
		   }
		},
		computed : {
			dayStatus() {
				const statusCode = this.data.dayStatus;
				
				return this.daystatusCodeInfo.get(statusCode);
			},
		},
		methods :
			{	
				setDate(flag) {
					if (this.isLoading) return;

					const currentDay = this.currentDate;

					switch (flag) {
						case 'prev':
							currentDay.setDate(currentDay.getDate() - 1);
						break;
						case 'today':
							const today = new Date;

							currentDay.setDate(today.getDate());
							currentDay.setMonth(today.getMonth());
						break;
						case 'next':
							currentDay.setDate(currentDay.getDate() + 1);
						break;
					}

					this.setData(currentDay);
					this.shownDate = this.currentDate.toEnStr();
				},
				async setData(date)
				{
					try {
						this.isLoading = true;
						const {data} = (await axios.post(`/hist/forClosedDay`,{date}))
						this.isShowButton = {prev: data.doesTheDayExistBefore, next: data.doesTheDayExistAfter};

						if (!data.isDayMissed) {
							const {currentDayData} = data;

							this.wasADailyPlanCreated = true;
							this.data.dayFinalMark    = currentDayData.dayFinalMark;
							this.data.dayOwnMark      = currentDayData.dayOwnMark;
							this.data.dayStatus       = currentDayData.dayStatus;
							this.commentText          = currentDayData.commentText; 
						} else {
							this.wasADailyPlanCreated = false;
						}

					} catch (error) {
						console.error(error);
					} finally {
						this.isLoading = false;
					}
				},
				editComment () {
					this.isCommentEdited = true;
					this.newComment = this.commentText;
				},
				saveComment() {
					axios.post('/edit-comment',{	
						comment    : this.newComment,
						date       : this.currentDate
					})
					.then((response) => {
						this.commentText     = this.newComment;
						this.isCommentEdited = false;
					})
				},
			}
	}
</script>
<style scoped>
	.closedReadyDayPlan_day-info-header {
		display: grid ;
		grid-template-columns: 200px 1fr 250px;
	}

	.closedReadyDayPlan_day-info-header .closedReadyDayPlan_day-info-header-date {
		text-align: left;
	}
	.closedReadyDayPlan_day-info-header .closedReadyDayPlan_header-finished {
		text-align: center;
	}
	.closedReadyDayPlan_day-info-header .closedReadyDayPlan_day-info-header-status {
		text-align: right;
	}

	.closedReadyDayPlan_header-text {
		margin-bottom: 0;
	}

	.key
	{
		font-weight : bold
	}

	.day-info-list {
		min-height: 172px;
	}

	.missed-day-text {
		font-size: 1.5rem;
		color: #212121;
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
		gap: 5px;
	}

	@import url('/css/ClosedReadyDayPlan/ClosedReadyDayPlanMedia.css');
</style>