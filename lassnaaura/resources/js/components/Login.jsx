import React, { useState } from 'react';

export default function Login() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [message, setMessage] = useState('');

  const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

  async function submit(e) {
    e.preventDefault();
    try {
      const res = await fetch('/login', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': csrf || '',
        },
        credentials: 'same-origin',
        body: JSON.stringify({ email, password }),
      });

      if (res.ok) {
        setMessage('Login successful — redirecting...');
        // Redirect to dashboard after successful login
        window.location.href = '/dashboard';
      } else {
        let payload;
        try {
          payload = await res.json();
        } catch (e) {
          payload = { message: await res.text() };
        }
        setMessage('Login failed: ' + (payload?.message || 'Unknown error'));
      }
    } catch (err) {
      setMessage('Network error');
    }
  }

  return (
    <div className="login-page">
      <div className="login-card">
        <div className="logo-wrap">
          <img
            src="/images/logo.jpg"
            alt="Logo"
            className="logo"
            onError={(e) => {
              e.currentTarget.onerror = null;
              e.currentTarget.src = '/images/logo.svg';
            }}
          />
        </div>
        <h2>Sign in</h2>
        <form onSubmit={submit} className="login-form">
          <input type="email" placeholder="Email" value={email} onChange={(e) => setEmail(e.target.value)} required />
          <input type="password" placeholder="Password" value={password} onChange={(e) => setPassword(e.target.value)} required />
          <button type="submit">Login</button>
        </form>
        {message && <p className="message">{message}</p>}
      </div>
    </div>
  );
}
