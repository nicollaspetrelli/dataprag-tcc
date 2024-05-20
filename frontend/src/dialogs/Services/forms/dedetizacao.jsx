import React, { useEffect } from 'react';
import { InputText } from 'primereact/inputtext';
import { InputNumber } from 'primereact/inputnumber';
import { MultiSelect } from 'primereact/multiselect';
import { Controller, useFormContext } from 'react-hook-form';
import { Calendar } from 'primereact/calendar';
import { classNames } from 'primereact/utils';
import { addDays } from 'date-fns';
import { serviceTypeIdentifierLabel } from '../../../utils/datatable/formats';

export default function DedetizacaoDetailedForm(props) {
  const {
    setValue,
    control,
    formState: { errors },
  } = useFormContext();

  const defaultValues = {
    dateExecution: '',
    dateValidity: '',
    products: JSON.parse('[]'),
    details: {
      local: '',
    },
    value: null,
    description: '',
  };

  const { customer, serviceData, isEditMode, productsList } = props;

  const [dateMin, setDateMin] = React.useState(
    new Date(serviceData?.dateExecution)
  );

  const resetForm = () => {
    setValue('dateExecution', new Date(serviceData?.dateExecution) ?? '');
    setValue('dateValidity', new Date(serviceData?.dateValidity) ?? '');
    setValue('products', JSON.parse(serviceData?.products ?? '[]'));
    setValue(
      'details.local',
      JSON.parse(serviceData.details ?? '[]')?.local ?? ''
    );
    setValue('value', serviceData?.value ?? '');
    setValue('description', serviceData?.description ?? '');
  };

  useEffect(() => {
    resetForm();
  }, [serviceData]);

  return (
    <>
      <label className="block mb-4">
        <span className="block text-md">{customer?.fantasyName}</span>
        <span className="text-gray-700 text-lg font-semibold dark:text-astro-50 block">
          {serviceTypeIdentifierLabel(serviceData?.documents_id)}
        </span>
      </label>

      <div className="flex">
        <label className="block mb-4 w-full mr-4">
          <span className="text-gray-700 mb-2 text-md dark:text-astro-100 block">
            Data de execução
            {errors?.dateExecution && (
              <span className="ml-2 text-red-400 text-xs">
                - Campo obrigatorio!
              </span>
            )}
          </span>

          <Controller
            name="dateExecution"
            control={control}
            defaultValue={defaultValues.dateExecution}
            rules={{ required: 'DateExecution is required.' }}
            render={({ field, fieldState }) => (
              <Calendar
                {...field}
                dateFormat="dd/mm/yy"
                className={classNames(
                  { 'p-invalid': fieldState.error },
                  'w-full'
                )}
                onChange={(e) => {
                  setValue('dateExecution', e.value);
                  setDateMin(addDays(e.value, 1));
                }}
                placeholder="Selecione uma data"
                disabled={!isEditMode}
                showIcon
              />
            )}
          />
        </label>

        <label className="block mb-4 w-full">
          <span className="text-gray-700 mb-2 text-md dark:text-astro-100 block">
            Data de validade
            {errors?.dateValidity && (
              <span className="ml-2 text-red-400 text-xs">
                - Campo obrigatorio!
              </span>
            )}
          </span>

          <Controller
            name="dateValidity"
            defaultValue={defaultValues.dateValidity}
            control={control}
            rules={{ required: 'DateValidity is required.' }}
            render={({ field, fieldState }) => (
              <Calendar
                {...field}
                dateFormat="dd/mm/yy"
                className={classNames(
                  { 'p-invalid': fieldState.error },
                  'w-full'
                )}
                minDate={dateMin}
                placeholder="Selecione uma data"
                disabled={!isEditMode}
                showIcon
              />
            )}
          />
        </label>
      </div>

      <label className="block mb-4">
        <span className="text-gray-700 mb-2 text-md dark:text-astro-100 block">
          Produtos utilizados
          {errors?.products && (
            <span className="ml-2 text-red-400 text-xs">
              - Campo obrigatorio!
            </span>
          )}
        </span>

        <Controller
          control={control}
          name="products"
          rules={{ required: 'Products is required.' }}
          defaultValue={defaultValues.products}
          render={({ field, fieldState }) => (
            <MultiSelect
              {...field}
              display="chip"
              placeholder="Selecione um ou mais produtos"
              className={classNames(
                { 'p-invalid': fieldState.error },
                'w-full'
              )}
              options={productsList}
              optionLabel="name"
              optionValue="id"
              // onKeyPress={enterKeyPrevent}
              filterPlaceholder="Buscar por produtos"
              emptyFilterMessage="Nenhum produto encontrado"
              appendTo="self"
              disabled={!isEditMode}
            />
          )}
        />
      </label>

      <div className="flex mb-4">
        <label className="block w-1/2 mr-4">
          <span className="text-gray-700 mb-2 text-md dark:text-astro-100 block">
            Local do serviço
          </span>

          <Controller
            name="details.local"
            defaultValue={defaultValues.details.local}
            control={control}
            render={({ field }) => (
              <InputText
                {...field}
                className="w-full"
                placeholder="Localização exata do serviço"
                disabled={!isEditMode}
              />
            )}
          />
        </label>

        <label className="block w-1/2">
          <span className="text-gray-700 mb-2 text-md dark:text-astro-100 block">
            Valor do Serviço
            {errors?.value && (
              <span className="ml-2 text-red-400 text-xs">
                - Campo obrigatorio!
              </span>
            )}
          </span>

          <Controller
            name="value"
            rules={{
              required: 'Value is required.',
              min: 1,
              max: 999999,
            }}
            defaultValue={defaultValues.value}
            control={control}
            render={({ field, fieldState }) => (
              <InputNumber
                {...field}
                mode="currency"
                currency="BRL"
                onChange={(e) => setValue('value', e.value)}
                locale="pt-BR"
                className={classNames(
                  { 'p-invalid': fieldState.error },
                  'w-full'
                )}
                placeholder="R$ 0,00"
                value={serviceData?.value ?? ''}
                disabled={!isEditMode}
              />
            )}
          />
        </label>
      </div>

      <label className="block mb-4">
        <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
          Descrição do serviço
          {errors?.description && (
            <span className="ml-2 text-red-400 text-xs">
              - Limite máximo de caracteres atingidos!
            </span>
          )}
        </span>

        <Controller
          name="description"
          rules={{
            maxLength: 244,
          }}
          defaultValue={defaultValues.description}
          control={control}
          render={({ field, fieldState }) => (
            <InputText
              {...field}
              className={classNames(
                { 'p-invalid': fieldState.error },
                'w-full'
              )}
              placeholder="Descrição do serviço"
              disabled={!isEditMode}
            />
          )}
        />
      </label>
    </>
  );
}
