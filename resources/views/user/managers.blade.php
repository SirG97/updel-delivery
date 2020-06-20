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
                    Managers
                </div>
                <div class="table-responsive">
                    <table class="table table-hover ">
                        <thead class="trx-bg-head text-secondary py-3 px-3">
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone</th>
                            <th scope="col">Created </th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="table-style">
                        @if(!empty($managers) && count($managers) > 0)
                            @foreach($managers as $manager)
                                <tr>
                                <td scope="row">
                                    {{ $manager['firstname'] }} {{ $manager['lastname']  }}
                                </td>
                                <td>{{ $manager['email'] }}</td>
                                <td>{{ $manager['phone'] }}</td>
                                <td>{{ $manager['created_at']->diffForHumans() }}</td>
                                <td>{{ $manager['status'] }}</td>

                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5">
                                    <div class="d-flex justify-content-center">No Managers yet</div>
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