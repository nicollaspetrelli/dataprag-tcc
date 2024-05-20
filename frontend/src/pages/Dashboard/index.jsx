import React from 'react';
import { Skeleton } from 'primereact/skeleton';
import * as HeroIcons from 'react-icons/hi';
import { useQuery } from 'react-query';
import Layout from '../../components/Layout';
import Cards from '../../components/Dashboard/Cards';
import dashboardData from '../../services/DashboardService';
import ExpiredServicesTable from './datatable';

export default function Dashboard() {
  const { data, isLoading } = useQuery('dashboardData', dashboardData);

  const dashboard = data?.data;

  return (
    <Layout>
      <div>
        <h2 className="my-6 text-2xl font-semibold text-gray-700 dark:text-jett-200">
          Painel de Controle
        </h2>

        <span className="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-green-100 bg-skye-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-green">
          <div className="flex items-center">
            <HeroIcons.HiStar size="1.2em" />
            <span>Essa é uma versão em Desenvolvimento! v2.0.0</span>
          </div>
          <span>Deixe seu feedback →</span>
        </span>

        <div className="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">
          <Cards
            icon={<HeroIcons.HiUserGroup size="1.5em" />}
            title="Total de Clientes"
            count={dashboard?.totalCustomers}
            color="orange"
            loading={isLoading}
          />

          <Cards
            icon={<HeroIcons.HiCreditCard size="1.5em" />}
            title="Total de Ganhos"
            subtitle="Ultimos 30 dias"
            count={dashboard?.totalEarnings}
            currency
            color="green"
            loading={isLoading}
          />

          <Cards
            icon={<HeroIcons.HiDocumentAdd size="1.5em" />}
            title="Novos Serviços"
            subtitle="Ultimos 30 dias"
            count={dashboard?.newServices}
            color="blue"
            loading={isLoading}
          />

          <Cards
            icon={<HeroIcons.HiExclamation size="1.5em" />}
            title="Serviços Expirados"
            count={dashboard?.expiredServices}
            color="red"
            loading={isLoading}
          />
        </div>

        <h2 className="my-6 text-2xl font-semibold text-gray-700 dark:text-jett-200">
          <span>Serviços Pendentes</span>
        </h2>

        {/* <Skeleton className="w-full block mt-2" height="20em" /> */}

        <ExpiredServicesTable />

        <h2 className="my-6 text-2xl font-semibold text-gray-700 dark:text-jett-200">
          Gráficos e Estatisticas
        </h2>

        <div className="grid gap-6 mb-8 md:grid-cols-2">
          <div>
            <Skeleton className="w-full block mt-2" height="20em" />
          </div>
          <div>
            <Skeleton className="w-full block mt-2" height="20em" />
          </div>
        </div>
      </div>
    </Layout>
  );
}
