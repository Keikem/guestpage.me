<template>
  <div>
    <v-card class="ma-2">
      <v-img
        height="100px"
        class="align-end"
        src="https://cdn.pixabay.com/photo/2020/07/12/07/47/bee-5396362_1280.jpg"
      >
        <v-card-title class="white--text mt-8">
          <p class="ml-3">
            {{ item.owner == null ? "Anonymous user" : item.owner.name }}
          </p>
        </v-card-title>
      </v-img>
      <v-card-text>
        <div class="font-weight-normal px-4">
          <p>
            <strong>{{ item.title }}</strong>
          </p>
          <p>{{ item.content }}</p>
          <p class="text-end">
            Created at <span>{{ formatTime(item.created_at) }}</span>
          </p>
        </div>
        <v-card-actions v-if="isLogged">
          <v-spacer />
          <v-btn
            outlined
            v-if="(isOwner && !isExpired) || isAdmin"
            @click="showEditForm = true"
            >Edit</v-btn
          >
          <v-btn
            outlined
            class="red"
            v-if="(isOwner && !isExpired) || isAdmin"
            @click="deleteRecord()"
            >Delete
          </v-btn>
        </v-card-actions>
      </v-card-text>
    </v-card>

    <edit-record v-model="showEditForm" v-bind:record="item" :editMode="true" />
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import moment from "moment";
import EditRecord from "./EditRecord";

export default {
  name: "Record",
  props: {
    item: Object,
    index: Number,
  },
  components: { EditRecord },
  computed: {
    ...mapGetters(["currentStatus", "isLogged", "isAdmin"]),
    isOwner() {
      return this.item.owner_id == this.$store.state.user.id;
    },
    isExpired() {
      var expireDate = Date.parse(this.item.created_at) + 2 * 3600 * 1000;
      return Date.now() >= expireDate;
    },
  },
  data: () => ({
    showEditForm: false,
  }),
  methods: {
    deleteRecord() {
      this.$parent.deleteComment(this.item.id, this.index);
    },
    getComments() {
      this.$parent.getComments();
    },
    formatTime(date) {
      return moment(date).format("h:mm YYYY-MM-DD");
    },
  },
};
</script>