import React from 'react';
import * as HeroIcons from 'react-icons/hi';
import { useParams, useNavigate } from 'react-router-dom';
import { Skeleton } from 'primereact/skeleton';
import { useQuery } from 'react-query';
import { Button } from 'primereact/button';
import Layout from '../../../components/Layout';
import NotFound from '../../../components/NotFound';
import ServicesTable from './datatable';
import { fetchCustomer } from '../../../services/CustomerService';

export default function ShowCustomers() {
  const { customerId } = useParams();
  const navigate = useNavigate();
  const serachCustomer = () => fetchCustomer(customerId);

  const queryKey = `searchCustomer:${customerId}`;
  const { isLoading, isError, data } = useQuery(queryKey, serachCustomer);
  const customer = data?.data;

  if (isError) {
    return <NotFound />;
  }

  if (isLoading) {
    return (
      <Layout>
        <div>
          <h2 className="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <HeroIcons.HiFolderOpen className="inline mr-2" size="1.5em" />
            Pasta do Cliente
          </h2>
        </div>

        <div className="grid gap-6 mb-8 md:grid-cols-2">
          <div>
            <Skeleton width="100%" height="325px" />
          </div>
          <div>
            <Skeleton width="100%" height="325px" />
          </div>
        </div>

        <Skeleton width="100%" height="325px" />
      </Layout>
    );
  }

  return (
    customer !== null && (
      <Layout>
        <div>
          <h2 className="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <HeroIcons.HiFolderOpen className="inline mr-2" size="1.5em" />
            Pasta do Cliente
          </h2>
        </div>

        <div className="grid gap-6 mb-8 md:grid-cols-2">
          <div className="min-w-0 p-4 pt-2 bg-white rounded-lg shadow-xs dark:bg-astro-800">
            <div className="mb-3 flex items-center justify-between align-middle">
              <h4 className="font-semibold text-lg text-gray-600 dark:text-gray-200">
                Informações de Cadastro
              </h4>
              <Button
                className="p-button-sm p-button-secondary"
                label="Editar"
                icon="pi pi-user-edit"
                aria-label="Submit"
                onClick={() => navigate(`/customers/${customer.id}/edit`)}
              />
            </div>
            <div className="text-gray-600 dark:text-astro-100">
              <table className="table-fixed mb-4">
                <tbody>
                  <tr>
                    <td>CNPJ/CPF:</td>
                    <td>{customer.documentNumber}</td>
                  </tr>

                  <tr>
                    <td>Razão Social:</td>
                    <td>{customer.companyName}</td>
                  </tr>
                  <tr>
                    <td>Nome Fantasia:</td>
                    <td>{customer.fantasyName}</td>
                  </tr>
                  <tr>
                    <td>Nome de Identificação:</td>
                    <td>{customer.identificationName}</td>
                  </tr>
                  <tr>
                    <td className="pt-4">Endereço:</td>
                    <td className="pt-4">
                      {customer.street}, {customer.number}
                    </td>
                  </tr>
                  <tr>
                    <td>Bairro:</td>
                    <td>{customer.neighborhood}</td>
                  </tr>
                  <tr>
                    <td>CEP:</td>
                    <td>{customer.zipcode}</td>
                  </tr>
                  <tr>
                    <td>Municipio:</td>
                    <td>
                      {customer.city}, {customer.state}
                    </td>
                  </tr>
                  <p className="mt-4 mb-2">Responsável:</p>
                  <tr>
                    <td>Nome:</td>
                    <td>{customer.respName ?? 'N/C'}</td>
                  </tr>
                  <tr>
                    <td>Telefone/Celular:</td>
                    <td>{customer.respPhone ?? 'N/C'}</td>
                  </tr>
                  <tr>
                    <td>Email:</td>
                    <td>{customer.respEmail ?? 'N/C'}</td>
                  </tr>
                </tbody>
              </table>

              {customer?.notes !== '' && (
                <>
                  <p>Observações:</p>
                  <p>{customer.notes ?? 'Nenhuma observação cadastrada'}</p>
                </>
              )}
            </div>
          </div>
          <div className="min-w-0 p-4 text-white bg-skye-600 rounded-lg shadow-xs">
            <h4 className="mb-1 font-semibold">Localização</h4>

            <p className="mb-4">
              Endereço: {customer.street}, {customer.number} -
              {customer.neighborhood} - CEP: {customer.zipcode} - {customer.city}
              {customer.state}
            </p>

            {/* <div>
              {position[0] !== 0 && position[1] !== 0 && (
                <Map position={position} />
              )}
              {position[0] === 0 && position[1] === 0 && (
                <Skeleton width="100%" height="325px" />
              )}
            </div> */}

            <p className="mt-3">
              Complemento: {customer.complement ?? 'Nenhum cadastrado.'}
            </p>
            <p>
              Ponto de Referencia:
              {customer.referencePoint ?? 'Nenhum cadastrado.'}
            </p>
          </div>
        </div>

        <ServicesTable customerId={customer?.id} customer={customer} />
      </Layout>
    )
  );
}
