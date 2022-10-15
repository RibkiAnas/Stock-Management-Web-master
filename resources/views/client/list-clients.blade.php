@extends('app')

@section('title','List de clients')

@section('content_page')
    <div class="row">
          <div class="col-lg-12 col-md-12 col-12">
            <!-- Page header -->
            <div class="border-bottom pb-4 mb-4">
                <h3 class="mb-0 fw-bold">List des Clients</h3>
            </div>
          </div>
        </div>

        <div class="py-4">
            <div class="card h-100">
                <!-- card header  -->
                <div class="card-header bg-white py-3 text-end mx-2">
                  <h4 class="mb-0"><a class="btn btn-dark" href="{{ route('client.create') }}"><i class="bi bi-plus"></i> Ajouter un client</a> </h4>
                </div>
                <!-- table  -->
                @if (count($clients) > 0)
                <div class="table-responsive mb-3 mx-2">
                  <table class="table text-nowrap mb-0" id="mytable">
                    <thead class="table-light">
                      <tr>
                        <th>N°</th>
                        <th>Nom complet</th>
                        <th>Télephone</th>
                        <th>RC</th>
                        <th>ICE</th>
                        <th>Societé</th>
                        <th>Crédit</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                      <tr>
                        <td class="align-middle">{{$loop->iteration}}</td>
                        <td class="align-middle">{{$client->nom_complet}}</td>
                        <td class="align-middle">{{$client->telephone}}</td>
                        <td class="align-middle">{{$client->rc}}</td>
                        <td class="align-middle">{{$client->ice}}</td>
                        <td class="align-middle">{{$client->nom_societe}}</td>
                        <td class="align-middle">{{$client->credit}}</td>
                        <td class="align-middle">
                          <div class="dropdown dropstart">
                            <a class="text-muted text-primary-hover" href="#" role="button" id="dropdownTeamOne" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical icon-xxs"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownTeamOne">
                              <a class="dropdown-item" href="{{route('client.edit', ['client'=>$client->id]) }}">Modifier</a>
                              <form action="{{ route('client.destroy', ['client'=>$client->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item">Delete</button>
                            </form>
                              <a class="dropdown-item" href="{{ route('client.show', ['client'=>$client->id]) }}">Détails client</a>
                            </div>
                          </div>
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
                @else
                  <x-data-not-found message="Il y a aucun client ce moment." />
                @endif
                @if (session()->exists('status'))
                   <div class="alert alert-success mx-2" role="alert">
                        {{ session('status', '') }}
                    </div>
                    @endif
              </div>
        </div>
@endsection

@section('custom_script')
<script src="{{asset('js/datatable_js.js')}}"></script>
@endsection
