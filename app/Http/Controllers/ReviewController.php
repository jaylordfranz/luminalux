<?php
namespace App\Http\Controllers;

use App\Models\Checkout;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        // Fetch all reviews with related product and customer data, paginate by 10
        $reviews = Review::with('product', 'customer')->paginate(10); // Adjust the relationships if necessary
        return view('admin.reviews', compact('reviews'));
    }
    
    public function show(Checkout $order)
    {
        return view('customer.reviews', [
            'order' => $order
        ]);
    }

    public function store(Request $request, Checkout $order)
    {
        $request->validate([
            'review' => 'required|string',
        ]);

        $order->reviews()->create([
            'content' => $request->input('review'),
        ]);

        return redirect()->route('reviews.show', $order->id)
                         ->with('success', 'Review submitted successfully!');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return redirect()->route('admin.reviews')->with('success', 'Review deleted successfully!');
    }
}
