<template>
	<v-dialog :max-width="maxWidth" 
	v-model="isShow"
	>
		<v-card class="addHashCode-card-wrapper">
			<v-card-title class="font-weight-bold v-card-title">Add #code</v-card-title>
			<v-card-text>
				<v-text-field 
				class="addHashCode-dialog-input-wrapper"
				label="#code" 
				required 
				v-model="hashCode"
				:rules="hashCodeRules"
				success
				ref="hashCodeInput"
				@keydown.enter="addHashCode"
				>
				</v-text-field>
				<v-row class="p-0 m-o addHashCode-alert-wrapper">
					<v-progress-circular
					v-if="isShowPreloader" 
                    indeterminate
                    color="#A10000"
                    size="48"
                    width="5"
                    ></v-progress-circular>
					<v-alert
					type="success"
					v-model="showAllert.success"
					>
					#code was added successfully
					</v-alert>
					<v-alert
					type="error"
					v-model="showAllert.error"
					>
					failed to add #code
					</v-alert>
				</v-row>
			</v-card-text>
			<v-card-text class="addHashCode-system-message">
				{{ systemMessage }}
			</v-card-text>
			<v-divider></v-divider>
			<v-card-actions class="justify-space-between v-card-actions">
				<v-tooltip right>
					<template v-slot:activator="{on}">
						<v-btn 
						icon 
						v-on="isHashCodeValid ? on : false" 
						v-on:click="addHashCode"
						:disabled="!isHashCodeValid ? true : false"
						:class="{'addHashCode-button-inactive': !isHashCodeValid}"
						>
							<v-icon color="#D71700" large>{{icons.mdiPlusBox}}</v-icon>
						</v-btn>
					</template>
					<span>Add #code</span>
				</v-tooltip>
				<v-tooltip right>
					<template v-slot:activator="{on}">
						<v-btn icon v-on="on" v-on:click="closeDialog">
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
	import {mdiPlusBox,mdiCancel, mdiBackspace} from '@mdi/js'
	export default
		{	
			props: {
				isShowDialog: {
					type: Boolean,
					required: true,
				},

				hashCodeVal: {
					type: String,
					required: true,
				},

				width: {
					default: 400,
				},

				defaultSavedTaskData: {
					type: Object,
				},

				taskName: {},
				time: {},
				type: {},
				priority: {},
				taskId: {}, 
			},
			data() {
				return {
					hashCode : '',
					icons : {mdiPlusBox,mdiCancel, mdiBackspace},
					isShow: false, 
					userHashCodes: new Array,
					hashCodeRules: [
						(inputVal) => {
							inputVal = inputVal.trim();
							if (inputVal[0] !== '#') return inputVal.length >= this.permissibleCodeLengthMin - 1 || `Minimum length is ${this.permissibleCodeLengthMin - 1} characters`;
							return inputVal.length >= this.permissibleCodeLengthMin || `Minimum length is ${this.permissibleCodeLengthMin} characters`;
						},

						(inputVal) => {
							inputVal = inputVal.trim();
							if (inputVal[0] !== '#') return inputVal.length <= this.permissibleCodeLengthMax - 1 || `Maximum length is ${this.permissibleCodeLengthMax - 1} characters`;
							return inputVal.length <= this.permissibleCodeLengthMax || `Maximum length is ${this.permissibleCodeLengthMax} characters`;
						},

						(inputVal) => {
							inputVal = inputVal.trim();
							if (inputVal[0] === '#') {
								return !this.userHashCodes.some(code => code === inputVal) || 'Your code must be unique';
							}

							return (!this.userHashCodes.some(code => code.slice(1) === inputVal)) || 'Your code must be unique';
						},

						(inputVal) => {
							inputVal = inputVal.trim();
							return inputVal.match(/^[A-Za-z0-9#_-]+$/) !== null || 'You can use Latin alphabet, numbers, symbols: # - _';
						},

						(inputVal) => {
							inputVal = inputVal.trim();
							return inputVal.match(/^#[Qq]-/) === null || 'You cannot use hash code starting with the characters "q-...". Such hash codes are reserved';
						}
					],
					isHashCodeValid: false,
					permissibleCodeLengthMin: 3,
					permissibleCodeLengthMax: 6,
					showAllert: {
						success: false,
						error: false,
					},
					isShowPreloader: false,
					loading: false, //тут храню статус загрузки, что бы нельзя было хаотично нажимать на Enter во время загрузки
					systemMessage: '',
					USING_DEFAULT_TASKS_SYSTEM_MESSAGE: 'Please, change default hash code for further usage',
				}
			},
			computed: {
				maxWidth: function() {
					return `${this.width}px`
				},
			},
			watch: {
				isShow(currentValue) {
					if (currentValue === false) {
						this.$emit('close');
					}
				},
				hashCode() {
					this.isHashCodeValid = this.hashCodeRules.map(check => {
						return check(this.hashCode);
					}).every(checkResult => checkResult === true);
					
					this.$emit('changeHashCode', this.hashCode);

					if (this.showAllert.error === true) this.showAllert.error = false;
				},
			},
			methods : {
				addHashCode() {
					if (this.isHashCodeValid) {
						if (!this.hashCode[0] === '#') {
							this.hashCode = `#${this.hashCode}`
						}
						sendHashCodeData = sendHashCodeData.bind(this);
						sendHashCodeData();
					}

					
					async function sendHashCodeData () {
						
						const checkHashCodeLength = () => {
							const permissibleLength = new Array;

							for (let i = this.permissibleCodeLengthMin; i <= this.permissibleCodeLengthMax; i++) {
								permissibleLength.push(i);
							}

							return permissibleLength.includes(this.hashCode.trim().length) ? true : false;
						}

						const showAllert = (success, error) => {
							this.showAllert = {
								success,
								error,
							}
						}

						const controllLoadingTime = (time, callback) => {
							const minPreloaderDispTime = 1000;
							
							if (time > minPreloaderDispTime) callback();
							else setTimeout(callback, minPreloaderDispTime - time);
						}

						const checkIsTaskBasedOnDefaultSavedTask = (requestData) => {

							const { defaultSavedTaskData } = this;

							
							if (!defaultSavedTaskData || !defaultSavedTaskData.isDefaultSAvedTaskSelected || !defaultSavedTaskData.selectedSavedTaskId) {
								return requestData;
							}

							return {
								...requestData, 
								default_saved_task_id: defaultSavedTaskData.selectedSavedTaskId
							};
						}
						
						if (this.loading || !checkHashCodeLength()) return;
						showAllert(false, false)
						this.loading = true;
						const loadingStart = Date.now();
						this.isShowPreloader = true;

						try {
						let requestData = {
							hash:     this.hashCode.trim(),
							taskName: this.taskName,
							time:     this.time,
							type:     this.type,
							priority: this.priority,
							task_id:  this.taskId,
						};

						requestData = checkIsTaskBasedOnDefaultSavedTask(requestData);

						const responce = await axios.post('/addHashCode', requestData)
						
						if (responce.data.status === 'success') {
							const loadingEnd = Date.now();
							controllLoadingTime(loadingEnd - loadingStart, () => {
								if (this.isShowPreloader) this.isShowPreloader = false;
								showAllert(true, false);

								setTimeout(() => {
									this.$emit('addHashCode', this.hashCode.trim());
									if (this.loading) this.loading = false;
									this.closeDialog();
								}, 1500);
							})

						} else {
							const loadingEnd = Date.now();
							this.systemMessage = responce.data.message;

							controllLoadingTime(loadingEnd - loadingStart, () => {
								if (this.isShowPreloader) this.isShowPreloader = false;
								if (this.loading) this.loading = false;

								showAllert(false, true);
							})
						}

					} catch (error) {
						const loadingEnd = Date.now();
						this.systemMessage = responce.data.message;

						controllLoadingTime(loadingEnd - loadingStart, () => {
							if (this.isShowPreloader) this.isShowPreloader = false;
							if (this.loading) this.loading = false;

							showAllert(false, true);
						})

						throw new Error(error);
					}
					};

				},

				closeDialog() {
					this.isShow = false;
				},

				async getHashCodes() {
					let hashCodes = new Array;

					try {
						const responce = await axios.post('/getSavedTasks'); 
						hashCodes = responce.data.hash_codes.map(item => item.hash_code);
					} catch(error) {
						throw new Error(error);
					} finally {
						return hashCodes;
					}
				}
			},

			created() {
				this.isShow = this.isShowDialog;
				this.hashCode = this.hashCodeVal;	
				
				if (this.defaultSavedTaskData !== undefined && this.defaultSavedTaskData.isDefaultSAvedTaskSelected === true) {
					this.systemMessage = this.USING_DEFAULT_TASKS_SYSTEM_MESSAGE;
				};
			},

			async mounted() {
				const hashCodes = await this.getHashCodes();
				if (hashCodes.length) this.userHashCodes = hashCodes;
				if (this.$refs.hashCodeInput) this.$refs.hashCodeInput.validate(true);
			}
		}
</script>

<style>
	.addHashCode-card-wrapper .addHashCode-dialog-input-wrapper .v-input__control .v-messages__wrapper{
		font-size: 14px;
	}

	.addHashCode-card-wrapper .addHashCode-alert-wrapper {
		min-height: 56px;
		justify-content: center;
		align-items: center;
	}

	.addHashCode-card-wrapper .addHashCode-alert-wrapper > div[role="alert"] {
		margin-bottom: 0;
		width: 70%;
		animation: .45s codeAlertAppearance ease;
		position: relative;
	}

	.addHashCode-card-wrapper .addHashCode-button-inactive {
		opacity: .4;
	}

	
	.addHashCode-card-wrapper .addHashCode-system-message {
		padding-bottom: 0 !important;
		text-align: center;
		font-weight: bold;
		min-height: 66px;
		font-size: 15px;
		line-height: 21px;
		color:  #49423D !important;
	}

	@keyframes codeAlertAppearance {
		from { opacity: 0;  top: -.5rem;}
		to { opacity: 1; top: 0;}
	}

</style>