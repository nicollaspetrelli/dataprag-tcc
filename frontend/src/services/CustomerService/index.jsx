import api from '..';

function fetchCustomers() {
  return api.get('/customers');
}

function fetchCustomer(id) {
  return api.get(`/customer/${id}`);
}

function storeCustomer(customer) {
  return api.post('/customer', customer);
}

function deleteCustomer(id) {
  return api.delete(`/customer/${id}`);
}

function updateCustomer(id, customer) {
  return api.put(`/customer/${id}`, customer);
}

function fetchServices(customerId) {
  return api.get(`/customer/${customerId}/services`);
}

export {
  fetchCustomers,
  fetchCustomer,
  storeCustomer,
  deleteCustomer,
  updateCustomer,
  fetchServices,
};
