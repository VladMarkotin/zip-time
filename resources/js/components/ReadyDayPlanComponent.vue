<template>
   <div>
      <AddJobComponent></AddJobComponent>
      <v-data-iterator
         :items="['temp']"
         hide-default-footer
         >
         <SectionComponent title="Required tasks:" :items="plan.filter((item) => [4,2].includes(item.type))"></SectionComponent>
         <v-divider></v-divider>
         <SectionComponent title="Non required tasks:" :items="plan.filter((item) => [3,1].includes(item.type))"></SectionComponent>
      </v-data-iterator>
      <div class=" d-flex justify-space-between mt-3">
         <v-tooltip right>
            <template v-slot:activator="{ on, attrs }">
               <v-btn color="#D71700" style="text-color:#ffffff" icon v-on:click="formSubmit()" v-bind="attrs"
                  v-on="on">
                  <v-icon md="1"
                     color="#D71700"
                     large
                     >
                     {{icons.mdiSendClock}}
                  </v-icon>
               </v-btn>
            </template>
            <span>Close Day</span>
         </v-tooltip>
         <v-tooltip right>
            <template v-slot:activator="{ on, attrs }">
               <v-btn color="#D71700" style="text-color:#ffffff" icon v-on:click="" v-bind="attrs"
                  v-on="on">
                  <v-icon md="1"
                     color="#D71700"
                     >
                     {{icons.mdiCarEmergency}}
                  </v-icon>
               </v-btn>
            </template>
            <span>Emergency call</span>
         </v-tooltip>
      </div>
   </div>
</template>
<script>
   import AddJobComponent from './AddJobComponent.vue'
   import SectionComponent from './SectionComponent.vue'
   import { minLength,maxLength } from 'vuelidate/lib/validators'
   import {
       mdiSendClock,
       mdiCarEmergency,
   } from '@mdi/js'
   export default {
   components: {
      AddJobComponent,
      SectionComponent
   },
     props : ['plan'],
         data: () => ({
           icons: {
               mdiSendClock,
               mdiCarEmergency,
           },
         }),
         validations: {
             // ? : {minLength : minLength(50),maxLength : maxLength(99)},
         },
   }
</script>