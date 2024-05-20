import { ProgressBar } from 'primereact/progressbar';
import React from 'react';
import exportServices from '../../services/ExportService';

const printServices = async (toast, servicesIds, isToPrintPayment) => {
  console.log('printServices in ', servicesIds);

  toast.current.show({
    severity: 'warn',
    summary: 'Aguarde',
    sticky: true,
    content: (
      <div className="flex w-full">
        <div className="text-left pr-5">
          <i
            className="pi pi-exclamation-triangle"
            style={{ fontSize: '3rem' }}
          />
        </div>
        <div className="w-full">
          <h4 className="pb-1">Gerando documentos...</h4>
          <ProgressBar mode="indeterminate" />
        </div>
      </div>
    ),
  });

  await exportServices(servicesIds, isToPrintPayment)
    .then((response) => {
      console.debug('[DEBUG] Export Services API returned');

      window.open(response.data.link, '_blank');

      toast.current.replace({
        severity: 'success',
        summary: 'Sucesso',
        detail: response.data.message,
        life: 10000,
      });
    })
    .catch((error) => {
      console.error(error);

      toast.current.replace({
        severity: 'error',
        summary: 'Error',
        detail: 'Error exporting services',
      });
    });
};

export default printServices;
