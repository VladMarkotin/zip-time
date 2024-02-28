<template>
    <v-dialog 
    v-model="dialogEditSubTask" 
    persistent 
    width="500">
        <v-card>
            <v-card-title class="text-h5 d-flex justify-content-center align-items-center">
                Edit Subtask
            </v-card-title>
            <v-card-text>
                Edit Subtask`s title:
                <form
                @keydown.enter="saveChangesInSubtask"
                >
                    <v-text-field 
                    class="ml-1 pt-0" 
                    :counter="subtaskRules.subtaskTitle.maxLength" 
                    v-model="subtaskInputsValues.title"
                    :rules="subtaskTitleRules"
                    success
                    @input="checkInputsValue"
                    ref="subtaskTitleInput"
                    >
    
                    </v-text-field>
                    Edit Subtask`s text:
                    <v-text-field 
                    :counter="subtaskRules.subtaskText.maxLength"
                    class="ml-1 pt-0" 
                    v-model="subtaskInputsValues.text"
                    :rules="subtaskTextRules"
                    success
                    @input="checkInputsValue"
                    ref="subtaskTextInput"
                    >
    
                    </v-text-field>
                </form>

            </v-card-text>
            <v-card-actions style="min-height: 88px;">
                <transition
                enter-active-class="edit-details-alert_appearance"
                leave-active-class="edit-details-alert_leave"
                >
                    <v-alert 
                    v-if="alert.isShowAlert"
                    text class="elevation-1" 
                    v-bind:type="alert.type"
                    >{{ alert.text }}
                    </v-alert>
                </transition>
                <v-spacer></v-spacer>
                <v-btn color="green-darken-1" variant="text" @click="dialogEditSubTask = false">
                    Cancel
                </v-btn>
                <v-btn
                v-if="isSubTaskInputValValid" 
                color="green-darken-1" 
                variant="text"
                @click="saveChangesInSubtask">
                    Save
                </v-btn>
            </v-card-actions>
        </v-card>
    </v-dialog>
</template>

<script>
export default {
    props: {
        isShowEditDetailsDialog: {
            type: Boolean,
            required: true,
        },

        modifiedDetailTemplate: {
            type: Object,
            required: true,
        },

        details: {
            type: Array,
            required: true,
        },

        subtaskRules: {
            type: Object,
        },

        subtaskTitleRules: {
            type: Array,
        },

        subtaskTextRules: {
            type: Array,
        },

        alertDisplayTime: {
            type: Number,
            default: 1500,
        }
    },
    data() {
        return {
            dialogEditSubTask: false,
            subtaskInputsValues: {
                title: '',
                text:  '',
            },
            alert: {type: '', text: '', isShowAlert: false},
            isSubTaskInputValValid: false,
        }
    },
    methods: {
        updateDetails() {
            const updateDetails = this.details.map(item => {
                if (item.taskId === this.modifiedDetailTemplate.id) return {...item, text: this.subtaskInputsValues.text, title: this.subtaskInputsValues.title};
                return item;
            })

            this.$emit('updateDetails', updateDetails);
        },

        setAlertData(alertData) {
            this.alert = {
                ...this.alert,
                type: alertData.type,
                text: alertData.text,
            }

            console.log(this.alert);
        },

        saveChangesInSubtask(){	
            if (this.isSubTaskInputValValid) {
				axios.post('/edit-subtask', 
                {id: this.modifiedDetailTemplate.id, title: this.subtaskInputsValues.title, text: this.subtaskInputsValues.text}) // type : item.type
					.then((response) => {
						
						if (response.data.status == 'success') {
							this.updateDetails();
						}

                        this.setAlertData({type: response.data.status, text: response.data.message});
                        this.alert.isShowAlert = true;

						setTimeout( () => {
							this.dialogEditSubTask = false;
						},this.alertDisplayTime)
				  })
            } else {
                this.setAlertData({type: 'error', text: 'Invalid data'})
                this.alert.isShowAlert = true;

                setTimeout(() => {
                    this.alert.isShowAlert = false;
                }, this.alertDisplayTime)
            }
			},

            checkInputsValue() {
                this.isSubTaskInputValValid = new Array(
                    ...this.subtaskTitleRules.map(check => check(this.subtaskInputsValues.title)),
                    ...this.subtaskTextRules.map(check => check(this.subtaskInputsValues.text)),
                ).every(checkResult => checkResult === true);
            },
    },
    watch: {
        dialogEditSubTask(dialogStatus) {
            if (dialogStatus === false) this.$emit('closeEditDetailsDialog');
        }
    },
    created() {
        this.dialogEditSubTask = this.isShowEditDetailsDialog;
        this.subtaskInputsValues = {title: this.modifiedDetailTemplate.title, text: this.modifiedDetailTemplate.text};
    },

    mounted() {
        const subtasksInputs = [this.$refs.subtaskTitleInput, this.$refs.subtaskTextInput]
        
        if (subtasksInputs.every(item => item)) {
                subtasksInputs.forEach(item => item.validate(true));
                this.checkInputsValue();
           }
    }
}
</script>

<style scoped>
    .edit-details-alert_appearance {
        animation: .3s edit_details_alert_appearance ease;
    }

    .edit-details-alert_leave {
        animation: .3s edit_details_alert_leave ease;
    }

    @keyframes edit_details_alert_appearance {
		from { opacity: 0; left: -10px;}
		to { opacity: 1; left: 0;}
	}

	@keyframes edit_details_alert_leave {
		from { opacity: 1; left: 0;}
		to { opacity: 0; left: 10px;}
	}
</style>