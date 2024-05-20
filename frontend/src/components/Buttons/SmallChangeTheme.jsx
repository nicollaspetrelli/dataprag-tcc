// import React, { useState } from 'react';
import * as HeroIcons from 'react-icons/hi';

function SmallChangeTheme() {
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
      type="button"
      className="rounded-md focus:outline-none"
      aria-label="Toggle color mode"
      // onClick={toggleTheme}
    >
      {theme === 'light' ? (
        <HeroIcons.HiMoon size="1.2em" />
      ) : (
        <HeroIcons.HiSun size="1.2em" />
      )}
    </button>
  );
}

export default SmallChangeTheme;
