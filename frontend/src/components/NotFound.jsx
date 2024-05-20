import React from 'react';
import { Link } from 'react-router-dom';

function NotFound() {
  return (
    <div className="bg-astro-800 w-screen h-screen flex justify-center items-center">
      <div className="container flex flex-col items-center px-6 mx-auto ">
        <svg
          className="w-12 h-12 mt-8 text-green-300"
          fill="currentColor"
          viewBox="0 0 20 20"
        >
          <path
            fillRule="evenodd"
            d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
            clipRule="evenodd"
          />
        </svg>
        <h1 className="text-6xl font-semibold text-gray-700 dark:text-gray-200">
          404
        </h1>
        <p className="text-gray-700 dark:text-gray-300">
          Página não encontrada. Verifique o endereço ou volte para a
          <Link
            to="/"
            className="hover:underline text-green-300 hover:text-skye-400"
          >
            página inicial
          </Link>
          .
        </p>
      </div>
    </div>
  );
}

export default NotFound;
