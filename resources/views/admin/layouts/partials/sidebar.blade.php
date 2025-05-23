<div class="iq-sidebar">
   <div class="iq-sidebar-logo d-flex justify-content-between">
      <a href="/panel">
         <!-- <img src="{{-- asset('fe/img/logo.png') --}}" class="img-fluid" alt=""> -->
         <h4 style="color:aliceblue; text-align: center; font-size: 25px;">GD LOCATION</h4>
      </a>
      <div class="iq-menu-bt-sidebar onlyMobile">
         <div class="iq-menu-bt align-self-center">
            <div class="wrapper-menu">
               <div class="main-circle"><i class="ri-arrow-left-s-line"></i></div>
               <div class="hover-circle"><i class="ri-arrow-right-s-line"></i></div>
            </div>
         </div>
      </div>
   </div>
   <div id="sidebar-scrollbar">
      <nav class="iq-sidebar-menu">
         <ul id="iq-sidebar-toggle" class="iq-menu">
            <li class="active">
               <a href="/panel" class="iq-waves-effect">
                  <i class="ri-home-7-line"></i><span>Tableau de Board</span></a>
            </li>

            <!-- <li class="iq-menu-title">
               <i class="ri-subtract-line"></i><span>Gestion Moto Location</span>
            </li> -->

            <li class="{{ Request::is('panel/Reservations') ? 'active' : '' }}">
               <a href="{{ route('reservations') }}" class="iq-waves-effect">
                  <i class="ri-calendar-fill"></i>
                  <span>Calendrier</span>
               </a>
            </li>

            <li class="{{ Request::is('panel/Reservations/list*') ? 'active' : '' }}">
               <a href="{{  route('admin.calendar.list') }}">
                  <i class="ri-calculator-line"></i><span>Liste des Reservations</span>
               </a>
            </li>

            <li class="{{ Request::is('panel/price_periods*') ? 'active' : '' }}">
               <a href="{{  route('price_periods.index') }}">
                  <i class="ri-price-tag-fill"></i>
                  <span>Tarifs</span>
               </a>
            </li>

            <li class="{{ Request::is('panel/promos*') ? 'active' : '' }}">
               <a href="{{ route('promos.index') }}">
                  <i class="ri-pages-fill"></i>
                  <span>Promos</span>
               </a>
            </li>

            <li class="{{ Request::is('panel/scooters*') ? 'active' : '' }}">
               <a href="{{ route('scooters.index') }}">
                  <i class="ri-motorbike-fill"></i>
                  <span>Gestion Scooters</span>
               </a>
            </li>

            <li class="{{ Request::is('panel/clients*') ? 'active' : '' }}">
               <a href="{{ route('clients.index') }}">
                  <i class="ri-account-box-fill">
                  </i>
                  <span>Gestion Clients</span>
               </a>
            </li>

            <!-- <li class="{{ Request::is('panel/paiements*') ? 'active' : '' }}">
               <a href="{{ route('admin.paiements.index') }}">
               <i class="ri-money-euro-box-fill"></i>
               <span>Gestion Paiements</span>
               </a>
            </li>               -->

            <li class="{{ Request::is('panel/company*') ? 'active' : '' }}">
               <a href="{{ route('company') }}">
                  <i class="ri-compasses-line"></i>
                  <span>GD LOCATION</span>
               </a>
            </li>
         </ul>
      </nav>
      <div class="p-3"></div>
      <form method="POST" action="{{ route('logout') }}">
         @csrf

         <x-dropdown-link :href="route('logout')"
            onclick="event.preventDefault(); this.closest('form').submit();">
            {{ __('Déconnexion') }}
         </x-dropdown-link>
      </form>
   </div>
</div>