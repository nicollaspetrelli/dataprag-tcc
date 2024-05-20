import React from 'react';
import { Avatar } from 'primereact/avatar';
import { confirmDialog } from 'primereact/confirmdialog';
import AuthContext from '../../contexts/AuthProvider';

export default function Profile() {
  const { logout } = React.useContext(AuthContext);
  const { avatar } = JSON.parse(localStorage.getItem('user'));

  const confirmLogout = () => {
    confirmDialog({
      message: 'Deseja realmente sair completamente do sistema?',
      header: 'Confirmação',
      icon: 'pi pi-exclamation-triangle',
      accept: () => {
        logout();
      },
      reject: () => {
        // Handle reject if needed
      },
      draggable: false,
      acceptLabel: 'Sim, Desconectar!',
      rejectLabel: 'Não',
    });
  };

  return (
    <Avatar
      image={avatar}
      shape="circle"
      size="medium"
      className="p-clickable"
      onClick={confirmLogout}
    />
  );
}
