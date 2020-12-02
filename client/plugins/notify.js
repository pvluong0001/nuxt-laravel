import Vue from 'vue';
import Swal from 'sweetalert2';

const notify = {
  success(title = null, configs = {}) {
    const defaultConfig = {
      title,
      icon: 'success',
      timer: 2000,
      showConfirmButton: false,
      allowOutsideClick: false,
    };

    configs = { ...defaultConfig, ...configs };

    return Swal.fire(configs);
  },
  error(title = null, configs = {}) {
    const defaultConfig = {
      title,
      icon: 'error',
      timer: 2000,
      showConfirmButton: false,
      allowOutsideClick: false,
    };

    configs = { ...defaultConfig, ...configs };

    return Swal.fire(configs);
  },
};

Vue.prototype.$notify = notify;

export { notify };
