<template>
    <v-select 
    label="#code"
    :items="filteredHashCodes" 
    :value="value" 
    @input="updateValue" 
    @change="selectHashCode"
    required>
        <template v-slot:prepend-item>
            <v-list-item class="search-item pt-2" :style="`width: ${searchItemWidth};`">
                <v-text-field 
                v-model="searchInputVal" 
                placeholder="Search..." 
                solo 
                dense 
                hide-details 
                clearable
                @input       = "debounceFilterHashCodes" 
                @click:clear = "resetSearch"
                @blur        = "resetSearch"
                ></v-text-field>
            </v-list-item>
        </template>
    </v-select>
</template>

<script>
import { debounce } from 'lodash';
import axios from 'axios';

export default {
    props: {
        value: {
            type: String,
            required: true,
        },
        hashCodes: {
            type: Array,
            default: () => [], // Убедитесь, что есть значение по умолчанию
        },
        searchItemWidth: {
            type: String,
            default: '100%',
        }
    },
    data() {
        return {
            searchInputVal: '',
            filteredHashCodes: [...this.hashCodes],
        };
    },
    watch: {
        hashCodes: {
            immediate: true,
            handler(newValue) {
                this.filteredHashCodes = [...newValue];
            },
        },
    },
    methods: {
        selectHashCode(value) {
            this.$emit('selectHashCode', value, true);
            this.resetSearch();
        },

        updateValue(value) {
            this.$emit('input', value);
        },

        resetSearch() {
            this.searchInputVal = '';
            this.filteredHashCodes = [...this.hashCodes];
        },

        debounceFilterHashCodes: debounce(function (value) {
            if (!value) {
                this.resetSearch();
                return;
            }
            const searchInputValue = value.trim().toLowerCase();
            this.filterHashCodes(searchInputValue);
        }, 1000), 

        async filterHashCodes(searchInputValue) {
            try {
                const response = await axios.post('/searchHashCodes', { searchInputValue });
                if (response.status === 200) {
                    this.filteredHashCodes = [...response.data.searchResults];
                } else {
                    this.resetSearch();
                }
            } catch (error) {
                this.resetSearch();
                console.error(error);
            }
        },
    },
};
</script>

<style scoped>
.v-list-item.search-item {
    position: sticky;
    top: 0;
    z-index: 1;
    /* Убедитесь, что элемент над другими */
    background-color: white;
    /* Установите фон, если необходимо */
}
</style>