<template>
    <v-select
        :label="label"
        required
        :items="taskTypes"
        :value="value"
        @input="$emit('update:modelValue', $event)"
        @change="$emit('change')"
        >
        <template v-slot:item="{item}" >
            <v-list-item >{{ item }}</v-list-item>
                <VSelectTooptip 
                :item="item"
                :tooltipData = "tooltipTypesData"
            />
        </template>
    </v-select>
</template>

<script>
import VSelectTooptip from './VSelectTooptip.vue';
    export default {
        props: {
            label: {
                type: String,
                default: 'Type',
            },
            value: {
                type: String,
                required: true,
            },
            taskTypes: {
                type: Array,
                required: true,
            }
        },
        components: {VSelectTooptip},
        emits: ['update:modelValue', 'change'],
        computed: {
            tooltipTypesData() {
                return {
                    titles: {
                        requiredJob: 'required job',
                        nonRequiredJob: 'non required job',
                        requiredTask: 'required task',
                        task: 'task',
                    },
                    descriptions: {
                        requiredJob: `<span style="text-indent: -1em; padding-left: 1em;">Main entity of your plan. By adding a required job, you kind of sign a commitment with yourself that you will at least start doing it today. After finishing working on a job, you should evaluate the effort you spent.</span><br><span style="text-indent: -1em; padding-left: 1em;">By 23:59 all (!) required jobs should be evaluated</span>`,
                        nonRequiredJob: `<span style="text-indent: -1em; padding-left: 1em;">Some of your day\`s jobs could be not so important but, anyway, you want to evaluate your efforts. So, non required jobs are exactly what you need. Failure to comply has no consequences. Moreover, to complete all non required jobs is a perfect way to increase your final day grade</span>`,
                        requiredTask: `<span style="text-indent: -1em; padding-left: 1em;">We often have a plenty of small (but important) tasks (e.g “call to the boss”). It would be difficult to evaluate the result of such task, but, anyway, you have to do it.</span>`,
                        task: `<span style="text-indent: -1em; padding-left: 1em;">Anything that\`s not so important and hard to evaluate but necessary personally for you ( e.g. “night out with friends” )</span>`,
                    },
                }
            },
        },
    }
</script>