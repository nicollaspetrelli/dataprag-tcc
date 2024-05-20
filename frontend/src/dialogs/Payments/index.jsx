import { Dropdown } from 'primereact/dropdown';
import { Button } from 'primereact/button';
import { Dialog } from 'primereact/dialog';
import React from 'react';
import { Controller, useForm } from 'react-hook-form';
import { MultiSelect } from 'primereact/multiselect';
import { InputNumber } from 'primereact/inputnumber';
import { InputText } from 'primereact/inputtext';
import { Checkbox } from 'primereact/checkbox';
import { useHookstate } from '@hookstate/core';
import DatePickerInputModal from '../../components/DatePicker/DatePickerInputModal';
import { formatCurrency, formatDate } from '../../utils/datatable/formats';
import { createPayment } from '../../services/PaymentsService';
import globalState from '../../store';
import { cantOpenPaymentDialog } from '../../utils/messages.tsx';

export default function PaymentsDialog({
  isDialogVisible,
  setIsDialogVisible,
  customer,
  unpaidServices,
  selectedServices,
  toast,
  actionSuccess,
  actionOnHide,
}) {
  const [date, setDate] = React.useState(new Date());

  const state = useHookstate(globalState);

  const print = state.get()?.isToPrintPayment;
  const setPrint = (value) => {
    state.set({
      ...state.get(),
      isToPrintPayment: value,
    });
  };

  const [selectedPaymentServices, setSelectedPaymentServices] = React.useState(
    []
  );

  React.useEffect(() => {
    setSelectedPaymentServices(selectedServices.map((service) => service.id));
  }, [selectedServices]);

  const paymentMethods = [
    { label: 'Dinheiro', value: 'money' },
    { label: 'Pix', value: 'pix' },
    { label: 'Boleto', value: 'boleto' },
    { label: 'Transferência', value: 'ted' },
    { label: 'Cartão de Crédito', value: 'credit' },
    { label: 'Cartão de Débito', value: 'debit' },
  ];

  const defaultValues = {
    paymentMethod: 'money',
    paymentDescription: '',
  };

  const {
    control,
    formState: { errors },
    setValue,
    reset,
    handleSubmit,
  } = useForm({ defaultValues });

  const onChangeServices = (servicesValues) => {
    setSelectedPaymentServices(servicesValues);
    setValue('services', servicesValues);

    let totalValue = 0;

    unpaidServices.forEach((service) => {
      if (servicesValues.includes(service.id)) {
        totalValue += +service.value;
      }
    });

    setValue('value', totalValue);
  };

  React.useEffect(() => {
    if (!isDialogVisible) return;
    if (!unpaidServices) return;

    const selectedServiceInUnpaidList = unpaidServices.filter((service) =>
      selectedPaymentServices.includes(service.id)
    );

    if (selectedServiceInUnpaidList.length !== selectedPaymentServices.length) {
      setValue('services', []);
      setSelectedPaymentServices([]);
      reset();
      cantOpenPaymentDialog(toast);

      setIsDialogVisible(false);
      return;
    }

    setValue('services', selectedPaymentServices);
    onChangeServices(selectedPaymentServices);
  }, [isDialogVisible, unpaidServices]);

  const onSubmit = (formData) => {
    const data = {
      ...formData,
      paymentDate: formData.paymentDate.toISOString().split('T')[0],
    };

    createPayment(data).then((response) => {
      actionSuccess(response);

      if (response?.status === 200) {
        toast?.current.show({
          severity: 'success',
          summary: 'Sucesso',
          detail: 'Pagamento realizado com sucesso!',
          life: 3000,
        });

        return;
      }

      toast?.current.show({
        severity: 'error',
        summary: 'Error',
        detail: `Erro ao tentar cadastrar o pagamento, contate o suporte.`,
        life: 3000,
      });
    });

    setIsDialogVisible(false);
    reset();
  };

  const onHideDialog = () => {
    setIsDialogVisible(false);
    if (actionOnHide) actionOnHide();
  };

  const changeDate = (selectedDate) => {
    setValue('paymentDate', selectedDate);
    setDate(selectedDate);
  };

  const footer = (
    <div>
      <Button
        className="p-button-sm"
        label="Cadastrar pagamento"
        icon="pi pi-check"
        onClick={handleSubmit(onSubmit)}
      />
      <Button
        className="p-button-secondary p-button-sm"
        label="Cancelar"
        icon="pi pi-times"
        onClick={onHideDialog}
      />
    </div>
  );

  const servicesTemplate = (option) => {
    const dateFormatted = formatDate(option?.dateExecution);
    const value = formatCurrency(option?.value);

    return (
      <div className="p-multiselect-services-option" key={option.id}>
        <span>
          {option.name} - {dateFormatted} - {value}
        </span>
      </div>
    );
  };

  const serviceLabelTemplate = (option) => {
    if (!option) {
      return 'ERROR';
    }

    const dateFormatted = formatDate(option?.dateExecution);
    const value = formatCurrency(option?.value);

    return `${option.name} - ${dateFormatted} - ${value}`;
  };

  return (
    <Dialog
      draggable
      maximizable
      header="Confirmação de Pagamento"
      visible={isDialogVisible}
      footer={footer}
      onHide={onHideDialog}
    >
      <div>
        <form onSubmit={handleSubmit(onSubmit)}>
          <label className="block mb-4">
            <span className="text-gray-700 text-lg font-semibold dark:text-astro-50 block">
              {customer?.fantasyName}
            </span>
            <span className="block text-md">{customer?.companyName}</span>
          </label>

          <label className="block mb-4">
            <span className="text-gray-700 mb-2 text-md dark:text-astro-100 block">
              Serviços correspondentes
              {errors.services && (
                <span className="ml-2 text-red-400 text-xs">
                  Campo obrigatorio!
                </span>
              )}
            </span>
            <Controller
              name="services"
              control={control}
              rules={{ required: true }}
              render={({ field }) => (
                <MultiSelect
                  {...field}
                  display="comma"
                  maxSelectedLabels={1}
                  value={selectedPaymentServices}
                  placeholder="Serviços que compõem o pagamento"
                  selectedItemsLabel="{0} serviços selecionados"
                  className="w-full"
                  options={unpaidServices}
                  optionLabel={serviceLabelTemplate}
                  optionValue="id"
                  itemTemplate={servicesTemplate}
                  onChange={(e) => onChangeServices(e.value)}
                  appendTo="self"
                />
              )}
            />
          </label>

          <label className="block mb-4">
            <span className="text-gray-700 mb-2 text-md dark:text-astro-100 block">
              Método de Pagamento
              {errors.paymentMethod && (
                <span className="ml-2 text-red-400 text-xs">
                  Campo obrigatorio!
                </span>
              )}
            </span>

            <Controller
              name="paymentMethod"
              control={control}
              rules={{ required: true }}
              render={({ field }) => (
                <Dropdown
                  {...field}
                  options={paymentMethods}
                  optionLabel="label"
                  placeholder="Selecione um método de pagamento"
                  optionValue="value"
                  className="w-full"
                />
              )}
            />
          </label>

          <div className="flex mb-4">
            <label className="block w-1/2 mr-4">
              <span className="text-gray-700 mb-2 text-md dark:text-astro-100 block">
                Data do Pagamento
                {errors.paymentDate && (
                  <span className="ml-2 text-red-400 text-xs">
                    Campo obrigatorio!
                  </span>
                )}
              </span>
              <Controller
                name="paymentDate"
                control={control}
                rules={{ required: true }}
                render={({ field }) => (
                  <DatePickerInputModal
                    {...field}
                    date={date}
                    setDate={(e) => changeDate(e)}
                  />
                )}
              />
            </label>

            <label className="block w-1/2">
              <span className="text-gray-700 mb-2 text-md dark:text-astro-100 block">
                Valor total do pagamento
                {errors.value && (
                  <span className="ml-2 text-red-400 text-xs">
                    Campo obrigatorio!
                  </span>
                )}
              </span>
              <Controller
                name="value"
                control={control}
                rules={{ required: true }}
                render={({ field }) => (
                  <InputNumber
                    {...field}
                    mode="currency"
                    currency="BRL"
                    onChange={(e) => setValue('value', e.value)}
                    locale="pt-BR"
                    className="w-full"
                    placeholder="R$ 0,00"
                    // onKeyPress={enterKeyPrevent}
                  />
                )}
              />
            </label>
          </div>

          <label className="block">
            <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
              Descrição do pagamento
              {errors.paymentDescription && (
                <span className="ml-2 text-red-400 text-xs">
                  Limite de caracteres excedido!
                </span>
              )}
            </span>
            <Controller
              name="paymentDescription"
              control={control}
              rules={{ maxLength: 100 }}
              render={({ field }) => (
                <InputText
                  {...field}
                  className="w-full"
                  placeholder="Observações do pagamento"
                  // onKeyPress={enterKeyPrevent}
                />
              )}
            />
          </label>

          <div className="field-checkbox flex mt-4">
            <Checkbox
              inputId="binary"
              checked={print}
              onChange={(e) => setPrint(e.checked)}
              className="self-center"
            />
            <label htmlFor="binary">
              <span className="ml-1 font-semibold text-md text-gray-600 dark:text-astro-100">
                Exibir o recibo em uma nova página ao finalizar o cadastro.
              </span>
            </label>
          </div>
        </form>
      </div>
    </Dialog>
  );
}
