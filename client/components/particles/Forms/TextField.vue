<template>
  <validation-provider
    v-slot="{ errors, valid }"
    :vid="$attrs.label.toLowerCase()"
    :name="$attrs.label.toLowerCase()"
    :rules="rules"
  >
    <v-text-field
      v-model="innerValue"
      :error-messages="errors"
      :success="valid"
      :placeholder="$attrs.label"
      v-bind="$attrs"
      v-on="$listeners"
    />
  </validation-provider>
</template>

<script>

export default {
  name: 'TextField',
  props: {
    rules: {
      type: [Object, String],
      default: '',
    },
    // must be included in props
    // eslint-disable-next-line vue/require-default-prop
    value: {
      type: null,
    },
  },
  data: () => ({
    innerValue: '',
  }),
  watch: {
    // Handles internal model changes.
    innerValue(newVal) {
      this.$emit('input', newVal);
    },
    // Handles external model changes.
    value(newVal) {
      this.innerValue = newVal;
    },
  },
  created() {
    if (this.value) {
      this.innerValue = this.value;
    }
  },
};
</script>
