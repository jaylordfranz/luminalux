@extends('layouts.app')


@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Add Billing Address</div>


                    <div class="card-body">
                        <form method="POST" action="{{ route('billing-addresses.store') }}">
                            @csrf


                            <div class="form-group">
                                <label for="addressName">Address Name</label>
                                <input type="text" class="form-control" id="addressName" name="address_name" required>
                            </div>


                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>


                            <div class="form-group">
                                <label for="contactNumber">Contact Number</label>
                                <input type="text" class="form-control" id="contactNumber" name="contact_number" required>
                            </div>


                            <button type="submit" class="btn btn-primary">Save Address</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
