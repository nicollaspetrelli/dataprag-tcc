/* eslint-disable jsx-a11y/no-static-element-interactions */
import { Controller, useForm } from 'react-hook-form';
import { Button } from 'primereact/button';
import { Dialog } from 'primereact/dialog';
import { Dropdown } from 'primereact/dropdown';
import { InputMask } from 'primereact/inputmask';
import { InputText } from 'primereact/inputtext';
import { InputTextarea } from 'primereact/inputtextarea';
import { ListBox } from 'primereact/listbox';
import React from 'react';
import { Skeleton } from 'primereact/skeleton';
import { Toast } from 'primereact/toast';
import { isValid as isValidCnpj } from '@fnando/cnpj';
import { useNavigate } from 'react-router-dom';
import format from 'date-fns/format';
import { storeCustomer, updateCustomer } from '../../services/CustomerService';
import { cities, states } from '../../utils/selects/states';

export default function CustomerForm(props) {
  const Navigate = useNavigate();
  const toast = React.useRef(null);
  const [loading, setLoading] = React.useState(false);
  const [selectedCities, setSelectedCities] = React.useState([]);
  const [displayStreetModal, setDisplayStreetModal] = React.useState(false);
  const [addressResultStreetSearch, setAddressResultStreetSearch] =
    React.useState(false);
  const [address, setAddress] = React.useState(null);

  const { formData, editingMode, restrictMode, rules, customerType } = props;

  const customer = formData;
  const isEditingMode = editingMode;
  const isRestrictMode = restrictMode;

  const defaultValues = {
    documentNumber: null,
    companyName: '',
    fantasyName: '',
    identificationName: '',
    state: '',
    city: '',
    zipCode: null,
    street: '',
    number: '',
    neighborhood: '',
    complement: '',
    notes: '',
  };

  const {
    control,
    formState: { errors },
    handleSubmit,
    reset,
    setValue,
    getValues,
    setFocus,
  } = useForm({ defaultValues });

  function setStateAndCity(stateUf, cityName) {
    if (stateUf === '' && cityName === '') {
      return;
    }

    console.log('setStateAndCity', stateUf, cityName);

    setValue(
      'state',
      states.find((state) => state.sigla === stateUf)
    );

    setSelectedCities(cities[stateUf]);
    const city = cities[stateUf].find(
      (cityItem) =>
        cityItem.nome
          .toLowerCase()
          .normalize('NFD')
          .replace(/[\u0300-\u036f]/g, '') ===
        cityName
          .toLowerCase()
          .normalize('NFD')
          .replace(/[\u0300-\u036f]/g, '')
    );
    setValue('city', city.nome);
  }

  React.useEffect(() => {
    if (!customer) {
      setLoading(true);
      return;
    }

    setSelectedCities([customer.city]);
    setValue('documentNumber', customer.documentNumber);
    setValue('companyName', customer.companyName);
    setValue('fantasyName', customer.fantasyName);
    setValue('identificationName', customer.identificationName);
    setValue('zipCode', customer.zipcode);
    setValue('street', customer.street);
    setValue('number', customer.number);
    setValue('neighborhood', customer.neighborhood);
    setValue('complement', customer.complement);
    setValue('notes', customer.notes ?? '');

    setStateAndCity(customer.state, customer.city);
    setLoading(false);
  }, [customer]);

  const handleSubmitUpdate = (data) => {
    setLoading(true);

    const customerData = {
      companyName: data.companyName,
      fantasyName: data.fantasyName,
      identificationName: data.identificationName,
      state: data.state.sigla,
      city: data.city,
      zipCode: data.zipCode,
      street: data.street,
      number: data.number,
      neighborhood: data.neighborhood,
      complement: data.complement,
      notes: data.notes,
    };

    updateCustomer(customer.id, customerData)
      .then((response) => {
        toast.current.show({
          severity: 'success',
          summary: 'Sucesso',
          detail: 'Cliente atualizado com sucesso',
        });
        console.log(response);
      })
      .catch((error) => {
        console.error(error);
        toast.current.show({
          severity: 'error',
          summary: 'Erro ao atualizar o cliente',
          detail: error?.message,
        });
      })
      .finally(() => {
        setLoading(false);
      });
  };

  const handleSubmitCreate = (data) => {
    setLoading(true);

    const customerData = {
      documentNumber: data.documentNumber,
      companyName: data.companyName,
      fantasyName: data.fantasyName,
      identificationName: data.identificationName,
      state: data.state.sigla,
      city: data.city,
      zipCode: data.zipCode,
      street: data.street,
      number: data.number,
      neighborhood: data.neighborhood,
      complement: data.complement,
      notes: data.notes,
    };
    // TODO: REAFACTOR THIS TO USE REACT QUERY
    storeCustomer(customerData)
      .then((response) => {
        toast.current.show({
          severity: 'success',
          summary: 'Sucesso',
          detail: 'Cliente cadastrado com sucesso',
        });
        reset(defaultValues);
        console.log(response);
      })
      .catch((error) => {
        console.error(error);
        toast.current.show({
          severity: 'error',
          summary: 'Erro ao cadastrar cliente',
          detail: error?.message,
        });
      })
      .finally(() => {
        setLoading(false);
      });
  };

  const onSubmit = (data) => {
    if (isEditingMode) {
      return handleSubmitUpdate(data);
    }

    return handleSubmitCreate(data);
  };

  const stateTemplate = (option) => (
    <div>
      {option.nome} ({option.sigla})
    </div>
  );

  const onStateChange = (e) => {
    setValue('state', e.target.value);
    setSelectedCities(cities[e.target.value.sigla]);
  };

  const cloneNames = () => {
    const companyName = getValues('companyName');

    setValue('fantasyName', companyName);
    setValue('identificationName', companyName);
  };

  function fillFormData(company, cnpj) {
    setLoading(true);

    reset();

    const fantasyName =
      company.fantasyName === ''
        ? company.companyName
        : company.fantasyName;
    const zipCode = company.zipCode.replace(/(\d{5})(\d{3})/, '$1-$2');

    setValue('documentNumber', cnpj);
    setValue('companyName', company.companyName);
    setValue('fantasyName', fantasyName);
    setValue('identificationName', fantasyName);
    setValue('zipCode', zipCode);
    setValue('street', company.street);
    setValue('number', company.number);
    setValue('complement', company.complement);
    setValue('neighborhood', company.neighborhood);

    setStateAndCity(company.state, company.city);

    setLoading(false);
  }

  const searchCNPJ = async () => {
    let cnpj = getValues('documentNumber');

    if (cnpj?.length === 18) {
      cnpj = cnpj.replace(/\.|\-|\//g, ''); //eslint-disable-line
    }

    setLoading(true);

    const backendURL = process.env.REACT_APP_API_URL;

    await fetch(`${backendURL}/cnpj/${cnpj}`)
      .then((response) => {
        if (response.ok) {
          return response.json();
        }

        response.json().then((data) => {
          toast.current.show({
            severity: 'warn',
            summary: 'Erro ao consultar',
            detail: data?.message,
          });
        });

        throw new Error();
      })
      .then((responseJson) => {

        let lastUpdatedAtFormatted = responseJson?.lastUpdateAt;
        if (lastUpdatedAtFormatted) {
          lastUpdatedAtFormatted = format(
            new Date(lastUpdatedAtFormatted),
            'dd/MM/yyyy',
          );
        }

        toast.current.show({
          severity: 'success',
          summary: 'Sucesso',
          life: 9999999,
          detail: `Consulta de CNPJ realizado com sucesso, via ${responseJson?.source} ultima atualização em ${lastUpdatedAtFormatted}`,
        });

        console.debug('[DEBUG] Resposta da API CNPJ com succeso', responseJson);
        fillFormData(responseJson, cnpj);
      })
      .catch((error) => {
        console.error(error);
      })
      .finally(() => {
        setLoading(false);
      });
  };

  async function handleSearchZipCode() {
    let zipCode = getValues('zipCode');

    if (!zipCode || zipCode.includes('_') || !zipCode.length > 9) {
      toast.current.show({
        severity: 'warn',
        summary: 'Aviso',
        detail: 'CEP inválido para consulta',
      });

      return;
    }

    if (zipCode?.length === 9) {
      zipCode = zipCode.replace(/\.|\-|\//g, ''); //eslint-disable-line
    }

    await fetch(`https://brasilapi.com.br/api/cep/v1/${zipCode}`)
      .then((response) => {
        if (response.ok) {
          return response.json();
        }

        response.json().then((data) => {
          toast.current.show({
            severity: 'error',
            summary: 'Erro ao consultar o CEP',
            detail: data?.message,
          });
        });

        throw new Error();
      })
      .then((responseJson) => {
        setValue('street', responseJson.street);
        setValue('neighborhood', responseJson.neighborhood);
        setStateAndCity(responseJson.state, responseJson.city);

        setFocus('number');

        toast.current.show({
          severity: 'success',
          summary: 'Sucesso',
          detail: 'CEP consultado com exito!',
        });
      })
      .catch((error) => {
        console.error('[DEBUG] Erro ao consultar a API CEP', error);
      });
  }

  function onEnterPress(event, action) {
    if (event.key === 'Enter') {
      event.preventDefault();
      action(event);
    }
  }

  async function searchStreet(e) {
    e.preventDefault();

    const street = getValues('street');
    const neighborhood = getValues('neighborhood');
    const city = getValues('city');
    const state = getValues('state');

    if (street === '' || city === '' || state?.sigla === '') {
      toast.current.show({
        severity: 'warn',
        summary: 'Preencha os campos',
        detail: 'Rua/Avenida, Cidade e Estado',
      });
      return;
    }

    if (street?.length < 3) {
      toast.current.show({
        severity: 'warn',
        summary: 'Preencha os campos',
        detail: 'Rua deve ter mais de 3 caracteres',
      });
      return;
    }

    setLoading(true);

    console.debug(
      '[DEBUG] Searching by parameters:',
      street,
      neighborhood,
      city,
      state?.sigla
    );

    const apiSerachStreetURL = `https://viacep.com.br/ws/${state?.sigla}/${city}/${street}/json/`;

    await fetch(apiSerachStreetURL)
      .then((response) => {
        if (response.ok) {
          return response.json();
        }

        response.json().then((data) => {
          toast.current.show({
            severity: 'error',
            summary: 'Erro ao consultar o CEP Reverso ',
            detail: data?.message,
          });
        });

        throw new Error();
      })
      .then((responseJson) => {
        console.debug(
          '[DEBUG] Resposta da API CEP Reverso com succeso',
          responseJson
        );

        if (responseJson.length === 0) {
          toast.current.show({
            severity: 'warn',
            summary: 'Aviso',
            detail: 'Nenhum resultado encontrado',
          });
          return;
        }

        setDisplayStreetModal(true);
        setAddressResultStreetSearch(responseJson);
      })
      .catch((error) => {
        console.error('[DEBUG] Erro ao consultar API CEP Reverso', error);
        toast.current.show({
          severity: 'error',
          summary: 'Erro ao consultar o CEP Reverso',
          detail: error?.message,
          life: 9999999,
        });
      })
      .finally(() => {
        setLoading(false);
      });
  }

  const onHideSearchModalFooter = () => {
    setDisplayStreetModal(false);
    setAddress(null);
  };

  const applyAddress = () => {
    setValue('zipCode', address.cep);
    setValue('street', address.logradouro);
    setValue('neighborhood', address.bairro);
    setStateAndCity(address.uf, address.localidade);

    setDisplayStreetModal(false);
    setAddress(null);

    setFocus('number');

    toast.current.show({
      severity: 'success',
      summary: 'Sucesso',
      detail: 'Endereço selecionado com exito!',
    });
  };

  const SearchModalFooter = (
    <div>
      <Button
        className="p-button-sm"
        label="Aplicar este endereço"
        icon="pi pi-check"
        onClick={applyAddress}
        disabled={address === null || address === undefined}
      />
      <Button
        className="p-button-sm"
        label="Cancelar"
        icon="pi pi-times"
        onClick={onHideSearchModalFooter}
      />
    </div>
  );

  const addressItemTemplate = (option) => (
    <div>
      <h2 className="text-bold text-lg">{option.cep}</h2>
      <p className="text-md"> Rua: {option.logradouro}</p>
      <p className="text-md"> Bairro: {option.bairro}</p>

      {option.complemento !== '' && (
        <p className="text-md"> Complemento: {option.complemento}</p>
      )}

      <p className="text-sm">
        
        {option.localidade} - {option.uf}
      </p>
    </div>
  );

  const enterKeyPrevent = (event) => {
    if (event.key === 'Enter') {
      event.preventDefault();
    }
  };

  return (
    <section>
      <Dialog
        draggable={false}
        maximizable
        header="Resultados da sua pesquisa"
        visible={displayStreetModal}
        style={{ width: '50vw' }}
        footer={SearchModalFooter}
        onHide={onHideSearchModalFooter}
      >
        <ListBox
          value={address}
          itemTemplate={addressItemTemplate}
          options={addressResultStreetSearch}
          onChange={(e) => setAddress(e.value)}
        />
      </Dialog>
      <Toast ref={toast} />
      <h2 className="mb-1 text-2xl font-semibold text-gray-700 dark:text-jett-200">
        <span>
          {isEditingMode ? 'Edição de Cliente' : 'Cadastro de Cliente'}
        </span>
      </h2>
      <h4 className="mb-4 text-xl font-semibold text-gray-600 dark:text-gray-300">
        Pessoa {customerType.name}
        {!isRestrictMode && (
          <span className="text-gray-600 dark:text-gray-300">
            - Sem restrições
          </span>
        )}
      </h4>

      <form onSubmit={handleSubmit(onSubmit)}>
        <div className="grid md:grid-cols-2 gap-4">
          <label className="block">
            <span className="text-gray-700 text-md dark:text-astro-100 text-md">
              
              Documento de Identificação
            </span>
            {loading ? (
              <Skeleton className="w-full block mt-2" height="41px" />
            ) : (
              <div className="p-inputgroup mt-2">
                <Controller
                  name="documentNumber"
                  control={control}
                  rules={rules.documentNumber}
                  render={({ field }) => (
                    <>
                      <InputMask
                        unmask
                        id={field.documentNumber}
                        {...field}
                        autoClear={false}
                        mask={customerType.documentNumberMask}
                        placeholder={customerType.documentNumberPlaceholder}
                        disabled={loading}
                        onKeyPress={(e) => {
                          onEnterPress(e, searchCNPJ);
                        }}
                      />
                      {customerType.name === 'Fisica' ? (
                        <Button
                          disabled={loading}
                          icon="pi pi-arrow-circle-left"
                          className="p-button-sm p-button-secondary"
                          onClick={(e) => {
                            e.preventDefault();
                            setValue('documentNumber', '00000000000');
                          }}
                        />
                      ) : (
                        <Button
                          disabled={loading}
                          icon="pi pi-search"
                          className="p-button-sm p-button-secondary"
                          onClick={(e) => {
                            e.preventDefault();
                            searchCNPJ();
                          }}
                        />
                      )}
                    </>
                  )}
                />
              </div>
            )}
            {errors.documentNumber &&
              errors.documentNumber.type === 'required' && (
                <p className="text-red-400 text-sm">Este campo é obrigatorio</p>
              )}
            {errors.documentNumber &&
              errors.documentNumber.type === 'validate' && (
                <p className="text-red-400 text-sm">
                  O CNPJ informado não é valido
                </p>
              )}
          </label>
          <label className="block">
            <span className="text-gray-700 dark:text-astro-100 text-md">
              
              Razão social
            </span>
            {loading ? (
              <Skeleton className="w-full block mt-2" height="41px" />
            ) : (
              <div className="p-inputgroup mt-2">
                <Controller
                  name="companyName"
                  control={control}
                  rules={{ required: 'Este campo é obrigatorio' }}
                  render={({ field }) => (
                    <InputText
                      id={field.companyName}
                      {...field}
                      className="block w-full mt-2"
                      placeholder="Razão social do Cliente"
                      onKeyPress={enterKeyPrevent}
                    />
                  )}
                />
                <Button
                  disabled={loading}
                  icon="pi pi-clone"
                  className="p-button-sm p-button-secondary"
                  onClick={(e) => {
                    e.preventDefault();
                    cloneNames();
                  }}
                />
              </div>
            )}
            <p className="text-red-400 text-sm">
              {errors.companyName && errors.companyName.message}
            </p>
          </label>
          <label className="block">
            <span className="text-gray-700 dark:text-astro-100 text-md">
              
              Nome Fantasia
            </span>
            {loading ? (
              <Skeleton className="w-full block mt-2" height="41px" />
            ) : (
              <Controller
                name="fantasyName"
                control={control}
                rules={rules.fantasyName}
                render={({ field }) => (
                  <InputText
                    id={field.fantasyName}
                    {...field}
                    className="block w-full mt-2"
                    placeholder="Nome da empresa/marca"
                    onKeyPress={enterKeyPrevent}
                  />
                )}
              />
            )}
            <p className="text-red-400 text-sm">
              {errors.fantasyName && 'Este campo é obrigatorio'}
            </p>
          </label>
          <label className="block">
            <span className="text-gray-700 dark:text-astro-100 text-md">
              
              Nome de identificação
            </span>
            {loading ? (
              <Skeleton className="w-full block mt-2" height="41px" />
            ) : (
              <Controller
                name="identificationName"
                control={control}
                rules={rules.identificationName}
                render={({ field }) => (
                  <InputText
                    id={field.identificationName}
                    {...field}
                    className="block w-full mt-2"
                    placeholder="Nome de identificação"
                    onKeyPress={enterKeyPrevent}
                  />
                )}
              />
            )}
            <p className="text-red-400 text-sm">
              {errors.identificationName && 'Este campo é obrigatorio'}
            </p>
          </label>
        </div>

        <div className="my-6">
          <div className="grid md:grid-cols-5 sm:grid-cols-2 gap-4">
            <label className="block col-span-2">
              <span className="text-gray-700 text-md dark:text-astro-100 text-md">
                
                CEP
              </span>
              {loading ? (
                <Skeleton className="w-full block mt-2" height="41px" />
              ) : (
                <Controller
                  name="zipCode"
                  control={control}
                  rules={rules.zipCode}
                  render={({ field }) => (
                    <div
                      className="p-inputgroup mt-2"
                      onKeyPress={(e) => {
                        onEnterPress(e, handleSearchZipCode);
                      }}
                    >
                      <InputMask
                        unmask
                        id={field.zipCode}
                        {...field}
                        autoClear={false}
                        mask="99999-999"
                        placeholder="CEP"
                        onKeyPress={(e) => {
                          onEnterPress(e, handleSearchZipCode);
                        }}
                      />
                      <Button
                        icon="pi pi-search"
                        className="p-button-sm p-button-secondary"
                        onClick={(e) => {
                          e.preventDefault();
                          handleSearchZipCode();
                        }}
                      />
                    </div>
                  )}
                />
              )}
              <p className="text-red-400 text-sm">
                {errors.zipCode && 'Este campo é obrigatorio'}
              </p>
            </label>

            <label className="block">
              <span className="text-gray-700 dark:text-astro-100 text-md">
                
                Estado
              </span>
              {loading ? (
                <Skeleton className="w-full block mt-2" height="41px" />
              ) : (
                <div className="block w-full mt-2">
                  <Controller
                    name="state"
                    control={control}
                    rules={rules.state}
                    render={({ field }) => (
                      <Dropdown
                        id={field.state}
                        {...field}
                        className="w-full"
                        options={states}
                        onChange={onStateChange}
                        optionLabel="sigla"
                        itemTemplate={stateTemplate}
                        placeholder="UF"
                        appendTo="self"
                        filter
                      />
                    )}
                  />
                </div>
              )}
              <p className="text-red-400 text-sm">
                {errors.state && 'Este campo é obrigatorio'}
              </p>
            </label>

            <label className="block col-span-2">
              <span className="text-gray-700 dark:text-astro-100 text-md">
                
                Cidade
              </span>
              {loading ? (
                <Skeleton className="w-full block mt-2" height="41px" />
              ) : (
                <div className="block w-full mt-2">
                  <Controller
                    name="city"
                    control={control}
                    rules={rules.city}
                    render={({ field }) => (
                      <Dropdown
                        id={field.city}
                        {...field}
                        optionValue="nome"
                        optionLabel="nome"
                        className="w-full"
                        options={selectedCities}
                        placeholder={
                          getValues('state') !== ''
                            ? 'Selecione a Cidade'
                            : 'Selecione um estado primeiro'
                        }
                        disabled={getValues('state') === ''}
                        appendTo="self"
                        filter
                      />
                    )}
                  />
                </div>
              )}
              <p className="text-red-400 text-sm">
                {errors.city && 'Este campo é obrigatorio'}
              </p>
            </label>
          </div>
          <div className="grid md:grid-cols-6 sm:grid-cols-2 gap-4 mt-4">
            <label className="block col-span-3">
              <span className="text-gray-700 dark:text-astro-100 text-md">
                
                Rua/Avenida
              </span>
              {loading ? (
                <Skeleton
                  className="w-full block mt-2 rounded-md"
                  height="41px"
                />
              ) : (
                <div className="p-inputgroup mt-2">
                  <Controller
                    name="street"
                    control={control}
                    rules={rules.street}
                    render={({ field }) => (
                      <InputText
                        id={field.street}
                        {...field}
                        className="block w-full mt-2"
                        onKeyPress={(e) => {
                          onEnterPress(e, searchStreet);
                        }}
                        placeholder="Rua/Avenida"
                      />
                    )}
                  />
                  <Button
                    disabled={loading}
                    icon="pi pi-search"
                    className="p-button-sm p-button-secondary"
                    onClick={(e) => {
                      searchStreet(e);
                    }}
                  />
                </div>
              )}
              <p className="text-red-400 text-sm">
                {errors.street && 'Este campo é obrigatorio'}
              </p>
            </label>

            <label className="block">
              <span className="text-gray-700 dark:text-astro-100 text-md">
                
                Numero
              </span>
              {loading ? (
                <Skeleton className="w-full block mt-2" height="41px" />
              ) : (
                <Controller
                  name="number"
                  control={control}
                  rules={rules.number}
                  render={({ field }) => (
                    <InputText
                      id={field.number}
                      {...field}
                      className="block w-full mt-2"
                      placeholder="Numero"
                      onKeyPress={enterKeyPrevent}
                    />
                  )}
                />
              )}
              <p className="text-red-400 text-sm">
                {errors.number && 'Este campo é obrigatorio'}
              </p>
            </label>

            <label className="block col-span-2">
              <span className="text-gray-700 dark:text-astro-100 text-md">
                
                Bairro
              </span>
              {loading ? (
                <Skeleton className="w-full block mt-2" height="41px" />
              ) : (
                <Controller
                  name="neighborhood"
                  control={control}
                  rules={rules.neighborhood}
                  render={({ field }) => (
                    <InputText
                      id={field.neighborhood}
                      value={field.neighborhood}
                      {...field}
                      className="block w-full mt-2"
                      placeholder="Bairro"
                      onKeyPress={enterKeyPrevent}
                    />
                  )}
                />
              )}
              <p className="text-red-400 text-sm">
                {errors.neighborhood && 'Este campo é obrigatorio'}
              </p>
            </label>

            <label className="block col-span-6">
              <span className="text-gray-700 dark:text-astro-100 text-md">
                
                Complemento
              </span>
              {loading ? (
                <Skeleton className="w-full block mt-2" height="41px" />
              ) : (
                <Controller
                  name="complement"
                  control={control}
                  rules={rules.complement}
                  render={({ field }) => (
                    <InputText
                      id={field.complement}
                      {...field}
                      className="block w-full mt-2"
                      placeholder="Complemento (Opcional)"
                      onKeyPress={enterKeyPrevent}
                    />
                  )}
                />
              )}
              {errors.complement && errors.complement.type === 'maxLength' && (
                <p className="text-red-400 text-sm">
                  O campo contem caractéres demais
                </p>
              )}
            </label>
          </div>
        </div>

        <div className="mb-6">
          <label>
            <span className="text-gray-700 text-md dark:text-astro-100 block mb-4">
              Notas sobre Cliente
            </span>
            {loading ? (
              <Skeleton className="w-full block mt-2" height="84.734px" />
            ) : (
              <Controller
                name="notes"
                control={control}
                rules={rules.notes}
                render={({ field }) => (
                  <InputTextarea
                    id={field.notes}
                    {...field}
                    className="block w-full mt-2"
                    rows={3}
                    placeholder="Notas sobre Cliente (Opcional)"
                  />
                )}
              />
            )}
            {errors.notes && errors.notes.type === 'maxLength' && (
              <p className="text-red-400 text-sm">
                O campo contem caractéres demais
              </p>
            )}
          </label>
        </div>

        <div className="flex justify-between">
          <div>
            <Button
              label={isEditingMode ? 'Atualizar' : 'Cadastrar'}
              className="mr-4"
              type="submit"
            />
            <Button
              label="Voltar"
              className="p-button-secondary"
              onClick={(e) => {
                e.preventDefault();
                Navigate('/customers');
              }}
            />
          </div>
          <div>
            <Button
              label="Visualizar Reponsável"
              className="p-button-secondary mr-4"
              onClick={(e) => {
                e.preventDefault();
              }}
            />
            <Button
              label="Limpar"
              className="p-button-secondary"
              onClick={(e) => {
                e.preventDefault();
                reset(defaultValues);
              }}
            />
          </div>
        </div>
      </form>
    </section>
  );
}
