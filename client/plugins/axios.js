// eslint-disable-next-line import/no-mutable-exports
let axiosClient = null;

export default function ({
  app, $axios, $cookies, redirect,
}) {
  axiosClient = $axios;
  app.$axiosClient = axiosClient;

  /** CONFIG for client */
  axiosClient.onResponse((response) => {
    console.log(response.data, '++++++++++');
    const { newToken = null } = response.data;
    if (newToken) {
      $cookies.set('clientToken', newToken);
    }
  });

  axiosClient.onRequest((config) => {
    const clientToken = app.$cookies.get('clientToken');
    if (clientToken) {
      config.headers.common.Authorization = `Bearer ${clientToken}`;
      config.headers.common.Locale = app.i18n.locale || 'en';
    }

    return config;
  });

  axiosClient.onResponseError((err) => {
    const errResponse = err.response;
    console.log(errResponse, '+++++++++++++++++=');

    const { data, status } = errResponse;

    switch (status) {
      // unauthenticated
      case 401:
        $cookies.remove('clientToken');
        redirect('/login');
        break;
      default:
        console.log(data, '+=++');
        break;
    }
  });
  /** END CONFIG for client */
}

export { axiosClient };
