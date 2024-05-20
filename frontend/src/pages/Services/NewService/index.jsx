import { Button } from 'primereact/button';
import { Dialog } from 'primereact/dialog';
import { InputSwitch } from 'primereact/inputswitch';
import { MultiSelect } from 'primereact/multiselect';
import { addMonths } from 'date-fns';
import { useForm } from 'react-hook-form';
import { useParams, useNavigate } from 'react-router-dom';
import { Toast } from 'primereact/toast';
import { useQuery } from 'react-query';
import { Skeleton } from 'primereact/skeleton';
import { ConfirmDialog } from 'primereact/confirmdialog';
import React from 'react';
import { useHookstate } from '@hookstate/core';
import SectionDedetizacao from './sections/dedetizacao';
import SectionDesratizacao from './sections/desratizacao';
import DateRangeInputModal from '../../../components/DateRange/DateRangeInputModal';
import Layout from '../../../components/Layout';
import { fetchCustomer } from '../../../services/CustomerService';
import NotFound from '../../../components/NotFound';
import { useCreateService } from '../../../services/ServicesService/hooks';
import allProducts from '../../../services/ProductsService';
import printServices from '../../../common/PrintService';
import PaymentsDialog from '../../../dialogs/Payments';
import { unpaidServices } from '../../../services/ServicesService';
import globalState from '../../../store';
import SectionCaixa from './sections/caixa';

export default function NewService() {
  const toast = React.useRef(null);
  const navigate = useNavigate();

  const DEDETIZACAO_TYPE = 'dd';
  const DESRATIZACAO_TYPE = 'dr';
  const DESIFECCAO_CAIXA_TYPE = 'dc';

  const defaultDate = [
    {
      startDate: new Date(),
      endDate: addMonths(new Date(), 6),
      key: 'selection',
    },
  ];

  const { customerId } = useParams();

  if (!customerId || customerId === undefined) {
    return <NotFound />;
  }

  const [isGlobalDate, setIsGlobalDate] = React.useState(true);
  const [IsPrintDialogVisible, setIsPrintDialogVisible] = React.useState(false);
  const [IsPaymentDialogOpen, setIsPaymentDialogOpen] = React.useState(false);
  const [IsPaymentQuestionVisible, setIsPaymentQuestionVisible] =
    React.useState(false);
  const [globalDate, setGlobalDate] = React.useState(defaultDate);
  const [isDefinitionsModalOpen, setIsDefinitionsModalOpen] =
    React.useState(false);
  const [selectedService, setSelectedService] = React.useState([]);
  const [createdServices, setCreatedServices] = React.useState([]);

  const defaultValues = {
    dd_date: defaultDate,
    dd_products: [],
    dd_local: '',
    dd_value: null,
    dd_description: '',
    dr_date: defaultDate,
    dr_products: [],
    dr_local: '',
    dr_value: null,
    dr_description: '',
  };

  const {
    control,
    reset,
    formState: { errors },
    handleSubmit,
    setValue,
  } = useForm({
    defaultValues,
  });

  const productsQueryResult = useQuery('allProducts', allProducts);
  const isProductsLoading = productsQueryResult.isLoading;
  const ddproducts = productsQueryResult.data?.data[1];
  const drproducts = productsQueryResult.data?.data[2];

  const servicesAvaliable = [
    {
      label: 'Dedetização',
      value: DEDETIZACAO_TYPE,
      component: (
        <SectionDedetizacao
          key={DEDETIZACAO_TYPE}
          defaultDate={globalDate}
          setValue={setValue}
          errors={errors}
          control={control}
          products={ddproducts}
          isProductsLoading={isProductsLoading}
        />
      ),
    },
    {
      label: 'Desratização',
      value: DESRATIZACAO_TYPE,
      component: (
        <SectionDesratizacao
          key={DESRATIZACAO_TYPE}
          defaultDate={globalDate}
          setValue={setValue}
          errors={errors}
          control={control}
          products={drproducts}
          isProductsLoading={isProductsLoading}
        />
      ),
    },
    {
      label: 'Desinfecção de Caixa d`água',
      value: DESIFECCAO_CAIXA_TYPE,
      component: (
        <SectionCaixa
          key={DESIFECCAO_CAIXA_TYPE}
          defaultDate={globalDate}
          setValue={setValue}
          errors={errors}
          control={control}
        />
      ),
    },
    // { label: 'Sanitização de Ambientes', value: 'SA', component: null },
    // { label: 'Descupinização', value: 'DSC', component: null },
  ];

  const searchCustomer = () => fetchCustomer(customerId);

  const queryKey = `searchCustomer:${customerId}`;
  const { isLoading, isError, data } = useQuery(queryKey, searchCustomer);

  const customer = data?.data;

  const createServiceMutation = useCreateService();

  const { data: unpaidServicesQuery, refetch: refetchUnpaidServices } =
    useQuery(
      ['unpaidServices', customer?.id],
      () => unpaidServices(customer?.id),
      { enabled: false }
    );

  const state = useHookstate(globalState);

  const acceptPrintDialog = () => {
    const isToPrintPayment = state.get()?.isToPrintPayment;

    printServices(
      toast,
      createdServices.map((service) => service.id),
      isToPrintPayment
    );

    state.set({
      ...state.get(),
      isToPrintPayment: false,
    });
  };

  const acceptPaymentDialog = () => {
    setIsPaymentDialogOpen(true);
  };

  const actionPaymentSuccess = () => {
    setIsPaymentDialogOpen(false);
    setIsPaymentQuestionVisible(false);
    refetchUnpaidServices();
    setIsPrintDialogVisible(true);
  };

  const submitGlobal = (formDataRaw) => {
    const eachService = {};

    selectedService.map((serviceType) => {
      const date = formDataRaw[`${serviceType}_date`];
      const products = formDataRaw[`${serviceType}_products`] ?? null;
      const details = formDataRaw[`${serviceType}_details`] ?? null;
      const value = formDataRaw[`${serviceType}_value`];
      const description = formDataRaw[`${serviceType}_description`];

      eachService[serviceType] = {
        date,
        products,
        details,
        value,
        description,
      };

      return null;
    });

    const formData = {
      customer: parseInt(customerId, 10),
      services: eachService,
    };

    console.log(formData);

    const onSuccess = (response) => {
      toast.current.show({
        severity: 'success',
        summary: 'Sucesso',
        detail: 'Serviço cadastrado com sucesso',
        life: 3000,
      });

      setCreatedServices(response?.data);
      setSelectedService([]);
      reset();
      refetchUnpaidServices();
      setIsPaymentQuestionVisible(true);
    };

    const onError = () => {
      toast.current.show({
        severity: 'error',
        summary: 'Erro',
        detail: 'Erro ao salvar o serviço, contate o suporte',
        life: 3000,
      });
    };

    createServiceMutation.mutate(formData, {
      onSuccess,
      onError,
    });
  };

  const onHideDefinitionsModal = () => {
    setIsDefinitionsModalOpen(false);
  };

  const DefinitionsModalFooter = (
    <div>
      <Button
        className="p-button-sm"
        label="Fechar"
        icon="pi pi-times"
        onClick={(e) => {
          e.preventDefault();
          setIsDefinitionsModalOpen(false);
        }}
      />
    </div>
  );

  const onChangeGlobalDate = (date) => {
    setGlobalDate(date);
  };

  if (isError) {
    return <NotFound />;
  }

  return (
    <Layout>
      <PaymentsDialog
        isDialogVisible={IsPaymentDialogOpen}
        setIsDialogVisible={setIsPaymentDialogOpen}
        customer={customer}
        selectedServices={createdServices}
        unpaidServices={unpaidServicesQuery?.data}
        toast={toast}
        actionSuccess={actionPaymentSuccess}
        actionOnHide={() => {
          setIsPrintDialogVisible(true);
        }}
      />
      <ConfirmDialog
        visible={IsPrintDialogVisible}
        onHide={() => setIsPrintDialogVisible(false)}
        header="Successo!"
        message="Deseja imprimir os documentos previamente criados agora?"
        icon="pi pi-question-circle"
        accept={acceptPrintDialog}
        acceptLabel="Sim"
        acceptIcon="pi pi-check"
        rejectLabel="Não"
        rejectIcon="pi pi-times"
      />
      <ConfirmDialog
        visible={IsPaymentQuestionVisible}
        onHide={() => setIsPaymentQuestionVisible(false)}
        header="Pagamento"
        message="Deseja realizar o pagamento dos serviços previamente criados agora?"
        icon="pi pi-question-circle"
        accept={acceptPaymentDialog}
        reject={() => setIsPrintDialogVisible(true)}
        acceptLabel="Sim"
        acceptIcon="pi pi-check"
        rejectLabel="Não"
        rejectIcon="pi pi-times"
      />
      <Toast ref={toast} />
      <Dialog
        draggable={false}
        header="Definições"
        visible={isDefinitionsModalOpen}
        style={{ width: '50vw' }}
        footer={DefinitionsModalFooter}
        onHide={onHideDefinitionsModal}
      >
        <div className="flex align-items-center">
          <div className="mr-2">
            <InputSwitch
              checked={isGlobalDate}
              onChange={(e) => setIsGlobalDate(e.value)}
            />
          </div>
          <p className="mt-1 font-semibold text-md text-gray-600 dark:text-gray-300">
            Utilizar um único campo de data para todos os serviços
          </p>
        </div>
      </Dialog>
      <h2 className="mt-8 mb-4 text-3xl font-semibold text-gray-700 dark:text-gray-200">
        Cadastro de Serviço
      </h2>
      {isLoading ? (
        <Skeleton className="w-full block mt-2" height="15.938em" />
      ) : (
        <div className="px-4 py-3 mt-2 bg-white rounded-lg shadow-md dark:bg-astro-800">
          <div className="flex mb-6 justify-between">
            <div>
              <h4 className="font-semibold mb-1 text-xl text-gray-600 dark:text-gray-300">
                Identificação do Cliente:
              </h4>
              <p className="text-gray-700 text-md dark:text-astro-100 block">
                {customer?.companyName} - ({customer?.fantasyName})
              </p>
            </div>

            <div>
              <Button
                icon="pi pi-cog"
                label="Definições"
                className="p-button-sm p-button-secondary"
                onClick={(e) => {
                  e.preventDefault();
                  setIsDefinitionsModalOpen(true);
                }}
              />
            </div>
          </div>

          <div className="flex justify-center gap-4">
            <div className="w-1/2">
              <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
                Serviços realizados
              </span>
              <MultiSelect
                name="services"
                display="chip"
                placeholder="Selecione um ou mais serviços"
                className="w-full"
                value={selectedService}
                options={servicesAvaliable}
                onChange={(e) => setSelectedService(e.value)}
                appendTo="self"
              />
            </div>
            <div className="w-1/2">
              <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
                Data de execução e validade
              </span>
              <DateRangeInputModal
                rangeDate={globalDate}
                setRangeDate={onChangeGlobalDate}
              />
            </div>
          </div>

          <form onSubmit={handleSubmit(submitGlobal)}>
            {selectedService.map(
              (service) =>
                servicesAvaliable.find(
                  (serviceAvaliable) => serviceAvaliable.value === service
                ).component
            )}

            <div className="mt-5 pb-1">
              <Button
                label="Cadastrar"
                className="mr-4 p-button-sm"
                type="submit"
              />
              <Button
                label="Voltar"
                className="p-button-sm p-button-secondary"
                onClick={(e) => {
                  e.preventDefault();
                  navigate(-1);
                }}
              />
            </div>
          </form>
        </div>
      )}
    </Layout>
  );
}
