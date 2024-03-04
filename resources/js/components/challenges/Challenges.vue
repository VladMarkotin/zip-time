<template>
<div v-if="showChallenges">
    <h1 class="text-center">Challenge!</h1>
    <v-window
        v-model="onboarding"
        :show-arrows=true
        @change="closeDescriptionPanel"
    >
    <v-window-item
      v-for="challenge in allChallenges"
      :key="`card-${challenge.id}`"
    >
      <v-card
        elevation="2"
        class="ma-2 p-3"
      >
        <v-card-title class="pb-2 pt-0 mb-2 justify-content-center ">{{ challenge.title }}</v-card-title>
        <v-row class="challenge-content-wrapper p-0 m-0">
          <v-col class="p-0 m-0 d-flex flex-column align-items-center " cols="5">
            <div style="width: 100%;" class="mb-2">
              <v-expansion-panels 
              style="width: 100%;"
              v-model="descriptionPanel"
              multiple
              >
                <v-expansion-panel 
                >
                  <v-expansion-panel-header>Challenge description</v-expansion-panel-header>
                  <v-expansion-panel-content>
                    <p class="challenge-description mb-2">
                      {{ getChallengeDataById(challenge.id, 'description')}}
                    </p>
                  </v-expansion-panel-content>
                </v-expansion-panel>
              </v-expansion-panels>
            </div>
            <v-card-title class="p-0 mb-2 justify-content-center">
              Goal: {{ getChallengeDataById(challenge.id, 'goal') }}
            </v-card-title>
            <v-progress-circular
            :rotate="360"
            :size="130"
            :width="17"
            :value="challenge.completeness"
            color="red"
            >
              {{ challenge.completeness }}%
            </v-progress-circular>
          </v-col>
        </v-row>
      </v-card>
    </v-window-item>
    </v-window>
</div>
<div v-else>
    <button @click="showCh()">Show my Challenges</button>
</div>
</template>
<script>
import store from '../../store'
import { mapGetters, mapActions } from 'vuex'

export default {
    name: 'Challenges',

    data: () => ({
      descriptionPanel: [],
      length: 3,
      onboarding: 0,
      value: 100,
      interval: {},
      showChallenges: 1,
    }),
    store,
    computed: mapGetters([
      'allChallenges', 
      'getChallengeDataById', 
    ]),
    beforeUnmount () {
      clearInterval(this.interval)
    },
    async mounted () {
      /*this.interval = setInterval(() => {
        if (this.value === 100) {
          return (this.value = 0)
        }
        this.value += 10
      }, 1000)*/
       this.fetchChallenges();
      //this.value = this.allChallenges[0]
      
    },
    methods: {
        ...mapActions(['fetchChallenges']),

        showCh() {
            
            this.showChallenges = !(this.showChallenges)
        },

        closeDescriptionPanel() {
          this.descriptionPanel = []
        }
    }
}
</script>

<style scoped>
  .challenge-content-wrapper {
    display: flex;
    justify-content: center;
  }

  .challenge-description {
    margin-bottom: 0;
    text-align: justify;
    text-indent: 2rem;
  }
</style>