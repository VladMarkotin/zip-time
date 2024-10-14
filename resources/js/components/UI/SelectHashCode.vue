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
            @input       = "debounceFilterHashCodes"
            @click:clear = "resetSearch"
            ></v-text-field>
        </v-list-item>
    </template>
    </v-select>
</template>

<script>
import { debounce } from 'lodash';
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
        computed: {
            debouncedFilterHashCodes() {
                return debounce(function(searchInputValue) {
					this.filterHashCodes(searchInputValue);
				}, 1500)
            },
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

            debounceFilterHashCodes(value) {
                if (!value) {
                    return;
                }

                const searchInputValue = value.trim().toLowerCase();

                this.debouncedFilterHashCodes(searchInputValue);
            },

            async filterHashCodes(searchInputValue) {
                try {
                    const response = await axios.post('/searchHashCodes', { searchInputValue });
                } catch (error) {
                    console.error(error);
                }
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