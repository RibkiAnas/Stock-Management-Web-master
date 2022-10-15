@extends('app')
@php
use Illuminate\Support\Str;
@endphp

@section('title', 'All devies')

@section('content_page')
    <div class="modal fade gd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <table id="table-details-devis" class="table mb-0">
                    <thead class="table-light">
                        <th>N°</th>
                        <th>REF</th>
                        <th>Libelle</th>
                        <th>Prix U</th>
                        <th>Quantité en stock</th>
                        <th>Quantité</th>
                        <th>Prix Total</th>
                    </thead>
                    <tbody id="tbl_tbody_produits">

                    </tbody>
                    <tfoot id="tbl_tfoot_price_global">
                        <tr>
                            <td colspan="2">Prix total HT</td>
                            <td colspan="7" id="prix_total_devie_HT">...</td>
                        </tr>
                        <tr>
                            <td colspan="2">Prix total (TT) du devie</td>
                            <td colspan="7" id="prix_total_devie_TT">...</td>
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
                <h3 class="mb-0 fw-bold">List des Fournisseurs</h3>
            </div>
        </div>
    </div>

    <div class="py-4">
        <div class="card h-100">
            <!-- card header  -->
            <div class="card-header bg-white py-3 text-end">
                <h4 class="mb-0"><a class="btn btn-dark" href="{{ route('devie.create') }}"><i class="bi bi-plus"></i>
                        Ajouter un devie</a> </h4>
            </div>
            <!-- table  -->
            @if (count($devies) > 0)
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0" id="mytable">
                        <thead class="table-light">
                            <tr>
                                <th>N°</th>
                                <th>Num devie</th>
                                <th>Client</th>
                                <th>Facture</th>
                                <th>Détails devis</th>
                                <th>Convertir á facture</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($devies as $devie)
                                <tr>
                                    <td class="align-middle">{{ $loop->iteration }}</td>
                                    @php
                                        $zeros = '';
                                        $nb_zeros = 8 - Str::length($devie->num);
                                        for ($i = 0; $i < $nb_zeros; $i++) {
                                            $zeros .= '0';
                                        }
                                        $devie_num = $zeros . $devie->num . '/' . $devie->created_at->format('y');
                                    @endphp
                                    <td class="align-middle">{{ $devie_num }}</td>
                                    <td class="align-middle">{{ $devie->client->nom_complet }}</td>
                                    <td class="align-middle">
                                        @if ($devie->facture != null)
                                            {{ $devie->facture->num }}
                                        @else
                                            ---
                                        @endif
                                    </td>
                                    <td><button type="button" data-bs-toggle="modal" data-bs-target=".gd-example-modal-lg"
                                            class="btn btn-primary btn_show_produits" data-devie_id="{{ $devie->num }}"><i
                                                class="bi bi-eye"></i></button></td>
                                    <td>
                                        @if ($devie->facture == null)
                                        <form action="{{ route('covertToInvoice') }}" method="post">
                                            @csrf
                                            <input type="hidden" name="devie" value="{{ $devie->num }}">
                                            <button type="submit" class="btn btn-primary btn_convert_to_invoice"
                                                data-devie_id="{{ $devie->num }}"><i
                                                    class="bi bi-arrow-left-right"></i></button>
                                        </form>
                                        @else
                                            ---
                                        @endif
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
                                                    href="{{ route('devie.edit', ['devie' => $devie->num]) }}">Modifier</a>

                                                <a class="dropdown-item"
                                                    href="{{ route('devie.show', ['devie' => $devie->num]) }}">+ Détails</a>
                                                    <a class="dropdown-item"
                                                    href="{{ route('impression', ['id' => $devie->num,'type'=>'devie']) }}">Imprimer</a>

                                                <form action="{{ route('devie.destroy', ['devie' => $devie->num]) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item">Supprimer</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-data-not-found message="Il y a aucun devie ce moment." />
            @endif
            @if (session()->exists('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status', '') }}
                </div>
            @endif
        </div>
    </div>
@endsection

@section('custom_script')
    <script>
        var produits = {{ Illuminate\Support\Js::from($produits) }};
    </script>
    <script src="{{ asset('js/devie/list-devies.js') }}"></script>
    <script src="{{asset('js/datatable_js.js')}}"></script>
@endsection
