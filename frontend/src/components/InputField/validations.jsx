function validateEmail(email) {
  let error = '';
  let message = '';

  if (email === '') {
    error = false;
    message = '';
    return {
      error,
      message,
    };
  }

  if (email.match(/^\S+@\S+\.\S+$/)) {
    error = false;
    message = '';
  }

  if (!email.match(/^\S+@\S+\.\S+$/)) {
    error = true;
    message = 'Por favor insira um e-mail válido.';
  }

  return {
    error,
    message,
  };
}

function validatePassword(password) {
  let error = '';
  let message = '';

  if (password === '') {
    error = false;
    message = '';
    return {
      error,
      message,
    };
  }

  if (password.length < 8) {
    error = true;
    message = 'Senhas precisam ter no minimo 8 caracteres.';
  }

  if (password.length >= 8) {
    error = false;
    message = '';
  }

  return {
    error,
    message,
  };
}

function handleValidate(name, value) {
  const map = {
    email: validateEmail(value),
    password: validatePassword(value),
  };

  return map[name];
}

export default handleValidate;
