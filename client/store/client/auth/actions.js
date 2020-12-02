import { getUserInfo, login, logout } from '~/services/client/authService';
// import { axiosClient } from '~/plugins/axios';

export async function loginHandle({ dispatch }, credentials) {
  const data = await login(credentials);

  const token = data.access_token;
  this.$cookies.set('clientToken', token);
  await dispatch('getUser');
}

export async function logoutHandle({ commit }) {
  await logout();
  this.$cookies.remove('clientToken');
  commit('setUser', null);
}

export async function getUser({ commit }) {
  const user = await getUserInfo();

  commit('setUser', user);
}
