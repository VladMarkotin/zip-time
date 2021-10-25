<template>
   <v-data-iterator
      :items="['temp']"
      hide-default-footer
      >
      <SectionComponent title="Required tasks:" :items="plan.filter((item) => [4,2].includes(item.type))"></SectionComponent>
      <v-divider></v-divider>
      <SectionComponent title="Non required tasks:" :items="plan.filter((item) => [3,1].includes(item.type))"></SectionComponent>
   </v-data-iterator>
</template>
<script>
   import SectionComponent from './SectionComponent.vue'
   import { minLength,maxLength } from 'vuelidate/lib/validators'
   export default {
   components: {
      SectionComponent
   },
     props : ['plan'],
         data: () => ({
             // ? : ?,
         }),
         validations: {
             // ? : {minLength : minLength(50),maxLength : maxLength(99)},
         },
   }
</script>