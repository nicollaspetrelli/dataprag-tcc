// import React, { useState } from 'react';
import * as HeroIcons from 'react-icons/hi';

function ChangeTheme() {
  // const [theme, setTheme] = useState(localStorage.getItem('theme') ?? 'light');
  const theme = 'dark';

  // function toggleTheme() {
  //   if (theme === 'dark') {
  //     localStorage.setItem('theme', 'light');
  //     document.body.classList.remove('dark');
  //     setTheme('light');
  //   } else {
  //     localStorage.setItem('theme', 'dark');
  //     document.body.classList.add('dark');
  //     setTheme('dark');
  //   }
  // }

  return (
    <button
      type='button'
      className="fade flex items-center justify-center w-full px-4 py-2 text-sm font-medium leading-5 text-gray-700 transition-colors duration-150 border border-gray-300 rounded-lg dark:text-gray-400 active:bg-transparent hover:border-gray-500 focus:border-gray-500 active:text-gray-500 focus:outline-none focus:shadow-outline-gray"
      aria-label="Toggle color mode"
      // onClick={toggleTheme}
    >
      <div className="rounded-md focus:outline-none focus:shadow-outline-green">
        {theme === 'dark' ? (
          <HeroIcons.HiSun size="1.2em" />
        ) : (
          <HeroIcons.HiMoon size="1.2em" />
        )}
      </div>
      <span>Alterar Tema</span>
    </button>
  );
}

export default ChangeTheme;
