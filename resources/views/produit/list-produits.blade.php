@extends('app')

@section('title', 'List de produits')

@section('content_page')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 mb-4">
                <h3 class="mb-0 fw-bold">List des Produits</h3>
            </div>
        </div>
        <div class="py-4">
            <div class="card h-100">
                <!-- card header  -->
                <div class="card-header bg-white py-3 text-end mx-2">
                    <h4 class="mb-0"><a class="btn btn-dark" href="{{ route('produit.create') }}"><i class="bi bi-plus"></i>
                            Ajouter un produit</a> </h4>
                </div>
                <!-- table  -->
                @if (count($produits) > 0)

                    <div class="table-responsive mx-2">
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
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produits as $produit)
                                    <tr>
                                        <td class="align-middle">{{ $loop->iteration }}</td>
                                        <td class="align-middle">{{ $produit->ref }}</td>
                                        <td class="align-middle">{{ $produit->libelle }}</td>
                                        <td class="align-middle">{{ $produit->price_buy }}</td>
                                        <td class="align-middle">{{ $produit->price }}</td>
                                        <td class="align-middle">{{ $produit->qte }}</td>
                                        <td class="align-middle">@php echo (($produit->bon_commande != null)?$produit->bon_commande->num . ' - ' . $produit->bon_commande->fournisseur->nom_complet : '- - -'); @endphp</td>
                                        <td class="align-middle">
                                            <div class="dropdown dropstart">
                                                <a class="text-muted text-primary-hover" href="#" role="button"
                                                    id="dropdownTeamOne" data-bs-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-more-vertical icon-xxs">
                                                        <circle cx="12" cy="12" r="1">
                                                        </circle>
                                                        <circle cx="12" cy="5" r="1">
                                                        </circle>
                                                        <circle cx="12" cy="19" r="1">
                                                        </circle>
                                                    </svg>
                                                </a>
                                                <div class="dropdown-menu" aria-labelledby="dropdownTeamOne">
                                                    <a class="dropdown-item"
                                                        href="{{ route('produit.edit', ['produit' => $produit->id]) }}">Modifier</a>
                                                    <form
                                                        action="{{ route('produit.destroy', ['produit' => $produit->id]) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item">Supprimer</button>
                                                    </form>
                                                    <a class="dropdown-item"
                                                        href="{{ route('produit.show', ['produit' => $produit->id]) }}">Détails
                                                        produit</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <x-data-not-found message="Il y a aucun produit ce moment." />
                @endif
                @if (session()->exists('status'))
                    <div class="alert alert-success mx-2" role="alert">
                        {{ session('status', '') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('custom_script')
<script src="{{asset('js/datatable_js.js')}}"></script>
@endsection