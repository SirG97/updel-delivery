@extends('user.layout.access_role')
@section('title', 'Order')
@section('icon', 'fa-user-plus')
@section('content')
    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12">
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                       Add new customer
                    </div>
                    <form action="/customer" method="POST">
                    <div class="container">
                        <div class="row cool-border trx-bg-head py-3">
                            <div class="col-md-8 offset-md-2">
                                @include('includes/message')
                                    <div class="form-row">
                                        <input type="hidden" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
                                        <div class="col-md-4 mb-3">
                                            <label for="firstname">First name</label>
                                            <input type="text" class="form-control" id="firstname" name="firstname" value="" required>

                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="surname">Surname</label>
                                            <input type="text" class="form-control" id="surname" name="surname" value="" required>

                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="email">Email</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="inputGroupPrepend3">@</span>
                                                </div>
                                                <input type="email" class="form-control" name="email" id="email" aria-describedby="inputGroupPrepend3" required>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-5 mb-3">
                                            <label for="phone">Phone number</label>
                                            <input type="text" class="form-control"  name="phone" id="phone" required>

                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="city">City</label>
                                            <input type="text" class="form-control" name="city" id="city" required>

                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="state">State</label>
                                            <select class="custom-select" id="state" name="state" required>
                                                <option selected value="Anambra">Anambra</option>
                                                <option value="Delta">Delta</option>
                                                <option value="Enugu">Enugu</option>
                                                <option value="Ebonyi">Ebonyi</option>
                                                <option value="Imo">Imo</option>
                                                <option value="Abia">Abia</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-5 mb-3">
                                            <label for="amount">Daily amount</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">&#8358</span>
                                                </div>
                                                <input type="text" name="amount" value="500"  class="form-control" aria-label="Amount (to the nearest dollar)">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-7 mb-3">
                                            <label for="state">Address</label>
                                            <input type="text" class="form-control"  name="address" id="address" required>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="invalidCheck3" required>
                                            <label class="form-check-label" for="invalidCheck3">
                                                Agree to terms and conditions
                                            </label>
                                        </div>
                                    </div>


                            </div>
                        </div>
                    </div>
                    <div class="panel-footer py-2 mt-2 mr-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm px-3">Save</button>
                    </div>
                </form>
                </div>
            </div>

        </div>
    </div>
@endsection()
