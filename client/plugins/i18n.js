export default ({ app, store }) => {
  app.i18n.setLocale(store.state.locale);
};
