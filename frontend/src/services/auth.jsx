import api from '.';

function Login(email, password) {
  const payload = {
    email,
    password,
  };

  return api.post('/auth/login', payload, {
    headers: {
      'Content-Type': 'application/json',
    },
  });
}

function Logout() {
  return api.post('/auth/logout');
}

export { Login, Logout };
