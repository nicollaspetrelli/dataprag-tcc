import api from '..';

function generateHandout(handoutParams) {
  return api.get('/handout', {
    params: handoutParams,
    responseType: 'blob',
  });
}

export default generateHandout;
