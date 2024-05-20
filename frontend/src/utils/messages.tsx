import { MutableRefObject } from 'react';

function notImplementedYet(toast: MutableRefObject<any>) {
  toast.current.show({
    severity: 'warn',
    summary: 'Aviso',
    detail: 'Funcionalidade ainda não implementada',
  });
}

function cantOpenPaymentDialog(toast: MutableRefObject<any>) {
  toast.current.show({
    severity: 'warn',
    summary: 'Aviso',
    detail:
      'Um ou mais serviços selecionados não estão mais pendentes de pagamento.',
  });
}

function hasNoServiceSelected(toast: MutableRefObject<any>) {
  toast.current.show({
    severity: 'warn',
    summary: 'Aviso',
    detail: 'Nenhum serviço selecionado.',
  });
}

export { notImplementedYet, cantOpenPaymentDialog, hasNoServiceSelected };
