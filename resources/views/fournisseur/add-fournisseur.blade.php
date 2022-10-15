@extends('app')

@section('title','Ajouter Fournisseur')

@section('content_page')
    <div class="row">
          <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 mb-4">
                <h3 class="mb-0 fw-bold">Ajouter Fournisseur</h3>
            </div>
          </div>
        </div>
        <div class="row mt-6">
          <div class="offset-xl-2 col-xl-8 offset-lg-1 col-lg-10 col-md-12
              col-12">
            <div class="row">
              <div class="col-12 mb-6">
                <!-- card  -->
                <div class="card">
                  <!-- card header  -->
                  <div class="card-header p-4 bg-white">
                    <h4 class="mb-0"><a href="{{ route('fournisseur.index') }}"><i class="bi bi-arrow-left"></i> Afficher tous les fournisseurs</a></h4>
                  </div>
                  <!-- card body  -->
                  <div class="card-body">
                    <!-- Validation Form -->
        <form action="{{ route('fournisseur.store') }}" method="post">
        @csrf
        <div class="mb-3">
            <label class="form-label" for="nom_complet">Nom complet</label>
            <input class="form-control" placeholder="Entre le nom complet du fournisseur" type="text" id="nom_complet" name="fournisseur_name" value="{{ old('fournisseur_name') }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="telephone">Telephone</label>
            <input class="form-control" placeholder="N° Tél Ex: 00 00 00 00 00" type="text" id="telephone" name="fournisseur_tele" value="{{ old('fournisseur_tele') }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="rc">RC</label>
            <input class="form-control" placeholder="N° RC Ex: 123456789" type="text" id="rc" name="fournisseur_rc" value="{{ old('fournisseur_rc') }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="nom_societe">Nom du societé</label>
            <input class="form-control" placeholder="Entre le nom correct de societé" type="text" id="nom_societe" name="fournisseur_nom_societe" value="{{ old('fournisseur_nom_societe') }}">
        </div>
        <div class="mb-3">
            <label class="form-label" for="ice">ICE</label>
            <input class="form-control" placeholder="N° ICE Ex: 123456789569" type="text" id="ice" name="fournisseur_ice" value="{{ old('fournisseur_ice') }}">
        </div>
        <div class="mb-3">
            <input class="btn btn-primary w-100" type="submit" name="btnAdd" id="btnAdd" value="Ajouter">
        </div>
        </form>
        @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status', '') }}
        </div>
        @endif
        @if ($errors->any())
                <ul class="list-group">
                    @foreach ($errors->all() as $error)
                        <li class="list-group-item list-group-item-danger mb-2">{{ $error }}</li>
                    @endforeach
                </ul>
        @endif
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection
