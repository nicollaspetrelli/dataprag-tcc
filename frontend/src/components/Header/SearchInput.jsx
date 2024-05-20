import React from 'react';
import * as HeroIcons from 'react-icons/hi';

export default function SearchInput({ value, onChange, placeholder }) {
  return (
    <div className="relative w-full max-w-xl mr-6 focus-within:text-skye-600">
      <div className="absolute inset-y-0 flex items-center pl-2">
        <HeroIcons.HiSearch size="1.3em" />
      </div>
      <input
        className="
                w-full
                h-10
                px-3
                pl-8
                text-sm text-gray-700
                placeholder-gray-600
                rounded-md
                focus:outline-none
                focus:ring
                focus:ring-green-600
                focus:ring-opacity-25
                focus:border-green-500
                dark:text-astro-100
                dark:placeholder-astro-100
                dark:bg-astro-700
                dark:focus:ring-green-500
                dark:focus:ring-opacity-30
                dark:focus:border
                dark:focus:border-skye-600
            "
        onChange={onChange}
        value={value}
        type="text"
        placeholder={placeholder}
      />
    </div>
  );
}
