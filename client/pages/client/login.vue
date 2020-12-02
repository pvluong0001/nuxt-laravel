<template>
  <div id="app">
    <v-app id="inspire">
      <v-container class="grey lighten-3" fluid fill-height>
        <v-card class="mt-4 mx-auto text-center hidden-sm-only" min-width="320">
          <v-card-text>
            <v-card class="v-card--offset mx-auto" color="primary" elevation="4" dark>
              <v-card-text class="headline white--text">
                Company Co
              </v-card-text>
              <v-card-text>
                <v-icon size="96">
                  mdi-language-html5
                </v-icon>
              </v-card-text>
            </v-card>
          </v-card-text>
          <validation-observer ref="obs" v-slot="{handleSubmit, invalid, validated}" tag="div">
            <v-form @submit.prevent="handleSubmit(login)">
              <v-card-text>
                <text-field
                  v-model="formData.email"
                  :label="$t('label.email')"
                  rules="required"
                  type="email"
                />
                <text-field
                  v-model="formData.password"
                  :label="$t('label.password')"
                  rules="required"
                  :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                  :type="showPassword ? 'text' : 'password'"
                  @click:append="showPassword = !showPassword"
                />
              </v-card-text>
              <v-card-actions>
                <v-row align="center" no-gutters>
                  <v-col class="text-center">
                    <div class="my-2">
                      <v-btn color="primary" type="submit" block :disabled="invalid || !validated">
                        Login
                      </v-btn>
                    </div>
                    <div>
                      <v-btn color="primary" x-small text>
                        ¿Forgot password?
                      </v-btn>
                    </div>
                    <div>
                      <v-btn color="primary" x-small text>
                        Register
                      </v-btn>
                    </div>
                  </v-col>
                </v-row>
              </v-card-actions>
            </v-form>
          </validation-observer>
        </v-card>
      </v-container>
    </v-app>
  </div>
</template>

<script>

import { handleAxiosException } from '~/helpers/validation';
import TextField from '~/components/particles/Forms/TextField';

export default {
  name: 'Login',
  components: { TextField },
  layout: 'empty',
  middleware({ $cookies, redirect }) {
    if ($cookies.get('clientToken')) {
      redirect('/');
    }
  },
  data: () => ({
    showPassword: false,
    formData: {
      email: '',
      password: '',
    },
  }),
  methods: {
    login() {
      this.$store.dispatch('client/auth/loginHandle', this.formData)
        .then(() => this.$router.replace('/'))
        .catch((e) => {
          handleAxiosException(e, { ref: this.$refs.obs });
        });
    },
  },
};
</script>

<style scoped>
.v-card--offset {
  top: -32px;
  position: relative;
}
</style>
