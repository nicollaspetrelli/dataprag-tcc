import { Controller, useFieldArray } from 'react-hook-form';
import { InputNumber } from 'primereact/inputnumber';
import { InputTextarea } from 'primereact/inputtextarea';
import React from 'react';
import { Dropdown } from 'primereact/dropdown';
import { InputText } from 'primereact/inputtext';
import DateRangeInputModal from '../../../../components/DateRange/DateRangeInputModal';

export default function SectionCaixa({
  defaultDate,
  setValue,
  errors,
  control,
}) {
  const [rangeDate, setRangeDate] = React.useState(defaultDate);
  const [quantity, setQuantity] = React.useState(1);

  const { fields, append, prepend, remove, swap, move, insert } = useFieldArray(
    {
      control,
      name: 'dc_details',
      focusAppend: false,
    }
  );

  const setDate = (date) => {
    setValue('dc_date', date);
    setRangeDate(date);
  };

  React.useEffect(() => {
    setDate(defaultDate);
  }, [defaultDate]);

  React.useEffect(() => {
    if (quantity > fields.length) {
      for (let i = 0; i < quantity - fields.length; i += 1) {
        append({ type: null, liters: 100, local: '' }, { shouldFocus: false });
      }
    } else if (quantity < fields.length) {
      for (let i = 0; i < fields.length - quantity; i += 1) {
        remove(fields.length - 1);
      }
    }
  }, [quantity]);

  const onValueChange = (e) => {
    setValue('dc_value', e.value);
  };

  const onQuantityChange = (e) => {
    setValue('dc_quantity', e.value);
    setQuantity(e.value);
  };

  const enterKeyPrevent = (event) => {
    if (event.key === 'Enter') {
      event.preventDefault();
    }
  };

  return (
    <section className="w-full mt-8 border-solid border-2 border-astro-500 rounded-lg p-5">
      <h4 className="text-xl font-semibold text-gray-600 dark:text-gray-300">
        Desinfecção de caixa d&apos;água
      </h4>
      <div className="grid lg:grid-cols-3 gap-4 mt-5">
        <div>
          <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
            Data de execução e validade
          </span>
          <DateRangeInputModal rangeDate={rangeDate} setRangeDate={setDate} />
        </div>
        <div>
          <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
            Quantidade de Caixas
            {errors.dc_quantity && (
              <span className="ml-2 text-red-400 text-sm">
                (Este campo é obrigatorio!)
              </span>
            )}
          </span>

          <Controller
            name="dc_quantity"
            control={control}
            rules={{ required: true, min: 1 }}
            render={({ field }) => (
              <InputNumber
                {...field}
                className="w-full"
                placeholder="Caixas"
                value={quantity}
                onChange={onQuantityChange}
                onKeyPress={enterKeyPrevent}
                showButtons
                buttonLayout="horizontal"
                decrementButtonClassName="p-button-secondary"
                incrementButtonClassName="p-button-secondary"
                incrementButtonIcon="pi pi-plus"
                decrementButtonIcon="pi pi-minus"
                min={1}
                max={20}
                suffix=" Caixas"
              />
            )}
          />
        </div>
        <label>
          <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
            Valor
            {errors.dc_value && (
              <span className="ml-2 text-red-400 text-sm">
                (Este campo é obrigatorio!)
              </span>
            )}
          </span>

          <Controller
            name="dc_value"
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

      {fields.map((item, index) => (
        <div className="grid lg:grid-cols-3 gap-4 mt-5">
          <div>
            <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
              Tipo de caixa
              {errors?.dc_details?.[index]?.type && (
                <span className="ml-2 text-red-400 text-sm">
                  (Este campo é obrigatorio!)
                </span>
              )}
            </span>

            <Controller
              name={`dc_details.${index}.type`}
              control={control}
              rules={{ required: true }}
              render={({ field }) => (
                <Dropdown
                  {...field}
                  key={item.id}
                  placeholder="Selecione o tipo de caixa"
                  className="w-full"
                  options={[
                    { name: 'Polipropileno', id: 1 },
                    { name: 'Metálica', id: 2 },
                    { name: 'Amianto', id: 3 },
                    { name: 'Plastica', id: 4 },
                    { name: 'Cimento', id: 5 },
                    { name: 'Alvenaria', id: 6 },
                    { name: 'Subterrânea', id: 7 },
                  ]}
                  optionLabel="name"
                  optionValue="id"
                  onKeyPress={enterKeyPrevent}
                  appendTo="self"
                />
              )}
            />
          </div>
          <div>
            <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
              Tamanho em Litros
              {errors?.dc_details?.[index]?.liters && (
                <span className="ml-2 text-red-400 text-sm">
                  (Este campo é obrigatorio!)
                </span>
              )}
            </span>

            <Controller
              name={`dc_details.${index}.liters`}
              control={control}
              rules={{ required: true }}
              render={({ field }) => (
                <InputNumber
                  {...field}
                  key={item.id}
                  className="w-full"
                  placeholder="Litros"
                  onKeyPress={enterKeyPrevent}
                  showButtons
                  decrementButtonClassName="p-button-secondary"
                  incrementButtonClassName="p-button-secondary"
                  incrementButtonIcon="pi pi-plus"
                  decrementButtonIcon="pi pi-minus"
                  buttonLayout="horizontal"
                  min={100}
                  max={1000000}
                  step={50}
                  onChange={(e) => {
                    setValue(`dc_details.${index}.liters`, e.value);
                  }}
                  suffix=" Litros"
                />
              )}
            />
          </div>
          <div>
            <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
              Local
              {errors?.dc_details?.[index]?.local && (
                <span className="ml-2 text-red-400 text-sm">
                  (Este campo é obrigatorio!)
                </span>
              )}
            </span>

            <Controller
              name={`dc_details.${index}.local`}
              control={control}
              rules={{ required: true, maxLength: 100 }}
              render={({ field }) => (
                <InputText
                  {...field}
                  key={item.id}
                  className="w-full"
                  placeholder="Digite o local da caixa"
                  onKeyPress={enterKeyPrevent}
                />
              )}
            />
          </div>
        </div>
      ))}
      <div className="grid md:grid-cols-1 gap-4 mt-8">
        <label>
          <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
            Descrição do serviço de Desinfecção de caixa d&apos;água
            {errors.dc_description && (
              <span className="ml-2 text-red-400 text-sm">
                (A descrição é muito longa!)
              </span>
            )}
          </span>
          <Controller
            name="dc_description"
            control={control}
            rules={{ maxLength: 190 }}
            render={({ field }) => (
              <InputTextarea
                {...field}
                className="w-full"
                onKeyPress={enterKeyPrevent}
                placeholder="Descreva o serviço de Desinfecção de caixa d'água"
                autoResize
              />
            )}
          />
        </label>
      </div>
    </section>
  );
}
