import React, { useContext } from 'react';
import { Navigate } from 'react-router-dom';
import AuthContext from '../../contexts/AuthProvider';

function ProtectedRoute({ children }) {
  const { user } = useContext(AuthContext);

  return user !== null && user !== undefined && user !== '' && user !== '{}' ? (
    children
  ) : (
    <Navigate to="/login" />
  );
}

export default ProtectedRoute;
