<template>
  <v-app-bar
    :clipped-left="clipped"
    fixed
    app
  >
    <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
    <v-btn
      icon
      @click.stop="miniVariant = !miniVariant"
    >
      <v-icon>mdi-{{ `chevron-${miniVariant ? 'right' : 'left'}` }}</v-icon>
    </v-btn>
    <v-btn
      icon
      @click.stop="clipped = !clipped"
    >
      <v-icon>mdi-application</v-icon>
    </v-btn>
    <v-spacer />

    <v-menu offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          class="mr-2"
          v-bind="attrs"
          small
          v-on="on"
        >
          <country-flag :country="mapCountry[locale]" size="small" />
        </v-btn>
      </template>
      <v-list>
        <v-list-item link @click="setLocale('en')">
          <v-list-item-title>
            <country-flag country="us" size="small" />
          </v-list-item-title>
        </v-list-item>
        <v-list-item link @click="setLocale('ja')">
          <v-list-item-title>
            <country-flag country="jp" size="small" />
          </v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
    <v-menu offset-y>
      <template v-slot:activator="{ on, attrs }">
        <v-icon
          v-bind="attrs"
          v-on="on"
        >
          mdi-menu
        </v-icon>
      </template>
      <v-list>
        <v-list-item link>
          <v-list-item-title>
            Settings
          </v-list-item-title>
        </v-list-item>
        <v-list-item link @click="logoutHandle">
          <v-list-item-title>
            Logout
          </v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
  </v-app-bar>
</template>

<script>
import CountryFlag from 'vue-country-flag';
import { mapState } from 'vuex';

export default {
  name: 'AppBar',
  components: { CountryFlag },
  data: () => ({
    mapCountry: {
      en: 'us',
      ja: 'jp',
    },
  }),
  computed: {
    ...mapState({
      locale: (rootState) => rootState.locale,
    }),
    clipped: {
      get() { return this.$store.state.client.layout.clipped; },
      set(value) { this.$store.commit('client/layout/setClipped', value); },
    },
    drawer: {
      get() { return this.$store.state.client.layout.drawer; },
      set(value) { this.$store.commit('client/layout/setDrawer', value); },
    },
    miniVariant: {
      get() { return this.$store.state.client.layout.miniVariant; },
      set(value) { this.$store.commit('client/layout/setMiniVariant', value); },
    },
  },
  methods: {
    setLocale(locale) {
      this.$store.dispatch('setLocale', locale);
    },
    async logoutHandle() {
      try {
        await this.$store.dispatch('client/auth/logoutHandle');
      } finally {
        this.$router.push('/login');
      }
    },
  },
};
</script>
