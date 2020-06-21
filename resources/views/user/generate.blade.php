@extends('user.layout.access_role')
@section('title', 'Generate Pins')
@section('icon', 'fa-user-plus')
@section('content')
<div class="container-fluid">
    <div class="row ">
        <div class="col-md-12">
            <div class="custom-panel card py-2">
                <div class="font-weight-bold text-secondary mb-1 py-3 px-3">
                    Generate QR code
                </div>
                <form action="/pins/new" method="POST">
                    <div class="container">
                        <div class="row cool-border trx-bg-head py-3">
                            <div class="col-md-8 offset-md-2">
                                @include('includes/message')
                                <div class="form-row">
                                    <input type="hidden" name="token" value="{{\App\Classes\CSRFToken::_token()}}">
                                    <div class="col-md-8 mb-3">
                                        <label for="email">Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend3">&#8358</span>
                                            </div>
                                            <input type="text" class="form-control" name="amt500" value="500" readonly aria-describedby="inputGroupPrepend3" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="qty5">Quantity</label>
                                        <div class="input-group">
                                            <input type="number" min="0" max="1000" id="qty5" name="qty500" class="form-control" aria-label="" placeholder="Quantity">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-8 mb-3">
                                        <label for="email">Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend3">&#8358</span>
                                            </div>
                                            <input type="text" class="form-control" name="amt1000" value="1000" readonly aria-describedby="inputGroupPrepend3" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="qty1000">Quantity</label>
                                        <div class="input-group">
                                            <input type="number" min="0" max="1000" id="qty1000" name="qty1000" class="form-control" aria-label="" placeholder="Quantity">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="col-md-8 mb-3">
                                        <label for="email">Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend3">&#8358</span>
                                            </div>
                                            <input type="text" class="form-control" name="amt2000" value="2000" readonly aria-describedby="inputGroupPrepend3" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="qty2000">Quantity</label>
                                        <div class="input-group">
                                            <input type="number" min="0" max="1000" id="qty2000" name="qty2000" class="form-control" aria-label="" placeholder="Quantity">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="col-md-8 mb-3">
                                        <label for="email">Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend3">&#8358</span>
                                            </div>
                                            <input type="text" class="form-control" name="amt3000" value="3000" readonly aria-describedby="inputGroupPrepend3" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="qty3000">Quantity</label>
                                        <div class="input-group">
                                            <input type="number" min="0" max="1000" id="qty3000" name="qty3000" class="form-control" aria-label="" placeholder="Quantity">
                                        </div>
                                    </div>

                                </div>
                                <div class="form-row">
                                    <div class="col-md-8 mb-3">
                                        <label for="email">Amount</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="inputGroupPrepend3">&#8358</span>
                                            </div>
                                            <input type="text" class="form-control" name="amt5000" value="5000" readonly aria-describedby="inputGroupPrepend3" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="qty5000">Quantity</label>
                                        <div class="input-group">
                                            <input type="number" min="0" max="1000" id="qty5000" name="qty5000" class="form-control" aria-label="" placeholder="Quantity">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer py-2 mt-2 mr-3 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary btn-sm px-3">Generate</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection()