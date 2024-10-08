<template>
	<v-card>
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
		<v-list v-if="wasADailyPlanCreated" class="day-info-list closedReadyDayPlan_dayInfoList-existing-day">
			<v-container>
				<v-expansion-panels>
				<v-expansion-panel>
					<v-expansion-panel-header>
						<v-list-item class="mark-wrapper p-0">
							<v-list-item-content class="key p-1"><span>Final mark:</span></v-list-item-content>
							<v-list-item-content class="align-end p-0 day-info_list-item-content-wrapper">
								<div v-if="data.dayFinalMark > 0 " class="day-info_list-item-content">{{data.dayFinalMark}} %</div>
								<div v-else class="align-end day-info_list-item-content"> - </div>
							</v-list-item-content>
						</v-list-item>
					</v-expansion-panel-header>
					<v-expansion-panel-content class="text-center">
						Final mark represents the arithmetic mean of tasks with the type "Required job"
						plus the arithmetic mean of tasks with "Non required jobs" type dividing on 2.
					</v-expansion-panel-content>
				</v-expansion-panel>
				<v-expansion-panel>
					<v-expansion-panel-header>
						<v-list-item class="mark-wrapper p-0">
							<v-list-item-content class="key p-1" ><span>Own mark:</span></v-list-item-content>
							<v-list-item-content class="align-end p-0 day-info_list-item-content-wrapper" >
								<div v-if="data.dayOwnMark > 0 " class="day-info_list-item-content">{{data.dayOwnMark}} %</div>
								<div v-else class="day-info_list-item-content">-</div>
							</v-list-item-content>
						</v-list-item>
					</v-expansion-panel-header>
					<v-expansion-panel-content class="text-center">
						Own mark represents your subjective assessment of the day's success.
					</v-expansion-panel-content>
				</v-expansion-panel>
				<v-expansion-panel>
					<v-expansion-panel-header>
						<v-list-item class="">
							<v-list-item-content class="key" >
								<span class="text-center">Create preplan</span>
							</v-list-item-content>
						</v-list-item>
					</v-expansion-panel-header>
					<v-expansion-panel-content class="">
						<PreplanDataPicker 
						v-model             = "planDate"
               			:todayDate          = "userTodayDate"
						:menuPosition       = "{'offset-x': true,}"
						:isShowSelectedDate = "false"
						@changePlanDate = "redirectToPreplanPAge"
						/>
					</v-expansion-panel-content>
				</v-expansion-panel>
				</v-expansion-panels>
			</v-container>
			<v-list-item >
				<v-list-item-content class="key p-1 justify-content-center" >Comment:</v-list-item-content>
			</v-list-item>
			<v-list-item class="justify-content-center">
				<v-list-item-content class="comment-wrapper p-0">
					<ClosedDayCommentDialog 
					:commentText        = "commentText"
					:newCommentText     = "newCommentText"
					commentFieldHeight = "150px"
					@editComment = "editComment"
					@saveComment = "saveComment"
					/>
				</v-list-item-content>
			</v-list-item>
		</v-list>
		<v-list v-else class="day-info-list d-flex justify-content-center">
			<v-list-item>
				<v-list-item-content class="key d-flex justify-content-center missed-day-text">
					In this day,<br class="br" /> a daily plan was not created.	
				</v-list-item-content>
			</v-list-item>
		</v-list>
		<v-card-actions class="d-flex justify-space-between">
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="setDate('prev')" :disabled="!isShowButton.prev">
						<v-icon color="#D71700" large>{{icons.mdiArrowLeft}}</v-icon>
					</v-btn>
				</template>
				<span>Prev day</span>
			</v-tooltip>
			<div>
				<v-tooltip right>
					<template v-slot:activator="{on}">
						<v-btn icon v-on="on" v-on:click="setDate('today')">
							<v-icon color="#D71700" large>{{icons.mdiCalendarToday}}</v-icon>
						</v-btn>
					</template>
					<span>Today</span>
				</v-tooltip>
			</div>
			<v-tooltip right>
				<template v-slot:activator="{on}">
					<v-btn icon v-on="on" v-on:click="setDate('next')" :disabled="!isShowButton.next">
						<v-icon color="#D71700" large>{{icons.mdiArrowRight}}</v-icon>
					</v-btn>
				</template>
				<span>Next day</span>
			</v-tooltip>
		</v-card-actions>
	</v-card>
</template>
<script>
	import store from '../../store';
	import { mapGetters, mapMutations, mapActions } from 'vuex/dist/vuex.common.js';
	import ClosedDayCommentDialog from '../dialogs/ClosedDayCommentDialog.vue';
	import {mdiArrowLeft,mdiCalendarToday,mdiArrowRight, mdiContentSaveMoveOutline } from '@mdi/js'
	import Challenges from "./../challenges/Challenges.vue";
	import { data } from 'jquery';
	import PreplanDataPicker from '../UI/PreplanDataPicker.vue';

	export default
	{
		props : {
			data: {
				type: Object,
			},
		},
		components: { Challenges, ClosedDayCommentDialog, PreplanDataPicker},
		data()
		{	
			const commentText = this.data.comment;
			const daystatusCodeInfo = new Map;

			daystatusCodeInfo.set(-1, 'Plan failed :(');
			daystatusCodeInfo.set(0, 'Emergency mode');
			daystatusCodeInfo.set(1, 'Weekend mode');
			daystatusCodeInfo.set(2, 'Failed');
			daystatusCodeInfo.set(3, 'Success');
			const currentDate = new Date;

			const userTodayDate = this.data.user_today_date ?? new Date().getTodayFormatedDate();

			return {
				   currentDate,
				   userTodayDate,
				   planDate: userTodayDate,
				   shownDate: this.transformDate(currentDate),
				   icons : {mdiArrowLeft,mdiCalendarToday,mdiArrowRight, mdiContentSaveMoveOutline },
			       disabled : {prevButton : false,nextButton : true},
				   commentText,
				   daystatusCodeInfo,
				   newCommentText: commentText,
				   wasADailyPlanCreated: true,
				   isLoading: false,
				   isShowButton: {
					prev: false,
					next: false,
				   },
		   }
		},
		store,
		computed : {
			...mapGetters(['getWindowScreendWidth']),
			dayStatus() {
				const statusCode = this.data.dayStatus;
				
				return this.daystatusCodeInfo.get(statusCode);
			},

			isMobile() {
				return this.getWindowScreendWidth < 550;
			}
		},
		
		methods :
			{	
				...mapMutations(['SET_WINDOW_SCREEN_WIDTH']),
				...mapActions(['setDisabledDates']),
				setDate(flag) {
					if (this.isLoading) return;

					if (flag === 'today') {
						this.setData(new Date().getCurrentDate(), flag);
					} else {
						this.setData(this.currentDate.getCurrentDate(), flag); // в файле functions.js расширял прототип
					}

					
				},
				transformDate(date) {
					const day = date.getDate().toString().padStart(2, '0');
					const month = (date.getMonth() + 1).toString().padStart(2, '0');
					const year = date.getFullYear();

					const formattedDate = `${day}-${month}-${year}`;
					return formattedDate;
				},
				async setData(date, flag)
				{
					try {
						this.isLoading = true;
						const {data} = (await axios.post(`/hist/forClosedDay`,{date, flag}))
						this.isShowButton = {prev: data.doesTheDayExistBefore, next: data.doesTheDayExistAfter};

						if (!data.isDayMissed) {
							const {currentDayData} = data;
							
							this.wasADailyPlanCreated = true;
							this.data.dayFinalMark    = currentDayData.dayFinalMark;
							this.data.dayOwnMark      = currentDayData.dayOwnMark;
							this.data.dayStatus       = currentDayData.dayStatus;
							this.commentText          = currentDayData.commentText; 
							this.newCommentText       = currentDayData.commentText;
							
							const {date} = currentDayData;
							this.currentDate = new Date(date);
							this.shownDate = this.transformDate(this.currentDate);
							
						} else {
							this.wasADailyPlanCreated = false;
						}

					} catch (error) {
						console.error(error);
					} finally {
						this.isLoading = false;
					}
				},
				editComment (value) {
					this.newCommentText = value;
				},
				async saveComment() {
					try {
						const response = await axios.post('/edit-comment',{	
							comment    : this.newCommentText,
							date       : this.currentDate
						})
						if (response.data.comment_updated_status === 'success') {
							this.commentText = this.newCommentText
						}
					} catch(error) {
						console.error(error);
					}
				},

				updateScreenWidth() {
            		this.SET_WINDOW_SCREEN_WIDTH({windowScreenWidth: window.innerWidth});
        		},

				redirectToPreplanPAge() {
					window.location.href = `/preplan?date=${this.planDate}`;
				}
			},
		
		created() {
			this.setDisabledDates({
				todayDate:        this.userTodayDate, 
				disableToday:     true,
         	});
		},
		
		mounted() {
			this.setDate('today');
			window.addEventListener('resize', this.updateScreenWidth);
		},

		beforeDestroy() {
			window.removeEventListener('resize', this.updateScreenWidth);
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

	.mark-wrapper {
		gap: 15px;
	}
	.mark-wrapper::after {
		display: none;
	}
	.mark-wrapper .key {
		display: grid;
		grid-template-columns: 1fr 120px;
	}

	.key {
		font-weight : bold;	
	}

	.key span {
		grid-column: 2/3;
		text-align: right;
	}

	.day-info-list {
		min-height: 172px;
	}

	.day-info_list-item-content {
		padding: 12px; 
		box-sizing: border-box;
	}

	.missed-day-text {
		font-size: 1.5rem;
		color: #212121;
	}

	.missed-day-text .br {
		display: none;
	}

	.comment-wrapper {
		min-height: 150px;
		justify-content: center;
		width: 60%; 
		flex: 0 0 auto;
		overflow: visible;
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

	.closeReadyDayPlan_comment-text-wrapper {
		word-break: break-word;
	}

	@import url('/css/ClosedReadyDayPlan/ClosedReadyDayPlanMedia.css');
</style>