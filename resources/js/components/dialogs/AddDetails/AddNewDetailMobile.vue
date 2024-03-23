<template>
     <v-dialog 
    v-model="addNewDetailMobileDialog"
    width="500">
        <v-card>
            <v-card-title class="text-h5 d-flex justify-content-center align-items-center">
                Add New Subtask
            </v-card-title>
            <v-card-text>
                <v-text-field 
                width="20px" 
                v-model="newDetailMobile.title" 
                :counter="subtaskRules.subtaskTitle.maxLength" 
                label="Subtask title"
                :rules="subtaskTitleRules"
                :success="dataOnValidofInputs.isTitleInpuValValid"
                required></v-text-field>

                <v-text-field 
                width="20px" 
                v-model="newDetailMobile.text" 
                :counter="subtaskRules.subtaskText.maxLength"
                label="Subtask details" 
                :rules="subtaskTextRules"
                :success="dataOnValidofInputs.isTextInputValValid"
                required></v-text-field>

                <v-row class="p-0 m-0 mt-3">
                    <v-col 
                    class="p-0 m-0"
                    cols="9"
                    >
                        <v-checkbox 
                        class="mt-0"
                        label="is required subtask?" 
                        v-model="newDetailMobile.checkpoint"
                        >
                        </v-checkbox>
                    </v-col>
                    <v-col class="p-0 m-0 d-flex justify-content-end align-items-start">
                        <AddSubtaskButton 
                        v-if="dataOnValidofInputs.areAllInputsValValid"
                        @addSubtask="addSubtask"
                        />
                    </v-col>
                </v-row>
            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import AddSubtaskButton from '../../UI/AddSubtaskButton.vue';
    export default {
        props: {
            isShowAddNewDetailMobileDialog: {
                type: Boolean,
                required: true,
            },
            newDetail: {
                type: Object,
                required: true
            },
            subtaskRules: {
                type: Object,
                required: true,
            },
            subtaskTitleRules: {
                type: Array,
                required: true,
            },
            subtaskTextRules: {
                type: Array,
                required: true,
            },
            dataOnValidofInputs: {
                type: Object,
                required: true,
            },
           
        },
        data() {
            return {
                addNewDetailMobileDialog: false,
                newDetailMobile: {
                    title: '',
                    text: '',
                    checkpoint: false,
                }
            }
        },
        components: {AddSubtaskButton,},
        watch: {
            addNewDetailMobileDialog(dialogStatus) {
                if (dialogStatus === false) {
                    this.$emit('closeAddNewDetailMobileDialog');
                    this.$emit('setNewDetail', {title: '', text: '', checkpoint: false});
                }
            },
            newDetailMobile: {
                handler(newVal) {
                    this.$emit('setNewDetail', newVal);
                },
                deep: true
            }
        },
        methods: {
            addSubtask() {
                this.$emit('addSubtask');
                this.addNewDetailMobileDialog = false;
            },
        },
        created() {
            this.addNewDetailMobileDialog = this.isShowAddNewDetailMobileDialog;
        }
    }
</script>