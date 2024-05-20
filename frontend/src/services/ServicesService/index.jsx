import api from '..';

function allExpiredServices() {
  return api.get('/service/expired');
}

function getService(serviceId) {
  if (serviceId === undefined || serviceId === null) {
    return Promise.resolve([]);
  }

  return api.get(`/service/${serviceId}`);
}

function createService(serviceParams) {
  return api.post('/service', serviceParams);
}

function unpaidServices(customerId) {
  if (customerId === undefined || customerId === null) {
    return Promise.resolve([]);
  }

  return api.get(`/service/${customerId}/unpaid`);
}

function deleteService(serviceId) {
  return api.delete(`/service/${serviceId}`);
}

function updateService(serviceId, serviceParams) {
  return api.put(`/service/${serviceId}`, serviceParams);
}

export {
  allExpiredServices,
  createService,
  unpaidServices,
  getService,
  deleteService,
  updateService,
};
