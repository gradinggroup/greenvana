<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Products;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $q = trim($request->get('q', ''));
        if ($q === '') {
            return redirect()->back();
        }

        $products = Products::query()
            ->where('status', 1) // opsional, kalau punya kolom status
            ->where(function ($query) use ($q) {
                $query->where('product_name_en', 'like', "%{$q}%")
                      ->orWhere('product_name_ind', 'like', "%{$q}%");
            })
            ->latest()
            ->paginate(24)
            ->appends(['q' => $q]);

        return view('frontend.search.results', compact('products', 'q'));
    }

    // Ajax suggest (maks 8 item)
    public function suggest(Request $request)
    {
        $q = trim($request->get('q', ''));
        if ($q === '') {
            return response()->json([]);
        }

        $rows = Products::query()
            ->select('id', 'product_name_en', 'product_name_ind', 'product_slug_en', 'product_slug_ind', 'product_thumbnail')
            ->where('status', 1) // opsional
            ->where(function ($query) use ($q) {
                // prefix match biar suggestion terasa cepat
                $query->where('product_name_en', 'like', "{$q}%")
                      ->orWhere('product_name_ind', 'like', "{$q}%");
            })
            ->orderBy('product_name_en')
            ->limit(8)
            ->get();

        $lang = session()->get('language') === 'ind' ? 'ind' : 'en';

        $data = $rows->map(function ($p) use ($lang) {
            return [
                'id'    => $p->id,
                'name'  => $lang === 'ind' ? $p->product_name_ind : $p->product_name_en,
                'url'   => $lang === 'ind'
                            ? url('/product/' . $p->id . '/' . $p->product_slug_ind)
                            : url('/product/' . $p->id . '/' . $p->product_slug_en),
                'thumb' => $p->product_thumbnail ? asset($p->product_thumbnail) : null,
            ];
        });

        return response()->json($data);
    }
}
