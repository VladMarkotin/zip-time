<template>
<div v-if="showChallenges">
    <h1 class="text-center">Challenge!</h1>
    <v-window
        v-model="onboarding"
        :show-arrows=true
    >
    <v-window-item
      v-for="challenge in allChallenges"
      :key="`card-${challenge.id}`"
    >
      <v-card
        elevation="2"
        class="ma-2 p-3"
      >
        <v-card-title class="p-2 justify-content-center ">{{ challenge.title }}</v-card-title>
        <v-row class="challenge-content-wrapper p-0 m-0">
          <v-col class="p-0 m-0 d-flex flex-column align-items-center" cols="3">
            <v-card-title class="p-0 mb-4 justify-content-center">
              Goal: {{ getChallengeDataById(challenge.id, 'goal') }}
            </v-card-title>
            <v-progress-circular
            :rotate="360"
            :size="100"
            :width="15"
            :value="challenge.completeness"
            color="red"
            >
              {{ challenge.completeness }}%
            </v-progress-circular>
          </v-col>
          <v-col class="p-0 m-0" cols="3">
            {{ getChallengeDataById(challenge.id, 'description')}}
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
        }
    }
}
</script>

<style scoped>
  .challenge-content-wrapper {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 25%;
  }
</style>