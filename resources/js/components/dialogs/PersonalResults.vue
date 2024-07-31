<template>
    <div 
    class="personal-results personal-results-card-wrapper" 
    >
    <v-card class="mx-auto personal-results-card" width="500" prepend-icon="mdi-home">
      <template v-slot:title> Your current personal results:</template>

      <v-card-text>
        <ul style="padding: 0; min-height: 40px;">
          <template v-if="!is_emergency_mode_activated">
            <li :class="{'less-rating': ratingData.ratingStatus === 'lessThatMin'}" v-html="betterThen"></li>
            <li v-html="moreResponsible"></li>
            <li v-html="userPurposelness"></li>
            <li v-html="betterThenPurposelness"></li>
          </template>
          <li v-else>Comparative information is unavailable during emergency mode</li>
        </ul>
        
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
              is_emergency_mode_activated: false,
              better_then: 0,
              more_pesponsible: 0,
              user_purposelness: 0,
              better_then_purposelness: 0,
              ratingData: {},
          }),
          methods :
          {
            setRatingData(ratingData) {
              this.ratingData = {...ratingData};
            }
          },
          computed: {
            betterThen() {
              const {ratingStatus} = this.ratingData;
              switch (ratingStatus) {
                case 'lessThatMin':
                  const {minReqRating} = this.ratingData;
                  const minRatingDescription = Number.isFinite(minReqRating)
                    ? `<br /> To compare with other users, your rating must be at least <strong>${minReqRating}</strong>`
                    : '';

                  return `Your rating is currently not high enough to compare with other users ${minRatingDescription}`
                case 'normal':
                  return `For now you are better than <strong>${this.better_then}%</strong>  of users in your group`
                case 'moreThenMax':
                  return `For now you are better than <strong>${this.better_then}%</strong>  of <strong>all</strong> users`
                default:
                  return `For now you are better than <strong>${this.better_then}%</strong>  of users in your group`;

              }
            },

            moreResponsible() {
              return this.more_pesponsible !== 'n/a'
                ? `For now you are responsible on <strong>${this.more_pesponsible}%</strong>`
                : ''
            },

            userPurposelness() {
              return `For now your purposefulness is <strong>${this.user_purposelness}%</strong>`;
            },

            betterThenPurposelness() {
              const {ratingStatus} = this.ratingData;
              switch (ratingStatus) {
                case 'lessThatMin':
                  return '';
                case 'normal':
                  return `For now Quipl estimate your purposefulness as <strong>${this.better_then_purposelness}%</strong> among users in your group`
                case 'moreThenMax':
                  return `For now Quipl estimate your purposefulness as <strong>${this.better_then_purposelness}%</strong> among <strong>all</strong> users`
                default:
                  return `For now Quipl estimate your purposefulness as <strong>${this.better_then_purposelness}%</strong> among users in your group`
              }
            }
          },
          async created() {
              await axios.post('/get-results')
              .then((response) => {
                  
                const getData = (response) => (key) => response.data[key];
                const getValue = getData(response);

                this.is_emergency_mode_activated = getValue('is_emergency_mode_activated');
                
                if (!this.is_emergency_mode_activated) {
                  this.better_then = getValue('better');
                  this.more_pesponsible = getValue('more_pesponsible');
                  this.user_purposelness = getValue('user_purposelness');
                  this.better_then_purposelness = getValue('better_then_purposelness');
  
                  this.setRatingData(getValue('ratingData'));
                }

              })
          }
      }
</script>
<style scoped>
  .personal-results{
      position:absolute;
      right: 5%;
  }

  .less-rating {
    margin-bottom: 5px;
  }
</style>