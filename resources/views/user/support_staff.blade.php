@extends('user.layout.base')
@section('title', 'Manager')
@section('icon', 'fa-user-plus')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @include('includes\message')
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">

                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        Support Staff
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover ">
                            <thead class="trx-bg-head text-secondary py-3 px-3">
                            <tr>
                                <th scope="col">Serial</th>
                                <th scope="col">Pin</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Generated On</th>
                                <th scope="col">Status</th>
                            </tr>
                            </thead>
                            <tbody class="table-style">
                            @if(!empty($support_staffs) && count($support_staffs) > 0)
                                @foreach($support_staffs as $support_staff)
                                    <tr>
                                        <td scope="row">
                                            {{ $manager['serial'] }}
                                        </td>
                                        <td>{{ $manager['pin'] }}</td>
                                        <td>{{ $manager['amount'] }}</td>
                                        <td>{{ $manager['created_at'] }}</td>
                                        <td>{{ $manager['status'] }}</td>

                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5">
                                        <div class="d-flex justify-content-center">No Support staff yet</div>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="panel-footer py-1 mt-0 mr-3 d-flex justify-content-end">
                        {!! $links !!}
                    </div>

                </div>
            </div>

        </div>

    </div>


@endsection