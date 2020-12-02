import { localize } from 'vee-validate';

export const state = () => ({
  locale: 'en',
});

export const mutations = {
  // eslint-disable-next-line no-shadow
  setLocale(state, locale) {
    state.locale = locale;
  },
};

export const actions = {
  setLocale({ commit }, locale) {
    this.$i18n.locale = locale;
    localize(locale);

    commit('setLocale', locale);
  },
};
