<template>
    <v-dialog fullscreen v-model="isShowPreloader">
        <v-container
            fluid
            fill-height
            style="background-color: rgb(0, 0, 0, 0.25);"
        >
            <v-layout justify-center align-center>
                <!-- <v-progress-circular
                    indeterminate
                    color="#A10000"
                    size="140"
                    width="7"
                    >
                </v-progress-circular> -->
                <div class="loader"></div>
            </v-layout>
        </v-container>
    </v-dialog>
</template>

<script>
export default {
    props: {
        showPreloader: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            isShowPreloader: false,
        };
    },
    created() {
        this.isShowPreloader = this.showPreloader;
    },
};
</script>

<style>
.loader {
  width: 150px;
  --b: 8px;
  aspect-ratio: 1;
  border-radius: 50%;
  background: #A10000;
  -webkit-mask:
    repeating-conic-gradient(#0000 0deg,#000 1deg 70deg,#0000 71deg 90deg),
    radial-gradient(farthest-side,#0000 calc(100% - var(--b) - 1px),#000 calc(100% - var(--b)));
  -webkit-mask-composite: destination-in;
          mask-composite: intersect;
  animation: l5 1s infinite;
}
@keyframes l5 {to{transform: rotate(.5turn)}}
</style>
