<template>
    <v-card
	width="400"
    >
		<v-card-title>Notes list</v-card-title>
		<v-divider></v-divider>
        <v-card-text style="min-height: 468px;">
            <v-list 
            v-if="!isLoading"
            class="d-flex flex-column" 
            style="gap: 30px"
            >
                <v-list-item v-for="(item, i) in notesList" :key="i">
                    <v-card
                    width="800"
                    style="min-height: 180px;"
                    >
                    <v-row class="p-4 m-0">
                        <v-col class="p-0 m-0" style="width: 100%;">
                            <v-card-title class="p-0 m-0">
                                Note from {{ item.created_at }}
                            </v-card-title>
                        </v-col>
                        <v-col class="p-0 m-0" cols="1">
                            x
                        </v-col>
                    </v-row>
                        <v-card-text class="bg-white text--primary">
                            <b>
                                {{ item.note }}
                            </b>
                        </v-card-text>
                        <v-divider v-if="item.created_at == new Date('d.m.Y')"></v-divider>
                    </v-card>
                </v-list-item>
            </v-list>
            <v-list
            style="min-height: inherit;"
            v-else
            class="d-flex justify-content-center align-items-center"
            >
                <DefaultPreloader 
                :size="96"
                :width="7"
                />
            </v-list>
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