import { Controller } from 'react-hook-form';
import { InputNumber } from 'primereact/inputnumber';
import { InputTextarea } from 'primereact/inputtextarea';
import { MultiSelect } from 'primereact/multiselect';
import React from 'react';
import { Skeleton } from 'primereact/skeleton';
import { InputText } from 'primereact/inputtext';
import DateRangeInputModal from '../../../../components/DateRange/DateRangeInputModal';

export default function SectionDedetizacao({
  defaultDate,
  setValue,
  errors,
  control,
  products,
  isProductLoading,
}) {
  const [rangeDate, setRangeDate] = React.useState(defaultDate);

  const setDate = (date) => {
    setValue('dd_date', date);
    setRangeDate(date);
  };

  React.useEffect(() => {
    setDate(defaultDate);
  }, [defaultDate]);

  const onValueChange = (e) => {
    setValue('dd_value', e.value);
  };

  const enterKeyPrevent = (event) => {
    if (event.key === 'Enter') {
      event.preventDefault();
    }
  };

  return (
    <section className="w-full mt-8 border-solid border-2 border-astro-500 rounded-lg p-5">
      <h4 className="text-xl font-semibold text-gray-600 dark:text-gray-300">
        Dedetização
      </h4>
      <div className="grid md:grid-cols-2 gap-4 mt-5">
        <div>
          <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
            Data de execução e validade
          </span>
          <DateRangeInputModal rangeDate={rangeDate} setRangeDate={setDate} />
        </div>
        <label>
          <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
            Valor
            {errors.dd_value && (
              <span className="ml-2 text-red-400 text-sm">
                (Este campo é obrigatorio!)
              </span>
            )}
          </span>

          <Controller
            name="dd_value"
            control={control}
            rules={{ required: true }}
            render={({ field }) => (
              <InputNumber
                {...field}
                mode="currency"
                currency="BRL"
                onChange={onValueChange}
                locale="pt-BR"
                className="w-full"
                placeholder="R$ 0,00"
                onKeyPress={enterKeyPrevent}
              />
            )}
          />
        </label>
      </div>

      <div className="grid md:grid-cols-2 gap-4 mt-5">
        <div>
          <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
            Produtos utilizados
            {errors.dd_products && (
              <span className="ml-2 text-red-400 text-sm">
                (Este campo é obrigatorio!)
              </span>
            )}
          </span>

          {isProductLoading ? (
            <Skeleton className="w-full block mt-2" height="41px" />
          ) : (
            <Controller
              name="dd_products"
              control={control}
              rules={{ required: true }}
              render={({ field }) => (
                <MultiSelect
                  {...field}
                  display="chip"
                  placeholder="Selecione um ou mais produtos"
                  className="w-full"
                  options={products}
                  optionLabel="name"
                  optionValue="id"
                  onKeyPress={enterKeyPrevent}
                  filterPlaceholder="Buscar por produtos"
                  emptyFilterMessage="Nenhum produto encontrado"
                  appendTo="self"
                />
              )}
            />
          )}
        </div>
        <div>
          <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
            Local
            {errors.dr_local && (
              <span className="ml-2 text-red-400 text-sm">
                (Este campo é obrigatorio!)
              </span>
            )}
          </span>

          {isProductLoading ? (
            <Skeleton className="w-full block mt-2" height="41px" />
          ) : (
            <Controller
              name="dr_local"
              control={control}
              rules={{ maxLength: 100 }}
              render={({ field }) => (
                <InputText
                  {...field}
                  className="w-full"
                  placeholder="Digite em qual local foi realizado o serviço"
                  onKeyPress={enterKeyPrevent}
                />
              )}
            />
          )}
        </div>
      </div>

      <div className="grid md:grid-cols-1 gap-4 mt-8">
        <label>
          <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
            Descrição do serviço de Dedetização
            {errors.dd_description && (
              <span className="ml-2 text-red-400 text-sm">
                (A descrição é muito longa!)
              </span>
            )}
          </span>
          <Controller
            name="dd_description"
            control={control}
            rules={{ maxLength: 190 }}
            render={({ field }) => (
              <InputTextarea
                {...field}
                className="w-full"
                onKeyPress={enterKeyPrevent}
                placeholder="Descreva o serviço de Dedetização"
                autoResize
              />
            )}
          />
        </label>
      </div>
    </section>
  );
}
