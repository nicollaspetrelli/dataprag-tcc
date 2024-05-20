import React from 'react';
import { createRoot } from 'react-dom/client';

/* PrimeReact Components And Theme */
import 'primereact/resources/primereact.min.css';
import 'primeicons/primeicons.css';
import './styles/primereact-theme.css';

/* App Overrides */
import './index.css';

import App from './App';

const container = document.getElementById('root');
const root = createRoot(container);

root.render(
  // <React.StrictMode>
    <App />
  // </React.StrictMode>,
);
