@php
    use Illuminate\Support\Str;
@endphp
@extends('app')

@section('title', 'List de Facture')

@section('content_page')
<div class="modal fade gd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <table id="table-details-facture" class="table mb-0">
            <thead class="table-light">
                <th>N°</th>
                <th>REF</th>
                <th>Libelle</th>
                <th>Prix d'achat</th>
                <th>Prix Unitaire</th>
                <th>Quantité</th>
                <th>Prix Total</th>
            </thead>
            <tbody id="tbl_tbody_produits">

            </tbody>
            <tfoot id="tbl_tfoot_price_global">
                <tr>
                    <td colspan="2">Prix total HT</td>
                    <td colspan="7" id="prix_total_facture_HT">...</td>
                </tr>
                <tr>
                    <td colspan="2">Prix total (TT) du devie</td>
                    <td colspan="7" id="prix_total_facture_TT">...</td>
                </tr>
            </tfoot>
        </table>
    </div>
  </div>
</div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 mb-4">
                <h3 class="mb-0 fw-bold">List des factures</h3>
            </div>
        </div>
    </div>

    <div class="py-4">
        <div class="card h-100">
            <!-- card header  -->
            <div class="card-header bg-white py-3 text-end mx-2">
                <h4 class="mb-0"><a class="btn btn-dark" href="{{ route('facture.create') }}"><i class="bi bi-plus"></i>
                        Ajouter une facture</a> </h4>
            </div>
            <!-- table  -->
            @if (count($factures) > 0)
                <div class="table-responsive mx-2 mb-3">
                    <table class="table text-nowrap mb-0" id="mytable">
                        <thead class="table-light">
                            <tr>
                                <th>N°</th>
                                <th>Num facture</th>
                                <th>Client</th>
                                <th>Devis</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($factures as $facture)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    @php
                                        $zeros = "";
                                        $nb_zeros = 8 - Str::length($facture->num);
                                        for ($i=0; $i < $nb_zeros; $i++) {
                                            $zeros .= "0";
                                        }
                                        $facture_num = $zeros . $facture->num . "/" . $facture->created_at->format('y');
                                    @endphp
                                    <td class="align-middle">{{ $facture_num }}</td>
                                    <td class="align-middle">{{ $facture->client->nom_complet }}</td>
                                    <td class="align-middle">@if($facture->devie != null) {{$facture->devie->num}} @else --- @endif</td>
                                    <td class="align-middle">
                            <button type="button" data-bs-toggle="modal" data-bs-target=".gd-example-modal-lg" class="btn btn-primary btn_show_produits" data-facture_id="{{ $facture->num }}" data-devie_id="@php echo $facture->devie != Null ? $facture->devie->num : '' @endphp"><i class="bi bi-eye"></i></button>
                        </td>
                                    <td class="align-middle">
                                        <div class="dropdown dropstart">
                                            <a class="text-muted text-primary-hover" href="#" role="button"
                                                id="dropdownTeamOne" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-more-vertical icon-xxs">
                                                    <circle cx="12" cy="12" r="1"></circle>
                                                    <circle cx="12" cy="5" r="1"></circle>
                                                    <circle cx="12" cy="19" r="1"></circle>
                                                </svg>
                                            </a>
                                            <div class="dropdown-menu" aria-labelledby="dropdownTeamOne">
                                                <a class="dropdown-item"
                                                    href="@php echo $facture->devie != Null ? route('devie.edit', ['devie' => $facture->devie->num]) : route('facture.edit', ['facture' => $facture->num]) @endphp">Modifier</a>
                                                    <a class="dropdown-item"
                                                    href="@php echo $facture->devie != Null ? route('impression', ['id' => $facture->devie->num ,'type'=>'devie']) : route('impression', ['id' => $facture->num,'type'=>'facture']) @endphp">Imprimer</a>
                                                <form
                                                    action="{{ route('facture.destroy', ['facture' => $facture->num]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item">Supprimer</button>
                                                </form>
                                                <a class="dropdown-item"
                                                    href="{{ route('facture.show', ['facture' => $facture->num]) }}">Détails</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-data-not-found message="Il y a aucune facture ce moment." />
            @endif
            @if (session()->exists('status'))
                <div class="alert alert-success mx-2 mb-3" role="alert">
                    {{ session('status', '') }}
                </div>
            @endif
        </div>
    </div>
@endsection
@section('custom_script')
<script>
        var produits_factures = {{ Illuminate\Support\Js::from($produits_factures) }};
        var produits_devies = {{ Illuminate\Support\Js::from($produits_devies) }};
    </script>
    <script src="{{ asset('js/facture/list-factures.js') }}"></script>
    <script src="{{asset('js/datatable_js.js')}}"></script>
@endsection
