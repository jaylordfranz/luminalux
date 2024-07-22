@extends('layouts.admin')


@section('content')
    @include('partials.header')


    <div class="main-content">
        <h2>Category Details</h2>


        <div class="card">
            <div class="card-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Name</th>
                            <td>{{ $category->name }}</td>
                        </tr>
                        <tr>
                            <th>Description</th>
                            <td>{{ $category->description }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">Back</a>
    </div>


    @include('partials.footer')
@endsection
