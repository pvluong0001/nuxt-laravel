import { axiosClient } from '~/plugins/axios';

export async function login(credentials) {
  const { data: response } = await axiosClient.post('v1/auth/login',
    credentials);

  return response.data;
}

export async function logout() {
  const { data: response } = await axiosClient.post('v1/auth/logout');

  return response.data;
}

export async function getUserInfo() {
  try {
    const { data: response } = await axiosClient.post('v1/auth/me');

    return response.data;
  } catch (e) {
    console.log(e, '~~~~~~~~~~');
    return null;
  }
}
