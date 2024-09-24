<template>
     <v-container>
    <v-menu v-model="menu" offset-y>
      <template #activator="{ props }">
        <v-btn 
        v-bind="props" 
        @click="menu = true"
        style="background-color: rgb(161, 0, 0); color: white"
        >Set date</v-btn>
      </template>
      
      <div>
        <v-date-picker 
        color="#A10000"
        :value="value" 
        :min="todayDate"
        @input  = "updateValue"
        @change = "$emit('changePlanDate')"
        ></v-date-picker>
      </div>
    </v-menu>

    <div>
        <p>Selected date: {{ displayDate }}</p>
    </div>
  </v-container>
</template>


<script>
export default {
    props: {
        value: {
            type: String,
            required: true,
        },
        todayDate: {
            type: String,
            default: new Date().getTodayFormatedDate(),
        }
    },
    data() {
    return {
        menu: false,
    };
  },
    computed: {
        displayDate() {
            const formatedDate = this.formatDate(this.value);
            
            const dayOfWeek = new Date(formatedDate).toLocaleString('en-US', { weekday: 'long' });

            return formatedDate === this.todayDate ? 'Today' : `${formatedDate} ${dayOfWeek}`;
        },
    },
    methods: {
        formatDate(date) {
            return new Date(date).getCurrentDate().slice(0,10);
        },
        updateValue(selectedDate) {
            this.menu = false;
            this.$emit('input', this.formatDate(selectedDate));
        }
    },
};
</script>