<template>
    <div class="personal-results" v-on:mouseup="showInfo">
    <v-card class="mx-auto" width="500" prepend-icon="mdi-home">
      <template v-slot:title> Your current personal results:</template>

      <v-card-text>
        For now you are better than {{result}}% of users in your group<br />
        For now you are more responsible than {{result}}% of all users<br />
        For now Quipl estimate your purposefulness higher than 89% of users<br/>
        <a href="#">How do we get that results?</a>
      </v-card-text>
    </v-card>
    </div>
  </template>
  <script>
  import {mdiCancel,mdiSendClock} from '@mdi/js'
  
  export default
      {
          data: () => ({
              
              
          }),
          methods :
          {
            showInfo() {
                alert('test');
            }
          },
          async created() {
            //alert('PersonalResults')
              /*await axios.post('/getSavedTasks')
              .then((response) => {
                  this.tags = response.data.hash_codes.map((obj) => obj.hash_code)
                  
              })*/
          }
      }
</script>
<style scoped>
  .personal-results{
      position:absolute;
      right: 5%;
      /*display: none;*/
  }
</style>