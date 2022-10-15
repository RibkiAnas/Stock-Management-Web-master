@extends('app')

@section('title', 'Details de ' . $produit->ref)

@section('content_page')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 mb-4 ">
                <h3 class="mb-0 fw-bold">Détails de produit:  {{ $produit->ref }}</h3>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-12 col-md-12 col-12 mb-6 mb-xl-0">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center
                    justify-content-between">
                        <div>
                            <h4 class="mb-0">Produit: {{ $produit->libelle }}</h4>
                        </div>
                    </div>
                   {{--  <div class="mt-3">
                        <img src="../assets/images/placeholder/placeholder-4by3.svg" class="card-img-top mb-2"
                            alt="...">
                        <h4 class="card-title"></h4>
                        {{-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                            card's content.</p>
                        <h5 class="">Les caractèristique de produit</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Cras justo odio</li>
                            <li class="list-group-item">Dapibus ac facilisis in</li>
                            <li class="list-group-item">Vestibulum at eros</li>
                        </ul>
                    </div>--}}
                    <div class="d-flex align-items-center justify-content-around">
                        <div class="text-center">
                            <h1 class="mt-3  mb-1 fw-bold">{{ $produit->price_buy }}</h1>
                            <p>Prix d'achat</p>
                        </div>
                        <div class="text-center">
                            <h1 class="mt-3  mb-1 fw-bold">{{ $produit->price }}</h1>
                            <p>Prix de vente</p>
                        </div>
                        <div class="text-center">
                            <h1 class="mt-3  mb-1 fw-bold">{{ $produit->qte }}</h1>
                            <p>Quantité</p>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('produit.edit', ['produit' => $produit->id]) }}"
                            class="btn btn-primary">Modifier</a>
                        <form action="{{ route('produit.destroy', ['produit' => $produit->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input class="btn btn-danger w-100" type="submit" name="btn_delete_produit"
                                id="btn_delete_produit" value="Supprimer">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-12 col-md-12 col-12">
            <div class="card h-100">
                <div class="card-header bg-white py-4 mx-2">
                    <h4 class="mb-0">Historique de produit </h4>
                </div>
                @if ($produit->bon_commande != null)
                    <div class="table-responsive mx-2">
                        <table class="table text-nowrap" id="mytable">
                            <thead class="table-light">
                                <tr>
                                    <th>Numéro</th>
                                    <th>Fournisseur</th>
                                    <th>Téléphone</th>
                                    <th>Date livraison</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="ms-3 lh-1">
                                                <h5 class=" mb-1">{{$produit->bon_commande->num}}</h5>
                                                {{-- <p class="mb-0">anita@example.com</p> --}}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="align-middle">{{$produit->bon_commande->fournisseur->nom_complet}}</td>
                                    <td class="align-middle">{{$produit->bon_commande->fournisseur->telephone}}</td>
                                    <td class="align-middle">{{date_format($produit->bon_commande->created_at, 'Y-m-d')}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @else

                @endif
            </div>
        </div>
    </div>
    </div>
@endsection
@section('custom_script')
<script src="{{asset('js/datatable_js.js')}}"></script>
@endsection
