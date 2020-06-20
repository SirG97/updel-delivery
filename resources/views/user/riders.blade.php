@extends('user.layout.access_role')
@section('title', 'Contributions')
@section('icon', 'fa-coins')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-6">
                <div class="searchbox mt-0 mr-0">
                    <div class="form-group has-search">
                        <span class="fa fa-search form-control-feedback"></span>
                        <input type="text" class="form-control" id="search-contribution" placeholder="Search Contributions" style="border:0;">
                    </div>
                    <div class="search-result">
                        <ul class="list-group list-group-flush" id="search-result-list">

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        Riders
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover ">
                            <thead class="trx-bg-head text-secondary py-3 px-3">
                            <tr>
                                <th scope="col">Pin</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Ledger balance</th>
                                <th scope="col">Available balance</th>
                                <th scope="col">Cycle</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(!empty($riders) && count($riders) > 0)
                                    @foreach($riders as $rider)
                                    <tr>
                                        <td scope="row">{{ $rider['pin'] }}</td>
                                        <td>{{ $rider['phone'] }}</td>
                                        <td>{{ $rider['ledger_bal'] }}</td>
                                        <td>{{ $rider['available_bal'] }}</td>
                                        <td>{{ $rider['points'] }}</td>
                                        <td>{{ $rider['created_at'] }}</td>
                                    </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5">
                                            <div class="d-flex justify-content-center">No riders yet</div>
                                        </td>
                                    </tr>
                                @endif

                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection()