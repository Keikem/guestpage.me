<template>
  <v-dialog v-model="show">
    <v-card
      class="ma-auto px-4 pb-4"
      :loading="ui.loading"
      :disabled="ui.loading"
    >
      <v-card-title class="justify-center"> Sign In </v-card-title>
      <v-form v-model="form.valid" class="ma-5" ref="form">
        <v-container>
          <v-text-field
            v-model="form.email"
            label="Email"
            required
            :rules="[rules.email.required, rules.email.valid]"
            :error-messages="form.emailError"
          />

          <v-text-field
            v-model="form.password"
            label="Password"
            :append-icon="ui.isPasswordShow ? 'mdi-eye' : 'mdi-eye-off'"
            @click:append="ui.isPasswordShow = !ui.isPasswordShow"
            :type="ui.isPasswordShow ? 'text' : 'password'"
            :rules="[rules.password.required, rules.password.min]"
            :error-messages="form.passwordError"
            required
          />
        </v-container>
      </v-form>
      <v-card-actions class="justify-center">
        <v-btn class="success" @click="login()" :disabled="!form.valid"
          >SUBMIT</v-btn
        >
        <v-btn @click="clear()">CLEAR</v-btn>
        <v-btn @click="resetValidation()">RESET</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  props: {
    value: Boolean,
  },
  data: () => ({
    form: {
      email: "",
      password: "",
      valid: true,
      emailError: "",
      passwordError: "",
    },
    ui: {
      loading: false,
      isPasswordShow: false,
    },
    rules: {
      email: {
        required: (v) => !!v || "Email is required!",
        valid: (v) =>
          /^(([^<>()[\]\\.,;:\s@']+(\.[^<>()\\[\]\\.,;:\s@']+)*)|('.+'))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(
            v
          ) || "E-mail must be valid",
      },
      password: {
        required: (v) => !!v || "Password is required!",
        min: (v) =>
          (v && v.length >= 6) || "Password must be at least 6 symbols",
      },
    },
  }),
  methods: {
    login() {
      this.validate();
      if (this.form.valid) {
        let email = this.form.email;
        let password = this.form.password;
        this.ui.loading = true;
        this.$store
          .dispatch("login", { email, password })
          .then(() => {
            this.show = false;
            this.ui.loading = false;
            this.$store.dispatch("me");
          })
          .catch((err) => {
            this.ui.loading = false;
            this.form.valid = false;
            this.form.emailError = "Email is wrong!";
            this.form.passwordError = "Password is wrong!";
          });
      }
    },
    validate() {
      this.$refs.form.validate();
    },
    clear() {
      this.$refs.form.reset();
    },
    resetValidation() {
      this.$refs.form.resetValidation();
      this.form.emailError = "";
      this.form.passwordError = "";
    },
  },
  computed: {
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
};
</script>