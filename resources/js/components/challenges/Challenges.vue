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
        height="200"
        class="d-flex align-center justify-center ma-2"
      >
        <div
          class=""
        >
            <div class="">
                <v-progress-circular
                :rotate="360"
                :size="100"
                :width="15"
                :value="challenge.completeness"
                color="red"
                >
                  {{ challenge.completeness }}%
                </v-progress-circular>
            </div>
        </div>
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
    computed: mapGetters(['allChallenges']),
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