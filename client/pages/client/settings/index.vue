<template>
  <card block-title="Settings">
    <v-tabs
      v-model="tab"
      center-active
      class="mb-5"
    >
      <v-tab href="#change-password">
        Change Password
      </v-tab>
      <v-tab href="#other">
        Other
      </v-tab>
    </v-tabs>

    <v-tabs-items v-model="tab">
      <v-tab-item value="change-password">
        <validation-observer ref="obs" v-slot="{ handleSubmit }">
          <v-form @submit.prevent="handleSubmit(submit)">
            <v-card-text>
              <text-field v-model="formData.oldPassword" rules="required" :label="$t('label.oldPassword')" outlined />
              <text-field v-model="formData.newPassword" rules="required" :label="$t('label.newPassword')" outlined />
            </v-card-text>
            <v-card-actions class="text-right">
              <v-btn color="success" type="submit" right absolute>
                Save
              </v-btn>
            </v-card-actions>
          </v-form>
        </validation-observer>
      </v-tab-item>
      <v-tab-item value="other">
        Other action
      </v-tab-item>
    </v-tabs-items>
  </card>
</template>

<script>
import Card from '~/components/particles/Elements/Card';
import TextField from '~/components/particles/Forms/TextField';

export default {
  name: 'IndexVue',
  layout: 'client',
  components: { TextField, Card },
  data: () => ({
    tab: null,
    formData: {
      oldPassword: '',
      newPassword: '',
    },
  }),
  methods: {
    submit() {
      console.log(this.formData, '+++++++');
    },
  },
};
</script>
