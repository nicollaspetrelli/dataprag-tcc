/* eslint-disable react/destructuring-assignment */
import { Dropdown } from 'primereact/dropdown';
import { Ripple } from 'primereact/ripple';
import { classNames } from 'primereact/utils';
import React from 'react';

const defaultPaginationTemplate = {
  layout:
    'CurrentPageReport RowsPerPageDropdown FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink',
  PrevPageLink: (options) => (
    <button
      type="button"
      className={options.className}
      onClick={options.onClick}
      disabled={options.disabled}
    >
      <span className="p-3">Anterior</span>
      <Ripple />
    </button>
  ),
  NextPageLink: (options) => (
    <button
      type="button"
      className={options.className}
      onClick={options.onClick}
      disabled={options.disabled}
    >
      <span className="p-3">Próximo</span>
      <Ripple />
    </button>
  ),
  PageLinks: (options) => {
    if (
      (options.view.startPage === options.page &&
        options.view.startPage !== 0) ||
      (options.view.endPage === options.page &&
        options.page + 1 !== options.totalPages)
    ) {
      const className = classNames(options.className, { 'p-disabled': true });

      return (
        <span className={className} style={{ userSelect: 'none' }}>
          ...
        </span>
      );
    }

    return (
      <button
        type="button"
        className={options.className}
        onClick={options.onClick}
      >
        {options.page + 1}
        <Ripple />
      </button>
    );
  },
  RowsPerPageDropdown: (options) => {
    const dropdownOptions = [
      { label: 8, value: 8 },
      { label: 10, value: 10 },
      { label: 20, value: 20 },
      { label: 50, value: 50 },
      { label: 'Todos', value: options.totalRecords },
    ];

    return (
      <div className="ml-auto mr-auto">
        <span
          className="text-astro-800 dark:text-jett-200"
          style={{ userSelect: 'none' }}
        >
          Mostrando
        </span>
        <Dropdown
          value={options.value}
          options={dropdownOptions}
          onChange={options.onChange}
          appendTo="self"
        />
        <span
          className="text-astro-800 dark:text-jett-200"
          style={{ userSelect: 'none' }}
        >
          Por página
        </span>
      </div>
    );
  },
};

export default defaultPaginationTemplate;
