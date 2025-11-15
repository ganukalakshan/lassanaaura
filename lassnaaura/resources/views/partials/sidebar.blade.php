<nav class="sidebar" aria-label="Main sidebar">
  <div class="brand">
    <a href="{{ url('/dashboard') }}" style="display:flex;align-items:center;gap:8px;text-decoration:none;color:inherit">
      <img src="{{ asset('images/logo.jpg') }}" alt="LassanaAura" class="brand-img" style="width:36px;height:36px;object-fit:cover;border-radius:6px;" />
      <span class="brand-label">LassanaAura</span>
    </a>
    <button id="sidebar-toggle" aria-label="Toggle sidebar" title="Toggle sidebar" type="button">◀</button>
  </div>

  <ul class="menu">
    <li>
      <a href="{{ url('/dashboard') }}" class="{{ request()->is('dashboard') ? 'active' : '' }}">
        <span class="icon" aria-hidden="true">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M3 13h8V3H3v10zM13 21h8V11h-8v10zM13 3v6h8V3h-8zM3 21h8v-8H3v8z" fill="currentColor"/>
          </svg>
        </span>
        <span class="label">Dashboard</span>
      </a>
    </li>
  </ul>
</nav>


