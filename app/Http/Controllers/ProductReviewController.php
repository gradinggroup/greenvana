<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductReviewController extends Controller
{
    public function store(Request $request, Products $product)
    {
        $data = $request->validate([
            'name'            => ['required','string','max:100'],
            'summary'         => ['required','string','max:150'],
            'review'          => ['required','string','max:3000'],
            'rating_quality'  => ['required','integer','between:1,5'],
            'rating_price'    => ['required','integer','between:1,5'],
            'rating_value'    => ['required','integer','between:1,5'],
        ]);

        $overall = round(($data['rating_quality'] + $data['rating_price'] + $data['rating_value']) / 3, 2);

        ProductReview::create([
            'products_id'      => $product->id,
            'user_id'         => auth()->id(), // nullable jika guest
            'name'            => $data['name'],
            'summary'         => $data['summary'],
            'review'          => $data['review'],
            'rating_quality'  => $data['rating_quality'],
            'rating_price'    => $data['rating_price'],
            'rating_value'    => $data['rating_value'],
            'rating_overall'  => $overall,

        ]);

        return back()->with('success', 'Terima kasih! Review Anda telah dikirim' . (config('shop.review_auto_approve', false) ? '.' : ' dan menunggu moderasi.'));
    }
}
