/* eslint-disable react/no-array-index-key */
import React from 'react';

export default function Tabs(props) {
  const { items } = props;
  const { activeIndex } = props;
  const { setActiveIndex } = props;

  return (
    <ul className="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-row w-full">
      {/* foreach items */}
      {items.map((Item, index) => (
        <li
          className="-mb-px mr-2 last:mr-0 flex-auto text-center w-1/5"
          key={index}
        >
          <button
            type="button"
            onClick={() => {
              setActiveIndex(index);
            }}
            className={`
                    ${
                      activeIndex === index
                        ? 'text-white bg-skye-600 '
                        : ' bg-white text-skye-600 dark:bg-astro-800 dark:text-white'
                    }
                    flex
                    items-center
                    justify-center
                    text-sm
                    font-bold
                    uppercase
                    px-5
                    py-3
                    shadow-sm
                    rounded
                    leading-normal
                    w-full
                    no-wrap
                    no-break
                    ${
                      Item.disabled
                        ? 'cursor-not-allowed opacity-50'
                        : 'cursor-pointer opacity-100'
                    }
                `}
            disabled={Item.disabled}
          >
            {activeIndex === index ? Item.selectedIcon : Item.icon}
            &nbsp; {Item.title}
          </button>
        </li>
      ))}
    </ul>
  );
}
