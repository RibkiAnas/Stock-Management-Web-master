<nav class="navbar-vertical navbar">
    <div class="nav-scroller">
        <!-- Brand logo -->
        <a class="navbar-brand" href="">
            <img src="{{ asset('assets/images/background/dash.jpeg') }}" alt="" style="height: 4.875rem;"  />
        </a>
        <!-- Navbar nav -->
        <ul class="navbar-nav flex-column" id="sideNavbar">
            <li class="nav-item">
                <a class="nav-link has-arrow  active " href="{{ route('dashboard', ['filter_value'=>'global']) }}">
                    <i data-feather="home" class="nav-icon icon-xs me-2"></i>  Dashboard
                </a>

            </li>


         <!-- Nav item -->
         <li class="nav-item">
            <div class="navbar-heading">Gestion Du Stock & RH</div>
        </li>


             <!-- Nav item -->
             <li class="nav-item">
                <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#navPages" aria-expanded="false" aria-controls="navPages">
                    <i data-feather="users" class="nav-icon icon-xs me-2"></i> Clients
                </a>

                <div id="navPages" class="collapse " data-bs-parent="#sideNavbar">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('client.create') }}">
                                Ajouter Client
                </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link has-arrow" href="{{ route('client.index') }}">
                                List des Clients
                                </a>

                        </li>
                    </ul>
                </div>

                </li>
                        <!-- Nav item -->
                        <li class="nav-item">
                            <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#navAuthentication" aria-expanded="false" aria-controls="navAuthentication">
                                <i data-feather="users" class="nav-icon icon-xs me-2"></i> Fornisseurs
                            </a>
                            <div id="navAuthentication" class="collapse " data-bs-parent="#sideNavbar">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('fournisseur.create') }}"> Ajouter Fournisseur</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('fournisseur.index') }}">List des Fournisseurs</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- Nav item -->
                        <li class="nav-item">
                            <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#navProducts" aria-expanded="false" aria-controls="navProducts">
                                <i data-feather="archive" class="nav-icon icon-xs me-2"></i> Produits
                            </a>
                            <div id="navProducts" class="collapse " data-bs-parent="#sideNavbar">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('produit.create') }}"> Ajouter Produit</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('produit.index') }}">List des Produits</a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <!-- Nav item -->
                        <li class="nav-item">
                            <div class="navbar-heading">Opérations</div>
                        </li>
                        <!-- Nav item -->
                        <li class="nav-item">
                            <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#navDevis" aria-expanded="false" aria-controls="navDevis">
                                <i data-feather="clipboard" class="nav-icon icon-xs me-2"></i> Devis
                            </a>
                            <div id="navDevis" class="collapse " data-bs-parent="#sideNavbar">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('devie.create') }}"> Ajouter Devis</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('devie.index') }}">List des Devis</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- Nav item -->
                        <li class="nav-item">
                            <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#navFacture" aria-expanded="false" aria-controls="navFacture">
                                <i data-feather="file" class="nav-icon icon-xs me-2"></i> Factures
                            </a>
                            <div id="navFacture" class="collapse " data-bs-parent="#sideNavbar">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('facture.create') }}"> Ajouter Facture</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('facture.index') }}">List des Factures</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- Nav item -->
                        <li class="nav-item">
                            <a class="nav-link has-arrow  collapsed " href="#!" data-bs-toggle="collapse" data-bs-target="#navBonCommande" aria-expanded="false" aria-controls="navBonCommande">
                                <i data-feather="shopping-bag" class="nav-icon icon-xs me-2"></i> Bon de Commande
                            </a>
                            <div id="navBonCommande" class="collapse " data-bs-parent="#sideNavbar">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('bon_commande.create') }}"> Ajouter Bon Commande</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('bon_commande.index') }}">List des Bon Commande</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>

                </div>
</nav>
