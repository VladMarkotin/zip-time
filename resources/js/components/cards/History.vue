<template>
	<v-row class="fill-height">
		<v-col>
			<v-sheet height="64">
				<v-toolbar flat>
					<v-btn outlined class="mr-4" color="grey darken-2" @click="setToday">
						Today
					</v-btn>
					<v-btn fab text small color="grey darken-2" @click="prev">
						<v-icon small>
							mdi-chevron-left
						</v-icon>
					</v-btn>
					<v-btn fab text small color="grey darken-2" @click="next">
						<v-icon small>
							mdi-chevron-right
						</v-icon>
					</v-btn>
					<v-toolbar-title v-if="$refs.calendar">
						{{ $refs.calendar.title }}
					</v-toolbar-title>
					<v-spacer></v-spacer>
				</v-toolbar>
			</v-sheet>
			<v-sheet height="600">
				<v-calendar 
				ref="calendar" 
				v-model="focus" 
				color="primary" 
				v-bind:events="shownEvents"
				:event-color="getEventColor" 
				:type="type" 
				@click:event="showEvent" 
				@change="updateRange"
				@mouseenter:day="onMouseEnterDay"
				@mouseleave:day="onMouseLeaveDay" 
				locale="en"
				>
				</v-calendar>
				<v-menu 
				max-width="100%" 
				style="z-index: 20;" 
				v-model="selectedOpen" 
				:close-on-content-click="false" 
				:activator="selectedElement" 
				offset-x
				>
					<HistoryDayCard 
					:selectedEvent="selectedEvent"
					:headers="headers"
					:newCommentText="newCommentText"
					@editComment="editComment"
					@saveComment="saveComment"
					@close="selectedOpen = false" 
					/>
				</v-menu>
			</v-sheet>
		</v-col>
	</v-row>
</template>
<script>
import store from '../../store';
import { mapMutations } from 'vuex/dist/vuex.common.js';
import HistoryDayCard from '../UI/HistoryDayCard.vue';
import { debounce } from 'lodash';

export default
	{
		data() {
			return {
				todayDate: new Date().getTodayFormatedDate(),
				focus: '',
				type: 'month',
				selectedEvent: {},
				selectedElement: null,
				selectedOpen: false,
				selectedDate: '',
				headers: [
					{ text: ' hash', value: 'hashCode' },
					{ text: 'Task name', value: 'taskName' },
					{ text: 'Mark', value: 'mark' }
				],
				events: [],
				isCommentEdited: false,
				newCommentText: '',
				DEBOUNCER_DELAY: 400,
			}
		},
		store,
		components: {HistoryDayCard},
		computed: {
			shownEvents() {
				return this.events.filter(dayData => {
					const areAnyPlans    = dayData.status !== 4;
					const isSelectedDate = dayData.date === this.selectedDate;

					return areAnyPlans || isSelectedDate;
				});
			},
			debouncedOnMouseEnterDay() {
				return debounce(function(callback) {
					callback();
				}, this.DEBOUNCER_DELAY);
			}
		},
		methods:
		{
			...mapMutations(['SET_WINDOW_SCREEN_WIDTH']),
			async mounted() {
				this.$refs.calendar.checkChange()
			},
			getEventColor(event) {
				return event.color
			},
			setToday() {
				this.focus = ''
			},
			prev() {
				this.$refs.calendar.prev()
			},
			next() {
				this.$refs.calendar.next()
			},
			showEvent({ nativeEvent, event }) {
				const open = () => {
					this.selectedEvent   = event
					this.selectedElement = nativeEvent.target
					this.newCommentText  = this.selectedEvent.comment
					requestAnimationFrame(() => requestAnimationFrame(() => this.selectedOpen = true))
				}

				if (this.selectedOpen) {
					this.selectedOpen = false
					requestAnimationFrame(() => requestAnimationFrame(() => open()))
				} else {
					open()
				}

				nativeEvent.stopPropagation()
			},
			
			async updateRange(period) {
				const history = await axios.post('/hist', {
					start_date: period.start.date,
					today_date: this.todayDate
				})
				this.events = []
				const plans = history.data.plans;
				for (const date in plans) {
					const isDayPassed = plans[date].isDayPassed;

					const cardHeaderData        = this.getCardHeaderData(plans[date].dayStatus, isDayPassed);
					const transformedFinalMark  = this.getTransformedMark(plans[date].dayFinalMark);
					const transformedDayOwnMark = this.getTransformedMark(plans[date].dayOwnMark);
					
					const dayData = {
						start: new Date(date),
						end: new Date(date),
						name: `Day status:\t${cardHeaderData.status}`,
						color: cardHeaderData.color,
						dayFinalMark: transformedFinalMark,
						dayOwnMark: transformedDayOwnMark,
						comment: plans[date].comment,
						tasks: plans[date].tasks,
						status: plans[date].dayStatus,
						date: date,
						isDayPassed: plans[date].isDayPassed,
					}

					this.events = [...this.events, dayData];
				}
			},

			getTransformedMark(finalMark) {
				if (finalMark == 0) {
					return '-';
				}
				return `${finalMark}%`;
			},

			getCardHeaderData(dayStatus, isDayPassed) {
				switch(dayStatus){
					case 4: //несозданный преплан
						return {status: '', color:  '#4285B4',};
					case 3: 
						return {status: 'Success', color:  '#A10000',};
					case 2: //преплан рабочий день
						return {status: 'Work day', color:  '#4285B4',};
					case 1:
						if (isDayPassed) {
							return {status: 'Weekend', color:  '#ffcfcf',};
						} else {
							return {status: 'Weekend', color:  '#ABCDEF',};
						}
					case 0:
						return {status: 'Emergency mode', color:  '#ffcfcf',};
					default:
						return {status: 'Fail !', color:  '#474747',};
					}
			},

			editComment (value) {
				this.newCommentText = value;
			},

			async saveComment() {
				const date = this.selectedEvent.end;

				try {
					const response = await axios.post('/edit-comment', {comment : this.newCommentText, date})
					if (response.data.comment_updated_status === 'success') {
						this.selectedEvent.comment = this.newCommentText;
					}
				} catch (error) {
					console.error(error);
				} 
			},

			updateScreenWidth() {
            	this.SET_WINDOW_SCREEN_WIDTH({windowScreenWidth: window.innerWidth});
        	},

			onMouseEnterDay({date}) {
				this.debouncedOnMouseEnterDay(() => {
					this.selectedDate = date;
				});
			},

			onMouseLeaveDay() {
				this.selectedDate = '';
			}
		},
		mounted() {
			window.addEventListener('resize', this.updateScreenWidth);
		},

		beforeDestroy() {
			window.removeEventListener('resize', this.updateScreenWidth);
		}
	}
</script>

<style scoped>

	@import url('/css/History/HistoryMedia.css');
</style>