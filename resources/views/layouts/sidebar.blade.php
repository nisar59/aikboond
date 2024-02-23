@php
$pref=Request()->route()->getPrefix();
@endphp

      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{url('/dashboard')}}"> <img alt="image" src="{{url('/img/settings/'.Settings()->portal_logo)}}" class="header-logo" /> <span
                class="logo-name"><!-- {{Settings()->portal_name}} --></span>
            </a>
          </div>
          <div class="sidebar-brand sidebar-brand-mini">
            <a href="{{url('/dashboard')}}"> <img alt="image" src="{{url('/img/settings/'.Settings()->portal_favicon)}}" class="header-logo" /> <span
                class="logo-name"><!-- {{Settings()->portal_name}} --></span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown @if($pref=='') active @endif">
              <a href="{{url('/dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            @can('users.view')
            <li class="dropdown @if($pref=='/users') active @endif">
              <a href="{{url('/users')}}" class="nav-link"><i class="fas fa-user-friends"></i><span>Users</span></a>
            </li>


            @endcan
            @can('permissions.view')
            <li class="dropdown @if($pref=='/roles') active @endif"><a class="nav-link" href="{{url('/roles')}}"><i class="fas fa-user-shield"></i><span>Roles & Permissions</span></a></li>
            @endcan


            
            @can('cities.view')
            <li class="menu-header">Cities</li>
            <li class="dropdown @if($pref=='/cities') active @endif">
              <a href="{{url('/cities')}}" class="nav-link"><i class="fas fa-city"></i><span>Cities</span></a>
            </li>
            @endcan

            
            @can('areas.view')
            <li class="menu-header">Areas</li>
            <li class="dropdown @if($pref=='/areas') active @endif">
              <a href="{{url('/areas')}}" class="nav-link"><i class="fa fa-map-marker" aria-hidden="true"></i><span>Areas</span></a>
            </li>
            @endcan


            
            @can('addresses-and-towns.view')
            <li class="menu-header">Addresses And Towns</li>
            <li class="dropdown @if($pref=='/addresses-and-towns') active @endif">
              <a href="{{url('/addresses-and-towns')}}" class="nav-link"><i class="fa fa-address-card" aria-hidden="true"></i><span>Addresses And Towns</span></a>
            </li>
            @endcan
            
            
            @can('donors.view')
            <li class="menu-header">Donors</li>
            <li class="dropdown @if($pref=='/donors') active @endif">
              <a href="{{url('/donors')}}" class="nav-link"><i class="fas fa-prescription-bottle"></i><span>Donors</span></a>
            </li>
            @endcan

            
            @can('compensation.view')
            <li class="menu-header">Compensation</li>
            <li class="dropdown @if($pref=='/compensation') active @endif">
              <a href="{{url('/compensation')}}" class="nav-link"><i class="fas fa-wallet"></i><span>Compensation</span></a>
            </li>
            @endcan

            @can('settings.view')
            <li class="menu-header">Panel Settings</li>
            <li class="dropdown @if($pref=='/settings') active @endif">
              <a href="{{url('/settings')}}" class="nav-link"><i class="fas fa-cogs"></i><span>Panel Settings</span></a>
            </li>
            @endcan
          </ul>
        </aside>
      </div>