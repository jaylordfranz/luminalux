@extends('layouts.app')




@section('content')




<div class="container profile-container">
    <div class="text-center">
        <img src="https://via.placeholder.com/150" alt="Profile Image" class="profile-image">
        <h2>{{ $user->name }}</h2>
        <p>Email: {{ $user->email }}</p>
    </div>




    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">Edit Profile</div>




                <div class="card-body">
                    <form method="POST" action="{{ route('customer.profile.update') }}">
                        @csrf
                        @method('PUT')




                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>




                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>




                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $user->email }}" required autocomplete="email">




                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>




                        <!-- Add New Billing Address Modal Button -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBillingAddressModal">
                            Add New Billing Address
                        </button>
                        <!-- End Add New Billing Address Modal Button -->




                   <!-- Default Billing Address Dropdown -->
<div class="form-group mt-3">
    <label for="defaultAddress">Default Billing Address</label>
    <select class="form-control" id="defaultAddress" name="default_address">
        <option value="">Select Default Address</option>
        @foreach($billingAddresses as $address)
            <option value="{{ $address->id }}" {{ $user->default_billing_address_id == $address->id ? 'selected' : '' }}>
                {{ $address->address_name }} - {{ $address->address }} - {{ $address->contact_number }}
            </option>
        @endforeach
    </select>
</div>
<!-- End Default Billing Address Dropdown -->








<div class="text-center">
    @if ($user->defaultBillingAddress)
        <p>
           <b> Default Billing Address: </b>
            {{ $user->defaultBillingAddress->address_name }} -
            {{ $user->defaultBillingAddress->address }} -
            {{ $user->defaultBillingAddress->contact_number }}
        </p>
    @else
        <p>No default billing address set.</p>
    @endif
</div>












                        <div class="form-group mt-3 mb-0">
                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>
                        </div>
                    </form>
                      <!-- Logout Form -->
                      <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger mt-3">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<!-- Add Billing Address Modal -->
<div class="modal fade" id="addBillingAddressModal" tabindex="-1" role="dialog" aria-labelledby="addBillingAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addBillingAddressModalLabel">Add New Billing Address</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="{{ route('billing-addresses.store') }}">
                @csrf
                <div class="modal-body">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Address</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Add Billing Address Modal -->




@endsection
