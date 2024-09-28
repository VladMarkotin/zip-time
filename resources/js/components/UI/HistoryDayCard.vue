<template>
    <v-card 
      color="grey lighten-4" 
      width="400px" 
      flat
    >
      <v-toolbar :color="selectedEvent.color" dark>
        <v-toolbar-title>{{ selectedEvent.name }}</v-toolbar-title>
        <v-spacer></v-spacer>
      </v-toolbar>
      <v-card-text>
        <v-data-table 
          :headers="headers" 
          :items="selectedEvent.tasks" 
          class="elevation-1"
          hide-default-footer
        />
      </v-card-text>
      <v-divider />
      <v-list class="history_final-data-list">
        <v-list-item class="history_final-data-li">
          <v-list-item-content class="key">Final mark:</v-list-item-content>
          <v-list-item-content>{{ selectedEvent.dayFinalMark }}</v-list-item-content>
        </v-list-item>
        <v-list-item class="history_final-data-li">
          <v-list-item-content class="key">Own mark:</v-list-item-content>
          <v-list-item-content>{{ selectedEvent.dayOwnMark }}</v-list-item-content>
        </v-list-item>
        <v-list-item>
          <v-list-item-content style="overflow: visible;">
            <ClosedDayCommentDialog 
              :commentText="selectedEvent.comment"
              :newCommentText="newCommentText"
              commentFieldHeight="150px"
              @editComment="editComment"
              @saveComment="$emit('saveComment')"
            />
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <v-card-actions>
        <v-row class="pt-3 pb-3">
          <v-btn text color="secondary" @click="$emit('close')">
            Cancel
          </v-btn>
        </v-row>
      </v-card-actions>
    </v-card>
  </template>
  
  <script>
  import ClosedDayCommentDialog from '../dialogs/ClosedDayCommentDialog.vue';
  export default {
    props: {
      selectedEvent: {
        type: Object,
        required: true,
      },
      headers: {
        type: Array,
        required: true,
      },
      newCommentText: {
        type: String,
        default: '',
      },
    },
    components: {ClosedDayCommentDialog},
    methods: {
      editComment(value) {
        this.$emit('editComment', value);
      },
    },
  };
  </script>