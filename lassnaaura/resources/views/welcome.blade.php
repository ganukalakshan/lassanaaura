<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome</title>
    <style>
      body{font-family:Inter,system-ui,Segoe UI,Roboto,Arial;background:#fff;margin:0;display:flex;align-items:center;justify-content:center;height:100vh}
      .box{max-width:520px;text-align:center;padding:30px;border-radius:12px;box-shadow:0 10px 40px rgba(0,0,0,0.06)}
      h1{color:#c2185b;margin:0 0 8px}
      p{color:#6b4250}
      a.button{display:inline-block;margin-top:18px;background:#c2185b;color:#fff;padding:10px 16px;border-radius:8px;text-decoration:none}
    </style>
  </head>
  <body>
    <div class="box">
      <h1>Welcome to Lassana Aura</h1>
      <p>Use the link below to sign in to the admin dashboard.</p>
      <div>
        <a href="{{ route('login') }}" class="button">Go to Login</a>
      </div>
    </div>
  </body>
  </html>
