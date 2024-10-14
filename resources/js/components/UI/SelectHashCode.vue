<template>
     <v-select
    :items = "hashCodes"
    :value = "value"
    @input       = "updateValue"
    @change      = "selectHashCode"
    @blur        = "resetSearch"
    required>
    <template v-slot:prepend-item>
        <v-list-item class="search-item pt-2">
            <v-text-field
            v-model="searchInputVal"
            placeholder="Search..."
            solo
            dense
            hide-details
            clearable
            @input       = "filterHashCodes"
            @click:clear = "resetSearch"
            ></v-text-field>
        </v-list-item>
    </template>
    </v-select>
</template>

<script>
    export default {
        props: {
            value: {
                type: String,
                required: true,
            },
            hashCodes: {
                type: Array,
            }
        },
        data() {
            return {
                searchInputVal: '',
                filteredHashCodes: this.hashCodes,
            }
        },
        methods: {
            selectHashCode(value) {
               this.$emit('selectHashCode', value, true);
            },

            updateValue(value) {
                this.$emit('input', value);
            },

            resetSearch() {
                this.filteredHashCodes = [...this.hashCodes];
            },

            filterHashCodes(value) {
                if (!value) {
                    return;
                }

                const searchInputValue = value.trim().toLowerCase();

                console.log(this.hashCodes);
            }
        }
    }
</script>

<style scoped>
    .v-list-item.search-item {
      width: 190px;
      position: sticky;
      top: 0;
      z-index: 1; /* Убедитесь, что элемент над другими */
      background-color: white; /* Установите фон, если необходимо */
   }
</style>