<template>
    <v-card
	width="400"
    >
		<v-card-title>Notes list</v-card-title>
		<!-- <v-divider></v-divider>
			<v-card-text style="height: 300px;">
				<template>
					<div class="d-flex align-center flex-column">
						<v-card
						width="800"
						title="This is a title"
						subtitle="This is a subtitle"
						text="This is content"
						v-model="notesList"
						v-for="(item, i) in notesList"
      					:key="i"
						>
						<v-card-title >
         					Note from {{ item.created_at }}
						</v-card-title>
						<v-card-text class="bg-white text--primary">
							<b>
								{{ item.note }}
							</b>
							<v-checkbox
								v-model="ex4[i]"
								label="red"
								color="red"
								value="red"
								hide-details
							></v-checkbox>
						</v-card-text>
						<v-divider v-if="item.created_at == new Date('d.m.Y')"></v-divider>
						</v-card>
						<span v-if="noteInfo.todayAmount == 0">
							There are no any notes
						</span>
			        </div>
			    </template>
		    </v-card-text>
				<v-divider></v-divider>
				<v-card-actions>
				<v-btn
					color="blue-darken-1"
					variant="text"
					@click="dialogNotes = false"
				>
					Close
				</v-btn>
				<v-btn
					color="blue-darken-1"
					variant="text"
					@click="dialogNotes = false"
				>
					Save
				</v-btn>
				</v-card-actions> -->
	</v-card>
</template>

<script>
    export default {
        props: {
            isLoading: {
                type: Boolean,
            },
        },
        data() {
            return {

            };
        },
        created() {
            console.log(this.isLoading);
        }
    }
</script>