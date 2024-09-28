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
				<v-calendar ref="calendar" v-model="focus" color="primary" v-bind:events="events"
					:event-color="getEventColor" :type="type" @click:event="showEvent" @change="updateRange">
				</v-calendar>
				<v-menu max-width="100%" style="z-index: 20;" v-model="selectedOpen" :close-on-content-click="false" :activator="selectedElement" offset-x>
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
import ClosedDayCommentDialog from '../dialogs/ClosedDayCommentDialog.vue';
import store from '../../store';
import { mapMutations } from 'vuex/dist/vuex.common.js';
import HistoryDayCard from '../UI/HistoryDayCard.vue';

export default
	{
		data() {
			return {
				focus: '',
				type: 'month',
				selectedEvent: {},
				selectedElement: null,
				selectedOpen: false,
				headers: [
					{ text: ' hash', value: 'hashCode' },
					{ text: 'Task name', value: 'taskName' },
					{ text: 'Mark', value: 'mark' }
				],
				events: [],
				isCommentEdited: false,
				newCommentText: '',
			}
		},
		store,
		components: {ClosedDayCommentDialog, HistoryDayCard},
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
					start_date: period.start.date
				})
				this.events = []
				let status;
				let color = '#A10000';
				for (const date in history.data.plans) {
					status = '';
					
					switch(history.data.plans[date].dayStatus ){
						case 3: 
							status = "Success"
							color = '#A10000';
							break;
						case 1:
							status = "Weekend"
							color = '#ffcfcf'
							break;
						case 0:
							status = "Emergency mode"
							color = '#ffcfcf';
							break;
						default:
							status = "Fail !";
							color = "#474747";
							break;

					}
					if (history.data.plans[date].dayFinalMark == 0) {
						history.data.plans[date].dayFinalMark = '-';
					} else {
						history.data.plans[date].dayFinalMark = history.data.plans[date].dayFinalMark +'%';
					}
					if (history.data.plans[date].dayOwnMark == 0) {
						history.data.plans[date].dayOwnMark = '-';
					} else {
						history.data.plans[date].dayOwnMark = history.data.plans[date].dayOwnMark +'%';
					}
					this.events.push({
						start: new Date(date),
						end: new Date(date),
						name: `Day status:\t${status}`,
						color: color,
						dayFinalMark: history.data.plans[date].dayFinalMark,
						dayOwnMark: history.data.plans[date].dayOwnMark,
						comment: history.data.plans[date].comment,
						tasks: history.data.plans[date].tasks
					})
				}
			},

			editComment (value) {
				this.newCommentText = value;
			},

			async saveComment() {
				const date = this.selectedEvent.end;
				console.log(this.newCommentText);

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
	.key {
		font-weight : bold
	}

	.history_final-data-list .history_final-data-li {
		gap: 25px;
		min-height: 0 ;
	}

	.history_final-data-list .history_final-data-li .key {
		justify-content: flex-start !important;
	}

	.history_final-data-list .history_final-data-li .v-list-item__content{
		padding: 4px;
		justify-content: flex-end;
	}

	@import url('/css/History/HistoryMedia.css');
</style>