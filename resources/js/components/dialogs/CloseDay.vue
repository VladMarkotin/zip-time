<template>
	<v-dialog 
	max-width="650px" 
	content-class="closeDay-closeDay-dialog"
	scrollable
	:fullscreen="isMobile"
	persistent 
	v-model="isShow"
	>
		<v-card id="close-day__wrapper">
			<v-card-title class="font-weight-bold v-card-title pt-6 closeDay-header">Close day</v-card-title>
			<v-card-text height="450px" class="closeDay-content">
				<v-container >
					<v-row class="justify-center">
						<v-col cols="3" class="closeDay-ownMark-input-wrapper">
							<div id="close-day__mark">
								<!-- Удалить -->
								<!-- <v-text-field label="Own Mark" required v-model="ownMark" >
									<v-icon slot="append">mdi-percent</v-icon>
								</v-text-field> -->
								<SetJobMark 
								:dayMark = "ownMark"
								:isUsedInTaskCard = "false"
								@showAlert = "showAlert"
								@sendMark  = "sendMark"
								/>
							</div>
						</v-col>
					</v-row>
					<v-row>
						<v-col id="close-day__comment-field">
							<v-textarea counter="256" label="Comment" rows="2" outlined shaped v-model="comment"></v-textarea>
						</v-col>
					</v-row>
					<v-row justify="space-around">
						<v-col
						cols="12"
						sm="10"
						md="8"
						>
						<v-sheet
							elevation="20"
							class="py-4 px-1"
							id="close-day_tomorrow-plan"
						>
						<p style="text-align: center;">
							You can choose tasks for tomorrow`s plan
						</p>
							<v-chip-group
							class="close-day_chips-wrapper"
							multiple
							active-class="primary--text"
							v-model="chosenChips"
							>
							<v-chip
								v-for="tag in tags"
								:key="tag"
								:input-value="chosenChips.includes(tag)"
								filter
								outlined
							>
								{{ tag }}
							</v-chip>
							</v-chip-group>
						</v-sheet>
						</v-col>
					</v-row>
				</v-container>
			</v-card-text>
			<v-divider></v-divider>
			<v-alert color="#404040" text class="elevation-1" v-bind:type="alert.type" v-if="isShowAlert">{{alert.text}}</v-alert>  
			<v-card-actions class="justify-space-between pb-6 pt-2 px-6 closeDay-footer">
				<v-tooltip right>
					<template v-slot:activator="{on}">
						<v-btn icon v-on="on" v-on:click="closeDay" id="close-day__icon">
							<v-icon color="#D71700" large>{{icons.mdiSendClock}}</v-icon>
						</v-btn>
					</template>
					<span>Close day</span>
				</v-tooltip>
				<v-progress-circular
					:rotate="90"
					:size="100"
					:width="5"
					:value="value"
					color="red"
					class="v-progress-circular"
					v-if="isShowProgress"
				>
					{{ value }}
				</v-progress-circular>
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
	import store from '../../store';
	import { mapGetters } from 'vuex/dist/vuex.common.js';
	import { driver } from "driver.js";
	import "driver.js/dist/driver.css";
	import {mdiCancel,mdiSendClock} from '@mdi/js'
	import Alert from '../dialogs/Alert.vue'
	import SetJobMark from './SetJobMark/SetJobMark.vue';
	export default
		{
			data: () => ({
				ownMark : 0,
				comment : '',
				isShowAlert: false,
				icons : {mdiCancel,mdiSendClock},
				isShow : true,
				alert      : {type: 'success', text: 'success'},
				interval: {},
				value: 0,
				isShowProgress: false,
				tags: [],
				chosenChips: [],
				minDefActiveChipsQuant: 4,
			}),
			store,
			components : {Alert, SetJobMark},
			computed: {
				...mapGetters(['getWindowScreendWidth']),
				isMobile() {
					return this.getWindowScreendWidth < 768;
				}
        	},
			methods :
			{
				sendMark(mark) {
					this.ownMark = mark;
				},
				closeDay()
				{
					let chosenChipValues = [];
					for(let i = 0; i < this.chosenChips.length; i++){
                        chosenChipValues.push(this.tags[this.chosenChips[i] ])
					}
					axios.post('/closeDay',{ownMark : this.ownMark,comment : this.comment, tomorow: chosenChipValues})
					.then((response) => {
						this.isShowAlert = true;
						this.setAlertData(response.data.status, response.data.message)
						if(response.data.status != "error"){
							this.$emit('showFirework');
							this.isShowProgress = true;
							this.interval = setInterval(() => {
							if (this.value === 100) {
								clearInterval(this.interval)
								return (this.value = 100)
							}
								this.value += 20
							}, 500)
							setTimeout( () => {
									this.isShowAlert    = false;
									this.isShowProgress = false;
									this.toggle()
									document.location.reload();
							},5000)
					    }else{
							setTimeout( () => {
									this.isShowAlert    = false;
									this.isShowProgress = false;
									this.toggle()
							},5000)
						}
				  })
				},
				toggle()
				{
					this.$emit('toggleCloseDayDialog')
				},
				setAlertData(type,text)
				{
					this.alert.type = type
					this.alert.text = text
				},
				showAlert({status, message}) {
					this.isShowAlert = true;
					this.setAlertData(status, message);
					setTimeout( () => {
						this.isShowAlert = false;
					},3000)
				},
				async loadHashCodes()
				{
					const response = (await axios.post('/getSavedTasks')).data;
					let length = response.data.hash_codes.length;
					for (let i = 0; i < length; i++) {
						this.tags[i] = response.data.hash_codes[i].hash_code;
						;
					}	
					
				} 
			},
			async created() {
				await axios.post('/getSavedTasks', {selection: 1}) //get most popular hash codes for next week`s day  
				.then((response) => {
					this.tags = response.data.hash_codes.map((obj) => obj.hash_code);
					this.chosenChips = this.tags.map((_, index) => index + 1 <= this.minDefActiveChipsQuant && index); //minDefActiveChipsQuant хардкодом задал в дате равную 4м
				})
			},
			async selectFirstThreeChips() {
				// Очистите массив selectedChips перед выбором новых элементов

				// Выделите первые 3 чипа и добавьте их значения в массив selectedChips
				for (let i = 0; i < 3; i++) {
					this.chosenChips(this.tags[i]);
				}
			},
			async mounted() {
			try {
				const response = await axios.post("/getEduStep", {});
				let currentEduStep = response.data.edu_step;
				if (currentEduStep == 3) {
					require("/css/customTooltip.css");

					const driverObj = driver({
						disableActiveInteraction: true,
						allowClose: false,
						nextBtnText: 'Next→',
						prevBtnText: '←Back',
						doneBtnText: 'Done',
						stagePadding: 0,
						popoverOffset: 15,
						smoothScroll: true,
						popoverClass: 'custom-tooltip__third-step',
						steps: [
							{
								element: '#close-day__wrapper',
								popover: {
									description: 'This is «Close-day window». Remember, you have to estimate all your required jobs/tasks to close the day!',
									side: 'right',
								},
							},
							{
								element: '#close-day__mark',
								popover: {
									description: 'Quipl can\'t know all your circumstances, so to make your mark more fair, you can put your own mark. It won\'t cancel or change Quipl\'s one, but it also would display in your day plan history.',
									side: 'right',
								},
							},
							{
								element: '#close-day__comment-field',
								popover: {
									description: 'You might want to leave a comment about your day. It isn\'t neccessary and you are free to leave this field empty.',
									side: 'right',
								},
							},
							
							{
								element: '#close-day_tomorrow-plan',
								popover: {
									description: 'Here you can choose saved tasks for tomorrow\'s plan. It isn\'t nessesary but would make tomorrow\'s plan creation faster.',
									side: 'right',
								},
							},
							{
								element: '#close-day__icon',
								popover: {
									description: 'After clicking this button, you would finish your day plan, so it would be be impossible to make any changes in it.',
									side: 'left',
									align: 'end',
								},
							},
						],
						onHighlighted: () => {
							const currentStepIndex = driverObj.getActiveIndex();
							const lastStepIndex = driverObj.getConfig().steps.length - 1;
							
							if (currentStepIndex === lastStepIndex) {
								const skipButton = document.querySelector('.driver-popover-navigation-btns').querySelector('.driver-popover-next-btn');
								const skipButtonClass = 'driver-popover-skip-button';
								if (!skipButton.classList.contains(skipButtonClass)) skipButton.classList.add(skipButtonClass);
							}
						},

						onPopoverRender: () => {
							const currentStepIndex = driverObj.getActiveIndex();
							const lastStepIndex = driverObj.getConfig().steps.length - 1;

							const createSkipButton = (buttonValue) => {
								const doneButton = document.createElement('button');
								const doneButtonAttributes = [['type', 'button'], ['class', 'custom-skip-button'], ['style', 'display: block;']];
								doneButtonAttributes.forEach((item) => {
									if (Array.isArray(item)) {
										doneButton.setAttribute(item[0], item[1]);
									}
								})
								doneButton.innerText = buttonValue;
								doneButton.addEventListener('click', () => {
									driverObj.destroy();
								})

								document.querySelector('.driver-popover-navigation-btns').prepend(doneButton);
							};

							const removeButton = (selector) => {
								if (document.querySelector(selector)) document.querySelector(selector).remove();
							}

							if (currentStepIndex === 0) { // по умолчанию в driver.js на 0 шаге отображается кнопка "предыдущий слайд", удаляю ее
								removeButton('.driver-popover-prev-btn');
							}

							if (currentStepIndex < lastStepIndex) { //добавляю кнопку "Skip" либо "Done" по аналогии с intro.js
								createSkipButton('Skip');
							} else {
								removeButton('.driver-popover-next-btn');
								createSkipButton('Done');
							}

							const popoverFooter = document.querySelector('.driver-popover > footer');

							const customBullets = document.createElement('div');
							customBullets.classList.add('custom-bullets');

							const customBulletsList = document.createElement('ul');
							for (let i = 0; i <= lastStepIndex; i++) {
								const cutstomBulletsLi = document.createElement('li');
								const customBulletsLink = document.createElement('a');
								
								customBulletsLink.setAttribute('data-stepnumber', i);
								if (i === currentStepIndex) customBulletsLink.classList.add('active');

								customBulletsLink.addEventListener('click', (e) => {
									driverObj.moveTo(+e.target.dataset.stepnumber);
								})

								cutstomBulletsLi.append(customBulletsLink);
								customBulletsList.append(cutstomBulletsLi);
							}

							customBullets.appendChild(customBulletsList);
							document.querySelector('.driver-popover').insertBefore(customBullets, popoverFooter)
						},

						onDestroyed: () => {
							axios.post('/updateEduStep', {
                     			newStep: ++currentEduStep,
			         		})
						}
					});

					driverObj.drive();
				}
			} catch (error) {
				console.error(error);
			}

		}
		}
</script>
<style scoped>
	.v-progress-circular{
		width: 50px;
		margin: auto;
	}

	.close-day_chips-wrapper ::v-deep .v-slide-group__wrapper {
		display: block;
	}

	.close-day_chips-wrapper ::v-deep .v-slide-group__wrapper .v-slide-group__content {
		display: block;
		white-space: normal;
	}

	.closeDay-content::-webkit-scrollbar {
        width: 12px;
    }

    .closeDay-content::-webkit-scrollbar-track {
        background: #e6e6e6;
        border-left: 1px solid #dadada;
    }

    .closeDay-content::-webkit-scrollbar-thumb {
        background: #b0b0b0;
        border: solid 3px #e6e6e6;
        border-radius: 7px;
    }

    .closeDay-content::-webkit-scrollbar-thumb:hover {
        background: rgb(161, 0, 0);
        cursor: pointer;
    }

	@media screen and (max-width: 424px) {
		::v-deep .closeDay-content .container {
			padding: 0 !important;
		}

		::v-deep .closeDay-header,
		::v-deep .closeDay-content,
		::v-deep .closeDay-footer {
			padding-left: 16px !important;
			padding-right: 16px !important;
		}
	}

	@import url('/css/CloseDay/CloseDayMedia.css');
</style>