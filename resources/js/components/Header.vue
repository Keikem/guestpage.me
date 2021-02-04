<template>
  <div>
    <v-toolbar flat>
      <v-toolbar-title>Guestpage.me</v-toolbar-title>
      <v-spacer />
      <v-btn
        outlined
        class="ma-2"
        @click="showSignInForm = true"
        v-if="!isLogged"
        >Sign in</v-btn
      >
      <v-btn
        outlined
        class="ma-2"
        @click="showSignUpForm = true"
        v-if="!isLogged"
        >Sign up</v-btn
      >
      <div class="pa-1" v-if="isLogged">
        Welcome,
        <span style="color: red">{{ this.$store.state.user.name }}</span>
        <v-btn outlined class="ma-2" @click="logout()">Logout</v-btn>
      </div>
    </v-toolbar>

    <signin v-model="showSignInForm" />
    <signup v-model="showSignUpForm" />
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import Signin from "./Signin";
import Signup from "./Signup";

export default {
  name: "Header",
  components: { Signup, Signin },
  data: () => ({
    showSignInForm: false,
    showSignUpForm: false,
  }),
  computed: {
    ...mapGetters(["currentStatus", "isLogged"]),
  },
  methods: {
    logout() {
      this.$store.dispatch("logout");
    },
  },
};
</script>