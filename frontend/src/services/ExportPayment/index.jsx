import api from '..';

function exportPayment(paymentId) {
  return api.get('/payments/export', {
    params: {
      payments: paymentId,
      output: 'pdf',
    },
  });
}

export default exportPayment;
