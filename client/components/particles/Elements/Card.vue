<template>
  <v-card :class="{hasBlockTitle: !!blockTitle}">
    <v-card-title>
      <div v-if="blockTitle" class="blockTitle green lighten-1 white--text">
        {{ blockTitle }}
      </div>
      <div v-else>
        {{ title }}
      </div>
    </v-card-title>
    <v-card-text>
      <slot />
    </v-card-text>
  </v-card>
</template>

<script>
export default {
  name: 'Card',
  props: {
    title: {
      type: String,
      default: '',
    },
    blockTitle: {
      type: String,
      default: '',
    },
  },
};
</script>

<style scoped lang="scss">
.hasBlockTitle {
  position: relative;
  margin-top: 50px;
  padding-bottom: 30px;
  .blockTitle {
    position: absolute;
    top: -30px;
    padding: 7px 25px;
    border: 1px solid #c1c1c1;
    border-radius: 5px;
    box-shadow: 0 7px 14px rgba(0,0,0,0.12), 0 5px 5px rgba(0,0,0,0.12);
  }
}
</style>
