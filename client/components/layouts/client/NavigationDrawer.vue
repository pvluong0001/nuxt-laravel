<template>
  <v-navigation-drawer
    v-model="drawer"
    :mini-variant="miniVariant"
    :clipped="clipped"
    fixed
    app
  >
    <v-list>
      <v-list-item
        v-for="(item, i) in items"
        :key="i"
        :to="item.to"
        router
        exact
      >
        <v-list-item-action>
          <v-icon>{{ item.icon }}</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title v-text="item.title" />
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
import { mapState } from 'vuex';

export default {
  name: 'NavigationDrawer',
  data() {
    return {
      items: [
        {
          icon: 'mdi-apps',
          title: this.$t('menu.dashboard'),
          to: '/',
        },
        {
          icon: 'mdi-chart-bubble',
          title: this.$t('menu.setting'),
          to: '/settings',
        },
      ],
    };
  },
  computed: {
    ...mapState({
      clipped: (state) => state.client.layout.clipped,
      miniVariant: (state) => state.client.layout.miniVariant,
    }),
    drawer: {
      get() { return this.$store.state.client.layout.drawer; },
      set(value) { this.$store.commit('client/layout/setDrawer', value); },
    },
  },
};
</script>

<style scoped>

</style>
