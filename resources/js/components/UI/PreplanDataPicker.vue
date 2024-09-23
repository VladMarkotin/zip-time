<template>
     <v-container>
    <v-menu v-model="menu" offset-y>
      <template #activator="{ props }">
        <v-btn v-bind="props" color="primary">Set date</v-btn>
      </template>
      
      <div>
        <v-date-picker v-model="picker" @input="menu = false"></v-date-picker>
      </div>
    </v-menu>

    <div>
      <p>: {{ picker }}</p>
    </div>
  </v-container>
</template>


<script>
export default {
  data() {
    return {
      menu: true,
      picker: null,
    };
  },
};
</script>