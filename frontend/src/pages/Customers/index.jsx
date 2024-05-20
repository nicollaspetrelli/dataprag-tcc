import React from 'react';
import * as HeroIcons from 'react-icons/hi';
import Layout from '../../components/Layout';
import CustomersTable from './datatable';

export default function Clients() {
  return (
    <Layout>
      <div>
        <h2 className="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
          <HeroIcons.HiUsers className="inline mr-2" size="1.5em" />
          Clientes Cadastrados
        </h2>
      </div>

      <CustomersTable id="clientsDatatable" />
    </Layout>
  );
}
