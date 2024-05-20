import React from 'react';
import { isValid as isValidCnpj } from '@fnando/cnpj';
import * as HeroIcons from 'react-icons/hi';

const CUSTOMER_KIT = {
  individual: {
    name: 'Fisica',
    documentNumberPlaceholder: 'Insira o CPF',
    documentNumberMask: '999.999.999-99',
  },
  legal: {
    name: 'Juridica',
    documentNumberPlaceholder: 'Insira o CNPJ',
    documentNumberMask: '99.999.999/9999-99',
  },
};

const defaultCustomerEmpty = {
  documentNumber: null,
  socialName: '',
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

const ReturnTabItems = (customerType) => [
  {
    type: 'legal',
    title: 'Pessoa Juridica',
    icon: <HeroIcons.HiOutlineOfficeBuilding size="1.5em" />,
    selectedIcon: <HeroIcons.HiOfficeBuilding size="1.5em" />,
    disabled: customerType !== 0,
  },
  {
    type: 'individual',
    title: 'Pessoa Fisica',
    icon: <HeroIcons.HiOutlineUser size="1.5em" />,
    selectedIcon: <HeroIcons.HiUser size="1.5em" />,
    disabled: customerType !== 1,
  },
];

const TabItems = [
  {
    type: 'legal',
    title: 'Pessoa Juridica',
    icon: <HeroIcons.HiOutlineOfficeBuilding size="1.5em" />,
    selectedIcon: <HeroIcons.HiOfficeBuilding size="1.5em" />,
  },
  {
    type: 'individual',
    title: 'Pessoa Fisica',
    icon: <HeroIcons.HiOutlineUser size="1.5em" />,
    selectedIcon: <HeroIcons.HiUser size="1.5em" />,
  },
];

const validateCNPJ = (documentNumber) => isValidCnpj(documentNumber);

const notSafeLegalRules = {
  companyName: {
    required: true,
  },
  fantasyName: {
    required: true,
  },
  identificationName: {
    required: true,
  },
  state: {
    required: true,
  },
  city: {
    required: true,
  },
  zipCode: {
    required: true,
  },
  street: {
    required: true,
  },
  number: {
    required: true,
  },
  neighborhood: {
    required: true,
  },
  complement: {
    maxLength: 190,
  },
  notes: {
    maxLength: 190,
  },
};

const safeLegalRules = {
  documentNumber: {
    required: true,
    validate: validateCNPJ,
  },
  companyName: {
    required: true,
  },
  fantasyName: {
    required: true,
  },
  identificationName: {
    required: true,
  },
  state: {
    required: true,
  },
  city: {
    required: true,
  },
  zipCode: {
    required: true,
  },
  street: {
    required: true,
  },
  number: {
    required: true,
  },
  neighborhood: {
    required: true,
  },
  complement: {
    maxLength: 190,
  },
  notes: {
    maxLength: 190,
  },
};

const legalRules = {
  safe: safeLegalRules,
  notSafe: notSafeLegalRules,
};

const individualRule = {
  documentNumber: {
    required: true,
  },
  companyName: {
    required: true,
  },
  fantasyName: {
    required: true,
  },
  identificationName: {
    required: true,
  },
  state: {
    required: true,
  },
  city: {
    required: true,
  },
  zipCode: {
    required: true,
  },
  street: {
    required: true,
  },
  number: {
    required: true,
  },
  neighborhood: {
    required: true,
  },
  complement: {
    maxLength: 190,
  },
  notes: {
    maxLength: 190,
  },
};

export {
  defaultCustomerEmpty,
  TabItems,
  legalRules,
  individualRule,
  CUSTOMER_KIT,
  ReturnTabItems,
};
