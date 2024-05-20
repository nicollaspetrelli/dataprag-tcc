/* eslint-disable no-shadow */
import React, { useState } from 'react';
import handleValidate from './validations';

function InputField({
  name,
  label,
  type,
  placeholder,
  className,
  required,
  state,
}) {
  const [message, setMessage] = useState('');

  const handleChange = (e) => {
    const { value } = e.target;
    state.setText(value);

    const { error, message } = handleValidate(name, value);

    if (error) {
      state.setError(true);
      setMessage(message);
    }

    if (!error) {
      state.setError(false);
      setMessage('');
    }
  };

  const handleKeyPress = (e) => {
    if (e.key === 'Enter') {
      if (state.text === '' && required === true) {
        state.setError(true);
        setMessage('Campo obrigatório');
      }

      if (state.error) {
        state.setError(true);
        setMessage(message);
      }
    }
  };

  return (
    <label className={`block text-sm ${className}` ?? ''}>
      <span className="text-gray-700 dark:text-astro-100">{label}</span>
      <input
        className={`
                    w-full
                    h-10
                    px-3
                    mt-1
                    text-sm text-gray-700
                    placeholder-gray-600
                    border
                    rounded-md
                    focus:outline-none
                    focus:ring
                    focus:ring-opacity-25
                    dark:text-astro-100
                    dark:placeholder-astro-100
                    dark:bg-astro-700
                    dark:border-astro-200
                    dark:focus:ring-opacity-30 ${
                      state.error
                        ? ' focus:ring-red-600 focus:border-red-500 dark:focus:ring-red-500 dark:focus:border-red-600'
                        : 'focus:ring-skye-600 focus:border-green-500 dark:focus:ring-green-500 dark:focus:border-skye-600'
                    }`}
        name={name}
        type={type}
        value={state.text}
        placeholder={placeholder}
        required={required}
        onKeyPress={(e) => handleKeyPress(e)}
        onChange={(e) => handleChange(e)}
      />
      {state.error && (
        <span className="text-red-600 dark:text-red-400">{message}</span>
      )}
    </label>
  );
}

export default InputField;
