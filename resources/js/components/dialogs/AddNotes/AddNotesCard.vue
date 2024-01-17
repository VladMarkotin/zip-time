<template>
    <v-card
	width="400"
    >
		<v-card-title>Notes list</v-card-title>
		<v-divider></v-divider>
			<v-card-text style="height: 300px;">
				<template>
					<div class="d-flex align-center flex-column">
						<v-card
						width="800"
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
						</v-card-text>
						<v-divider v-if="item.created_at == new Date('d.m.Y')"></v-divider>
						</v-card>
						<span v-if="!notesList.length">
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
				>
					Close
				</v-btn>
				<v-btn
					color="blue-darken-1"
					variant="text"
				>
					Save
				</v-btn>
				</v-card-actions>
	</v-card>
</template>

<script>
import DefaultPreloader from '../../UI/DefaultPreloader.vue';
    export default {
        props: {
            notesList: {
                type: Array,
                required: true,
            },
            isLoading: {
                type: Boolean,
            },
        },
        data() {
            return {

            };
        },
        components: {
            DefaultPreloader,
        },
    }
</script>