<aside class="sidebar">
   <div class="sidebar__menu-group">
      <ul class="sidebar_nav">
         <li class="menu-title">
            <span>Main menu</span>
         </li>
         <li>
            <a href="{{ route('prowectcms.admin.dashboard') }}" class="{{ Route::is('prowectcms.admin.dashboard') ? 'active' : ''}}">
            <span data-feather="home" class="nav-icon"></span>
            <span class="menu-text">Dashboard</span>
            </a>
         </li>
      </ul>
   </div>
</aside>