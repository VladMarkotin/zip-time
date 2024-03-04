<template>
<div class="challenges">
  <div class="p-2 d-flex justify-content-center align-items-center">
      <ChallengeToggleButton 
      @toggleDispChallenges = "showCh"
      :showChallenges = "showChallenges"
      />
  </div>
  <transition name="challenges-fade">
    <div v-if="showChallenges" class="mt-4 mb-4">
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
                      <v-expansion-panel-header>
                        <span style=" color: rgba(0,0,0,.6); font-size: 1rem;">
                          Challenge description:
                        </span>
                      </v-expansion-panel-header>
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
                  <div class="challenge-completeness">
                    {{ challenge.completeness }}%
                  </div>
                </v-progress-circular>
              </v-col>
            </v-row>
          </v-card>
        </v-window-item>
        </v-window>
        <v-row class="p-0 m-0 d-flex justify-content-end">
          <v-col class="p-0 m-0 d-flex justify-content-center" cols="1">
            <span>{{ getSliderCounter }}</span>
          </v-col>
        </v-row>
    </div>
  </transition>
</div>
</template>
<script>
import store from '../../store'
import ChallengeToggleButton from '../UI/ChallengeToggleButton.vue'
import { mapGetters, mapActions } from 'vuex'

export default {
    name: 'Challenges',

    data: () => ({
      descriptionPanel: [],
      length: 3,
      onboarding: 0,
      value: 100,
      interval: {},
      showChallenges: false,
    }),
    store,
    computed: {
        ... mapGetters([
        'allChallenges', 
        'getChallengeDataById', 
      ]),

      getSliderCounter() {
        return `${this.onboarding + 1 } / ${this.allChallenges.length}`
      }
    },
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
    components: {ChallengeToggleButton},
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

  .challenge-completeness {
    font-size: 1.5rem;
  }

  .challenge-description {
    margin-bottom: 0;
    text-align: justify;
    text-indent: 2rem;
  }

  .challenges-fade-enter-active, .challenges-fade-leave-active {
    transition: all 0.3s;
  }
  .challenges-fade-enter{
    opacity: 0;
    transform: translateX(-5%);
  }

  .challenges-fade-leave-to  {
    opacity: 0;
    transform: translateX(5%);
  }
</style>