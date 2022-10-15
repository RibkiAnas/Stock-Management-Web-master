@extends('app')

@section('title', 'Dashboad')

@section('dashboard')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="mb-2 mb-lg-0">
                        <h3 class="mb-0  text-white">Stats</h3>
                    </div>
                    {{-- <div>
                    <a href="#" class="btn btn-white">Create New Project</a>
                  </div> --}}
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card ">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0">Nombre de clients</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
                      rounded-2">
                            <i class="bi bi-briefcase fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">{{ $nb_clients }}</h1>
                        {{-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card ">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0">Nombre des fournisseurs</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
                      rounded-2">
                            <i class="bi bi-list-task fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">{{ $nb_fournisseurs }}</h1>
                        {{-- <p class="mb-0"><span class="text-dark me-2"></span>Completed</p> --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card ">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0">Les gains</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
                      rounded-2">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">{{ $gains }}</h1>
                        {{-- <p class="mb-0"><span class="text-dark me-2">1</span>Completed</p> --}}
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card ">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                        <div>
                            <h4 class="mb-0">Les depenses</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
                      rounded-2">
                            <i class="bi bi-bullseye fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">{{ $expenses ?? '0' }}</h1>
                        {{-- <p class="mb-0"><span class="text-success me-2">5%</span>Completed</p> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-6">
        <div class="col-md-12 col-12">
            <!-- card  -->
            @if (count($produits_with_small_qte) > 0)
                <div class="card">
                    <!-- card header  -->
                    <div class="card-header bg-white  py-4">
                        <h4 class="mb-0">Les produits avec petite quantité</h4>
                    </div>
                    <!-- table  -->
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0" id="mytable">
                            <thead class="table-light">
                                <tr>
                                    <th>N°</th>
                                    <th>REF</th>
                                    <th>Libelle</th>
                                    <th>Prix d'achat</th>
                                    <th>Prix Unitaire</th>
                                    <th>Quantité</th>
                                    <th>Bon de commande - Fournisseur</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produits_with_small_qte as $produit)
                                    <tr>
                                        <td class="align-middle">
                                            <div class="d-flex
                            align-items-center">
                                                <div class="ms-3 lh-1">
                                                    <h5 class=" mb-1"> <a href="#"
                                                            class="text-inherit">{{ $loop->iteration }}</a></h5>

                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle">{{ $produit->ref }}</td>
                                        <td class="align-middle"><span
                                                class="badge
                            bg-warning">{{ $produit->libelle }}</span>
                                        </td>
                                        <td class="align-middle">
                                            <div class="avatar-group">
                                                <span class="avatar avatar-sm avatar-primary">
                                                    <span
                                                        class="avatar-initials rounded-circle
                                fs-6">{{ $produit->price_buy }}</span>
                                                </span>
                                            </div>
                                        </td>
                                        <td class="align-middle text-dark">
                                            <div class="float-start me-3">{{ $produit->price }}</div>
                                        </td>
                                        <td class="align-middle text-dark">
                                            <div class="float-start me-3">{{ $produit->qte }}</div>
                                        </td>
                                        <td class="align-middle text-dark">
                                            <div class="float-start me-3">@php echo (($produit->bon_commande != null)?$produit->bon_commande->num . ' - ' . $produit->bon_commande->fournisseur->nom_complet : '- - -'); @endphp</div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="card-footer bg-white text-center">
                    <p>Il y a aucun produit avec petite quantité ce moment.</p>
                </div>
            @endif
        </div>
    </div>

    <div class="row my-6">
        <div class="col-xl-4 col-lg-12 col-md-12 col-12 mb-6 mb-xl-0">
            <!-- card  -->
            <div class="card h-100">
                <!-- card body  -->
                <div class="card-body">
                    <!-- icon with content  -->
                    <div class="d-flex align-items-center justify-content-around">
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-check-circle icon-sm text-success">
                                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                <polyline points="22 4 12 14.01 9 11.01"></polyline>
                            </svg>
                            <h1 class="mt-3  mb-1 fw-bold">{{ $credit }}</h1>
                            <p>Credit</p>
                        </div>
                        <div class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-trending-up icon-sm text-warning">
                                <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                                <polyline points="17 6 23 6 23 12"></polyline>
                            </svg>
                            <h1 class="mt-3  mb-1 fw-bold">{{ $dette }}</h1>
                            <p>Dette</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-around">
                        <div id="btn_clients_with_credit" class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-trending-down icon-sm text-danger">
                                <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                <polyline points="17 18 23 18 23 12"></polyline>
                            </svg>
                            <h1 class="mt-3  mb-1 fw-bold">{{ $nb_clients_with_credit }}</h1>
                            <p>Nombre des clients ayant des credits</p>
                        </div>
                        <div id="btn_fournisseurs_with_dette" class="text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-trending-down icon-sm text-danger">
                                <polyline points="23 18 13.5 8.5 8.5 13.5 1 6"></polyline>
                                <polyline points="17 18 23 18 23 12"></polyline>
                            </svg>
                            <h1 class="mt-3  mb-1 fw-bold">{{ $nb_fournisseurs_with_dette }}</h1>
                            <p>Nombre des fournisseurs ayant dettes</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- card  -->
        <div class="col-xl-8 col-lg-12 col-md-12 col-12">
            <div class="card h-100">
                <!-- card header  -->
                <div class="card-header bg-white py-4">
                    <h4 class="mb-0">Clients / Fournisseurs </h4>
                </div>
                <!-- table  -->
                <div class="table-responsive">
                    <table class="table text-nowrap" id="mytable">
                        <thead class="table-light">
                            <tr>
                                <th>N°</th>
                                <th>Nom complet</th>
                                <th>Telephone</th>
                                <th>ٌRC</th>
                                <th>Nom du societe</th>
                                <th>ICE</th>
                                <th>Credit/dette</th>
                                <th>Date d'enregistrement</th>
                            </tr>
                        </thead>
                        <tbody id="tbl_tbody_persons">
                            {{-- <tr>
                        <td class="align-middle">
                          <div class="d-flex align-items-center">
                            <div>
                              <img src="assets/images/avatar/avatar-1.jpg" alt="" class="avatar-md avatar rounded-circle">
                            </div>
                            <div class="ms-3 lh-1">
                              <h5 class=" mb-1">Jitu Chauhan</h5>
                              <p class="mb-0">jituchauhan@example.com</p>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle">Project Director </td>
                        <td class="align-middle">Today</td>
                        <td class="align-middle">
                          <div class="dropdown dropstart">
                            <a class="text-muted text-primary-hover" href="#" role="button" id="dropdownTeamTwo" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical icon-xxs"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownTeamTwo">
                              <a class="dropdown-item" href="#">Action</a>
                              <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else
                                here</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle">
                          <div class="d-flex align-items-center">
                            <div>
                              <img src="assets/images/avatar/avatar-3.jpg" alt="" class="avatar-md avatar rounded-circle">
                            </div>
                            <div class="ms-3 lh-1">
                              <h5 class=" mb-1">Sandeep Chauhan</h5>
                              <p class="mb-0">sandeepchauhan@example.com</p>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle">Full- Stack Developer</td>
                        <td class="align-middle">Yesterday</td>
                        <td class="align-middle">
                          <div class="dropdown dropstart">
                            <a class="text-muted text-primary-hover" href="#" role="button" id="dropdownTeamThree" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical icon-xxs"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownTeamThree">
                              <a class="dropdown-item" href="#">Action</a>
                              <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else
                                here</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle">
                          <div class="d-flex align-items-center">

                            <div>
                              <img src="assets/images/avatar/avatar-4.jpg" alt="" class="avatar-md avatar rounded-circle">
                            </div>

                            <div class="ms-3 lh-1">
                              <h5 class=" mb-1">Amanda Darnell</h5>
                              <p class="mb-0">amandadarnell@example.com</p>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle">Digital Marketer</td>
                        <td class="align-middle">3 May, 2021</td>
                        <td class="align-middle">
                          <div class="dropdown dropstart">
                            <a class="text-muted text-primary-hover" href="#" role="button" id="dropdownTeamFour" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical icon-xxs"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownTeamFour">
                              <a class="dropdown-item" href="#">Action</a>
                              <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else
                                here</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>

                        <td class="align-middle">
                          <div class="d-flex align-items-center">

                            <div>
                              <img src="assets/images/avatar/avatar-5.jpg" alt="" class="avatar-md avatar rounded-circle">
                            </div>

                            <div class="ms-3 lh-1">
                              <h5 class=" mb-1">Patricia Murrill</h5>
                              <p class="mb-0">patriciamurrill@example.com</p>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle">Account Manager</td>
                        <td class="align-middle">3 May, 2021</td>
                        <td class="align-middle">
                          <div class="dropdown dropstart">
                            <a class="text-muted text-primary-hover" href="#" role="button" id="dropdownTeamFive" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical icon-xxs"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownTeamFive">
                              <a class="dropdown-item" href="#">Action</a>
                              <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else
                                here</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td class="align-middle border-bottom-0">
                          <div class="d-flex align-items-center">
                            <div>
                              <img src="assets/images/avatar/avatar-6.jpg" alt="" class="avatar-md avatar rounded-circle">
                            </div>
                            <div class="ms-3 lh-1">
                              <h5 class=" mb-1">Darshini Nair</h5>
                              <p class="mb-0">darshininair@example.com</p>
                            </div>
                          </div>
                        </td>
                        <td class="align-middle border-bottom-0">Front End Developer</td>
                        <td class="align-middle border-bottom-0">3 May, 2021</td>
                        <td class="align-middle border-bottom-0">
                          <div class="dropdown dropstart">
                            <a class="text-muted text-primary-hover" href="#" role="button" id="dropdownTeamSix" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical icon-xxs"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownTeamSix">
                              <a class="dropdown-item" href="#">Action</a>
                              <a class="dropdown-item" href="#">Another action</a>
                              <a class="dropdown-item" href="#">Something else
                                here</a>
                            </div>
                          </div>
                        </td>
                      </tr> --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_script')
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/datatable_js.js') }}"></script>
@endsection
