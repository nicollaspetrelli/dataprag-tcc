import api from '..';

function dashboardData() {
  return api.get('/dashboard');
}

export default dashboardData;
