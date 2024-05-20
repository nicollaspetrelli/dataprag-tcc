import api from '..';

function createPayment(paymentParams) {
  return api.post('/payments', paymentParams);
}

// eslint-disable-next-line import/prefer-default-export
export { createPayment };
