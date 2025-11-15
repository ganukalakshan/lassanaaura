<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'App')</title>
    @vite(['resources/js/app.jsx', 'resources/css/app.css'])
    <style>
      :root { --pink-50: #fff0f6; --pink-300: #ff99c8; --pink-500: #ff4da6; --muted: #6b7280; --sidebar-width: 240px; --sidebar-collapsed: 72px; }
      body { margin: 0; font-family: system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background: var(--pink-50); color: #111827; }

      /* Sidebar base */
      nav.sidebar { width: var(--sidebar-width); min-height: 100vh; position: fixed; left: 0; top: 0; padding: 1rem; box-sizing: border-box; background: #ffffff; border-right: 1px solid rgba(16,24,40,0.04); transition: width 200ms ease; display:flex; flex-direction:column; }
      nav.sidebar .brand { display:flex; align-items:center; justify-content:space-between; gap:8px; margin-bottom: 1rem; }
      nav.sidebar .brand a { color: var(--pink-500); font-weight:700; font-size:1.05rem; display:flex; align-items:center; gap:8px }
      nav.sidebar .brand .brand-label { transition: opacity 150ms ease, transform 150ms ease; white-space:nowrap; }
      nav.sidebar #sidebar-toggle { background:transparent;border:0;color:var(--muted);cursor:pointer;font-size:14px;padding:4px;border-radius:6px }

      nav.sidebar .menu { list-style: none; padding: 0; margin: 0; }
      nav.sidebar .menu li { margin-bottom: 0.25rem; }
      nav.sidebar .menu a { display:flex; align-items:center; gap:10px; color: #111827; text-decoration: none; padding: 0.5rem; border-radius: 6px; }
      nav.sidebar .menu .icon { width:24px; height:24px; display:inline-flex; align-items:center; justify-content:center; color:var(--muted); }
      nav.sidebar .menu .label { transition: opacity 120ms ease, transform 120ms ease; }
      nav.sidebar .menu a.active, nav.sidebar .menu a:hover { background: var(--pink-50); color: var(--pink-500); }

      /* Collapsed state */
      body.sidebar-collapsed nav.sidebar { width: var(--sidebar-collapsed); }
      body.sidebar-collapsed main.content { margin-left: var(--sidebar-collapsed); }
      body.sidebar-collapsed nav.sidebar .brand-label { opacity: 0; transform: translateX(-6px); width:0; overflow:hidden; }
      body.sidebar-collapsed nav.sidebar .label { opacity: 0; transform: translateX(-6px); width:0; overflow:hidden; }
      body.sidebar-collapsed nav.sidebar #sidebar-toggle { transform: rotate(180deg); }

      /* Expanded state */
      main.content { margin-left: var(--sidebar-width); padding: 1.25rem; min-height: 100vh; box-sizing: border-box; transition: margin-left 200ms ease; }

      .card { background: #ffffff; border-radius: 8px; padding: 1rem; box-shadow: 0 1px 2px rgba(16,24,40,0.04); }
      h1.page-title { color: var(--pink-500); margin-top: 0; }
      .subtitle { color: var(--muted); }
    </style>
  </head>
  <body>
    @include('partials.sidebar')

    <main class="content">
      @yield('content')
    </main>

    <script>
      (function(){
        const storageKey = 'sidebar-collapsed';
        const body = document.body;
        const toggle = document.getElementById('sidebar-toggle');

        function applyState(collapsed){
          if(collapsed) body.classList.add('sidebar-collapsed');
          else body.classList.remove('sidebar-collapsed');
        }

        // Initialize from localStorage
        try{
          const saved = localStorage.getItem(storageKey);
          applyState(saved === '1');
        }catch(e){}

        if(toggle){
          toggle.addEventListener('click', function(){
            const collapsed = !body.classList.contains('sidebar-collapsed');
            applyState(collapsed);
            try{ localStorage.setItem(storageKey, collapsed ? '1' : '0'); }catch(e){}
          });
        }
      })();
    </script>
  </body>
  </html>
