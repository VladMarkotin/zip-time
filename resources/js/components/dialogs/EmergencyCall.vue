<template>
	<v-dialog 
	max-width="650px" 
	content-class="emergencyCall_emergencyCall-dialog"
	persistent v-model="isShow"
	>
		<v-card>
			<v-card-title class="font-weight-bold v-card-title">Emergency call</v-card-title>
			<v-card-text>
				<v-container>
					<v-row>
						<v-col cols="12" sm="7">
							<v-date-picker 
							v-model="dates"
							color="#A10000"
							range 
							:min="minDate"
							:max="maxDate"
							>
							</v-date-picker>
						</v-col>
						<v-col cols="12" sm="5">
							<v-text-field 
							class="input-data-period"
							v-model="dateRangeText"
							label="Date period" 
							prepend-icon="mdi-calendar" 
							append-icon="mdi-close-circle" 
							@click:append="resetDates"
							readonly 
							>
						</v-text-field>
						</v-col>
					</v-row>
					<v-row>
						<v-col cols="12">
							<v-textarea counter="256" label="Comment" rows="2" outlined shaped v-model="comment" style="margin-top : -25px"></v-textarea>
						</v-col>
					</v-row>
				</v-container>
			</v-card-text>
			<v-divider></v-divider>
			<v-card-actions class="justify-space-between v-card-actions emergencyCall_emergencyCall-footer">
				<v-tooltip right>
					<template v-slot:activator="{on}">
						<v-btn 
							icon 
							v-on="on" 
							v-on:click="callEmergency"
							:disabled = "!isDateSet"
							>
							<v-icon color="#D71700" large>{{icons.mdiCarEmergency}}</v-icon>
						</v-btn>
					</template>
					<span>Emergency call</span>
				</v-tooltip>
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
	import {mdiCarEmergency,mdiCancel} from '@mdi/js'
import { watch } from 'vue';
	export default
		{
			data()
			{
				const currDate = new Date();
				const today = new Date();
				const daysAllowedinOrder = 14 //тут менять разрешенное колличество дней emergency mode подряд;
				const maxDate = new Date(new Date().setDate(new Date().getDate() + daysAllowedinOrder)).toISOString();
				
				return {
					dates : [currDate.toEnStr(),currDate.addDays(2).toEnStr()],
					comment : '',
					icons : {mdiCarEmergency,mdiCancel}, 
					isShow : true,
					minDate: today.toISOString(),
					daysAllowedinOrder: daysAllowedinOrder,
					maxDate:  maxDate,
				}
			},
			computed :
			{
				dateRangeText()
				{
					return this.dates.join(' - ')
				},
				maxSelectableDate() {
					if (this.dates && this.dates[0]) {
						const firstSelectableDate = new Date(this.dates[0]);
						const maxDateLimit = firstSelectableDate.getTime() + this.daysAllowedinOrder * 24 * 60 * 60 * 1000;
						return maxDateLimit;
					}
					return null;
    			},
				minSelectableDate() {
					if (this.dates.length) {
						return new Date(this.dates[0]).getTime();
					}
					return new Date();
				},
				isDateSet() {
					const dates = this.dates;
					return dates.length == 2 && dates.every(date => !!date);
				}
			},
			watch: {
				maxSelectableDate() {
					this.updateDate('update_max_date');
				},
				minSelectableDate() {
					this.updateDate('update_min_date');
				}
			},
			methods :
			{
				callEmergency()
				{
					const today = (new Date()).toEnStr();
					axios.post('/emergency',{from : this.dates[0],to : this.dates[1],comment : this.comment})
					.then(response => {
						if (response.data.status === 'success') {
							if (this.dates[0] === today) {
								this.toggle();
								location.reload(); //пофиксить - временное решение
							}
						}
					})
				},
				toggle()
				{
					this.$emit('toggleEmergencyCallDialog')
				},
				updateDate(flag) {
					switch(flag) {
						case 'update_max_date':
							this.maxDate = this.maxSelectableDate 
												? new Date(this.maxSelectableDate).toISOString() 
												: null;
						break;
						case 'update_min_date':
							this.minDate = this.minSelectableDate 
												? new Date(this.minSelectableDate).toISOString()
												: new Date().toISOString()
						break;
					}
				},
				resetDates() {
					this.dates = [null, null];
				}
			},
		}
</script>

<style>
	.input-data-period input[type="text"] {
		font-size: 14px !important;
	}
	@import url('/css/EmergencyCall/EmergencyCallMedia.css');
</style>
