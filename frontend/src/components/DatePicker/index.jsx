/* eslint-disable react/no-this-in-sfc */
import React, { useState } from 'react';

import { Calendar } from 'react-date-range';
import { ptBR } from 'date-fns/locale';

function DatePicker({ onChange, date }) {
  const [state, setState] = useState(date);

  const handleOnChange = (dateSelected) => {
    onChange(dateSelected);
    setState(dateSelected);
  };

  return (
    <Calendar
      onChange={handleOnChange}
      locale={ptBR}
      dateDisplayFormat="dd/MM/yyyy"
      weekdayDisplayFormat="EEEEEE"
      date={state}
      color="#38a169"
    />
  );
}

export default DatePicker;
