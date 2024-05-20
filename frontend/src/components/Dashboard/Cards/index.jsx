import React from 'react';
import CountUp from 'react-countup';
import { Skeleton } from 'primereact/skeleton';

function Cards(props) {
  const { icon, title, subtitle, count, color, loading, currency } = props;

  const animationDurationInSecounds = 4;

  if (loading) {
    return (
      <div className="w-full">
        <Skeleton height="6.6em" />
      </div>
    );
  }

  return (
    <div className="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-astro-800">
      <div
        className={`p-3 mr-4 text-${color}-500 bg-${color}-100 rounded-full dark:text-${color}-100 dark:bg-${color}-500`}
      >
        {icon}
      </div>
      <div>
        <p className="text-sm font-medium text-gray-600 dark:text-jett-200">
          {title}
        </p>
        <p className="countable text-lg font-semibold text-gray-700 dark:text-jett-200">
          <CountUp
            end={count}
            duration={animationDurationInSecounds}
            {...(currency === true && {
              decimals: 2,
              decimal: ',',
              separator: '.',
              prefix: 'R$ ',
            })}
          />
        </p>
        {subtitle && <p className="text-xs text-astro-100">{subtitle}</p>}
      </div>
    </div>
  );
}

export default Cards;
