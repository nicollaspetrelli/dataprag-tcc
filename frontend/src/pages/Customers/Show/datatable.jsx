import { ConfirmDialog, confirmDialog } from 'primereact/confirmdialog';

import { Column } from 'primereact/column';
import { ContextMenu } from 'primereact/contextmenu';
import { DataTable } from 'primereact/datatable';
import { FilterMatchMode } from 'primereact/api';

import React from 'react';
import { SplitButton } from 'primereact/splitbutton';
import { Toast } from 'primereact/toast';
import { useNavigate } from 'react-router-dom';
import { useQuery } from 'react-query';
import { useHookstate } from '@hookstate/core';
import SearchInput from '../../../components/Header/SearchInput';

import { fetchServices } from '../../../services/CustomerService';
import {
  descriptionTemplate,
  expiredDateTemplate,
  formatCurrency,
  formatDate,
  formatDateTime,
  paymentTemplate,
  productsTemplate,
  serviceStatusTemplate,
  serviceTypeIdentifierLabel,
} from '../../../utils/datatable/formats';
import defaultPaginationTemplate from '../../../utils/datatable/defaults';
import printServices from '../../../common/PrintService';
import PrintPayment from '../../../common/PrintPayment';
import PaymentsDialog from '../../../dialogs/Payments';
import { unpaidServices } from '../../../services/ServicesService';
import { useDeleteService } from '../../../services/ServicesService/hooks';
import {
  notImplementedYet,
  cantOpenPaymentDialog,
  hasNoServiceSelected,
} from '../../../utils/messages.tsx';
import globalState from '../../../store';
import EditServiceDialog from '../../../dialogs/Services';

export default function ServicesTable(props) {
  const navigate = useNavigate();
  const [IsPaymentDialogOpen, setIsPaymentDialogOpen] = React.useState(false);
  const [IsServiceDialogOpen, setIsServiceDialogOpen] = React.useState(false);
  const [selectedServices, setSelectedServices] = React.useState([]);
  const [globalFilterValue, setGlobalFilterValue] = React.useState('');
  const toast = React.useRef(null);
  const context = React.useRef(null);
  const [IsEditMode, setIsEditMode] = React.useState(null);

  const { customerId, customer } = props;
  const [seeAllRow, setSeeAllRow] = React.useState(false);

  const deleteServiceMutation = useDeleteService();

  const printService = () => {
    const servicesIds = selectedServices.map((service) => service.id);
    printServices(toast, servicesIds);
  };

  const printPaymentFunction = () => {
    const paymentsId = selectedServices[0].payments_id || null;

    if (paymentsId === null) {
      toast.current.show({
        severity: 'warn',
        summary: 'Aviso',
        detail: 'Esse serviço não possui pagamento',
      });
      return;
    }

    PrintPayment(toast, paymentsId);
  };

  const { data: servicesQuery, refetch: refetchServices } = useQuery(
    ['customerServices', customerId],
    () => fetchServices(customerId)
  );

  const state = useHookstate(globalState);
  const isToPrint = state.get()?.isToPrintPayment;

  const actionPaymentSuccess = (response) => {
    setIsPaymentDialogOpen(false);
    setSelectedServices([]);
    refetchServices();

    if (isToPrint) {
      const paymentsId = response.data.payment.id;
      PrintPayment(toast, paymentsId);
    }
  };

  const { data: unpaidServicesQuery, refetch: refetchUnpaidServices } =
    useQuery(['unpaidServices', customerId], () => unpaidServices(customerId), {
      enabled: false,
    });

  const performPayment = () => {
    if (selectedServices.length <= 0) {
      hasNoServiceSelected(toast);

      return;
    }

    const hasPaidService = selectedServices.some(
      (service) => service.payments_id
    );

    if (hasPaidService) {
      cantOpenPaymentDialog(toast);
      return;
    }

    setIsPaymentDialogOpen(true);
    refetchUnpaidServices();
  };

  const validateAction = (action) => {
    if (selectedServices.length <= 0) {
      toast.current.show({
        severity: 'warn',
        summary: 'Aviso',
        detail: 'Nenhum serviço selecionado',
      });
      return;
    }

    if (selectedServices.length > 1) {
      toast.current.show({
        severity: 'warn',
        summary: 'Aviso',
        detail: 'Selecione apenas um serviço',
      });
      return;
    }

    if (selectedServices.length === 1) {
      action();
    }
  };

  const validateMultipleAction = (action) => {
    if (selectedServices.length <= 0) {
      toast.current.show({
        severity: 'warn',
        summary: 'Aviso',
        detail: 'Nenhum serviço selecionado',
      });
      return;
    }

    action();
  };

  const accept = () => {
    const serviceId = selectedServices[0].id;

    deleteServiceMutation.mutate(serviceId, {
      onSuccess: () => {
        toast.current.show({
          severity: 'success',
          summary: 'Sucesso',
          detail: 'Serviço removido com sucesso!',
          life: 3000,
        });
      },
      onError: () => {
        toast.current.show({
          severity: 'error',
          summary: 'Erro',
          detail: 'Erro ao remover serviço',
          life: 3000,
        });
      },
    });

    setSelectedServices([]);
    refetchServices();
    refetchUnpaidServices();
  };

  const reject = () => {
    toast.current.show({
      severity: 'info',
      summary: 'Cancelado',
      detail: 'A ação foi cancelada',
      life: 3000,
    });
  };

  const confirmDeletion = () => {
    confirmDialog({
      draggable: false,
      header: 'Confirmar deleção!',
      message: `Você tem certeza que deseja excluir esse serviço?`,
      icon: 'pi pi-info-circle',
      acceptLabel: 'Sim',
      acceptIcon: 'pi pi-check',
      rejectLabel: 'Não',
      rejectIcon: 'pi pi-times',
      accept,
      reject,
    });
    refetchServices();
    refetchUnpaidServices();
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

  const newSplitButtonItems = [
    {
      label: 'Pagamento',
      icon: 'pi pi-credit-card',
      command: () => {
        validateMultipleAction(performPayment);
      },
    },
    {
      label: 'Orçamento',
      icon: 'pi pi-book',
      command: () => {
        notImplementedYet(toast);
      },
    },
  ];

  const editServiceAction = (editMode) => {
    if (selectedServices.length <= 0) {
      toast.current.show({
        severity: 'warn',
        summary: 'Aviso',
        detail: 'Nenhum serviço selecionado',
      });

      return;
    }

    if (selectedServices.length > 1) {
      toast.current.show({
        severity: 'warn',
        summary: 'Aviso',
        detail: 'Selecione apenas um serviço',
      });

      return;
    }

    if (selectedServices.length === 1) {
      setIsEditMode(editMode);
      setIsServiceDialogOpen(true);
    }
  };

  const menuModel = [
    {
      label: 'Detalhes',
      icon: 'pi pi-fw pi-search',
      command: () => editServiceAction(false),
    },
    {
      label: 'Editar',
      icon: 'pi pi-fw pi-pencil',
      command: () => editServiceAction(true),
    },
    {
      label: 'Imprimir',
      icon: 'pi pi-fw pi-print',
      command: () => printService(),
    },
    {
      label: 'Pagamento',
      icon: 'pi pi-fw pi-credit-card',
      items: [
        {
          label: 'Adicionar',
          icon: 'pi pi-fw pi-plus',
          command: () => validateMultipleAction(performPayment),
        },
        {
          label: 'Remover',
          icon: 'pi pi-fw pi-trash',
          command: () => notImplementedYet(toast),
        },
        {
          label: 'Imprimir',
          icon: 'pi pi-fw pi-print',
          command: () => validateAction(printPaymentFunction),
        },
        {
          label: 'Visualizar',
          icon: 'pi pi-fw pi-eye',
          command: () => notImplementedYet(toast),
        },
      ],
    },
    {
      label: 'Deletar',
      icon: 'pi pi-fw pi-trash',
      command: () => validateAction(confirmDeletion),
    },
  ];

  const printSplitButtonItems = [
    {
      label: 'Editar',
      icon: 'pi pi-pencil',
      command: () => editServiceAction(),
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
      command: () => notImplementedYet(toast),
    },
    {
      label: 'Definições',
      icon: 'pi pi-cog',
      command: () => notImplementedYet(toast),
    },
  ];

  const newService = () => {
    navigate(`/services/create/${customerId}`);
  };

  const renderHeader = () => (
    <div
      id="datatableHeader"
      className="bg-jett-300 dark:bg-astro-800 grid px-4 py-3 text-xs font-semibold tracking-wide rounded-t-lg text-gray-500 sm:grid-cols-9 dark:text-jett-200"
    >
      <div className="flex items-center justify-start col-span-3 text-lg font-semibold text-gray-600 dark:text-jett-200">
        <p>Serviços</p>
      </div>
      <div className="flex items-center justify-center col-span-3">
        <SearchInput
          value={globalFilterValue}
          onChange={onGlobalFilterChange}
          placeholder="Pesquisar por descrição ou produtos"
        />
      </div>
      <div className="flex col-span-3 mt-2 sm:mt-auto sm:justify-end">
        <div className="mr-4">
          <SplitButton
            appendTo="self"
            label="Novo Serviço"
            icon="pi pi-plus"
            model={newSplitButtonItems}
            onClick={newService}
            className="p-button-sm"
          />
        </div>

        <SplitButton
          appendTo="self"
          label="Imprimir"
          icon="pi pi-print"
          model={printSplitButtonItems}
          onClick={printService}
          className="p-button-sm"
        />
      </div>
    </div>
  );

  const header = renderHeader();

  return (
    <div>
      <EditServiceDialog
        isDialogVisible={IsServiceDialogOpen}
        setIsDialogVisible={setIsServiceDialogOpen}
        setSelectedServices={setSelectedServices}
        service={selectedServices[0] ?? null}
        customer={customer}
        isEditMode={IsEditMode}
        setEditMode={setIsEditMode}
        toast={toast}
      />
      <PaymentsDialog
        isDialogVisible={IsPaymentDialogOpen}
        setIsDialogVisible={setIsPaymentDialogOpen}
        customer={customer}
        selectedServices={selectedServices}
        unpaidServices={unpaidServicesQuery?.data}
        toast={toast}
        actionSuccess={actionPaymentSuccess}
      />
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
        emptyMessage="Nenhum cliente encontrado."
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
          field="documents_id"
          body={(rowData) => serviceTypeIdentifierLabel(rowData.documents_id)}
          header="Tipo de Serviço"
          sortable
        />
        <Column
          field="description"
          style={{ whiteSpace: 'nowrap' }}
          body={(rowData) => descriptionTemplate(rowData.description)}
          header="Descrição"
        />
        <Column
          field="products"
          body={(rowData) =>
            productsTemplate(
              rowData.products,
              rowData.id,
              seeAllRow,
              setSeeAllRow
            )
          }
          header="Produtos Utilizados"
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
