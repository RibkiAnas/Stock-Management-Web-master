@extends('app')

@section('title', 'Detail Facture N° ')

@section('content_page')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 mb-4">
                <h3 class="mb-0 fw-bold">Détails Facture</h3>
            </div>
        </div>
    </div>

    <div class="py-4">
        <div class="card h-100">
            <!-- card header  -->
            <div class="card-header bg-white py-3 text-end mx-2">
                <h4 class="mb-0"><a class="btn btn-dark" href="{{ route('facture.index') }}">
                        Afficher les Factures</a></h4>
                <div class="row text-start mt-3">
                    @php
                        use Illuminate\Support\Str;
                        $zeros = "";
                        $nb_zeros = 8 - Str::length($facture->num);
                        for ($i=0; $i < $nb_zeros; $i++) {
                            $zeros .= "0";
                        }
                        $facture_num = $zeros . $facture->num . "/" . $facture->created_at->format('y');
                    @endphp
                    <div class="col-xs-12 col-md-4">N° Facture: <strong>{{ $facture_num }}</strong></div>
                    <div class="col-xs-12 col-md-4">Client: <strong>{{ $facture->client->nom_complet }}</strong></div>
                    <div class="col-xs-12 col-md-4 mb-2">Devis N°: <strong>@php echo $facture->devie != null? $facture->devie->num: '- - -' @endphp</strong></div>
                    <div class="col-xs-12 col-md-6">
                        <a href="{{ route('facture.edit', ['facture' => $facture->num]) }}" class="btn btn-success w-100">Modifier</a>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <form action="{{ route('facture.destroy', ['facture' => $facture->num]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" name="btnDelete" id="btnDelete" class="btn btn-danger w-100">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- table  -->
            @php
                $produits = $facture->devie == null ? $facture->produits : $facture->devie->produits;
            @endphp
            @if (count($produits) > 0)
                <div class="table-responsive mx-2 mb-3">
                    <table class="table text-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>N°</th>
                                <th>REF</th>
                                <th>Libelle</th>
                                <th>Quantité en stock</th>
                                <th>Prix Unitaire</th>
                                <th>Quantité</th>
                                <th>Prix T</th>
                                <th>Bon de commande - Fournisseur</th>
                                <th>Telephone</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($produits as $produit)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    <td class="align-middle">{{ $produit->ref }}</td>
                                    <td class="align-middle">{{ $produit->libelle }}</td>
                                    <td class="align-middle">{{ $produit->qte }}</td>
                                    <td class="align-middle">{{ $produit->price }}</td>
                                    <td class="align-middle">@if ($facture->devie == null) {{ $produit->facture_produit->quantity }} @else {{ $produit->devie_produit->quantity }} @endif</td>
                                    <td class="align-middle">@if ($facture->devie == null) {{ $produit->price * $produit->facture_produit->quantity }} @else {{ $produit->price * $produit->devie_produit->quantity }} @endif</td>
                                    <td class="align-middle">@if ($produit->bon_commande != null) {{ $produit->bon_commande->num . '-' . $produit->bon_commande->fournisseur->num }} @else --- @endif</td>
                                    <td class="align-middle">@if ($produit->bon_commande != null) {{ $produit->bon_commande->fournisseur->telephone }} @else --- @endif</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-data-not-found message="Il y a aucun produit pour cette facture." />
            @endif
            @if (session()->exists('status'))
                <div class="alert alert-success mx-2" role="alert">
                    {{ session('status', '') }}
                </div>
            @endif
        </div>
    </div>
@endsection
