<template>
  <v-app>
    <k-header />
    <v-main fluid fill-height>
      <router-view/>
    </v-main>
  </v-app>
</template>

<script>
import KHeader from "./Header";
import KMain from "./KMain";

export default {
  name: "App",
  components: { KHeader, KMain },
  beforeMount() {
    this.$vuetify.theme.dark = true;
  },
};
</script>