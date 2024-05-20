/* eslint-disable react/jsx-no-constructed-context-values */ // TODO: FIX THIS
import React, { createContext, useState } from 'react';
import { Login, Logout } from '../services/auth';

const AuthContext = createContext(null);

export function AuthProvider({ children }) {
  const [user, setUser] = useState(localStorage.getItem('user'));
  const [loading, setLoading] = useState(null);

  async function logout() {
    await Logout()
      .then((response) => {
        setUser(null);
        localStorage.removeItem('user');
      })
      .catch((error) => {
        console.error(error);
      });
  }

  async function login(email, password) {
    let error = false;
    setLoading(true);

    await Login(email, password)
      .then((response) => {
        const newUser = {
          email: response.data.data.user.email,
          name: response.data.data.user.name,
          avatar: response.data.data.user.picture,
          token: response.data.data.token,
        };

        setUser(newUser);
        localStorage.setItem('user', JSON.stringify(newUser));
      })
      .catch((response) => {
        console.error(response);
        error = 'Erro ao realizar login, verifique seus dados';

        if (response?.response?.status === 401) {
          error = 'Essas credenciais não correspondem aos nossos registros.';
        }
      });

    setLoading(false);
    return error;
  }
    
  return (
    <AuthContext.Provider value={{ login, user, loading, logout }}>
      {children}
    </AuthContext.Provider>
  );
}

export default AuthContext;
