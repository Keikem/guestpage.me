<template>
  <v-dialog v-model="show">
    <v-card class="ma-auto pa-4" :loading="isLoading" :disabled="isLoading">
      <v-card-title class="justify-center"> {{ cardTitle }}</v-card-title>
      <v-form v-model="valid" class="ma-5" ref="form">
        <v-container>
          <v-text-field v-model="title" label="Title" required />

          <v-text-field v-model="content" label="Content" required />
        </v-container>
      </v-form>
      <v-card-actions class="justify-center">
        <v-btn class="success" @click="clickButton()">SUBMIT</v-btn>
        <v-btn @click="clear()">CLEAR</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
import { newComment, editComment } from "../utils/api";

export default {
  props: {
    value: Boolean,
    record: Object,
    editMode: Boolean,
  },
  data: () => ({
    title: "",
    content: "",
    isLoading: false,
    valid: true,
  }),
  methods: {
    clickButton() {
      if (this.editMode) this.editComment();
      else this.createComment();
    },
    createComment() {
      let id = this.record.id;
      let title = this.title;
      let content = this.content;
      newComment({ title, content }, this.$store.state.token).then(() => {
        this.show = false;
        this.$parent.getComments();
      });
    },
    editComment() {
      let id = this.record.id;
      let title = this.title;
      let content = this.content;
      editComment({ title, content }, id).then(() => {
        this.show = false;
        this.$parent.getComments();
      });
    },
    validate() {
      this.$refs.form.validate();
    },
    clear() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
    },
  },
  computed: {
    cardTitle() {
      if (this.editMode) return "Edit comment";
      else return "Create comment";
    },
    show: {
      get() {
        return this.value;
      },
      set(value) {
        this.$emit("input", value);
        this.clear();
      },
    },
  },
  beforeMount() {
    this.title = this.record.title;
    this.content = this.record.content;
  },
};
</script>