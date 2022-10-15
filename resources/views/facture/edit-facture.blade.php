@extends('app')

@section('title', 'Modifier Facture')

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
                <h3 class="mb-0 fw-bold">Modifier une Facture</h3>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <form action="{{ route('facture.update', ['facture' => $facture->num]) }}" method="post">
                @csrf
                @method('PUT')
                <div class="card h100">
                    <div class="card-header bg-white py-4">
                        <div class="row">
                            <div class="col-xs-12 col-md-4">
                                @php
                                    use Illuminate\Support\Str;
                                    $zeros = "";
                                    $nb_zeros = 8 - Str::length($facture->num);
                                    for ($i=0; $i < $nb_zeros; $i++) {
                                        $zeros .= "0";
                                    }
                                    $facture_num = $zeros . $facture->num . "/" . $facture->created_at->format('y');
                                @endphp
                                <input class="form-control form-control-sm" placeholder="N° facture" type="text"
                                    id="facture_num" name="facture_num" value="{{ $facture_num }}">
                            </div>
                            <div class="col-xs-12 col-md-8">
                                <div class="input-group">
                                    <select class="livesearchclient form-control" id="client"
                                        name="client">
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}" {{ $client->id == $facture->client->id ? 'selected' : '' }}>{{ $client->nom_complet }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-xs-12 col-md-6">
                                <div class="input-group">
                                    <select class="livesearchproduit form-control" id="list_produits"
                                        name="livesearchproduit"></select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-2">
                                <input class="form-control form-control-sm" placeholder="QTE" type="text"
                                    id="produit_qte">
                                @php
                                    // get products ids & their quantities:
                                    $produits_ids_arr = collect([]);
                                    $quantities_values_arr = collect([]);
                                    foreach ($facture->produits as $produit) {
                                        $produits_ids_arr[] = $produit->id;
                                        $quantities_values_arr[] = $produit->facture_produit->quantity;
                                    }
                                @endphp
                                <input type="hidden" id="produit_price">
                                <input type="hidden" name="produits" id="produits_ids"
                                    value="{{ $produits_ids_arr->join(',') }}">
                                <input type="hidden" name="quantities" id="quantities_values"
                                    value="{{ $quantities_values_arr->join(',') }}">
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="input-group">
                                    <input class="form-control form-control-sm" placeholder="Prix Total" type="text"
                                        id="produit_price_total">
                                    <button class="btn btn-secondary btn-sm" type="button" id="btn_add_produit"><i
                                            class="bi bi-plus"></i></button>
                                    <button class="btn btn-secondary btn-sm d-none" type="button"
                                        id="btn_update_produit"><i class="bi bi-pencil-square"></i></button>
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6 mt-2">
                                <button type="submit" name="btnAdd" id="btnAdd"
                                    class="btn btn-primary btn-sm w-100">Modifier</button>
                            </div>
            </form>
            <div class="col-xs-12 col-md-6 mt-2">
                <form action="{{ route('facture.destroy', ['facture' => $facture->num]) }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" name="btnDelete" id=""
                        class="btn btn-danger btn-sm w-100">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
    <div class="table-responsive mx-2 mb-3">
        <table class="table text-nowrap mb-0">
            <thead class="table-light">
                <tr>
                    <th>N°</th>
                    <th>REF</th>
                    <th>Libelle</th>
                    <th>Prix U</th>
                    <th>Quantité en stock</th>
                    <th>Quantité</th>
                    <th>Prix T</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="tbl_tbody_produits">
                @foreach ($facture->produits as $produit)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $produit->ref }}</td>
                        <td>{{ $produit->libelle }}</td>
                        <td>{{ $produit->price }}</td>
                        <td>{{ $produit->qte }}</td>
                        <td>{{ $produit->facture_produit->quantity }}</td>
                        <td>{{ $produit->price * $produit->facture_produit->quantity }}</td>
                        <td>
                            <button class="btn btn-success btn-sm me-1 btn_edit_produit"
                                data-produit_id="{{ $produit->id }}"><i class="bi bi-pencil-square"></i></button>
                            <button class=" btn btn-danger btn-sm btn_Delete_produit"
                                data-produit_id="{{ $produit->id }}"><i class="bi bi-trash3"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot id="tbl_tfoot_price_global">
                @php
                    $price_total = 0;
                    foreach ($facture->produits as $produit) {
                        $price_total += $produit->price * $produit->facture_produit->quantity;
                    }
                @endphp
                <tr>
                    <td colspan="2">Prix total HT</td>
                    <td colspan="7" id="prix_total_facture_HT">{{ $price_total }}</td>
                </tr>
                <tr>
                    <td colspan="2">Prix total (TT) du devie</td>
                    <td colspan="7" id="prix_total_facture_TT">{{ ($price_total * 20) / 100 + $price_total }}</td>
                </tr>
            </tfoot>
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
@endsection

@section('custom_script')
    <script>
        var produits = {{ Illuminate\Support\Js::from($produits) }};
    </script>
    <script src="{{ asset('assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('js/facture/edit-facture.js') }}"></script>
@endsection
