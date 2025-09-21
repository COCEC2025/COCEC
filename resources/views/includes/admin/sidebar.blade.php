<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
            <span class="brand-logo-text">
                <img src="{{ URL::asset('assets/images/Logo.png') }}" alt="COCEC Logo">
            </span>
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="{{ route('admin.dashboard') }}">
                    <iconify-icon icon="mage:dashboard" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>

            @hasFullAccess
            <li class="sidebar-menu-group-title">Actions</li>

            <li class="dropdown">
                {{-- {{ route('admin.announcements') }} --}}
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:bullhorn-outline" class="menu-icon"></iconify-icon>
                    <span>Annonces</span>
                </a>

                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('announcement.index') }}">
                            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Liste des annonces
                        </a>

                    </li>
                    <li>
                        <a href="{{ route('announcement.create') }}">
                            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Ajouter une annonce
                        </a>

                    </li>
                </ul>
            </li>

            <li class="dropdown">

                <a href="javascript:void(0)">
                    <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>

                    <span>Blog</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.blogs') }}">
                            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Liste des blogs
                        </a>

                    </li>
                    <li>
                        <a href="{{ route('blog.create') }}">
                            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Ajouter un blog
                        </a>

                    </li>
                </ul>
                <!-- <a href="{{ route('admin.blogs') }}">
                    <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
                    <span>Blog</span>
                </a> -->
            </li>
            {{-- <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:cog-outline" class="menu-icon"></iconify-icon>
                    <span>Système</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('settings.localities') }}">
                            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Localités
                        </a>
                    </li>
                </ul>
            </li> --}}
            @endhasFullAccess

            @canCreateAccounts
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:account-plus-outline" class="menu-icon"></iconify-icon>
                    <span>Création de Comptes</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.users.index') }}">
                            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Gestion des Utilisateurs
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.create') }}">
                            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Créer un Compte
                        </a>
                    </li>
                </ul>
            </li>
            @endcanCreateAccounts

            @hasFullAccess
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:briefcase-outline" class="menu-icon"></iconify-icon>
                    <span>Emploi</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('career.index') }}">Liste des offres</a>
                    </li>

                    <li>
                        <a href="{{ route('career.create') }}">Ajouter une offre</a>
                    </li>
                    <li>
                        <a href="{{ route('jobList.index') }}">Liste des demandes </a>
                    </li>

                </ul>
            </li>
            @endhasFullAccess

            @hasFullAccess
            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:map-marker-outline" class="menu-icon"></iconify-icon>
                    <span>Agences</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('agency.index') }}">Liste des agences</a>
                    </li>

                    <li>
                        <a href="{{ route('agency.create') }}">Ajouter une agence</a>
                    </li>

                </ul>
            </li>
            @endhasFullAccess


            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:account-group-outline" class="menu-icon"></iconify-icon>
                    <span>Gestion de compte</span>
                </a>

                <ul class="sidebar-submenu">
                    @hasFullAccess
                    <li>
                        <a href="{{ route('accounts.physical.index') }}">Demande physique</a>
                    </li>

                     <li>
                        <a href="{{ route('accounts.moral.index') }}">Demande morale</a>
                    </li> 
                    @else
                    <li>
                        <a href="{{ route('admin.accounts.index') }}">Vue d'ensemble</a>
                    </li>
                    @endif
                </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:bank" class="menu-icon"></iconify-icon>
                    <span>Finance Digitale</span>
                </a>
                                   <ul class="sidebar-submenu">
                       <li>
                           <a href="{{ route('admin.digitalfinance.updates.index') }}">
                               <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                               Formulaires de mise à jour
                           </a>
                       </li>
                       <li>
                           <a href="{{ route('admin.digitalfinance.contracts.index') }}">
                               <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                               Contrats d'adhésion
                           </a>
                       </li>
                   </ul>
            </li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="mdi:message-text-outline" class="menu-icon"></iconify-icon>
                    <span>Plaintes</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('admin.complaint.index') }}">
                            <i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Gestion des plaintes
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </div>
</aside>
