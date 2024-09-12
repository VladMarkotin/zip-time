<template>
    <v-dialog 
    :fullscreen = "isShowFullScreen" 
    v-model     = "isShowDialogDetails" 
    scrollable 
    width="auto">
        <template v-slot:activator="{ props }">
            <v-btn 
            icon 
            v-bind="props" 
            @click="showAddDetailsDialog" 
            :id="!num ? 'card-details' : false"
            >
                <v-icon color="#D71700">{{ icons.mdiChartGantt }}</v-icon>
            </v-btn>
        </template>
        <template v-if="isShowDialogDetails">
            <AddDetailsCard 
            :item               = "item"
			:taskId             = "item.taskId"
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
        num: {},
        item: {
            type: Object,
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
                this.reset_to_default_values({taskId: this.item.taskId});
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