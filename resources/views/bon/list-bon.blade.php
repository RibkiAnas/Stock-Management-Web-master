@extends('app')

@section('title', 'Details de bon N°' . $bon_commande->num)

@section('content_page')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 mb-4 ">
                <h3 class="mb-0 fw-bold">Détails bon de commande</h3>
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
                            <h4 class="mb-0">Bon de Commande N°: {{$bon_commande->num}}</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-around">
                        <div class="text-center">
                            <h1 class="mt-3  mb-1 fw-bold">{{$bon_commande->fournisseur->nom_complet}}</h1>
                            <p>Nom founisseurs</p>
                        </div>
                        <div class="text-center">
                            <h1 class="mt-3  mb-1 fw-bold">{{$bon_commande->fournisseur->telephone}}</h1>
                            <p>Tél Fournisseur</p>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('bon_commande.edit', ['bon_commande' => $bon_commande->id]) }}"
                            class="btn btn-primary">Modifier</a>
                        <form action="{{ route('bon_commande.destroy', ['bon_commande' => $bon_commande->id]) }}" method="POST">
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
                <div class="card-header bg-white py-4">
                    <h4 class="mb-0">Historique de produit </h4>
                </div>
                 @if (count($bon_commande->produits) > 0)
                <div class="table-responsive mx-2">
                    <table class="table text-nowrap">
                        <thead class="table-light">
                            <tr>
                                <th>N°</th>
                                <th>REF</th>
                                <th>Libelle</th>
                                <th>Prix d'achat</th>
                                <th>Prix Unitaire</th>
                                <th>Quantité</th>
                            </tr>
                        </thead>
                         <tbody>
                            @foreach ($bon_commande->produits as $produit)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $produit->ref }}</td>
                                    <td class="align-middle">{{ $produit->libelle }}</td>
                                    <td class="align-middle">{{ $produit->price_buy }}</td>
                                    <td class="align-middle">{{ $produit->price }}</td>
                                    <td class="align-middle">{{ $produit->qte }}</td>
                                </tr>
                            @endforeach
                    </tbody>
                    </table>
                </div>
                 @else
                    <x-data-not-found message="Il y a aucun produit pour ce bon de commande." />
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection

