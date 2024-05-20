import { Dropdown } from 'primereact/dropdown';
import React from 'react';
import { Calendar } from 'primereact/calendar';
import { Button } from 'primereact/button';
import { Controller, useForm } from 'react-hook-form';
import { Toast } from 'primereact/toast';
import { ProgressBar } from 'primereact/progressbar';
import generateHandout from '../../services/HandoutSerivce';
import { fetchCustomers } from '../../services/CustomerService';
import Layout from '../../components/Layout';

// eslint-disable-next-line @typescript-eslint/no-var-requires
const { DateTime } = require('luxon');

export default function Handout() {
  const [customers, setCustomers] = React.useState([]);
  const [selectedCustomer, setSelectedCustomer] = React.useState(null);
  const [selectedDate, setSelectedDate] = React.useState(null);
  const toast = React.useRef(null);

  // TODO: REFACTOR TO USE REACT QUERY
  React.useEffect(() => {
    fetchCustomers()
      .then((response) => {
        setCustomers(response.data);
      })
      .catch((error) => {
        console.error(error);
        // toast.current.show({ severity: 'error', summary: 'Error', detail: 'Error fetching customers' });
      })
      .finally(() => {
        // setDatatableLoading(false);
      });
  }, []);

  const {
    control,
    formState: { errors },
    handleSubmit,
    setValue,
  } = useForm({
    // reset, getValues, setFocus
    defaultValues: {
      customer: null,
      startDate: null,
    },
  });

  const submitGlobal = async (data) => {
    console.log(data);

    const startDateFormatted = DateTime.fromJSDate(data.startDate).toFormat(
      'yyyy-MM-dd HH:mm:ss'
    );

    const handoutParams = {
      customName: data.customer,
      startDate: startDateFormatted,
    };

    toast.current.show({
      severity: 'warn',
      sticky: true,
      content: (
        <div className="flex w-full">
          <div className="text-left pr-5">
            <i
              className="pi pi-exclamation-triangle"
              style={{ fontSize: '3rem' }}
            />
          </div>
          <div className="w-full">
            <h4 className="pb-1">Gerando documento...</h4>
            <ProgressBar mode="indeterminate" />
          </div>
        </div>
      ),
    });

    await generateHandout(handoutParams)
      .then((response) => {
        console.debug('[DEBUG] Export Handout API returned');
        console.debug(response);

        const file = new Blob([response.data], {
          type: 'application/pdf',
        });

        const fileURL = URL.createObjectURL(file);
        window.open(fileURL);
      })
      .catch((error) => {
        console.error(error);
      })
      .finally(() => {
        toast.current.clear();
      });
  };

  return (
    <Layout>
      <Toast ref={toast} />
      <section>
        <h2 className="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
          Comunicados
        </h2>

        <div className="p-6 mt-2 bg-white rounded-lg shadow-md dark:bg-astro-800">
          <h4 className="font-semibold mb-4 text-xl text-gray-600 dark:text-gray-300">
            Emissão de Comunicado:
          </h4>

          <form onSubmit={handleSubmit(submitGlobal)}>
            <section className="mb-4">
              <span className="text-gray-700 mb-3 text-md dark:text-astro-100 block">
                Titulo do Cliente
              </span>
              <Controller
                name="customer"
                control={control}
                rules={{ required: true }}
                render={() => (
                  <Dropdown
                    placeholder="Selecione e/ou edite o titulo do cliente"
                    value={selectedCustomer}
                    options={customers}
                    onChange={(e) => {
                      setSelectedCustomer(e.value);
                      setValue('customer', e.value);
                    }}
                    filter
                    editable
                    filterPlaceholder="Pesquisar por cliente"
                    optionLabel="fantasyName"
                    optionValue="fantasyName"
                    appendTo="self"
                    className="w-1/2"
                  />
                )}
              />
              {errors.customer && (
                <p className="text-red-400 text-sm">Este campo é obrigatorio</p>
              )}
            </section>
            <section className="field col-12 md:col-4">
              <label
                htmlFor="startDate"
                className="text-gray-700 mb-3 text-md dark:text-astro-100 block"
              >
                Dia e Hora da Execução
              </label>
              <Controller
                name="startDate"
                control={control}
                rules={{ required: true }}
                render={() => (
                  <Calendar
                    id="startDate"
                    value={selectedDate}
                    className="w-1/2"
                    onChange={(e) => {
                      setSelectedDate(e.value);
                      setValue('startDate', e.value);
                    }}
                    showTime
                    showIcon
                    dateFormat="dd/mm/yy"
                    placeholder="Selecione a data e hora da execução"
                  />
                )}
              />
              {errors.startDate && (
                <p className="text-red-400 text-sm">Este campo é obrigatorio</p>
              )}
            </section>
            <div className="mt-5 pb-1">
              <Button
                label="Emitir Comunicado"
                className="mr-4 p-button-sm"
                type="submit"
              />
              <Button
                label="Cancelar"
                className="p-button-sm p-button-secondary"
                onClick={(e) => {
                  e.preventDefault();
                }}
              />
            </div>
          </form>
        </div>
      </section>
    </Layout>
  );
}
