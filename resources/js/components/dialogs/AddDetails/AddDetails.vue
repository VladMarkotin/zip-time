<template>
    <v-dialog 
    :fullscreen = "isShowFullScreen" 
    v-model     = "isShowDialogDetails" 
    scrollable 
    width="auto">
        <template v-slot:activator="{ props }">
            <v-tooltip right>
                <template v-slot:activator="{ on: tooltip  }">
                    <v-btn 
                    icon 
                    v-on="tooltip"
                    v-bind="props" 
                    @click="showAddDetailsDialog" 
                    :id="!cardIdx ? 'card-details' : false"
                    >
                        <v-icon color="#D71700">{{ icons.mdiChartGantt }}</v-icon>
                    </v-btn>
                </template>
                <span>Show details</span>
            </v-tooltip>
        </template>
        <template v-if="isShowDialogDetails">
            <AddDetailsCard 
			:taskId             = "taskId"
            :alert              = "alert"
            :generateUniqKey    = "generateUniqKey"
            @closeAddDetailsDialog    = "closeAddDetailsDialog"
            @updateAlertData          = "setAlertData"
            @resetDayMarkToDefVal     = "$emit('resetDayMarkToDefVal')"
            />
        </template>
    </v-dialog>
</template>

<script>
import store from '../../../store';
import { mapActions, mapGetters } from 'vuex/dist/vuex.common.js';
import AddDetailsCard from './AddDetailsCard.vue';
import {mdiChartGantt,}  from '@mdi/js'  
import { uuid } from 'vue-uuid';
export default {
    props: {
        cardIdx: { //нужен для презентации
            type: Number,
            required: true,
        },
        taskId: {
            type: Number,
            required: true,
        },
    },
    data() {
        return {
            isShowDialogDetails: false,
            isShowAllDialogDetails: false,
            alert: {type: 'success', text: 'success'},
            icons: {mdiChartGantt, },
            minPreloaderDispTime: 500,
        }
    },
    store,
    emits: ['resetDayMarkToDefVal'],
    components: {AddDetailsCard},
    computed: {
        ...mapGetters(['getWindowScreendWidth']),
        isShowFullScreen() {
            return this.getWindowScreendWidth < 768; 
        }  
    },
    watch: {
        isShowDialogDetails(value) {
            if (!value) {
                this.reset_to_default_values({taskId: this.taskId});
            }
        },
    },
    methods: {
        ...mapActions(['fetchDetails', 'reset_to_default_values']),
        showAddDetailsDialog() {
            this.isShowDialogDetails = true;
        },

        closeAddDetailsDialog() {
            this.isShowDialogDetails = false;
        },

        setAlertData({type, text}) {
            if (type) this.alert.type = type;
            if (text) this.alert.text = text;
		},

        generateUniqKey() {
             return uuid.v1();
        }
    },
}
</script>