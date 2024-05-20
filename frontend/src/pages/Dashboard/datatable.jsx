import { ConfirmDialog } from 'primereact/confirmdialog';
import { Column } from 'primereact/column';
import { ContextMenu } from 'primereact/contextmenu';
import { DataTable } from 'primereact/datatable';
import { FilterMatchMode } from 'primereact/api';
import React from 'react';
import { Toast } from 'primereact/toast';
import { useQuery } from 'react-query';

import {
  companyNameTemplate,
  expiredDateTemplate,
  formatCurrency,
  formatDate,
  formatDateTime,
  paymentTemplate,
  serviceStatusTemplate,
  serviceTypeIdentifierLabel,
} from '../../utils/datatable/formats';
import defaultPaginationTemplate from '../../utils/datatable/defaults';
import { allExpiredServices } from '../../services/ServicesService';
import SearchInput from '../../components/Header/SearchInput';
import { notImplementedYet } from '../../utils/messages.tsx';

export default function ExpiredServicesTable(props) {
  const [selectedServices, setSelectedServices] = React.useState([]);
  const [globalFilterValue, setGlobalFilterValue] = React.useState('');
  const toast = React.useRef(null);
  const context = React.useRef(null);

  const { data: servicesQuery } = useQuery(
    'expiredServices',
    () => allExpiredServices()
  );

  const [filters, setFilters] = React.useState({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
  });

  const onGlobalFilterChange = (e) => {
    const { value } = e.target;
    const localFilters = { ...filters };
    localFilters.global.value = value;

    setFilters(localFilters);
    setGlobalFilterValue(value);
  };

  const menuModel = [
    {
      label: 'Ir para o cliente',
      icon: 'pi pi-fw pi-folder-open',
      command: () => notImplementedYet(toast),
    },
    {
      label: 'Notificar cliente',
      icon: 'pi pi-fw pi-bell',
      command: () => notImplementedYet(toast),
    },
  ];

  const renderHeader = () => (
    <div
      id="datatableHeader"
      className="bg-jett-300 dark:bg-astro-800 grid px-4 py-3 text-xs font-semibold tracking-wide rounded-t-lg text-gray-500 sm:grid-cols-9 dark:text-jett-200"
    >
      <div className="flex items-center justify-start col-span-3 text-lg font-semibold text-gray-600 dark:text-jett-200">
        {/* <p>Serviços Expirados</p> */}
      </div>
      <div className="flex items-center justify-center col-span-3">
        <SearchInput
          value={globalFilterValue}
          onChange={onGlobalFilterChange}
          placeholder="Pesquisar por todos os campos"
        />
      </div>
    </div>
  );

  const header = renderHeader();

  return (
    <div>
      <Toast ref={toast} />
      <ConfirmDialog />
      <ContextMenu model={menuModel} ref={context} />
      <DataTable
        contextMenuSelection={selectedServices}
        onContextMenuSelectionChange={(e) => {
          const allItems = [...selectedServices, e.value];

          const uniqueItems = allItems.filter(
            (item, index) => allItems.indexOf(item) === index
          );

          setSelectedServices(uniqueItems);
        }}
        onContextMenu={(e) => context.current.show(e.originalEvent)}
        resizableColumns
        columnResizeMode="fit"
        className="mb-6"
        header={header}
        value={servicesQuery?.data}
        filters={filters}
        globalFilterFields={['description', 'products']}
        rows={8}
        paginator
        rowHover
        paginatorTemplate={defaultPaginationTemplate}
        selection={selectedServices}
        onSelectionChange={(e) => setSelectedServices(e.value)}
        responsiveLayout="scroll"
        emptyMessage="Nenhum serviço expirado encontrado."
        currentPageReportTemplate={`Página {first} de {last} - Total de {totalRecords} registros${
          selectedServices.length > 0
            ? ` e ${selectedServices.length} selecionados`
            : ''
        }`}
        alwaysShowPaginator
        sortField="dateExecution"
        sortOrder={-1}
      >
        <Column
          field="id"
          selectionMode="multiple"
          headerStyle={{ width: '3em', textAling: 'center' }}
        />
        <Column
          field="clients"
          body={(rowData) =>
            companyNameTemplate(
              rowData?.clients?.companyName,
              rowData?.clients?.fantasyName,
              rowData?.clients?.identificationName
            )
          }
          header="Razão Social"
          sortable
        />
        <Column
          field="documents_id"
          body={(rowData) => serviceTypeIdentifierLabel(rowData.documents_id)}
          header="Tipo de Serviço"
          sortable
        />
        <Column
          field="dateExecution"
          body={(rowData) => formatDate(rowData.dateExecution)}
          style={{ whiteSpace: 'nowrap' }}
          header="Executado em"
          sortable
        />
        <Column
          field="dateValidity"
          body={(rowData) =>
            expiredDateTemplate(rowData.dateValidity, rowData.expired)
          }
          style={{ whiteSpace: 'nowrap' }}
          header="Expira em"
          sortable
        />
        <Column
          field="expired"
          body={(rowData) => serviceStatusTemplate(rowData.expired)}
          header="Status"
          sortable
        />
        <Column
          field="value"
          body={(rowData) => formatCurrency(rowData.value)}
          header="Valor"
          sortable
        />
        <Column
          field="payments_id"
          body={(rowData) => paymentTemplate(rowData.payments_id)}
          header="Pagamento"
          sortable
        />
        <Column
          field="updated_at"
          body={(rowData) => formatDateTime(rowData.updated_at)}
          style={{ whiteSpace: 'nowrap' }}
          dataType="date"
          header="Atualizado em"
          hidden
          sortable
        />
      </DataTable>
    </div>
  );
}
