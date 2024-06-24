@extends('layouts.app')

@section('content')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reviews</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <style>
        /* Custom styles */
        .review-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
        }
        .review-form {
            margin-bottom: 30px;
        }
        .review-item {
            margin-bottom: 20px;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            transition: transform 0.3s ease-in-out;
        }
        .review-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }
        .review-header {
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .review-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            margin-right: 10px;
            border: 2px solid #dee2e6;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .review-details {
            flex-grow: 1;
        }
        .review-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .review-rating {
            margin-bottom: 5px;
        }
        .review-body {
            margin-bottom: 15px;
            color: #555;
        }
        .review-actions {
            margin-top: 15px;
        }
        .btn-edit {
            background-color: #ffc107;
            border-color: #ffc107;
            transition: background-color 0.3s ease-in-out;
        }
        .btn-edit:hover {
            background-color: #e0a800;
            border-color: #e0a800;
        }
        .btn-delete {
            background-color: #dc3545;
            border-color: #dc3545;
            transition: background-color 0.3s ease-in-out;
        }
        .btn-delete:hover {
            background-color: #c82333;
            border-color: #c82333;
        }
        .star-rating i {
            color: #ffc107;
        }
    </style>
</head>
<body>

<div class="container review-container">
    <!-- Review Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title">Write Your Review</h5>
        </div>
        <div class="card-body">
            <form action="#" method="POST" id="reviewForm">
                @csrf
                <div class="form-group">
                    <label for="reviewTitle">Review Title</label>
                    <input type="text" class="form-control" id="reviewTitle" name="reviewTitle" placeholder="Enter review title">
                </div>
                <div class="form-group">
                    <label for="reviewRating">Rating</label>
                    <div class="star-rating" id="starRating">
                        <button type="button" class="btn btn-star" data-rating="1"><i class="far fa-star"></i></button>
                        <button type="button" class="btn btn-star" data-rating="2"><i class="far fa-star"></i></button>
                        <button type="button" class="btn btn-star" data-rating="3"><i class="far fa-star"></i></button>
                        <button type="button" class="btn btn-star" data-rating="4"><i class="far fa-star"></i></button>
                        <button type="button" class="btn btn-star" data-rating="5"><i class="far fa-star"></i></button>
                    </div>
                    <input type="hidden" id="reviewRating" name="reviewRating">
                </div>
                <div class="form-group">
                    <label for="reviewBody">Review</label>
                    <textarea class="form-control" id="reviewBody" name="reviewBody" rows="4" placeholder="Enter your review"></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Submit Review</button>
            </form>
        </div>
    </div>

    <!-- Reviews List -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">Customer Reviews</h5>
        </div>
        <div class="card-body">
            @for ($i = 1; $i <= 5; $i++)
            <div class="review-item">
                <div class="review-header">
                    <img src="https://via.placeholder.com/50" alt="User Avatar" class="review-avatar">
                    <div class="review-details">
                        <div class="review-title">Review Title {{ $i }}</div>
                        <div class="review-rating">
                            @for ($j = 1; $j <= 5; $j++)
                            <i class="fas fa-star"></i>
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="review-body">
                    This is a placeholder review. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec aliquet, quam et convallis consequat, ligula nisl congue velit, sed semper lorem turpis in dolor.
                </div>
                <div class="review-actions">
                    <button class="btn btn-edit"><i class="fas fa-edit"></i> Edit</button>
                    <button class="btn btn-delete"><i class="fas fa-trash-alt"></i> Delete</button>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>

<!-- Bootstrap and Font Awesome JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js"></script>
<script>
    // Star rating script
    $(document).ready(function () {
        $(".btn-star").click(function () {
            var rating = $(this).data('rating');
            $("#reviewRating").val(rating);
            $(this).parent().children(".btn-star").each(function (index) {
                if (index < rating) {
                    $(this).html('<i class="fas fa-star"></i>');
                } else {
                    $(this).html('<i class="far fa-star"></i>');
                }
            });
        });
    });
</script>

@endsection

