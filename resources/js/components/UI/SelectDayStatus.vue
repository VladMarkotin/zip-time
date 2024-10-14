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
            }
        },
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
        },
        methods: {
            updateValue(value) {
                this.$emit('input', value);
            }
        },
        created() {
            console.log(this.isWeekendAvailable);
        }
    }
</script>