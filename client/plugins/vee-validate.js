import Vue from 'vue';
import {
  ValidationObserver, ValidationProvider, extend, localize, configure,
} from 'vee-validate';
import en from 'vee-validate/dist/locale/en.json';
import ja from 'vee-validate/dist/locale/ja.json';
import * as rules from 'vee-validate/dist/rules';

Object.keys(rules).forEach((rule) => {
  extend(rule, rules[rule]);
});

localize({
  en, ja,
});

export default function ({ store }) {
  localize(store.state.locale);
}

configure({
  classes: {
    valid: 'is-valid', // model is valid
    invalid: 'is-invalid', // model is invalid
  },
});

Vue.component('validation-observer', ValidationObserver);
Vue.component('validation-provider', ValidationProvider);
