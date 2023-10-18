<template>
	<v-dialog max-width="650px" persistent v-model="isShow">
		<v-card>
			<v-card-title class="font-weight-bold v-card-title">Add #code</v-card-title>
			<v-card-text>
				<v-text-field label="#code" required v-model="hashCode"></v-text-field>
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
			data()
			{
				return {hashCode : '',icons : {mdiPlusBox,mdiCancel, mdiBackspace}, isShow : true}
			},
			methods :
			{
				addHashCode()
				{
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
				toggle()
				{
					this.$emit('toggleAddHashCodeDialog')
				}
			}
		}
</script>