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
				<v-menu v-model="selectedOpen" :close-on-content-click="false" :activator="selectedElement" offset-x>
					<v-card color="grey lighten-4" min-width="350px" flat>
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
						<v-list>
							<v-list-item>
								<v-list-item-content>Final mark:</v-list-item-content>
								<v-list-item-content>{{ selectedEvent.dayFinalMark }}</v-list-item-content>
							</v-list-item>
							<v-list-item>
								<v-list-item-content>Own mark:</v-list-item-content>
								<v-list-item-content>{{ selectedEvent.dayOwnMark }}</v-list-item-content>
							</v-list-item>
							<v-list-item>
								<v-list-item-content>Comment:</v-list-item-content>
								<v-list-item-content>{{ selectedEvent.comment }}</v-list-item-content>
							</v-list-item>
						</v-list>
						<v-card-actions>
							<v-btn text color="secondary" @click="selectedOpen = false">
								Cancel
							</v-btn>
						</v-card-actions>
					</v-card>
				</v-menu>
			</v-sheet>
		</v-col>
	</v-row>
</template>
<script>
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
					{ text: '#hash', value: 'hashCode' },
					{ text: 'Task name', value: 'taskName' },
					{ text: 'Details', value: 'details' },
					{ text: 'Mark', value: 'mark' }
				],
				events: []
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
				for (const date in history.data.plans) {
					this.events.push({
						start: new Date(date),
						end: new Date(date),
						name: `Day status:\t${history.data.plans[date].dayStatus}`,
						color: '#A10000',
						dayFinalMark: history.data.plans[date].dayFinalMark,
						dayOwnMark: history.data.plans[date].dayOwnMark,
						comment: history.data.plans[date].comment,
						tasks: history.data.plans[date].tasks
					})
				}
			}
		}
	}
</script>