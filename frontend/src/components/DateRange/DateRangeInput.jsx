import 'react-date-range/dist/styles.css';
import '../../styles/react-date-range-theme.css';

import { useEffect, useRef, useState } from 'react';

import { Button } from 'primereact/button';
import { InputText } from 'primereact/inputtext';
import format from 'date-fns/format';
import DateRangeFilter from './DateRangeFilter';

function DateRangeInput({ rangeDate, setRangeDate }) {
  const [placeholder, setPlaceholder] = useState(
    'Selecione um período de datas'
  );
  const [open, setOpen] = useState(false);
  const refOne = useRef(null);

  const hideOnEscape = (e) => {
    if (e.key === 'Escape') {
      setOpen(false);
    }
  };

  const hideOnClickOutside = (e) => {
    if (refOne.current && !refOne.current.contains(e.target)) {
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
    document.addEventListener('click', hideOnClickOutside, true);
  }, []);

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

  return (
    <div className="calendarWrap">
      <div className="p-inputgroup">
        <InputText readOnly placeholder={placeholder} onClick={toggle} />
        <Button
          icon="pi pi-calendar"
          className="p-button-sm p-button-secondary"
          onClick={toggle}
        />
      </div>

      <div ref={refOne}>
        {open && <DateRangeFilter date={rangeDate} onChange={handleSelect} />}
      </div>
    </div>
  );
}

export default DateRangeInput;
