@extends('app')
@section('custom_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('title','Details de ' . $fournisseur->nom_complet)

@section('content_page')
        <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 mb-4 ">
                <h3 class="mb-0 fw-bold">détails du client</h3>
            </div>
        </div>
        </div>
        <div class="row align-items-center">
          <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <!-- Bg -->
            <div class="pt-20 rounded-top" style="background:
                url({{asset('assets/images/background/profile-cover.jpg')}}) no-repeat;
                background-size: cover;">
            </div>
            <div class="bg-white rounded-bottom smooth-shadow-sm ">
              <div class="d-flex align-items-center justify-content-between
                  pt-4 pb-6 px-4">
                <div class="d-flex align-items-center">
                  <!-- avatar -->
                  <div class="avatar-xxl avatar-indicators avatar-online me-2
                      position-relative d-flex justify-content-end
                      align-items-end mt-n10">
                    <img src="{{ asset('assets/images/avatar/avatar-1.jpg') }}" class="avatar-xxl
                        rounded-circle border border-4 border-white-color-40" alt="">
                    <a href="#!" class="position-absolute top-0 right-0 me-2" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Verified">
                      <img src="{{ asset('assets/images/svg/checked-mark.svg') }}" alt="" width="30" height="30">
                    </a>
                  </div>
                  <!-- text -->
                  <div class="lh-1">
                    <h2 class="mb-0">{{ $fournisseur->nom_complet }}
                      <a href="#!" class="text-decoration-none" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Beginner">

                      </a>
                    </h2>
                    {{-- <p class="mb-0 d-block">@imjituchauhan</p> --}}
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <a href="{{route('fournisseur.edit', ['fournisseur'=>$fournisseur->id]) }}" class="btn btn-outline-primary me-1">Modifier</a>
                      <form action="{{ route('fournisseur.destroy', ['fournisseur'=>$fournisseur->id]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger"><i data-feather="trash-2" class="nav-icon icon-xs"></i></button>
                    </form>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="py-6">
          <!-- row -->
            <div class="row">
                <div class="col-xl-6 col-lg-12 col-md-12 col-12 mb-6">
                <!-- card -->
                <div class="card">
                    <!-- card body -->
                    <div class="card-body">
                    <!-- card title -->
                    <h4 class="card-title">A propos de  {{ $fournisseur->nom_complet }}</h4>
                    {{-- <span class="text-uppercase fw-medium text-dark
                        fs-5 ls-2">Bio</span>
                    <!-- text -->
                    <p class="mt-2 mb-6">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspen disse var ius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla, ut commodo diam libero vitae erat.
                    </p> --}}
                    <!-- row -->
                    <div class="row">
                        <div class="col-12 mb-5">
                        <!-- text -->
                        <h6 class="text-uppercase fs-5 ls-2">Nom Sociéte
                        </h6>
                        <p class="mb-0">{{ $fournisseur->nom_societe }}</p>
                        </div>
                        <div class="col-6 mb-5">
                        <h6 class="text-uppercase fs-5 ls-2">Téléphone </h6>
                        <p class="mb-0">{{ $fournisseur->telephone }}</p>
                        </div>
                        <div class="col-6 mb-5">
                        <h6 class="text-uppercase fs-5 ls-2">RC </h6>
                        <p class="mb-0">{{ $fournisseur->rc }}</p>
                        </div>
                        <div class="col-6">
                        <h6 class="text-uppercase fs-5 ls-2">ICE </h6>
                        <p class="mb-0">{{ $fournisseur->ice }}</p>
                        </div>
                        <div class="col-6">
                        <h6 class="text-uppercase fs-5 ls-2">Dette
                        </h6>
                        <p class="mb-0">{{ $fournisseur->dette }}</p>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <div class="col-xl-6 col-lg-12 col-md-12 col-12 mb-6">
                    <div class="py-4">
                        <div class="card h-100">
                            <!-- card header  -->
                            <div class="card-header bg-white py-3">
                            <h4 class="mb-0">Bon de commandes</h4>
                            </div>
                            <!-- table  -->
                            @if (count($fournisseur->bon_commandes) > 0)
                            <div class="table-responsive">
                            <table class="table text-nowrap mb-0">
                                <thead class="table-light">
                                <tr>
                                    <th>N°</th>
                                    <th>Num Bon de commande</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="tbl_bon_commande">
                                    @foreach ($fournisseur->bon_commandes as $bon_commande)
                                <tr>
                                    <td class="align-middle">{{$loop->iteration}}</td>
                                    <td class="align-middle">{{$bon_commande->num}}</td>
                                    <td class="align-middle">
                                    <div class="dropdown dropstart">
                                        <a class="text-muted text-primary-hover" href="#" role="button" id="dropdownTeamOne" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical icon-xxs"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="dropdownTeamOne">
                                            <form action="{{ route('bon_commande.edit', ['bon_commande'=>$bon_commande->id]) }}" method="get">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Modifier</button>
                                            </form>
                                        <form action="{{ route('bon_commande.destroy', ['bon_commande'=>$bon_commande->id, 'page' => 'list-fournisseur']) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item">Supprimer</button>
                                            </form>
                                            <button class="btn_show_produits dropdown-item" data-bon_commande_id="{{$bon_commande->id}}">Afficher ses produits</button>
                                        </div>
                                    </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            </div>
                            @else
                                <x-data-not-found message="Il y a aucun bon de commande pour ce fournisseur." />
                            @endif
                        </div>
                    </div>
                </div>
                <div class="py-4 products_in_bon d-none">
                    <div class="card h-100">
                        <!-- card header  -->
                        <div class="card-header bg-white py-3 text-start">
                        <h4 class="mb-0">Produits du bon de commande</h4>
                        </div>
                        <!-- table  -->
                        <div class="table-responsive">
                        <table class="table text-nowrap mb-0">
                            <thead class="table-light">
                            <tr>
                                <th>N°</th>
                                <th>REf</th>
                                <th>Libelle</th>
                                <th>Prix Unitaire</th>
                                <th>Quantité</th>
                            </tr>
                            </thead>
                            <tbody id="tbl_tbody_produits">

                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('custom_script')
<script src="{{ asset('js/fournisseur/list-fournisseur.js') }}"></script>
@endsection
