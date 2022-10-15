@extends('app')

@section('title', 'Ajouter Bon De Commande')

@section('custom_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('custom_libs')
<link href="{{ asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" />
@endsection

@section('content_page')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 mb-4 ">
                <h3 class="mb-0 fw-bold">Ajouter bon de commande</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-3 col-lg-12 col-md-12 col-12 mb-6 mb-xl-0">
            <div class="card h-100">
                <div class="card-body">
                    <div class="card-header bg-white">
                        <h4 class="border-bottom">Ajouter produit</h4>
                    </div>
                    <form action="{{ route('produit.store') }}" method="post" id="frm_produit">
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-sm" name="produit_libelle" id="produit_libelle" placeholder="Libelle">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-sm" id="produit_ref" name="produit_ref" placeholder="REF">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-sm" id="produit_price_buy" name="produit_price_buy" placeholder="Prix U (prix d'achat)">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-sm" id="produit_price" name="produit_price" placeholder="Prix U">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control form-control-sm" id="produit_qte" name="produit_qte" placeholder="Quantité">
                        </div>
                        <div class="mb-3">
                            <input type="submit" id="btn_add_produit" value="Ajouter ce produit" class="btn btn-primary btn-sm w-100">
                            <input type="submit" class="btn btn-primary btn-sm w-100 d-none" id="btn_update_produit" value="modifier ce produit">
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-12 col-md-12 col-12">
            <div class="card h-100">
                <div class="card-header bg-white py-4">
                    <form action="{{ route('bon_commande.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <input type="text" id="bon_commande_num" class="form-control form-control-sm" name="bon_commande_num" value="{{ old('bon_commande_num') }}" placeholder="Numéro bon de commande">
                        </div>
                        <div class="col-xs-12 col-md-8">
                            <select name="fournisseur" id="fournisseur" class="livesearchfournisseurs form-control"></select>
                        </div>
                        <div class="col-xs-12 mt-2">
                            <input type="hidden" name="produits" id="produits_ids">
                            <button type="submit" id="btnAdd" class="btn btn-primary btn-sm w-100">Ajouter</button>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="table-responsive mx-2 mb-3">
                    <table class="table text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th>N°</th>
                                <th>REF</th>
                                <th>Libelle</th>
                                <th>Prix d'achat</th>
                                <th>Prix Unitaire</th>
                                <th>Quantité</th>
                                <th colspan="2">actions</th>
                            </tr>
                        </thead>
                         <tbody id="tbl_tbody_produits">

                        </tbody>
                    </table>
                </div>
                @if (session('status'))
                    <div class="alert alert-success mx-2" role="alert">
                        {{ session('status', '') }}
                    </div>
                @endif
                @if ($errors->any())
                    <ul class="list-group mx-2">
                        @foreach ($errors->all() as $error)
                            <li class="list-group-item list-group-item-danger mb-2">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection
@section('custom_script')
<script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
<script src="{{ asset('js/bon/add-bon.js') }}"></script>
@endsection
