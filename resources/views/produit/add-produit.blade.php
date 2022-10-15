@extends('app')

@section('title', 'Ajouter Produit')

@section('content_page')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 mb-4">
                <h3 class="mb-0 fw-bold">Ajouter Produit</h3>
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
                            <h4 class="mb-0"><a href="{{ route('produit.index') }}"><i class="bi bi-arrow-left"></i>
                                    Afficher tous les Produits</a></h4>
                        </div>
                        <!-- card body  -->
                        <div class="card-body">
                            <!-- Validation Form -->
                            <form action="{{ route('produit.store') }}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label" for="nom_complet">REF</label>
                                    <input class="form-control" placeholder="Entre REF de produit" type="text"
                                        id="produit_ref" name="produit_ref" value="{{ old('produit_ref') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="telephone">Libelle</label>
                                    <input class="form-control" placeholder="Entre libelle de produit" type="text"
                                        id="produit_libelle" name="produit_libelle" value="{{ old('produit_libelle') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="rc">Prix d'achat</label>
                                    <input class="form-control" placeholder="Entre le prix d'achat de produit"
                                        type="text" id="produit_price_buy" name="produit_price_buy"
                                        value="{{ old('produit_price_buy') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="rc">Quantité en stock</label>
                                    <input class="form-control" placeholder="Entre la quantité en stock de produit"
                                        type="text" id="produit_qte" name="produit_qte" value="{{ old('produit_qte') }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="rc">Prix Unitaire</label>
                                    <input class="form-control" placeholder="Entre le prix de produit" type="text"
                                        id="produit_price" name="produit_price" value="{{ old('produit_price') }}">
                                </div>
                                <div class="mb-3">
                                    <input class="btn btn-primary" type="submit" name="btnAdd" id="btnAdd"
                                        value="Ajouter">
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
