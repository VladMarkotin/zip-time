<template>
    <div 
    class="personal-results personal-results-card-wrapper" 
    >
    <v-card class="mx-auto personal-results-card" width="500" prepend-icon="mdi-home">
      <template v-slot:title> Your current personal results:</template>

      <v-card-text>
        <ul style="padding: 0; min-height: 40px;">
          <template v-if="!isEmergencyModeActivated">
            <li v-if="!isOnlyOneUserInGroup" :class="{'less-rating': ratingData.ratingStatus === 'lessThatMin'}" v-html="betterThenText"></li>
            <li v-else>At the moment, you are the only one in your group</li>
            <li v-html="moreResponsibleText"></li>
            <li v-html="userPurposelnessText"></li>
            <li v-html="betterThenPurposelnessText"></li>
          </template>
          <li v-else>Comparative information is unavailable during emergency mode</li>
        </ul>
      </v-card-text>
    </v-card>
    </div>
  </template> 

  <script>
  import { mapActions, mapGetters } from 'vuex/dist/vuex.common.js';
  import store from '../../store';
  
  export default
      {
          store,
          methods :
          {
            ...mapActions(['fetchPersonalResults']),
          },
          computed: {
            ...mapGetters(['getPersonalResultData']),
            isEmergencyModeActivated() {
              return this.getPersonalResultData('is_emergency_mode_activated');
            },
            isOnlyOneUserInGroup() {
              return this.getPersonalResultData('is_only_one_user_in_group');
            },
            ratingData() {
              return this.getPersonalResultData('ratingData');
            },
            better_then() {
              return this.getPersonalResultData('better_then');
            },
            more_pesponsible() {
              return this.getPersonalResultData('more_pesponsible');
            },
            user_purposelness() {
              return this.getPersonalResultData('user_purposelness');
            },
            better_then_purposelness() {
              return this.getPersonalResultData('better_then_purposelness');
            },
            betterThenText() {
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

            moreResponsibleText() {
              return this.more_pesponsible !== 'n/a'
                ? `For now you are responsible on <strong>${this.more_pesponsible}%</strong>`
                : ''
            },

            userPurposelnessText() {
              return `For now your purposefulness is <strong>${this.user_purposelness}%</strong>`;
            },

            betterThenPurposelnessText() {
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
            this.fetchPersonalResults();
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