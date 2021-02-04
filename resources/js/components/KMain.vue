<template>
  <v-container fluid fill-height>
    <v-layout
      justify-center
      align-top
      v-if="records.length > 0 && !loading"
      row
      class="py-10 ma-auto"
    >
      <record
        v-for="(record, index) in records"
        :key="index"
        :item="record"
        :index="index"
      />
    </v-layout>

    <v-layout
      justify-center
      align-center
      v-if="records.length == 0 && !loading"
    >
      <h1>Empty</h1>
    </v-layout>

    <v-layout justify-center align-center v-if="loading">
      <v-progress-circular indeterminate size="164" />
    </v-layout>

    <v-btn
      dark
      fixed
      bottom
      :style="{ left: '50%', transform: 'translateX(-50%)' }"
      @click="showCreateForm = true"
      >Add comment</v-btn
    >
    <v-snackbar v-model="snackbar"> Something went wrong </v-snackbar>

    <edit-record
      v-model="showCreateForm"
      :editMode="false"
      v-bind:record="{}"
    />
  </v-container>
</template>

<script>
import { newComment, getComments, deleteComment } from "../utils/api";
import Record from "./Record";
import EditRecord from "./EditRecord";

export default {
  name: "KMain",
  components: { Record, EditRecord },
  data: () => ({
    records: [],
    showCreateForm: false,
    loading: false,
    snackbar: false,
  }),
  methods: {
    deleteComment(id, index) {
      deleteComment(id).then(() => {
        this.records.splice(index, 1);
      });
    },
    getComments() {
      this.loading = true;
      getComments()
        .then(({ data }) => {
          this.loading = false;
          this.records = data;
        })
        .catch(() => {
          this.loading = false;
          this.snackbar = true;
        });
    },
  },
  beforeMount() {
    this.getComments();
  },
};
</script>