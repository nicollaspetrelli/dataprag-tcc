import api from '..';

function allProducts() {
  return api.get('/products');
}

export default allProducts;
