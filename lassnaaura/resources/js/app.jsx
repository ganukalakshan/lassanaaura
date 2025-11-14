import './bootstrap';
import '../css/login.css';

import React from 'react';
import { createRoot } from 'react-dom/client';
import Login from './components/Login';
import Dashboard from './components/Dashboard';
import './bootstrap';

// Mount Login when present
const loginMount = document.getElementById('react-root');
if (loginMount) {
    const root = createRoot(loginMount);
    root.render(<Login />);
}

// Mount Dashboard when present
const dashMount = document.getElementById('dashboard-root');
if (dashMount) {
    // lazy import CSS for dashboard
    import('../css/dashboard.css');
    const root = createRoot(dashMount);
    root.render(<Dashboard />);
}
