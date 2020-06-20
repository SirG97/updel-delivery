@extends('user.layout.access_role')
@section('title', 'Pins')
@section('icon', 'fa-user-plus')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                @include('includes/message')
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <nav class="nav pin-nav mr-2">
                    <a class="nav-link active" href="#">General</a>
                    <a class="nav-link " href="#">Contributions</a>
                </nav>
                <div class="custom-panel card py-2">
                    <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                        Customer contribution
                    </div>

                    <form class="cool-border py-3 px-2">
                        <div class="col-md-12">
                            <div class="form-row">
                                <input type="hidden" id="customer_id"  value="" required>
                                <input type="hidden" id="token" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
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
                                        <input type="text" name="amount" id="amount" value=""  class="form-control" aria-label="Amount (to the nearest dollar)">
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

                        </div>
                    </form>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="deleteCustomerBtn">Save</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection