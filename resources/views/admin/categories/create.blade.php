@extends('layouts.admin')

@section('content')
    @include('partials.header')

    <div class="main-content">
        <h2>Add Category</h2>

        {{-- Display validation errors summary --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="addCategoryForm" action="{{ route('categories.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>

    @include('partials.footer')
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $('#addCategoryForm').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                description: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "Please enter a category name",
                    maxlength: "The name cannot be more than 255 characters"
                },
                description: {
                    required: "Please enter a description"
                }
            },
            submitHandler: function(form) {
                form.submit();
            }
        });
    });
</script>
@endsection
