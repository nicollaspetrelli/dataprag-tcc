import api from '..';

function exportServices(services, isToPrintPayment) {
  let payments = 0;

  if (isToPrintPayment) {
    payments = 1;
  }

    return api.get('/service/export', {
      params: {
        services,
        payments,
        output: 'pdf',
      },
    });
}

export default exportServices;
