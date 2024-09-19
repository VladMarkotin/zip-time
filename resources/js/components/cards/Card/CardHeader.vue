<template>
    <div class="card-demo">
		<AddHashCode 
		v-if="isShowAddHashCodeDialog"
		:width  		= "450"
		:hashCodeVal    = "hash"
		:isShowDialog   = "isShowAddHashCodeDialog"
		:taskName       = "taskName"
		:time           = "time"
		:type           = "transformedType"
		:priority       = "priority"
		:taskId 		= "taskId"
		@close          = "isShowAddHashCodeDialog = false"
		@addHashCode    = "renameHashCode"
		/>
		<div class="card-demo"></div>
		<v-card-title class="font-weight-bold justify-space-between v-card-title">
			<v-row class="m-0 p-0">
				<v-col 
				class="m-0 p-0 d-flex justify-content-start align-items-start"
				cols="auto"
				style="min-width: 88px;"
				>
					<v-row 
					class="m-0 p-0"
					v-if="hash == '#'"
					>
						<AddHashCodeButton 
						:buttonColor = "'white'"
						:buttonSize  = "26"
						@addHashCodeButtonClick="isShowAddHashCodeDialog = true"
						/>	
					</v-row>
					<v-row 
					class="m-0 p-0"
					v-else
					>
						<span style="line-height: 1.5rem;" class="p-0">{{ hash }}</span>
					</v-row>
				</v-col>
				<v-col class="m-0 p-0 d-flex justify-content-center align-items-start task-name-wrapper">
					<span v-if="!isTaskNameLong" class="task-name">{{ taskName }}</span>
					<span 
					v-else
					:class="maxTaskNameLen.forRender === 255 ? 'task-name trancated-task-name-full' : 'task-name pointer'"
					@click="maxTaskNameLen.forRender = 255"
					@mouseleave="maxTaskNameLen.forRender = maxTaskNameLen.default"
					>
						{{truncatedTaskName}}
					</span>
				</v-col>
				<v-col 
				class="m-0 p-0 d-flex justify-content-end align-items-start"
				cols="auto"
				style="min-width: 22px;"
				>
					<span v-if="priority == 1"> </span>
					<span v-else-if="priority == 2">!</span>
					<span v-else-if="priority == 3">!!!</span>
					<span v-else>  </span>
				</v-col>
			</v-row>
		</v-card-title>
		</div>
</template>

<script>
import { mapMutations } from 'vuex/dist/vuex.common.js';
import AddHashCode from '../../dialogs/AddHashCode.vue';
import AddHashCodeButton from '../../UI/AddHashCodeButton.vue';
    export default {
        props: ['hash', 'taskName', 'time', 'transformedType', 'priority', 'taskId'],
        data() {
            return {
                isShowAddHashCodeDialog : false,
                //Тут менять от скольки символов название таски обрезается,з начения полей объекта должны совпадать.
                maxTaskNameLen: { 
					default: 50,
					forRender: 50,
				},
            }
        },
        components: {AddHashCode, AddHashCodeButton},
        computed: {
            isTaskNameLong() {
				return this.taskName.length > this.maxTaskNameLen.default;
			},

            truncatedTaskName() {
				const taskName = this.taskName;

				if (taskName.length > this.maxTaskNameLen.forRender) {
					return taskName.slice(0, this.maxTaskNameLen.forRender) + '...';
				}

				return taskName;
			},
        },
        methods: {
            ...mapMutations(['UPDATE_TASK_DATA']),
            renameHashCode(newHash) {
				this.UPDATE_TASK_DATA({
					updatedTaskData: {hash: newHash, taskId: this.taskId},
				});
			},
        }
    }
</script>

<style scoped> 
    .task-name-wrapper {
		padding: 0 10px !important;
		min-height: 48px;
		word-break: break-word;
		text-align: center;
	}

    .task-name {
		line-height: 1.5rem;
	}

    .pointer {
		cursor: pointer;
	}

    .trancated-task-name-full {
		animation: taskNameAppearance  0.3s ease-in-out;
	}

    @keyframes taskNameAppearance {
		from {opacity: 0;}
		to {opacity: 1;}
	}
</style>