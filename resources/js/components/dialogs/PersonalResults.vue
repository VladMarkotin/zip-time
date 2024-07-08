<template>
    <div 
    class="personal-results personal-results-card-wrapper" 
    >
    <v-card class="mx-auto personal-results-card" width="500" prepend-icon="mdi-home">
      <template v-slot:title> Your current personal results:</template>

      <v-card-text>
        For now you are better than <strong>{{better_then}}%</strong>  of users in your group<br />
       For now you are responsible on {{more_pesponsible}}% <br />   <!--It has to be more_responsible than % of users in the group -->
         For now Quipl estimate your purposefulness as {{user_purposelness}}% among users in your group<br/>
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
              better_then: 0,
              more_pesponsible: 0,
              user_purposelness: 0
              
          }),
          methods :
          {
            // showInfo() {
            //     alert('test');
            // }
          },
          async created() {
            //alert('PersonalResults')
              await axios.post('/get-results')
              .then((response) => {
                  console.log(response);
                  //this.tags = response.data.hash_codes.map((obj) => obj.hash_code)
                  this.better_then = response.data.better
                  this.more_pesponsible = response.data.more_pesponsible.toFixed(2);
                  this.user_purposelness = response.data.user_purposelness
              })
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