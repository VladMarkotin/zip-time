<template>
   <div>
      <div>{{ title }}</div>
      <v-row>
         <v-col cols="6" v-for="item of items" :key="item.id" >
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
                        <v-textarea
                           outlined
                           rows="2"
                           row-height="4"
                           shaped
                           placeholder="Details"
                           counter="256"
                           :value="item.details"
                        ></v-textarea>
                     </v-list-item-content>
                  </v-list-item>
                  <v-list-item>
                     <v-list-item-content>Note:</v-list-item-content>
                     <v-list-item-content class="align-end">
                        <v-textarea
                           outlined
                           rows="2"
                           row-height="4"
                           shaped
                           placeholder="Notes"
                           counter="256"
                           :value="item.notes"
                        ></v-textarea>
                     </v-list-item-content>
                  </v-list-item>
               </v-list>
               <v-divider></v-divider>
               <v-card-title class="subheading font-weight-bold">
                  <form class="d-flex align-center">
                     <div>Mark</div> 
                     <v-text-field style="width : 54px;" class="ml-1">
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
   </div>
</template>
<script>
   export default {
     props : ['title','items'],
   }
</script>