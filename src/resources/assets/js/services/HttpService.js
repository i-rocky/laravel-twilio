import Axios from 'axios';
import ResponseMapperService from '../mappers/ResponseMapper';

Axios.defaults.baseURL = '/api/';

Axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');

Axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;

export default {
  get(route, params = {}, config = {}) {
    const promise = Axios.get(route, makeGetRequest(params, config));
    return withMappedPromise(promise);
  },
  post(route, data = {}) {
    const promise = Axios.post(route, makeFormRequest(data));
    return withMappedPromise(promise);
  },
  postJSON(route, data = {}) {
    const promise = Axios.post(route, data);
    return withMappedPromise(promise);
  },
  put(route, data = {}) {
    data['_method'] = 'PUT';
    const promise = Axios.post(route, makeFormRequest(data));
    return withMappedPromise(promise);
  },
  putJSON(route, data = {}) {
    const promise = Axios.put(route, data);
    return withMappedPromise(promise);
  },
  patch(route, data = {}) {
    const promise = Axios.patch(route, makeFormRequest(data));
    return withMappedPromise(promise);
  },
  delete(route, data = {}) {
    const promise = Axios.delete(route, {data});
    return withMappedPromise(promise);
  },
};

function withMappedPromise(promise) {
  return new Promise((resolve, reject) => {
    promise
        .then(response => resolve(ResponseMapperService.mapSuccessResponse(response)))
        .catch(error => reject(ResponseMapperService.mapErrorResponse(error)),
        );
  });
}

function makeFormRequest(data, form = null, parent = null) {
  if (!form) {
    form = new FormData();
  }
  Object.keys(data).forEach(key => {
    const value = data[key];
    if (value === undefined) {
      return;
    }
    if (typeof value === 'object' && value.constructor.name !== 'File') {
      form = makeFormRequest(value, form, key);
    }
    else {
      let _value = value;
      if (typeof value === 'boolean') {
        _value = value ? 1 : 0;
      }
      if (!parent) {
        form.append(key, _value);
      }
      else {
        form.append(`${parent}[${key}]`, _value);
      }
    }
  });
  return form;
}

function makeGetRequest(params = {}, config = {}) {
  return {
    params: {
      ...params,
    },
    ...config,
  };
}
