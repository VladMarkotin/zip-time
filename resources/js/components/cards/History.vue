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
							<v-btn icon>
								<v-icon>mdi-pencil</v-icon>
							</v-btn>
							<v-toolbar-title v-html="selectedEvent.name"></v-toolbar-title>
							<v-spacer></v-spacer>
							<v-btn icon>
								<v-icon>mdi-heart</v-icon>
							</v-btn>
							<v-btn icon>
								<v-icon>mdi-dots-vertical</v-icon>
							</v-btn>
						</v-toolbar>
						<v-card-text>
							<span v-html="selectedEvent.details"></span>
						</v-card-text>
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
				const history = await axios.get('/hist');
				for (const date in history.data.plans) {
					this.events = [
						{
							name: history.data.plans[date].tasks[0].taskName,
							start: new Date(date),
							end: new Date(date),
							color: '#A10000'
						}
					];
				}
			}
		}
	}
</script>