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
					<v-card 
					color="grey lighten-4" 
					width="400px" 
					flat
					>
						<v-toolbar :color="selectedEvent.color" dark>
							<v-toolbar-title>{{ selectedEvent.name }}</v-toolbar-title>
							<v-spacer></v-spacer>
						</v-toolbar>
						<v-card-text>
							<v-data-table :headers="headers" :items="selectedEvent.tasks" class="elevation-1"
								hide-default-footer>
							</v-data-table>
						</v-card-text>
						<v-divider></v-divider>
						<v-list class="history_final-data-list">
							<v-list-item class="history_final-data-li">
								<v-list-item-content class="key">Final mark:</v-list-item-content>
								<v-list-item-content>{{ selectedEvent.dayFinalMark }}</v-list-item-content>
							</v-list-item>
							<v-list-item class="history_final-data-li">
								<v-list-item-content class="key">Own mark:</v-list-item-content>
								<v-list-item-content>{{ selectedEvent.dayOwnMark }}</v-list-item-content>
							</v-list-item>
							<v-list-item class="history_final-data-li history_comment-wrapper">
								<v-list-item-content> 
									<span class="key">Comment:</span>
									<div>
										<EditCommentButton 
										:isCommentEdited = "isCommentEdited"
										:iconSize        = "29"
										@click = "editComment"
										/>
										<SaveCommentButton 
										:isCommentEdited = "isCommentEdited"
										:iconSize        = "29"
										@click         = "saveComment"
										@keydown.enter ="saveComment"
										/>
									</div>
								</v-list-item-content>
								<v-list-item-content v-if="!isCommentEdited"
								class="history_comment-value" 
								style="word-break: break-word">
									{{ selectedEvent.comment }}
								</v-list-item-content>
								<v-list-item-content v-else>
									<v-textarea 
										solo
										clear-icon="mdi-close-circle"
										label="Describe your day"
										v-model="newComment"
									></v-textarea>
								</v-list-item-content>
							</v-list-item>
						</v-list>
						<v-card-actions>
							<v-row class="pt-3 pb-3">
								<v-btn text color="secondary" @click="selectedOpen = false">
									Cancel
								</v-btn>
							</v-row>
						</v-card-actions>
					</v-card>
				</v-menu>
			</v-sheet>
		</v-col>
	</v-row>
</template>
<script>

import EditCommentButton from '../UI/EditCommentButton.vue';
import SaveCommentButton from '../UI/SaveCommentButton.vue';

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
					{ text: 'Details', value: 'details' },
					{ text: 'Mark', value: 'mark' }
				],
				events: [],
				isCommentEdited: false,
				newComment: '',
			}
		},
		components: {EditCommentButton, SaveCommentButton},
		watch: {
			selectedOpen(value) {
				if (value === false) {
					this.isCommentEdited = false;
				}
			}
		},
		methods:
		{
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
					this.selectedEvent = event
					this.selectedElement = nativeEvent.target
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
						name: `Day status:\t${status}`,//history.data.plans[date].dayStatus
						color: color,//'#A10000',
						dayFinalMark: history.data.plans[date].dayFinalMark,
						dayOwnMark: history.data.plans[date].dayOwnMark,
						comment: history.data.plans[date].comment,
						tasks: history.data.plans[date].tasks
					})
				}
			},

			editComment () {
				this.isCommentEdited = true;
				this.newComment      = this.selectedEvent.comment;
			},

			async saveComment() {
				const date = this.selectedEvent.end;

				try {
					const response = await axios.post('/edit-comment', {comment : this.newComment, date})
					if (response.status === 200) {
						this.selectedEvent.comment = this.newComment;
					}
				} catch (error) {
					console.error(error);
				} finally {
					this.isCommentEdited = false;
				}
			},
		},
	}
</script>

<style scoped>
	.key {
		font-weight : bold
	}

	.history_final-data-list .history_comment-wrapper .v-list-item__content {
		align-self: flex-start;
    }

	.history_final-data-list .history_final-data-li {
		align-items: flex-start;
        display: grid;
        grid-column-gap: 20px;
        grid-template-columns: 80px 1fr;
	}

	.history_final-data-list .history_final-data-li::after {
		display: none;
	}

	@import url('/css/History/HistoryMedia.css');
</style>