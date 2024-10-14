<template>
       <v-select
        :items="dayStatuses"
        label="Day status"
        :value="value"
        @input="updateValue"
        item-disabled="disable"
        item-text="status"
        required
        @change="$emit('change')"
        @focus="checkIsShowSnackbar"
        @blur="$emit('removeSnackbar')"
        ></v-select>       
</template>

<script>
    export default {
        props: {
            value: {
                type: String,
                required: true,
            },
            isWeekendAvailable: {
                type: Boolean,
                required: true,
            },
            planDate: {
                type: String,
            }
        },
        emits: ['change', 'input', 'removeSnackbar', 'showSnackbar'],
        computed: {
            dayStatuses() {
                return [
                    {
                        status: 'Work Day',
                        disable: false,
                    },
                    {
                        status: 'Weekend',
                        disable: !this.isWeekendAvailable,
                    }
                ];
            },
            snackbarText() {
                const formatedDate = new Date(this.planDate).formatDateToDMY();
                const {mondayDate, sundayDate} = this.getMondayAndSunday(this.planDate);

                return `On ${formatedDate}, only the Work day status is available 
                because the limit for weekend days has been exceeded from ${mondayDate} to ${sundayDate}. 
                Once a week, you can change the allowed number of weekends on the settings page.`;
            }
        },
        methods: {
            getMondayAndSunday(date) {
                const dayOfWeek    = new Date(date).getDay();

                const monday = new Date(date);
                const sunday = new Date(date);

                const daysToMonday = (dayOfWeek === 0) ? -6 : 1 - dayOfWeek;
                monday.setDate(monday.getDate() + daysToMonday);

                const daysToSunday = (dayOfWeek === 0) ? 0 : 7 - dayOfWeek; 
                sunday.setDate(sunday.getDate() + daysToSunday);

                return {
                    mondayDate: monday.formatDateToDMY(), 
                    sundayDate: sunday.formatDateToDMY()
                };
            },
            updateValue(value) {
                this.$emit('input', value);
            },
            checkIsShowSnackbar() {
                if (!this.isWeekendAvailable) {
                    this.$emit('showSnackbar', this.snackbarText, 45000);
                }
            },
        },
    }
</script>