@php
use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <style>
        @media print {
        hr,.btn{
            display: none
        }
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="card-body">
            <div class="container mb-5 mt-3">
                <div class="container">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-items-center">
                                <p class="pt-0"><img src="{{ asset('assets/images/background/logo.png') }}" alt="logo" srcset=""
                                    style="width:350px;" ></p>
                                <p class="fw-bold" style=" font-size: 2.7em;">بيع مواد الكهرباء</p>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-xl-8">
                            <table class="table table-bordered border-dark">
                                <thead class="table-secondary border-dark">
                                  <tr>
                                    <th scope="col">CLIENT</th>
                                    <th scope="col">DATE</th>
                                    <th scope="col">FACTUR</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td class="fw-bolder">{{ isset($devie) ? $devie->client->nom_societe : (isset($facture) ? $facture->client->nom_complet : '---') }}</td>
                                    <td class="fw-bolder">{{ isset($devie) ? date_format($devie->created_at, 'Y-m-d') : (isset($facture) ? date_format($facture->created_at, 'Y-m-d') : '---') }}</td>
                                    <td class="fw-bolder">
                                        @php
                                        $zeros = '';
                                        $nb_zeros = 8 - Str::length(isset($devie) ? $devie->num : (isset($facture) ? $facture->num : ''));
                                        for ($i = 0; $i < $nb_zeros; $i++) {
                                            $zeros .= '0';
                                        }
                                        $object_num = $zeros . (isset($devie) ? $devie->num : (isset($facture) ? $facture->num : 0)) . '/' . (isset($devie) ? $devie->created_at->format('y') : (isset($facture) ? $facture->created_at->format('y') : 0));
                                        @endphp
                                        N°:</span>{{ $object_num }}
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                              <div class="text-center">
                                <p class="fs-5 text-primary">ICE:{{ isset($devie) ? $devie->client->ice : (isset($facture) ? $facture->client->ice : '---') }}</p>
                              </div>
                        </div>
                    </div>
                    @php
                        $produits = isset($devie) ? $devie->produits : (isset($facture) && $facture->devie == null ? $facture->produits : $facture->devie->produits);
                    @endphp
                    @if (count($produits) > 0)
                        <div class="row my-2 mx-1 justify-content-center">
                            <table class="table table-bordered border-dark">
                                <thead class="table-secondary border-dark">
                                  <tr>
                                    <th scope="col">Q</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">P.U HT</th>
                                    <th scope="col">Total HT</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($produits as $produit)
                                    @php $qte = isset($devie) ? $produit->devie_produit->quantity : (isset($facture) && $facture->devie == null ? $produit->facture_produit->quantity : $produit->devie_produit->quantity) @endphp
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $produit->libelle }}</td>
                                        <td>{{ $produit->price }}</td>
                                        <td>{{  $qte * $produit->price }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                              </table>
                        </div>
                        <div class="row my-2 mx-1 justify-content-center">
                            @php
                                $price_total = 0;
                                foreach ($produits as $produit) {
                                    $qte = isset($devie) ? $produit->devie_produit->quantity : (isset($facture) && $facture->devie == null ? $produit->facture_produit->quantity : $produit->devie_produit->quantity);
                                    $price_total += $produit->price * $qte;
                                }
                            @endphp
                            <table class="table table-bordered border-dark">
                                <tbody>
                                      <tr>
                                        <th rowspan="4" style="width: 50%;" class="">
                                           <textarea class="text-center fs-7" cols="30" rows="3" style="width: 100%; border:none;"></textarea>
                                        </th>
                                        <tr class="table-secondary">
                                            <th>TOTAL HT</th>
                                            <td>{{$price_total}}</td>
                                        </tr>
                                        <tr class="table-secondary">
                                            <th>TVA 20%</th>
                                            <td>{{ ($price_total * 20) / 100 }}</td>
                                        </tr>
                                        <tr class="table-secondary">
                                            <th>TOTAL TTC</th>
                                            <td>{{ ($price_total * 20) / 100 + $price_total }}</td>
                                        </tr>
                                      </tr>
                                      
                                </tbody>
                              </table>
                        </div>
                        <div class="row">
                            <div class="col-xl-2">
                                <button type="button" class="btn btn-primary text-capitalize"
                                    style="background-color:#60bdf3 ;" onclick="window.print();">Imprimer</button>
                                    <a href="{{ route('dashboard', ['filter_value'=>'global']) }}" class="btn btn-primary text-capitalize"
                                    style="background-color:#60bdf3 ;">GO back</a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
