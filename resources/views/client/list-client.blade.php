@extends('app')

@section('title','Details de ' . $client->nom_complet)

@section('content_page')
<div class="row">
  <div class="col-lg-12 col-md-12 col-12">
    <!-- Page header -->
      <div class="border-bottom pb-4 mb-4 ">
          <h3 class="mb-0 fw-bold">Détails du fournisseur</h3>
    </div>
  </div>
</div>
<div class="row align-items-center">
          <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <!-- Bg -->
            <div class="pt-20 rounded-top" style="background:
                url(../assets/images/background/profile-cover.jpg) no-repeat;
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
                    <img src="../assets/images/avatar/avatar-1.jpg" class="avatar-xxl
                        rounded-circle border border-4 border-white-color-40" alt="">
                    <a href="#!" class="position-absolute top-0 right-0 me-2" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Verified">
                      <img src="../assets/images/svg/checked-mark.svg" alt="" width="30" height="30">
                    </a>
                  </div>
                  <!-- text -->
                  <div class="lh-1">
                    <h2 class="mb-0">{{ $client->nom_complet }}
                      <a href="#!" class="text-decoration-none" data-bs-toggle="tooltip" data-placement="top" title="" data-original-title="Beginner">

                      </a>
                    </h2>
                    <p class="mb-0 d-block"><span>@</span>{{ $client->nom_complet }}</p>
                  </div>
                </div>
                <div class="d-flex align-items-center">
                  <a href="{{route('client.edit', ['client'=>$client->id]) }}" class="btn btn-outline-primary me-1">Modifier</a>
                  <form action="{{ route('client.destroy', ['client'=>$client->id]) }}" method="post">
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
                  <h4 class="card-title">A propos {{ $client->nom_complet }}</h4>
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
                      <p class="mb-0">{{ $client->nom_societe }}</p>
                    </div>
                    <div class="col-6 mb-5">
                      <h6 class="text-uppercase fs-5 ls-2">Téléphone </h6>
                      <p class="mb-0">{{ $client->telephone }}</p>
                    </div>
                    <div class="col-6 mb-5">
                      <h6 class="text-uppercase fs-5 ls-2">RC </h6>
                      <p class="mb-0">{{ $client->rc }}</p>
                    </div>
                    <div class="col-6">
                      <h6 class="text-uppercase fs-5 ls-2">ICE </h6>
                      <p class="mb-0">{{ $client->ice }}</p>
                    </div>
                    <div class="col-6">
                      <h6 class="text-uppercase fs-5 ls-2">Crédit
                      </h6>
                      <p class="mb-0">{{ $client->credit }}</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-6 col-lg-12 col-md-12 col-12 mb-6">
              <!-- card -->
              <div class="card">
                <!-- card body -->
                <div class="card-body">
                  <!-- card title -->
                  <h4 class="card-title">Détails Transaction</h4>
                  @if (count($client->factures) > 0)
                    @foreach ($client->factures as $facture)
                        <div class="d-md-flex justify-content-between
                            align-items-center mb-4">
                            <div class="d-flex align-items-center">
                                <div class="ms-3 ">
                                    <h5 class="mb-1"><a class="text-inherit">Numéro de facture</a></h5>
                                    <p class="mb-0 fs-5 text-muted">{{$facture->num}}</p>
                                </div>
                            <!-- text -->
                            <div class="ms-3 ">
                                <h5 class="mb-1"><a class="text-inherit">Nombre des produits</a></h5>
                                <p class="mb-0 fs-5 text-muted">{{$facture->produits()->count()}}</p>
                            </div>
                            </div>
                        </div>
                    @endforeach
                  @else
                    <x-data-not-found message="Il y a aucune facture pour ce client." />
                  @endif
                  {{-- <div class="d-md-flex justify-content-between
                      align-items-center mb-4">
                    <div class="d-flex align-items-center">
                      <div>
                        <!-- icon shape -->
                        <div class="icon-shape icon-lg border p-4 rounded-1">
                          <img src="../assets/images/brand/3dsmax-logo.svg" alt="">
                        </div>
                      </div>
                      <!-- text -->
                      <div class="ms-3 ">
                        <h5 class="mb-1"><a href="#" class="text-inherit">Design 3d Character</a></h5>
                        <p class="mb-0 fs-5 text-muted">Project description and details about...</p>
                      </div>
                    </div>

                    <div class="d-flex align-items-center ms-10 ms-md-0 mt-3">
                      <!-- avatar group -->
                      <div class="avatar-group me-2">
                        <span class="avatar avatar-sm">
                             <!-- img -->
                            <img alt="avatar" src="../assets/images/avatar/avatar-4.jpg" class="rounded-circle">
                          </span>
                        <span class="avatar avatar-sm">
                             <!-- img -->
                            <img alt="avatar" src="../assets/images/avatar/avatar-5.jpg" class="rounded-circle">
                          </span>
                        <span class="avatar avatar-sm">
                             <!-- img -->
                            <img alt="avatar" src="../assets/images/avatar/avatar-6.jpg" class="rounded-circle">
                          </span>
                      </div>
                      <div>
                        <!-- dropdown -->
                        <div class="dropdown dropstart">
                          <a href="#" class="text-muted text-primary-hover" id="dropdownprojectTwo" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical icon-xxs"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                          </a>
                          <div class="dropdown-menu" aria-labelledby="dropdownprojectTwo">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else
                                here</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="d-md-flex justify-content-between
                      align-items-center mb-4">
                    <div class="d-flex align-items-center">
                      <div>
                        <!-- icon shape -->
                        <div class="icon-shape icon-lg border p-4 rounded-1">
                          <img src="../assets/images/brand/github-logo.svg" alt="">
                        </div>
                      </div>
                      <!-- text -->
                      <div class="ms-3 ">
                        <h5 class="mb-1"><a href="#" class="text-inherit">Github Development</a></h5>
                        <p class="mb-0 fs-5 text-muted">Project description and details about...</p>
                      </div>
                    </div>
                    <div class="d-flex align-items-center ms-10 ms-md-0 mt-3">
                      <!-- avatar group -->
                      <div class="avatar-group me-2">
                        <span class="avatar avatar-sm">
                             <!-- img -->
                            <img alt="avatar" src="../assets/images/avatar/avatar-7.jpg" class="rounded-circle">
                          </span>
                        <span class="avatar avatar-sm">
                             <!-- img -->
                            <img alt="avatar" src="../assets/images/avatar/avatar-8.jpg" class="rounded-circle">
                          </span>
                        <span class="avatar avatar-sm">
                             <!-- img -->
                            <img alt="avatar" src="../assets/images/avatar/avatar-9.jpg" class="rounded-circle">
                          </span>
                      </div>
                      <div>
                        <!-- dropdown -->
                        <div class="dropdown dropstart">
                          <a href="#" class="text-muted text-primary-hover" id="dropdownprojectThree" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical icon-xxs"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                          </a>
                          <div class="dropdown-menu" aria-labelledby="dropdownprojectThree">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else
                                here</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="d-md-flex justify-content-between
                      align-items-center mb-4">
                    <div class="d-flex align-items-center">
                      <!-- icon shape -->
                      <div>
                        <div class="icon-shape icon-lg border p-4 rounded-1">
                          <img src="../assets/images/brand/dropbox-logo.svg" alt="">
                        </div>
                      </div>
                      <!-- text -->
                      <div class="ms-3 ">
                        <h5 class="mb-1"><a href="#" class="text-inherit">Dropbox Design
                            System</a></h5>
                        <p class="mb-0 fs-5 text-muted">Project description and details about...</p>
                      </div>
                    </div>
                    <div class="d-flex align-items-center ms-10 ms-md-0 mt-3">
                      <!-- avatar group -->
                      <div class="avatar-group me-2">
                        <!-- img -->
                        <span class="avatar avatar-sm">
                            <img alt="avatar" src="../assets/images/avatar/avatar-10.jpg" class="rounded-circle">
                          </span>
                        <!-- img -->
                        <span class="avatar avatar-sm">
                            <img alt="avatar" src="../assets/images/avatar/avatar-11.jpg" class="rounded-circle">
                          </span>
                        <!-- img -->
                        <span class="avatar avatar-sm">
                            <img alt="avatar" src="../assets/images/avatar/avatar-12.jpg" class="rounded-circle">
                          </span>
                      </div>
                      <div>
                        <!-- dropdown -->
                        <div class="dropdown dropstart">
                          <a href="#" class="text-muted text-primary-hover" id="dropdownprojectFour" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical icon-xxs"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                          </a>
                          <div class="dropdown-menu" aria-labelledby="dropdownprojectFour">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else
                                here</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="d-md-flex justify-content-between
                      align-items-center">
                    <div class="d-flex align-items-center">
                      <!-- icon shape -->
                      <div>
                        <div class="icon-shape icon-lg border p-4 rounded-1
                            bg-primary">
                          <img src="../assets/images/brand/layers-logo.svg" alt="">
                        </div>
                      </div>
                      <!-- text -->
                      <div class="ms-3 ">
                        <h5 class="mb-1"><a href="#" class="text-inherit">Project Management</a></h5>
                        <p class="mb-0 fs-5 text-muted">Project description and details about...</p>
                      </div>
                    </div>
                    <div class="d-flex align-items-center ms-10 ms-md-0 mt-3">
                      <!-- avatar group -->
                      <div class="avatar-group me-2">
                        <!-- img -->
                        <span class="avatar avatar-sm">
                            <img alt="avatar" src="../assets/images/avatar/avatar-13.jpg" class="rounded-circle">
                          </span>
                        <!-- img -->
                        <span class="avatar avatar-sm">
                            <img alt="avatar" src="../assets/images/avatar/avatar-14.jpg" class="rounded-circle">
                          </span>
                        <!-- img -->
                        <span class="avatar avatar-sm">
                            <img alt="avatar" src="../assets/images/avatar/avatar-15.jpg" class="rounded-circle">
                          </span>
                      </div>
                      <div>
                        <!-- dropdown -->
                        <div class="dropdown dropstart">
                          <a href="#" class="text-muted text-primary-hover" id="dropdownprojectFoufive" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical icon-xxs"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                          </a>
                          <div class="dropdown-menu" aria-labelledby="dropdownprojectFoufive">
                            <a class="dropdown-item" href="#">Action</a>
                            <a class="dropdown-item" href="#">Another action</a>
                            <a class="dropdown-item" href="#">Something else
                                here</a>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div> --}}
                </div>
              </div>
            </div>
            </div>
          </div>
        </div>
@endsection
