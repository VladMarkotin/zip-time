<template>
    <v-card 
      color="grey lighten-4" 
      width="400px" 
      flat
      class="history-day-card d-flex flex-column"
    >
      <v-toolbar :color="selectedEvent.color" dark class="history-day-card_header">
        <v-toolbar-title>{{ selectedEvent.name }}</v-toolbar-title>
        <v-spacer></v-spacer>
        <span>{{ formatedDate }}</span>
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
      <v-list class="history_final-data-list" v-if="isDayPassed || isEmergencyModeActive">
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
      <v-list v-else>
        <v-list-item>
          <v-list-item-content class="justify-content-center">
            <a :href="preplanUrl">
              <v-btn style="width: 100%;">{{isPreplanExists ? 'update plan' : 'create plan'}}</v-btn>
            </a>
          </v-list-item-content>
        </v-list-item>
      </v-list>
      <v-spacer></v-spacer> 
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
    computed: {
      isPreplanExists() {
        return this.selectedEvent.status !== 4;
      },
      isDayPassed() {
        return this.selectedEvent.isDayPassed;
      },
      isEmergencyModeActive() {
        return this.selectedEvent.status === 0;
      },
      formatedDate() {
        return new Date(this.selectedEvent.date).formatDateToDMY();
      },
      preplanUrl() {
        return `/preplan?date=${this.selectedEvent.date}`;
      }, 
    },
    methods: {
      editComment(value) {
        this.$emit('editComment', value);
      },
    },
  };
  </script>

<style scoped>
  .history-day-card {
    min-height: 566px;
  }

  .history-day-card_header {
    flex-grow: 0;
  }

  .key {
	  font-weight : bold
	}

	.history_final-data-list .history_final-data-li {
		gap: 25px;
		min-height: 0 ;
	}

	.history_final-data-list .history_final-data-li .key {
		justify-content: flex-start !important;
	}

	.history_final-data-list .history_final-data-li .v-list-item__content{
		padding: 4px;
		justify-content: flex-end;
	}

  @import url('/css/History/HistoryMedia.css');
</style>