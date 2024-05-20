import React, { useContext } from 'react';
import { useNavigate } from 'react-router-dom';
import Loading from '../../components/Icons/Loading';
import ChangeTheme from '../../components/Buttons/ChangeTheme';
import InputField from '../../components/InputField';
import AuthContext from '../../contexts/AuthProvider';

export default function Login() {
  const { login, loading } = useContext(AuthContext);

  const Navegate = useNavigate();

  const [email, setEmail] = React.useState('');
  const [emailError, setEmailError] = React.useState(false);

  const [password, setPassword] = React.useState('');
  const [passwordError, setPasswordError] = React.useState(false);

  const [formError, setFormError] = React.useState(false);
  const [messageError, setMessageError] = React.useState('');

  const emailState = {
    text: email,
    setText: setEmail,
    error: emailError,
    setError: setEmailError,
  };

  const passwordState = {
    text: password,
    setText: setPassword,
    error: passwordError,
    setError: setPasswordError,
  };

  async function handleLoginSubmit(event) {
    localStorage.removeItem('user');
    event.preventDefault();
    console.log('Form acionado');

    if (emailError || passwordError) {
      console.log('Email and password errors');
      setFormError(true);
      setMessageError('Por favor, preencha os campos corretamente.');
      return;
    }

    const errorResponse = await login(email, password);

    console.log(errorResponse);

    if (errorResponse === false) {
      console.log('Login realizado com sucesso');
      Navegate('/dashboard');
    }

    setFormError(true);
    setMessageError(errorResponse);
  }

  return (
    <div className="flex items-center min-h-screen p-6 bg-gray-50 dark:bg-astro-900">
      <div className="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-astro-800">
        <div className="flex flex-col overflow-y-auto md:flex-row">
          <div className="h-32 md:h-auto md:w-1/2">
            <img
              aria-hidden="true"
              className="object-cover w-full h-full"
              src="https://homologa.nicollasdev.com/img/login-light.jpg"
              alt="Office"
            />
          </div>
          <div className="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
            <div className="w-full">
              <img
                src="https://homologa.nicollasdev.com/img/DataPragLogo.png"
                alt="Logo"
                className="w-3/4 mb-14"
              />

              <h1 className="mb-4 text-xl text-left font-semibold text-gray-600 dark:text-jett-400">
                Informe suas credenciais de acesso.
              </h1>

              <form onSubmit={(e) => handleLoginSubmit(e)}>
                <InputField
                  name="email"
                  label="E-mail"
                  type="email"
                  placeholder="Email"
                  required
                  state={emailState}
                  className="mb-4"
                />

                <InputField
                  name="password"
                  type="password"
                  label="Senha"
                  placeholder="Senha"
                  state={passwordState}
                  required
                />

                <button
                  className={`
                    block
                    w-full
                    px-4
                    py-2
                    mt-4
                    text-sm
                    font-medium
                    leading-5
                    text-center
                    text-white
                    transition-colors
                    duration-150
                    border
                    border-transparent 
                    rounded-lg
                    focus:outline-none ${
                      loading
                        ? 'bg-gray-600 opacity-50 cursor-not-allowed'
                        : 'bg-skye-600 active:bg-skye-600 hover:bg-skye-700'
                    }`}
                  type="submit"
                >
                  {loading && <Loading />}
                  <span>Entrar</span>
                </button>
                {formError && (
                  <span className="text-red-600 dark:text-red-400 text-sm mt-2">
                    {messageError}
                  </span>
                )}
              </form>

              <hr className="my-8" />

              <ChangeTheme />

              <p className="mt-4">
                <a
                  className="text-sm font-medium text-green-600 dark:text-green-400 hover:underline"
                  href="mailto:contato@nicollas.dev"
                >
                  Esqueceu sua senha?
                </a>
              </p>
              <p className="mt-1">
                <a
                  className="text-sm font-medium text-green-600 dark:text-green-400 hover:underline"
                  href="mailto:contato@nicollas.dev"
                >
                  Solicitar cadastro
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}
