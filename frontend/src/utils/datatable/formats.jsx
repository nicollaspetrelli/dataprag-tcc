/* eslint-disable jsx-a11y/click-events-have-key-events */
/* eslint-disable jsx-a11y/no-static-element-interactions */
/* eslint-disable react/no-array-index-key */
/* eslint-disable react/jsx-no-useless-fragment */
import { Tooltip } from 'primereact/tooltip';
import React from 'react';
import * as HeroIcons from 'react-icons/hi';

/* Date and DateTime Formats  */

const formatDate = (value) => {
  const date = new Date(value);

  return date.toLocaleDateString('pt-BR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
  });
};

const formatDateTime = (value) => {
  const date = new Date(value);

  return date.toLocaleDateString('pt-BR', {
    day: '2-digit',
    month: '2-digit',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
};

/* Customer or Clients Formats  */

const customerTypeTemplate = (type) => (
  <>
    {type === 0 ? (
      <span className="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-skye-700 dark:text-green-100">
        Jurídica
      </span>
    ) : (
      <span className="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-skye-700 dark:text-green-100">
        Fisica
      </span>
    )}
  </>
);

const cityAndStateTemplate = (city, state) => (
  <p>
    {city} - {state}
  </p>
);

const companyNameTemplate = (companyName, fantasyName, identificationName) => (
  <>
    <Tooltip
      className="fixed"
      target=".socialName"
      appendTo={this}
      position="bottom"
    />

    <p className="font-semibold">{companyName}</p>
    <p
      className="text-xs socialName"
      data-pr-tooltip={`Nome Fantasia: ${fantasyName}`}
    >
      {identificationName}
    </p>
  </>
);

const addressTemplate = (street, number, neighborhood) => (
  <>
    <p className="font-semibold">
      {street}, {number}
    </p>
    <p className="text-xs">{neighborhood}</p>
  </>
);

/* Services Formats  */

const serviceTypeIdentifierLabel = (documentId) => {
  switch (documentId) {
    case 1:
      return 'Dedetização';
    case 2:
      return 'Desratização';
    case 3:
      return 'Desinfecção de Caixa D’água';
    default:
      return 'Não identificado';
  }
};

const serviceStatusTemplate = (status) => {
  let statusLabel = 'Pendente';
  let textColor = 'text-cyan-100';
  let bgColor = 'bg-cyan-700';
  let message = 'O status desse serviço ainda não foi processado. Aguarde.';

  if (status === 1) {
    statusLabel = 'Contrato Ativo';
    textColor = 'text-green-100';
    bgColor = 'bg-green-700';
    message = 'O serviço não está vencido e nem próximo a vencer.';
  }

  if (status === 2) {
    statusLabel = 'Expira em breve';
    textColor = 'text-white';
    bgColor = 'bg-amber-500';
    message =
      'O serviço está próximo a expirar. Verifique a data de vencimento.';
  }

  if (status === 3) {
    statusLabel = 'Expirado';
    textColor = 'text-white';
    bgColor = 'bg-red-500';
    message =
      'O serviço está vencido e não foi renovado pois não possui serviços precedentes.';
  }

  if (status === 4) {
    statusLabel = 'Finalizado';
    textColor = 'text-jett-200';
    bgColor = 'bg-astro-500';
    message = 'O serviço foi finalizado pois possui serviços precedentes.';
  }

  return (
    <>
      <Tooltip target=".status" position="bottom" />
      <span
        data-pr-tooltip={message}
        className={`
          status
          px-2 
          py-1 
          font-semibold 
          leading-tight 
          ${textColor}
          ${bgColor}
          rounded-full 
        `}
      >
        {statusLabel}
        <HeroIcons.HiQuestionMarkCircle className="inline" size="1.1rem" />
      </span>
    </>
  );
};

const expiredDateTemplate = (dateValidity, expiredStatus) => {
  const dateString = formatDate(dateValidity);

  return dateString;
};

const descriptionTemplate = (description) => {
  if (description === null) {
    return '-';
  }

  if (description.length > 20) {
    const sortDescription = `${description.substring(0, 20)}...`;

    return (
      <>
        <Tooltip target=".description" position="bottom" />
        <span
          className="description"
          data-pr-tooltip={description}
          style={{ userSelect: 'none' }}
        >
          {sortDescription}
        </span>
      </>
    );
  }

  return description;
};

const productsTemplate = (products, id, seeAllState, setSeeAllState) => {
  if (products === null || products.length === 0) {
    return '-';
  }

  const allProducts = products.map((product, index) => (
    <React.Fragment key={index}>
      <span className="whitespace-nowrap px-2 py-1 mr-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-astro-700 dark:text-white">
        {product}
      </span>
    </React.Fragment>
  ));

  if (products.length > 1) {
    return seeAllState !== id ? (
      <>
        <span className="whitespace-nowrap px-2 py-1 mr-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-astro-700 dark:text-white">
          {products[0]}
        </span>

        <span
          onClick={() => {
            setSeeAllState(id);
          }}
          className="whitespace-nowrap px-2 py-1 mr-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-astro-700 dark:text-white"
        >
          Ver mais
        </span>
      </>
    ) : (
      allProducts
    );
  }

  return allProducts;
};

/* Payments and Currency Value Formats  */

const formatCurrency = (value) =>
  new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL',
    minimumFractionDigits: 2,
  }).format(value);

const paymentTemplate = (paymentId) => {
  if (paymentId !== null && paymentId !== undefined) {
    return (
      <span className="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-skye-700 dark:text-green-100">
        Pago
      </span>
    );
  }

  return (
    <span className="px-2 py-1 font-semibold leading-tight text-red-500 bg-red-100 rounded-full dark:bg-red-500 dark:text-white">
      Pendente
    </span>
  );
};

export {
  serviceTypeIdentifierLabel,
  formatDate,
  formatDateTime,
  expiredDateTemplate,
  formatCurrency,
  descriptionTemplate,
  productsTemplate,
  paymentTemplate,
  customerTypeTemplate,
  cityAndStateTemplate,
  companyNameTemplate,
  addressTemplate,
  serviceStatusTemplate,
};
