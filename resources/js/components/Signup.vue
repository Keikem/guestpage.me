<template>
  <v-dialog v-model="show">
    <v-card
      class="ma-auto px-4 pb-4"
      :loading="ui.loading"
      :disabled="ui.loading"
    >
      <v-card-title class="justify-center"> Sign Up </v-card-title>

      <v-form v-model="form.valid" class="ma-5" ref="form">
        <v-text-field
          v-model="form.name"
          label="Name"
          required
          :rules="[rules.name.required, rules.name.min]"
        />
        <v-text-field
          v-model="form.email"
          label="Email"
          required
          :rules="[rules.email.required, rules.email.valid]"
        />
        <v-text-field
          v-model="form.password"
          label="Password"
          :append-icon="ui.isPasswordShow ? 'mdi-eye' : 'mdi-eye-off'"
          @click:append="ui.isPasswordShow = !ui.isPasswordShow"
          :type="ui.isPasswordShow ? 'text' : 'password'"
          :rules="[rules.password.required, rules.password.min]"
          required
        />
        <v-text-field
          v-model="form.password_confirmation"
          label="Password confirmation"
          :append-icon="
            ui.isPasswordConfirmationShow ? 'mdi-eye' : 'mdi-eye-off'
          "
          @click:append="
            ui.isPasswordConfirmationShow = !ui.isPasswordConfirmationShow
          "
          :type="ui.isPasswordConfirmationShow ? 'text' : 'password'"
          :rules="[
            rules.password_confirmation.required,
            form.password === form.password_confirmation ||
              'Passwords dont match!',
          ]"
          required
        />
      </v-form>
      <v-card-actions class="justify-center">
        <v-btn class="success" @click="register()" :disabled="!form.valid"
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
      name: "Adrian",
      password: "123456",
      password_confirmation: "123456",
      email: "adrian@mail.con",
      valid: false,
      nameError: "",
      emailError: "",
      passwordError: "",
    },
    ui: {
      loading: false,
      isPasswordShow: false,
      isPasswordConfirmationShow: false,
    },
    rules: {
      name: {
        required: (v) => !!v || "Name is required!",
        min: (v) => (v && v.length >= 5) || "Name must be at least 5 symbols",
      },
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
      password_confirmation: {
        required: (v) => !!v || "Password confirmation is required!",
        match: (v) => v === this.form.password || "Passwords dont match!",
      },
    },
  }),
  methods: {
    register() {
      this.validate();
      if (this.form.valid) {
        let name = this.form.name;
        let email = this.form.email;
        let password = this.form.password;
        let password_confirmation = this.form.password_confirmation;
        this.ui.loading = true;
        this.$store
          .dispatch("register", {
            name,
            email,
            password,
            password_confirmation,
          })
          .then(() => {
            this.show = false;
            this.ui.loading = false;
            this.$store.dispatch("me");
          })
          .catch((err) => {
            this.ui.loading = false;
            this.form.valid = false;
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