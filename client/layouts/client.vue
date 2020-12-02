<template>
  <v-app dark>
    <navigation-drawer :key="$i18n.locale" />

    <app-bar />

    <v-main>
      <v-container fluid>
        <nuxt />
      </v-container>
    </v-main>

    <app-footer />
  </v-app>
</template>

<script>
import NavigationDrawer from '~/components/layouts/client/NavigationDrawer';
import AppBar from '~/components/layouts/client/AppBar';
import AppFooter from '~/components/layouts/client/AppFooter';

export default {
  name: 'LayoutClient',
  components: { AppFooter, AppBar, NavigationDrawer },
};
</script>
