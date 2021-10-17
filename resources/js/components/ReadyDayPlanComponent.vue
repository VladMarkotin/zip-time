<template>
   <v-data-iterator
      :items="['temp']"
      hide-default-footer
      >
      <template v-slot:default="props">
         <v-row>
            <v-col cols="6" v-for="item of params.plan" :key="item.id" >
               <v-card>
                  <v-card-title class="subheading font-weight-bold justify-space-between" style="background-color: #A10000;color: white;">
                     <span>{{ item.hash }}</span>
                     <span>{{ item.taskName }}</span>
                     <span v-if="item.priority > 1"> ! </span>
                     <span v-else>  </span>
                  </v-card-title>
                  <v-list dense>
                     <v-list-item>
                        <v-list-item-content>Time:</v-list-item-content>
                        <v-list-item-content class="align-end">
                           {{ item.time }}
                        </v-list-item-content>
                     </v-list-item>
                     <v-list-item>
                        <v-list-item-content>Details:</v-list-item-content>
                        <v-list-item-content class="align-end">
                           {{ item.details }}
                        </v-list-item-content>
                     </v-list-item>
                     <v-list-item>
                        <v-list-item-content>Note:</v-list-item-content>
                        <v-list-item-content class="align-end">
                           {{ item.notes }}
                        </v-list-item-content>
                     </v-list-item>
                  </v-list>
                  <v-divider></v-divider>
                  <v-card-title class="subheading font-weight-bold">
                     <form class="d-flex align-center">
                        <div>Mark</div> 
                        <v-text-field style="width : 54px;" :class="{invalid : false/*($v.?.$dirty && !$v.?.required)*/}" class="ml-1">
                           <v-icon
                              slot="append"
                              >
                              mdi-percent
                           </v-icon>
                        </v-text-field>
                     </form>
                  </v-card-title>
               </v-card>
            </v-col>
         </v-row>
      </template>
   </v-data-iterator>
</template>
<script>
   import { minLength,maxLength } from 'vuelidate/lib/validators'
   export default {
     props : ['params'],
         data: () => ({
             // ? : ?,
         }),
         validations: {
             // ? : {minLength : minLength(50),maxLength : maxLength(99)},
         },
   }
</script>