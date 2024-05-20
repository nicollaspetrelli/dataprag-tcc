/* eslint-disable react/no-array-index-key */
import React, { useEffect } from 'react';
import { Link } from 'react-router-dom';
import {
  BsChevronDoubleLeft,
  BsChevronDoubleRight,
} from 'react-icons/bs';
import brand from '../../images/brand.png';
import SidebarData from './data';

export default function SideBar() {
  const currentPath = window.location.pathname;

  const currentIndex = SidebarData.findIndex((item) =>
    currentPath.includes(item.path)
  );

  if (localStorage.getItem('sidebar-open') === null) {
    localStorage.setItem('sidebar-open', true);
  }

  const [selected, setSelected] = React.useState(currentIndex);
  const [open, setOpen] = React.useState(localStorage.getItem('sidebar-open') === true);
  const [fixed, setFixed] = React.useState(
    localStorage.getItem('sidebar-fixed') === 'true'
  );

  // const handleMouseEnter = (state) => {
  //   if (fixed) {
  //     return;
  //   }

  //   if (!state) {
  //     setTimeout(() => {
  //       setOpen(false);
  //     }, 250);
  //     return;
  //   }

  //   setOpen(true);
  // };

  useEffect(() => {
    localStorage.setItem('sidebar-fixed', fixed);
  }, [fixed]);

  return (
    <aside
      className={` ${
        open ? 'w-64 ' : 'w-20 justify-center '
      } bg-white dark:bg-astro-800 h-screen pt-5 relative flex-shrink-0  duration-300 py-4 text-gray-500 dark:text-astro-100`}
      // onMouseEnter={() => handleMouseEnter(true)}
      // onMouseLeave={() => handleMouseEnter(false)}
    >
      <div className="flex gap-x-4 items-center">
        <img
          src={brand}
          width="30"
          className={`cursor-pointer duration-500 ml-6 text-lg font-bold text-gray-800 dark:text-gray-200 ${
            open && 'rotate-[360deg]'
          }`}
          alt="logo"
        />
        <h1
          className={`cursor-pointer ml-0 text-lg font-bold text-gray-800 dark:text-gray-200 origin-left duration-200 ${
            !open && 'scale-0'
          }`}
        >
          Ambientalis
        </h1>
      </div>
      <ul className="mt-6">
        {SidebarData.map((Menu, index) => (
          <li
            key={index}
            className={`relative px-6 py-3 
                ${Menu.gap ? 'mt-9' : 'mt-0'}`}
          >
            {selected === index ? (
              <span
                className="absolute inset-y-0 left-0 w-1 bg-skye-600 rounded-tr-lg rounded-br-lg"
                aria-hidden="true"
              />
            ) : null}

            <Link
              to={Menu.path}
              className={`
                            ${
                              selected === index
                                ? 'text-gray-900 dark:text-gray-200 '
                                : ' '
                            }
                            ${!open ? 'justify-center ' : ' '}
                            inline-flex
                            items-center
                            w-full
                            text-sm
                            font-semibold
                            transition-colors
                            duration-1000
                            hover:text-gray-800
                            dark:hover:text-gray-200
                        `}
              onClick={() => {
                setSelected(index);
              }}
            >
              {selected === index ? Menu.iconOpen : Menu.icon}
              <span
                className={`${
                  !open && 'hidden '
                } ml-4 origin-left duration-200 whitespace-nowrap`}
              >
                {Menu.title}
              </span>
            </Link>
          </li>
        ))}
      </ul>

      <div className="px-4 my-6 absolute bottom-0 w-full">
        <button
          type="button"
          className="flex items-center justify-evenly w-full px-3 py-2 text-sm font-medium text-white transition-colors duration-150 bg-skye-600 border border-transparent rounded-lg active:bg-skye-600 hover:bg-skye-700 focus:outline-none"
          onClick={() => {
            setOpen((prevState) => {
              localStorage.setItem('sidebar-open', !prevState);
              return !prevState;
            });
          }}
        >
          {open ? (
            <BsChevronDoubleLeft size="1.5em" />
          ) : (
            <BsChevronDoubleRight size="1.5em" />
          )}
          <span
            className={`text-md origin-left duration-200 whitespace-nowrap ${
              !open && 'scale-0 hidden'
            }`}
          >
            Minimizar barra lateral
          </span>
        </button>
      </div>
    </aside>
  );
}
