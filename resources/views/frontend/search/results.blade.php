@extends('frontend.main_master')

@section('title')
  @if(session()->get('language') == 'ind') Hasil Pencarian @else Search Results @endif
@endsection

@section('content')
<div class="container my-4">
  <h3 class="mb-3">
    @if(session()->get('language') == 'ind') Hasil untuk: @else Results for: @endif
    <em>"{{ $q }}"</em>
  </h3>

  @if($products->count() === 0)
    <p class="text-muted">
      @if(session()->get('language') == 'ind') Tidak ada produk ditemukan. @else No products found. @endif
    </p>
  @else
    <div class="row">
      @foreach($products as $product)
        <div class="col-6 col-md-3 mb-4">
          <a href="{{ route('product.details', [
                  'id'   => $product->id,
                  'slug' => session()->get('language') == 'ind'
                              ? $product->product_slug_ind
                              : $product->product_slug_en
              ]) }}"
            class="text-decoration-none">

            <div class="card h-100">
              <img src="{{ asset($product->product_thambnail) }}" width="85" class="card-img-top" alt="...">
              <div class="card-body">
                <h6 class="card-title mb-1">
                  {{ session()->get('language') == 'ind' ? $product->product_name_ind : $product->product_name_en }}
                </h6>
                @isset($product->selling_price)
                  <div class="text-primary fw-bold">Rp {{ number_format($product->selling_price,0,',','.') }}</div>
                @endisset
              </div>
            </div>
          </a>
        </div>
      @endforeach
    </div>

    <div>
      {{ $products->links() }}
    </div>
  @endif
</div>
@endsection
