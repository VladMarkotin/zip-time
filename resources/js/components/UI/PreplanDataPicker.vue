<template>
     <v-container class="dataPicker-wraper">
    <v-menu v-model="menu" menuPosition>
      <template #activator="{ props }">
        <v-btn 
        v-bind="props" 
        @click="menu = true"
        style="background-color: rgb(161, 0, 0); color: white"
        >Set future plans</v-btn>
      </template>
      
      <div>
        <v-date-picker 
        color="#A10000"
        :value="value" 
        :min="todayDate"
        @input  = "updateValue"
        @change = "$emit('changePlanDate')"
        :allowed-dates="isDateAllowed"
        ></v-date-picker>
      </div>
    </v-menu>

    <div v-if="isShowSelectedDate">
        <p class="mb-0">Selected date: {{ displayDate }}</p>
    </div>
  </v-container>
</template>


<script>
import store from '../../store';
import { mapGetters } from 'vuex/dist/vuex.common.js';
export default {
    props: {
        value: {
            type: String,
            required: true,
        },
        todayDate: {
            type: String,
            default: new Date().getTodayFormatedDate(),
        },
        menuPosition: {
            type: Object,
            default: () => ({
                'offset-y': true,
            })
        },
        isShowSelectedDate: {
            type: Boolean,
            default: true,
        }
    },
    data() {
    return {
        menu: false,
    };
},
    store,
    computed: {
        ...mapGetters(['getDisabledDates']),
        displayDate() {
            const formatedDate = this.formatDate(this.value);
            const dmyDate      = new Date(formatedDate).formatDateToDMY(); 
            
            const dayOfWeek = new Date(formatedDate).toLocaleString('en-US', { weekday: 'long' });

            return formatedDate === this.todayDate ? 'Today' : `${dmyDate} ${dayOfWeek}`;
        },
        disabledDates() {
            return this.getDisabledDates;
        }
    },
    methods: {
        formatDate(date) {
            return new Date(date).getTodayFormatedDate();
        },
        updateValue(selectedDate) {
            this.menu = false;
            this.$emit('input', this.formatDate(selectedDate));
        },
        isDateAllowed(date) {
           return !this.disabledDates.includes(date);
        }
    },
};
</script>

<style scoped>
    .dataPicker-wraper {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 0 0;
        justify-content: center;
    }

    @media screen and (max-width: 900px) {
        .dataPicker-wraper {
            flex-direction: column;
            gap: 0;
            padding: 0;
        }
    }
</style>