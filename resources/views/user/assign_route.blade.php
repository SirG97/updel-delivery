@extends('user.layout.access_role')
@section('title', 'Assign Routes')
@section('icon', 'fa-paper-plane')
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
                       Select a rider to assign route
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover ">
                            <thead class="trx-bg-head text-secondary py-3 px-3">
                            <tr>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Routes </th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="table-style">
                            @if(!empty($staffs) && count($staffs) > 0)
                                @foreach($staffs as $staff)
                                    <tr class="">
                                        <td scope="row" class="align-middle py-2">
                                            @if($staff['image'] !== '')
                                                <img class="avatar rounded-circle img-thumbnail img-fluid" src="/{{$staff['image']}}" alt="profile pics">
                                            @else
                                                <img class="avatar rounded-circle img-thumbnail img-fluid" src="/img/avatar-1.jpg" alt="profile pics">
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            {{ $staff['firstname'] }} {{ $staff['lastname']  }}
                                        </td>
                                        <td class="align-middle">{{ $staff['phone'] }}</td>
                                        <td class="align-middle">{{ $staff['created_at']->diffForHumans() }}</td>
                                        <td class="table-action align-middle">
                                            <a href="/assign_routes/{{ $staff['user_id'] }}" >Assign route</a> &nbsp; &nbsp;
                                        </td>

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
