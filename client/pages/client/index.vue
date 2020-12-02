<template>
  <div>
    <card title="Dashboard" />
  </div>
</template>

<script>
import Card from '~/components/particles/Elements/Card';

export default {
  name: 'Index',
  components: { Card },
  data: () => ({
    text: '',
  }),
  layout: 'client',
  middleware: ['client/auth'],
  methods: {},
};
</script>
