import React, { useEffect } from 'react';
import { Button } from 'primereact/button';
import { Dialog } from 'primereact/dialog';
import { format, formatDistanceToNow, parseISO } from 'date-fns';
import { Checkbox } from 'primereact/checkbox';
import { useQuery } from 'react-query';
import { Skeleton } from 'primereact/skeleton';
import { FormProvider, useForm } from 'react-hook-form';
import ptBR from 'date-fns/locale/pt-BR';
import allProducts from '../../services/ProductsService';
import { serviceTypeIdentifierLabel } from '../../utils/datatable/formats';
import { getService } from '../../services/ServicesService';
import DedetizacaoDetailedForm from './forms/dedetizacao';
import { useUpdateService } from '../../services/ServicesService/hooks';

export default function EditServiceDialog({
  isDialogVisible,
  setIsDialogVisible,
  setSelectedServices,
  service,
  customer,
  isEditMode,
  setEditMode,
  toast,
}) {
  const headerTitle = isEditMode ? 'Edição do Serviço' : 'Detalhes do Serviço';

  const productsQueryResult = useQuery('allProducts', allProducts);
  const isProductsLoading = productsQueryResult.isLoading;
  const ddproducts = productsQueryResult.data?.data[1];

  const serviceId = service?.id;
  const fetchService = () => getService(serviceId);
  const serviceQueryKey = `getService:${service?.id}`;
  const serviceQueryResult = useQuery(serviceQueryKey, fetchService);
  const isServiceLoading = serviceQueryResult.isLoading;
  const serviceData = serviceQueryResult.data?.data;
  const isLoading = isProductsLoading || isServiceLoading;
  const serviceError = serviceQueryResult.error;

  if (serviceError) {
    console.error(serviceError);
  }

  const methods = useForm({
    shouldFocusError: false,
  });

  const { handleSubmit } = methods;
  const updateServiceMutation = useUpdateService(serviceId);

  const onHideDialog = () => {
    setIsDialogVisible(false);
    methods.reset();
  };
  
  function updatedService(payload) {
    updateServiceMutation.mutate(payload, {
      onSuccess: () => {
        toast.current.show({
          severity: 'success',
          summary: 'Sucesso',
          detail: 'Serviço atualizado com sucesso!',
          life: 3000,
        });
        setEditMode(false);
        serviceQueryResult.refetch();
        setSelectedServices([]);

        onHideDialog();
      },
      onError: () => {
        toast.current.show({
          severity: 'error',
          summary: 'Erro',
          detail: 'Erro ao atualizar serviço',
          life: 3000,
        });
      },
    });
  }

  const footer = (
    <div>
      {isEditMode && (
        <Button
          className="p-button-sm"
          label="Atualizar Serviço"
          icon="pi pi-check"
          onClick={handleSubmit(updatedService, (errors) => {
            console.error(errors);
            toast.current.show({
              severity: 'error',
              summary: 'Erro',
              detail: 'Formulário inválido verifique os campos destacados',
              life: 3000,
            });
          })}
        />
      )}
      <Button
        className="p-button-secondary p-button-sm"
        label="Fechar"
        icon="pi pi-times"
        onClick={onHideDialog}
      />
    </div>
  );

  function formatDateBrazilian(dateString) {
    if (!dateString) {
      return '-';
    }

    const parsedDate = parseISO(dateString);
    return format(parsedDate, 'dd/MM/yyyy HH:mm:ss');
  }

  const serviceUnavailable = service?.documents_id !== 1;

  // const services = [
  //   {
  //     label: 'Dedetização',
  //     component: (
  //       <DedetizacaoDetailedForm
  //         customer={customer}
  //         serviceData={serviceData}
  //         isEditMode={isEditMode}
  //         productsList={ddproducts}
  //       />
  //     ),
  //   },
  // ];

  return (
    <Dialog
      draggable
      maximizable
      header={headerTitle}
      visible={isDialogVisible}
      footer={footer}
      onHide={onHideDialog}
    >
      {isLoading && !serviceUnavailable && (
        <div>
          <div>
            <div>
              <Skeleton width="10rem" height="1.5rem" className="block mb-2" />
            </div>

            <Skeleton width="20rem" height="3rem" className="block mb-4" />
          </div>

          <div>
            <div>
              <Skeleton width="10rem" height="1.5rem" className="block mb-2" />
            </div>

            <Skeleton width="20rem" height="3rem" className="block mb-4" />
          </div>

          <div>
            <div>
              <Skeleton width="10rem" height="1.5rem" className="block mb-2" />
            </div>

            <Skeleton width="20rem" height="3rem" className="block mb-4" />
          </div>
          <div>
            <div>
              <Skeleton width="10rem" height="1.5rem" className="block mb-2" />
            </div>

            <Skeleton width="20rem" height="3rem" className="block mb-4" />
          </div>
        </div>
      )}
      {serviceUnavailable && (
        <div className="flex flex-col items-center justify-center">
          <div className="text-gray-700 text-lg font-semibold dark:text-astro-50 block">
            Serviço não disponivel para visualização/edição
          </div>
          <div className="text-gray-700 text-md font-semibold dark:text-astro-50 block">
            {serviceTypeIdentifierLabel(service?.documents_id)}
          </div>
        </div>
      )}
      {!isLoading && !serviceUnavailable && (
        <>
          <FormProvider {...methods}>
            <form onSubmit={handleSubmit(updatedService)}>
              <DedetizacaoDetailedForm
                customer={customer}
                serviceData={serviceData}
                isEditMode={isEditMode}
                productsList={ddproducts}
              />
            </form>
          </FormProvider>

          <label className="block">
            <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
              Detalhes do registro
            </span>

            <p className="text-gray-700 dark:text-astro-100">
              Criado em: {formatDateBrazilian(serviceData?.created_at ?? '')}
            </p>
            <p className="text-gray-700 dark:text-astro-100">
              Atualizado em: {formatDateBrazilian(serviceData?.updated_at ?? '')} - {formatDistanceToNow(parseISO(serviceData?.updated_at ?? ''), { locale: ptBR })} átras
            </p>
          </label>

          <div className="field-checkbox flex mt-4">
            <Checkbox
              inputId="binary"
              checked={isEditMode}
              onChange={(e) => setEditMode(e.checked)}
              className="self-center"
            />
            <label htmlFor="binary">
              <span className="ml-1 font-semibold text-md text-gray-600 dark:text-astro-100">
                Modo de edição
              </span>
            </label>
          </div>
        </>
      )}
    </Dialog>
  );
}
