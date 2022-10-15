@extends('app')

@section('title', 'Modifier produit')

@section('content_page')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 mb-4">
                <h3 class="mb-0 fw-bold">Modifier les information d'un produit</h3>
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
                                    Afficher tous les produits</a></h4>
                        </div>
                        <!-- card body  -->
                        <div class="card-body">
                            <!-- Validation Form -->
                            <form action="{{ route('produit.update', ['produit' => $produit->id]) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label" for="produit_ref">REF</label>
                                    <input class="form-control" placeholder="Entre le REF de produit" type="text"
                                        id="produit_ref" name="produit_ref" value="{{ $produit->ref }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="produit_libelle">Libelle</label>
                                    <input class="form-control" placeholder="Entre libelle de produit" type="text"
                                        id="produit_libelle" name="produit_libelle" value="{{ $produit->libelle }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="rc">Prix d'achat</label>
                                    <input class="form-control" placeholder="Entre le prix d'achat de produit"
                                        type="text" id="produit_price_buy" name="produit_price_buy"
                                        value="{{ $produit->price_buy }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="rc">Quantité en stock</label>
                                    <input class="form-control" placeholder="Entre la quantité en stock de produit"
                                        type="text" id="produit_qte" name="produit_qte" value="{{ $produit->qte }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="produit_price">Prix Unitaire</label>
                                    <input class="form-control" placeholder="Entre prix de produit" type="text"
                                        id="produit_price" name="produit_price" value="{{ $produit->price }}">
                                </div>
                                @if ($produit->bon_commande != null)
                                    <div class="mb-3">
                                        <label class="form-label" for="rc">Bon de commande</label>
                                        <select class="form-control" name="bon_commande" id="">
                                            @foreach ($bon_commandes as $bon_commande)
                                                <option value="{{ $bon_commande->id }}"
                                                    {{ $bon_commande->id == $produit->bon_commande->id ? 'selected' : '' }}>
                                                    {{ $bon_commande->num }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="mb-3">
                                    <input class="btn btn-primary w-100" type="submit" name="btn_update_produit"
                                        id="btn_update_produit" value="Modifier">
                                </div>
                            </form>
                            <form action="{{ route('produit.destroy', ['produit' => $produit->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <input class="btn btn-danger w-100 mb-3" type="submit" name="btn_delete_produit"
                                    id="btn_delete_produit" value="Supprimer">
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
