import 'react-date-range/dist/styles.css';
import '../../styles/react-date-range-theme.css';

import { useEffect, useState } from 'react';

import { Button } from 'primereact/button';
import { InputText } from 'primereact/inputtext';
import format from 'date-fns/format';
import { Dialog } from 'primereact/dialog';
import DateRangeFilter from './DateRangeFilter';

function DateRangeInputModal({ rangeDate, setRangeDate }) {
  const [placeholder, setPlaceholder] = useState(
    'Selecione um período de datas'
  );
  const [open, setOpen] = useState(false);

  const hideOnEscape = (e) => {
    if (e.key === 'Escape') {
      setOpen(false);
    }
  };

  useEffect(() => {
    setPlaceholder(
      `${format(rangeDate[0].startDate, 'dd/MM/yyyy')} - ${format(
        rangeDate[0].endDate,
        'dd/MM/yyyy'
      )}`
    );

    document.addEventListener('keydown', hideOnEscape, true);
  }, [rangeDate]);

  const renderPlaceholder = (dateRange) => {
    const startDate = format(dateRange?.startDate, 'dd/MM/yyyy');
    const endDate = format(dateRange?.endDate, 'dd/MM/yyyy');

    setPlaceholder(`${startDate} - ${endDate}`);
  };

  const handleSelect = (date) => {
    setRangeDate([date]);
    renderPlaceholder(date);
  };

  const toggle = () => {
    setOpen((prevCheck) => !prevCheck);
  };

  const onHideModal = () => {
    setOpen(false);
  };

  const modalHeader = () => (
    <p className="text-gray-700 pl-8 text-sm text-center dark:text-astro-100 block">
      Selecione um período de datas
    </p>
  );

  return (
    <div className="calendarWrap">
      <div className="p-inputgroup">
        <InputText readOnly placeholder={placeholder} onClick={toggle} />
        <Button
          icon="pi pi-calendar"
          className="p-button-sm p-button-secondary"
          onClick={(e) => {
            e.preventDefault();
            toggle();
          }}
        />
      </div>

      <Dialog
        visible={open}
        className="DateRangeModal"
        header={modalHeader}
        onHide={onHideModal}
      >
        <DateRangeFilter date={rangeDate} onChange={handleSelect} />
      </Dialog>
    </div>
  );
}

export default DateRangeInputModal;
