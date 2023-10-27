<template>
	<v-dialog max-width="450px" v-model="isShow">
		<v-card>
			<v-card-title class="font-weight-bold v-card-title">Add #code</v-card-title>
			<v-card-text>
				<v-text-field 
				label="#code" 
				required 
				v-model="hashCode"
				:rules="hashCodeRules"
				success
				ref="hashCodeInput"
				>
				</v-text-field>
			</v-card-text>
			<v-divider></v-divider>
			<v-card-actions class="justify-space-between v-card-actions">
				<v-tooltip right>
					<template v-slot:activator="{on}">
						<v-btn icon v-on="on" v-on:click="addHashCode">
							<v-icon color="#D71700" large>{{icons.mdiPlusBox}}</v-icon>
						</v-btn>
					</template>
					<span>Add #code</span>
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
	import {mdiPlusBox,mdiCancel, mdiBackspace} from '@mdi/js'
	export default
		{	
			props: {
				isShowDialog: {
					type: Boolean,
					required: true,
				}
			},
			data() {
				return {
					hashCode : '',
					icons : {mdiPlusBox,mdiCancel, mdiBackspace},
					isShow: false, 
					userHashCodes: new Array,
					hashCodeRules: [
						(inputVal) => {
							return inputVal.trim().length > 2 || 'Minimum length is 3 characters';
						},

						(inputVal) => {
							return inputVal.trim().length <= 6 || 'Maximum length is 6 characters';
						},

						(inputVal) => {
							if (inputVal[0] === '#') {
								return !this.userHashCodes.some(code => code === inputVal) || 'your code must be unique';
							}

							return (!this.userHashCodes.some(code => code.slice(1) === inputVal)) || 'your code must be unique';
						}
					],
					isHashCodeValid: false,
				}
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

					console.log(this.isHashCodeValid);
				},
			},
			methods : {
				addHashCode() {
					if (this.hashCode.length >= 3 && this.hashCode.length <= 6)
					{
						if (this.hashCode.includes('#'))
						{
							this.toggle()
							this.$emit('addHashCode',this.hashCode)
						}
						else
						{
							this.hashCode = `#${this.hashCode}`
						}
					}
				},
				toggle() {
					this.$emit('toggleAddHashCodeDialog')
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
			},

			async mounted() {
				if (this.$refs.hashCodeInput) this.$refs.hashCodeInput.validate(true);
				const hashCodes = await this.getHashCodes();
				if (hashCodes.length) this.userHashCodes = hashCodes;
			}
		}
</script>