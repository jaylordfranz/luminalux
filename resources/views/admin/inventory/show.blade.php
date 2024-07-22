@extends('layouts.admin')


@section('content')
    @include('partials.header')


    <div class="main-content">
        <h2>Inventory Details</h2>


        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th>Product Name</th>
                            <td>{{ $inventory->product->name }}</td>
                        </tr>
                        <tr>
                            <th>Quantity</th>
                            <td>{{ $inventory->quantity }}</td>
                        </tr>
                        <tr>
                            <th>Last Updated</th>
                            <td>{{ $inventory->updated_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <a href="{{ route('inventory.index') }}" class="btn btn-primary mt-3">Back</a>
    </div>


    @include('partials.footer')
@endsection


