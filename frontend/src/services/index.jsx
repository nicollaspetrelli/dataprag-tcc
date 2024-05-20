/* eslint-disable no-param-reassign */
import axios from 'axios';

const api = axios.create({
  baseURL: process.env.REACT_APP_API_URL,
});

function logout() {
  localStorage.removeItem('user');
  window.location.reload();
}

api.interceptors.request.use(
  (config) => {
    const user = JSON.parse(localStorage.getItem('user'));

    if (user?.token !== null || user?.token !== undefined) {
      config.headers.authorization = `Bearer ${user?.token}`;
    }

    config.headers.accept = 'application/json';

    return config;
  },
  (error) => Promise.reject(error)
);

api.interceptors.response.use(
  (response) => {
    if (response?.status === 401) {
      logout();
    }
    return response;
  },
  (error) => {
    if (error === undefined) {
      logout();
    }

    if (error.config.url.includes('login')) {
      return Promise.reject(error);
    }

    if (error.message === 'Network Error') {
      logout();
    }

    if (error?.response?.status === 401) {
      logout();
    }

    if (error.response && error.response.data) {
      return Promise.reject(error.response.data);
    }

    return Promise.reject(error.message);
  }
);

export default api;
