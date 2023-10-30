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

				taskName: {},
				time: {},
				type: {},
				priority: {},
				details: {},
				notes: {}  
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
							if (inputVal[0] !== '#') return inputVal.length > 1 || 'Minimum length is 2 characters';
							return inputVal.length > 2 || 'Minimum length is 3 characters';
						},

						(inputVal) => {
							inputVal = inputVal.trim();
							if (inputVal[0] !== '#') return inputVal.length <= 5 || 'Maximum length is 5 characters';
							return inputVal.length <= 6 || 'Maximum length is 6 characters';
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
						}
					],
					isHashCodeValid: false,
					permissibleCodeLengthMin: 3,
					permissibleCodeLengthMax: 6,
					showAllert: {
						success: false,
						error: false,
					},
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
				},
			},
			methods : {
				addHashCode() {
					const closeAfterAdding = async () => {
						const permissibleLength = new Array;
						for (let i = this.permissibleCodeLengthMin; i <= this.permissibleCodeLengthMax; i++) {
							permissibleLength.push(i);
						}

						if (permissibleLength.includes(this.hashCode.trim().length)) {
							try {
								const responce = await axios.post('/addHashCode', {
									hash:     this.hashCode.trim(),
									taskName: this.taskName,
									time:     this.time,
									type:     this.type,
									priority: this.priority,
									details:  this.details,
									notes:    this.notes,
								})
								
								if (responce.data.status === 'success') {
									this.showAllert = {
										success: true,
										error: false,
									};

									this.$emit('addHashCode');
									setTimeout(() => {
										this.closeDialog();
									}, 1500);
								}
								else {
									this.showAllert = {
										success: false,
										error: true,
									}
								}

							} catch(error) {
								throw new Error(error);
							}
						}
					};

					if (this.isHashCodeValid) {
						if (this.hashCode[0] === '#') {
							closeAfterAdding();
						} else {
							this.hashCode = `#${this.hashCode}`
							closeAfterAdding();
						}
					}

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
			},

			async mounted() {
				if (this.$refs.hashCodeInput) this.$refs.hashCodeInput.validate(true);
				const hashCodes = await this.getHashCodes();
				if (hashCodes.length) this.userHashCodes = hashCodes;
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

	@keyframes codeAlertAppearance {
		from { opacity: 0;  top: -.5rem;}
		to { opacity: 1; top: 0;}
	}

</style>