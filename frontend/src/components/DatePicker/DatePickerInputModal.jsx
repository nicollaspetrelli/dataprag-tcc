import 'react-date-range/dist/styles.css';
import '../../styles/react-date-range-theme.css';

import { useEffect, useState } from 'react';

import { Button } from 'primereact/button';
import { InputText } from 'primereact/inputtext';
import { Dialog } from 'primereact/dialog';
import { format } from 'date-fns';
import DatePicker from '.';

function DatePickerInputModal({ date, setDate, inputPlaceholder }) {
  const [placeholder, setPlaceholder] = useState(
    inputPlaceholder ?? 'Selecione uma data'
  );
  const [open, setOpen] = useState(false);

  const renderPlaceholder = (dateSelected) => {
    const startDate = format(dateSelected, 'dd/MM/yyyy');

    setPlaceholder(`${startDate}`);
  };

  useEffect(() => {
    setDate(date);

    if (!inputPlaceholder) renderPlaceholder(date);
  }, [date]);

  const handleSelect = (dateSelected) => {
    setDate(dateSelected);
    renderPlaceholder(dateSelected);
    setOpen(false);
  };

  const toggle = () => {
    setOpen((prevCheck) => !prevCheck);
  };

  const onHideModal = () => {
    setOpen(false);
  };

  const modalHeader = () => (
    <p className="text-gray-700 pl-4 text-sm text-center dark:text-astro-100 block">
      Selecione uma data
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
        draggable={false}
        visible={open}
        className="DatePickerModal"
        header={modalHeader}
        onHide={onHideModal}
        resizable={false}
      >
        <DatePicker date={date} onChange={handleSelect} />
      </Dialog>
    </div>
  );
}

export default DatePickerInputModal;
