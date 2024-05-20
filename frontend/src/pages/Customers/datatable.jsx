import React from 'react';
import { DataTable } from 'primereact/datatable';
import { Column } from 'primereact/column';
import { FilterMatchMode } from 'primereact/api';
import { Button } from 'primereact/button';
import { ConfirmDialog, confirmDialog } from 'primereact/confirmdialog';
import { Toast } from 'primereact/toast';
import { SplitButton } from 'primereact/splitbutton';
import { useNavigate } from 'react-router-dom';
import { ContextMenu } from 'primereact/contextmenu';
import SearchInput from '../../components/Header/SearchInput';
import { fetchCustomers, deleteCustomer } from '../../services/CustomerService';
import defaultPaginationTemplate from '../../utils/datatable/defaults';
import {
  addressTemplate,
  cityAndStateTemplate,
  companyNameTemplate,
  customerTypeTemplate,
  formatDateTime,
} from '../../utils/datatable/formats';

export default function CustomersTable() {
  const navigate = useNavigate();
  const [selectedCustomers, setSelectedCustomers] = React.useState([]);
  const [globalFilterValue, setGlobalFilterValue] = React.useState('');
  const [datatableLoading, setDatatableLoading] = React.useState(true);
  const toast = React.useRef(null);

  const [customers, setCustomers] = React.useState([]);
  React.useEffect(() => {
    fetchCustomers()
      .then((response) => {
        setCustomers(response.data);
      })
      .catch((error) => {
        console.error(error);
        toast.current.show({
          severity: 'error',
          summary: 'Error',
          detail: 'Error fetching customers',
        });
      })
      .finally(() => {
        setDatatableLoading(false);
      });
  }, []);

  const validateAction = (action) => {
    if (selectedCustomers.length <= 0) {
      toast.current.show({
        severity: 'warn',
        summary: 'Aviso',
        detail: 'Nenhum cliente selecionado',
      });
      return;
    }

    if (selectedCustomers.length > 1) {
      toast.current.show({
        severity: 'warn',
        summary: 'Aviso',
        detail: 'Selecione apenas um cliente',
      });
      return;
    }

    if (selectedCustomers.length === 1) {
      action();
    }
  };

  const acceptDelete = () => {
    deleteCustomer(selectedCustomers[0].id)
      .then((response) => {
        toast.current.show({
          severity: 'success',
          summary: 'Sucesso',
          detail: 'Cliente excluído com sucesso',
        });
        console.log(response);
        setSelectedCustomers([]);
        setCustomers(
          customers.filter(
            (customer) => customer.id !== selectedCustomers[0].id
          )
        );
      })
      .catch((error) => {
        console.log(error);
        toast.current.show({
          severity: 'error',
          summary: 'Erro ao tentar deletar o cliente',
          detail: 'Error deleting customer',
        });
      });
  };

  const rejectDelete = () => {
    toast.current.show({
      severity: 'info',
      summary: 'Cancelado',
      detail: 'A ação foi cancelada',
    });
  };

  const confirmDeletion = () => {
    confirmDialog({
      draggable: false,
      header: 'Você tem certeza?',
      message: `Você realmente deseja excluir esse cliente? ${selectedCustomers[0].companyName}`,
      icon: 'pi pi-info-circle',
      acceptLabel: 'Sim',
      acceptIcon: 'pi pi-check',
      rejectLabel: 'Não',
      rejectIcon: 'pi pi-times',
      accept: acceptDelete,
      reject: rejectDelete,
    });
  };

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

  const items = [
    {
      label: 'Editar',
      icon: 'pi pi-pencil',
      command: () => {
        validateAction(() => {
          navigate(`/customers/${selectedCustomers[0].id}/edit`);
        });
      },
    },
    {
      label: 'Deletar',
      icon: 'pi pi-times',
      command: () => {
        validateAction(confirmDeletion);
      },
    },
    {
      label: 'Atualizar',
      icon: 'pi pi-refresh',
      // command: () => {},
    },
    {
      label: 'Definições',
      icon: 'pi pi-cog',
      // command: () => {},
    },
  ];

  const showCustomer = () => {
    validateAction(() => {
      navigate(`/customers/${selectedCustomers[0].id}`, {
        state: { customer: selectedCustomers[0] },
      });
    });
  };

  const renderHeader = () => (
    <div className="bg-jett-300 dark:bg-astro-800 grid px-4 py-3 text-xs font-semibold tracking-wide rounded-t-lg text-gray-500 sm:grid-cols-9 dark:text-jett-200">
      <div className="flex items-center justify-start col-span-3 text-lg font-semibold text-gray-600 dark:text-jett-200">
        <p className="uppercase">Clientes</p>
      </div>
      <div className="flex items-center justify-center col-span-3">
        <SearchInput
          value={globalFilterValue}
          onChange={onGlobalFilterChange}
          placeholder="Pesquisar por todos os campos"
        />
      </div>
      <div className="flex col-span-3 mt-2 sm:mt-auto sm:justify-end">
        <div className="mr-4">
          <Button
            className="p-button-sm"
            label="Novo"
            icon="pi pi-plus"
            onClick={() => {
              navigate('/customers/create');
            }}
          />
        </div>

        <SplitButton
          appendTo="self"
          label="Visualizar"
          icon="pi pi-eye"
          model={items}
          onClick={showCustomer}
          className="p-button-sm"
        />
      </div>
    </div>
  );

  const header = renderHeader();

  const context = React.useRef(null);

  const menuModel = [
    {
      label: 'Visualizar',
      icon: 'pi pi-fw pi-search',
      command: () => {
        validateAction(() => {
          navigate(`/customers/${selectedCustomers[0].id}`, {
            state: { customer: selectedCustomers[0] },
          });
        });
      },
    },
    {
      label: 'Editar',
      icon: 'pi pi-fw pi-pencil',
      command: () => {
        validateAction(() => {
          navigate(`/customers/${selectedCustomers[0].id}/edit`);
        });
      },
    },
    {
      label: 'Deletar',
      icon: 'pi pi-fw pi-times',
      command: () => {
        validateAction(confirmDeletion);
      },
    },
  ];

  return (
    <div>
      <Toast ref={toast} />
      <ConfirmDialog />
      <ContextMenu
        model={menuModel}
        ref={context}
        onHide={() => setSelectedCustomers([])}
      />
      <DataTable
        contextMenuSelection={selectedCustomers}
        onContextMenuSelectionChange={(e) => setSelectedCustomers([e.value])}
        onContextMenu={(e) => context.current.show(e.originalEvent)}
        loading={datatableLoading}
        className="mb-6"
        header={header}
        value={customers}
        filters={filters}
        globalFilterFields={[
          'companyName',
          'fantasyName',
          'identificationName',
          'documentNumber',
          'street',
          'number',
          'neighborhood',
          'city',
          'state',
          'zipcode',
        ]}
        rows={8}
        paginator
        rowHover
        paginatorTemplate={defaultPaginationTemplate}
        selection={selectedCustomers}
        onSelectionChange={(e) => setSelectedCustomers(e.value)}
        responsiveLayout="scroll"
        emptyMessage="Nenhum cliente encontrado."
        currentPageReportTemplate={`Página {first} de {last} - Total de {totalRecords} registros${
          selectedCustomers.length > 0
            ? ` e ${selectedCustomers.length} selecionados`
            : ''
        }`}
        alwaysShowPaginator
        sortField="created_at"
        sortOrder={-1}
      >
        <Column
          field="id"
          selectionMode="multiple"
          headerStyle={{ width: '3em', textAling: 'center' }}
        />
        <Column
          field="companyName"
          body={(rowData) =>
            companyNameTemplate(
              rowData.companyName,
              rowData.fantasyName,
              rowData.identificationName
            )
          }
          header="Razão Social"
          sortable
        />
        <Column
          field="street"
          style={{ whiteSpace: 'nowrap' }}
          body={(rowData) =>
            addressTemplate(
              rowData.street,
              rowData.number,
              rowData.neighborhood
            )
          }
          header="Endereço"
          sortable
        />
        <Column
          field="city"
          body={(rowData) => cityAndStateTemplate(rowData.city, rowData.state)}
          header="Municipio"
          sortable
        />
        <Column field="zipcode" style={{ whiteSpace: 'nowrap' }} header="CEP" />
        <Column
          field="documentNumber"
          style={{ whiteSpace: 'nowrap' }}
          header="CNPJ/CPF"
        />
        <Column
          field="type"
          body={(rowData) => customerTypeTemplate(rowData.type)}
          header="Tipo"
          sortable
        />
        <Column
          field="created_at"
          body={(rowData) => formatDateTime(rowData.updated_at)}
          style={{ whiteSpace: 'nowrap' }}
          dataType="date"
          header="Ultima atualização em"
          sortable
        />
      </DataTable>
    </div>
  );
}
