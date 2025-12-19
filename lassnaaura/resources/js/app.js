import './bootstrap';
import '../css/login.css';

import React from 'react';
import { createRoot } from 'react-dom/client';
import Login from './components/Login.jsx';

const mount = document.getElementById('react-root');
if (mount) {
	const root = createRoot(mount);
	root.render(<Login />);
}
