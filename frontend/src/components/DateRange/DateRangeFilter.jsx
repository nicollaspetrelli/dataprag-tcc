/* eslint-disable react/no-this-in-sfc */
import React, { useState } from 'react';
import { addMonths, isSameDay } from 'date-fns';

import { DateRangePicker } from 'react-date-range';
import { ptBR } from 'date-fns/locale';

function DateRangeFilter({ onChange, date }) {
  const [state, setState] = useState(date);

  const handleOnChange = (ranges) => {
    const { selection } = ranges;
    onChange(selection);
    setState([selection]);
  };

  const sidebarRanges = [
    {
      label: '1 mês',
      range: () => ({
        startDate: state[0]?.startDate,
        endDate: addMonths(state[0]?.startDate, 1),
      }),
      isSelected(range) {
        const definedRange = this.range();
        return (
          isSameDay(range.startDate, definedRange.startDate) &&
          isSameDay(range.endDate, definedRange.endDate)
        );
      },
    },
    {
      label: '2 meses',
      range: () => ({
        startDate: state[0]?.startDate,
        endDate: addMonths(state[0]?.startDate, 2),
      }),
      isSelected(range) {
        const definedRange = this.range();
        return (
          isSameDay(range.startDate, definedRange.startDate) &&
          isSameDay(range.endDate, definedRange.endDate)
        );
      },
    },
    {
      label: '3 meses',
      range: () => ({
        startDate: state[0]?.startDate,
        endDate: addMonths(state[0]?.startDate, 3),
      }),
      isSelected(range) {
        const definedRange = this.range();
        return (
          isSameDay(range.startDate, definedRange.startDate) &&
          isSameDay(range.endDate, definedRange.endDate)
        );
      },
    },
    {
      label: '4 meses',
      range: () => ({
        startDate: state[0]?.startDate,
        endDate: addMonths(state[0]?.startDate, 4),
      }),
      isSelected(range) {
        const definedRange = this.range();
        return (
          isSameDay(range.startDate, definedRange.startDate) &&
          isSameDay(range.endDate, definedRange.endDate)
        );
      },
    },
    {
      label: '5 meses',
      range: () => ({
        startDate: state[0]?.startDate,
        endDate: addMonths(state[0]?.startDate, 5),
      }),
      isSelected(range) {
        const definedRange = this.range();
        return (
          isSameDay(range.startDate, definedRange.startDate) &&
          isSameDay(range.endDate, definedRange.endDate)
        );
      },
    },
    {
      label: '6 meses',
      range: () => ({
        startDate: state[0]?.startDate,
        endDate: addMonths(state[0]?.startDate, 6),
      }),
      isSelected(range) {
        const definedRange = this.range();
        return (
          isSameDay(range.startDate, definedRange.startDate) &&
          isSameDay(range.endDate, definedRange.endDate)
        );
      },
    },
    {
      label: '1 ano',
      range: () => ({
        startDate: state[0]?.startDate,
        endDate: addMonths(state[0]?.startDate, 12),
      }),
      isSelected(range) {
        const definedRange = this.range();
        return (
          isSameDay(range.startDate, definedRange.startDate) &&
          isSameDay(range.endDate, definedRange.endDate)
        );
      },
    },
  ];

  return (
    <DateRangePicker
      onChange={handleOnChange}
      showMonthAndYearPickers={false}
      moveRangeOnFirstSelection={false}
      months={2}
      ranges={state}
      direction="horizontal"
      staticRanges={sidebarRanges}
      locale={ptBR}
      dateDisplayFormat="dd/MM/yyyy"
      editableDateInputs
      weekdayDisplayFormat="EEEEEE"
      monthDisplayFormat="MMMM"
      showPreview={false}
      inputRanges={[]}
      rangeColors={['#38a169']}
    />
  );
}

export default DateRangeFilter;
