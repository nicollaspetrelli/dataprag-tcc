import React from 'react';
import Layout from '../../components/Layout';
import Maintenance from '../../components/Maintenance';

export default function Services() {
  return (
    <Layout>
      <h2 className="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Serviços
      </h2>

      <Maintenance />
    </Layout>
  );
}
