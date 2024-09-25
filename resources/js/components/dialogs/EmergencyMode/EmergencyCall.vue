<template>
	<v-dialog 
	max-width="650px" 
	content-class="emergencyCall_emergencyCall-dialog"
	persistent 
	scrollable
	v-model="isShow"
	:fullscreen="isMobile"
	>
		<v-card class="emergencyCall-card">
			<v-card-title class="font-weight-bold v-card-title pt-6 emergencyCall-header">Emergency call</v-card-title>
			<v-card-text v-if="!isShowEmergencyConfirmation" height="450px" class="emergencyCall-content pb-0">
				<div class="pt-4 pb-4">
					<v-row class="date-wrapper">
						<v-col cols="12" sm="7" class="date-datePicker-wrapper">
							<v-date-picker 
							v-model="dates"
							color="#A10000"
							range 
							:min="minDate"
							:max="maxDate"
							>
							</v-date-picker>
						</v-col>
						<v-col cols="12" sm="5" class="date-textField">
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
							<v-textarea 
							counter="256" 
							label="Comment" 
							rows="2" 
							outlined 
							shaped 
							v-model="comment" 
							style="margin-top : -25px">
							</v-textarea>
						</v-col>
					</v-row>
				</div>
			</v-card-text>
			<EmergencyConfirmation 
			v-else
			:emergencyModeDates  = "dates"
			:isTheCheckCompleted = "isTheCheckCompleted"
			@goBackOneStep          = "goBackOneStep"
			@setIsTheCheckCompleted = "setIsTheCheckCompleted"
			@callEmergency          = "callEmergency"
			/>
			<v-divider></v-divider>
			<v-card-actions class="justify-space-between v-card-actions emergencyCall-footer px-6 pb-6 pt-5">
					<v-tooltip right>
						<template v-slot:activator="{on}">
							<v-btn 
								icon 
								v-on="on" 
								v-on:click="callEmergency"
								:disabled = "isEmergencyCallButtonDis"
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
	import store from '../../../store';
	import { mapGetters } from 'vuex/dist/vuex.common.js';
	import {mdiCarEmergency,mdiCancel} from '@mdi/js'
	import EmergencyConfirmation from './EmergencyConfirmation.vue';
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
					isShowEmergencyConfirmation: false,
					isTheCheckCompleted: false,
				}
			},
			components: {EmergencyConfirmation},
			computed :
			{
				...mapGetters(['getWindowScreendWidth']),
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
					return dates.every(date => !!date);
				},
				isEmergencyCallButtonDis() {
					if (!this.isShowEmergencyConfirmation) {
						return !this.isDateSet;
					}
					return !this.isTheCheckCompleted;
				},
				isMobile() {
                	return this.getWindowScreendWidth < 768;
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
					if (this.isShowEmergencyConfirmation === false) {
						this.isShowEmergencyConfirmation = true;
						return;
					}

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
				},
				goBackOneStep() {
					this.isShowEmergencyConfirmation = false
					this.isTheCheckCompleted = false;
				},
				setIsTheCheckCompleted(checkResult) {
					this.isTheCheckCompleted = checkResult;
				}
			},
		}
</script>

<style>
	.v-dialog:not(.v-dialog--fullscreen).emergencyCall_emergencyCall-dialog {
		max-height: none;
	}
	.input-data-period input[type="text"] {
		font-size: 14px !important;
	}

	.emergencyCall-content::-webkit-scrollbar {
        width: 12px;
    }

    .emergencyCall-content::-webkit-scrollbar-track {
        background: #e6e6e6;
        border-left: 1px solid #dadada;
    }

    .emergencyCall-content::-webkit-scrollbar-thumb {
        background: #b0b0b0;
        border: solid 3px #e6e6e6;
        border-radius: 7px;
    }

    .emergencyCall-content::-webkit-scrollbar-thumb:hover {
        background: rgb(161, 0, 0);
        cursor: pointer;
    }


	@import url('/css/EmergencyCall/EmergencyCallMedia.css');
</style>
