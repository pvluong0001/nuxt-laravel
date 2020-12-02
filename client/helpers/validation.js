import { notify } from '~/plugins/notify';

export function handleAxiosException(exception, options = {}) {
  // eslint-disable-next-line no-prototype-builtins
  if (exception.hasOwnProperty('response')) {
    const { status = null, data } = exception.response;
    const { ref = null } = options;
    switch (status) {
      case 422:
        ref.setErrors(data.errors);
        break;
      default:
        notify.error(data.message || 'Error!');
        break;
    }
  }
}
