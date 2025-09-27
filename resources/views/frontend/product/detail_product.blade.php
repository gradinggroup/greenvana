@extends('frontend.main_master')
@section('content')

@section('title')
	Product Detail
@endsection()



<!-- ===== ======== HEADER : END ============================================== -->


<div class="body-content outer-top-xs">
	<div class='container'>
		<div class='row single-product'>
			<div class='col-md-3 sidebar'>
				<div class="sidebar-module-container">
				<div class="home-banner outer-top-n">
<img src="{{ asset('frontend/assets/images/banners/LHS-banner.jpg') }}" alt="Image">
</div>		
  
    
    
    	<!-- ====================== HOT DEALS ============================== -->
    	@include('frontend.common.hotdeals_product')
<!-- ============================== HOT DEALS: END ================================== -->					

<!-- ============================================== NEWSLETTER ============================================== -->
<div class="sidebar-widget newsletter wow fadeInUp outer-bottom-small outer-top-vs">
	<h3 class="section-title">Newsletters</h3>
	<div class="sidebar-widget-body outer-top-xs">
		<p>Sign Up for Our Newsletter!</p>
        <form>
        	 <div class="form-group">
			    <label class="sr-only" for="exampleInputEmail1">Email address</label>
			    <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Subscribe to our newsletter">
			  </div>
			<button class="btn btn-primary">Subscribe</button>
		</form>
	</div><!-- /.sidebar-widget-body -->
</div><!-- /.sidebar-widget -->
<!-- ============================================== NEWSLETTER: END ============================================== -->

<!-- ============================================== Testimonials (Product Reviews) ============================================== -->
@php
    // Ambil 10 review terbaru utk produk ini
    $sidebarReviews = $product->reviews()->latest()->take(10)->get();
@endphp

<div class="sidebar-widget wow fadeInUp outer-top-vs">
    <h3 class="section-title">Customer Reviews</h3>

    <div id="advertisement" class="advertisement">
        @forelse ($sidebarReviews as $rv)
            <div class="item">
                <div class="avatar">
                    {{-- pakai foto user jika ada, fallback ke avatar default --}}
                    <img src="{{ optional($rv->user)->profile_photo_url ?? asset('frontend/assets/images/testimonials/default.png') }}" alt="Avatar">
                </div>

                <div class="testimonials">
                    {{-- ringkas review agar rapi di sidebar --}}
                    <em>"</em> {{ \Illuminate\Support\Str::limit($rv->review, 140) }} <em>"</em>
                </div>

                <div class="clients_author">
                    {{ $rv->name }}
                    <span>{{ $rv->created_at->diffForHumans() }}</span>
                </div>

<div class="rv-stars m-t-10 ">
  @php $stars = (int) round($rv->rating_overall); @endphp
  @for($i=1;$i<=5;$i++)
    <i class="fa {{ $i <= $stars ? 'fa-star' : 'fa-star-o' }}"></i>
  @endfor
  <small class="text-muted">({{ number_format($rv->rating_overall,1) }})</small>
</div>


            </div><!-- /.item -->
        @empty




		




        @endforelse
    </div><!-- /#advertisement.advertisement -->
</div>
<!-- ============================================== Testimonials: END ============================================== -->





				</div>
			</div><!-- /.sidebar -->
			<div class='col-md-9'>
            <div class="detail-block">
				<div class="row  wow fadeInUp">
                
					     <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
    <div class="product-item-holder size-big single-product-gallery small-gallery">

        <div id="owl-single-product">

        	@foreach($multiImg as $img)
            <div class="single-product-gallery-item" id="slide{{ $img->id }}">
                <a data-lightbox="image-1" data-title="Gallery" href="{{ asset($img->photo_name) }}">
                    <img class="img-responsive" alt="" src="{{ asset($img->photo_name) }}" data-echo="{{ asset($img->photo_name) }}" />
                </a>
            </div>
            @endforeach()<!-- /.single-product-gallery-item -->


        </div><!-- /.single-product-slider -->



        <div class="single-product-gallery-thumbs gallery-thumbs">

            <div id="owl-single-product-thumbnails">

            	@foreach($multiImg as $img)
                <div class="item">
                    <a class="horizontal-thumb active" data-target="#owl-single-product" data-slide="1" href="#slide{{ $img->id }}">
                        <img class="img-responsive" width="85" alt="" src="{{ asset($img->photo_name) }}" data-echo="{{ asset($img->photo_name) }}" />
                    </a>
                </div>
                @endforeach

                   
            </div><!-- /#owl-single-product-thumbnails -->

            

        </div><!-- /.gallery-thumbs -->

    </div><!-- /.single-product-gallery -->
</div><!-- /.gallery-holder -->        			
					<div class='col-sm-6 col-md-7 product-info-block'>
						<div class="product-info">
							<h1 class="name" id="pname">@if(session()->get('language') == 'ind') {{ $product->product_name_ind }} @else {{ $product->product_name_en }} @endif</h1>
							
@php
    // ambil semua review produk
    $reviews = $product->reviews;
    $reviewCount = $reviews->count();
    $averageRating = $reviewCount > 0
        ? round($reviews->avg('rating_overall'), 1)
        : 0;
@endphp

<div class="rating-reviews m-t-20">
    <div class="row">
        <div class="col-sm-3">
            {{-- tampilkan bintang rata-rata --}}
            <div class="rv-stars">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fa {{ $i <= round($averageRating) ? 'fa-star' : 'fa-star-o' }}"></i>
                @endfor
            </div>
        </div>
        <div class="col-sm-8">
            <div class="reviews">
                <a href="#review" class="lnk">
                    ({{ $reviewCount }} Reviews • {{ $averageRating }}/5)
                </a>
            </div>
        </div>
    </div><!-- /.row -->
</div><!-- /.rating-reviews -->


							<div class="stock-container info-container m-t-10">
								<div class="row">
									<div class="col-sm-2">
										<div class="stock-box">
											<span class="label">Tersedia :</span>
										</div>	
									</div>
									<div class="col-sm-9">
										<div class="stock-box">
											<span class="value">{{ $product->product_qty }}</span>
										</div>	
									</div>
								</div><!-- /.row -->	
							</div><!-- /.stock-container -->

							<div class="description-container m-t-20">
								@if(session()->get('language') == 'ind') {{ $product->short_descp_ind }} @else {{ $product->short_descp_en }} @endif
							</div><!-- /.description-container -->

							<div class="price-container info-container m-t-20">
								<div class="row">

									@php
			                            $amount = $product->selling_price - $product->discount_price;
			                            $discount = ($amount/$product->selling_price) * 100;

			                         @endphp
									

									<div class="col-sm-6">
										<div class="price-box">
											@if($product->discount_price == NULL)
											<span class="price">{{ $product->selling_price }}</span>
											@else
											<span class="price">Rp. {{ $product->selling_price }}</span>
											<span class="price-strike">Rp. {{ $product->discount_price }}</span>
											@endif
										</div>
									</div>

									<div class="col-sm-6">
										<div class="favorite-button m-t-10">
											<a class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Wishlist" href="#">
											    <i class="fa fa-heart"></i>
											</a>
											<a class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Add to Compare" href="#">
											   <i class="fa fa-signal"></i>
											</a>
											<a class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="E-mail" href="#">
											    <i class="fa fa-envelope"></i>
											</a>
										</div>
									</div>

								</div><!-- /.row -->
							</div><!-- /.price-container -->


							<div class="price-container info-container m-t-20">
								<div class="row">

									<div class="col-sm-6">
										<div class="form-group">
											<label>Color</label>
											<select name="" class="form-control" id="color">
												<option disabled selected> Pilih Color </option>
												@foreach($product_color_en as $color)
												<option value="{{ $color }}"> {{ $color }} </option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="col-sm-6">
										<div class="form-group">
											@if($product->product_size_en == NULL)
											@else
											<label>Size</label>
											<select name="" class="form-control" id="size">
												<option disabled selected> Pilih Size </option>
												@foreach($product_size_en as $size)
												<option value="{{ $size }}"> {{ $size }} </option>
												@endforeach
											</select>
											@endif
											
										</div>
									</div>

			

								</div><!-- /.row -->
							</div>



							<div class="quantity-container info-container">
								<div class="row">
									
									<div class="col-sm-2">
										<span class="label">Qty :</span>
									</div>
									
									<div class="col-sm-2">
										<div class="cart-quantity">
											<div class="quant-input">
								                <div class="arrows">
								                  <div class="arrow plus gradient"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div>
								                  <div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
								                </div>
								                <input type="number" id="qty" min="1" value="1" class="form-control">
							              </div>
							            </div>
									</div>

									<input type="hidden" id="product_id" value="{{ $product->id }}" min="1">


									<div class="col-sm-7">
										<button type="submit" onclick="addToCart()" class="btn btn-primary"><i class="fa fa-shopping-cart inner-right-vs"></i> TAMBAHKAN KE KERANJANG</button>
									</div>

									
								</div><!-- /.row -->
							</div><!-- /.quantity-container -->

							

							

							
						</div><!-- /.product-info -->
					</div><!-- /.col-sm-7 -->
				</div><!-- /.row -->
                </div>
				
				<div class="product-tabs inner-bottom-xs  wow fadeInUp">
					<div class="row">
						<div class="col-sm-3">
							<ul id="product-tabs" class="nav nav-tabs nav-tab-cell">
								<li class="active"><a data-toggle="tab" href="#description">DESCRIPTION</a></li>
								<li><a data-toggle="tab" href="#review">REVIEW</a></li>

							</ul><!-- /.nav-tabs #product-tabs -->
						</div>
						<div class="col-sm-9">

							<div class="tab-content">
								
								<div id="description" class="tab-pane in active">
									<div class="product-tab">
										<p class="text">
											@if(session()->get('language') == 'ind') {!! $product->long_descp_ind !!} @else {!! $product->long_descp_en !!} @endif
										</p>
									</div>	
								</div><!-- /.tab-pane -->

								<div id="review" class="tab-pane">
									<div class="product-tab">
																				
										<div class="product-reviews">
											<h4 class="title">Customer Reviews</h4>

											<div class="reviews">
												<div class="review">
													<div class="review-title"><span class="summary">Saya sangat menyukai produk ini</span><span class="date"><i class="fa fa-calendar"></i><span>3 days ago</span></span></div>
													<div class="text">"Produknya asli buatan handmade, banyak pilihan dari daur ulang"</div>
																										</div>
											
											</div><!-- /.reviews -->
										</div><!-- /.product-reviews -->
										

										

											
											<div class="review-form">
												<div class="form-container">
<form role="form" class="cnt-form" method="POST" action="{{ route('products.reviews.store', $product->id) }}">
    @csrf

    <div class="row">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="exampleInputName">Name<span class="astk">*</span></label>
                <input type="text" class="form-control txt" id="exampleInputName" name="name" value="{{ old('name') }}" required>
                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="form-group">
                <label for="exampleInputSummary">Summary <span class="astk">*</span></label>
                <input type="text" class="form-control txt" id="exampleInputSummary" name="summary" value="{{ old('summary') }}" required>
                @error('summary')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="exampleInputReview">Review <span class="astk">*</span></label>
                <textarea class="form-control txt txt-review" id="exampleInputReview" name="review" rows="4" required>{{ old('review') }}</textarea>
                @error('review')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
        </div>
    </div>

    <!-- Tabel rating -->
    <div class="review-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                <tr>
                    <th class="cell-label">&nbsp;</th>
                    <th>Bintang 1</th>
                    <th>Bintang 2</th>
                    <th>Bintang 3</th>
                    <th>Bintang 4</th>
                    <th>Bintang 5</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="cell-label">Kualitas</td>
                    @for($i=1;$i<=5;$i++)
                        <td><input type="radio" name="rating_quality" class="radio" value="{{ $i }}" {{ old('rating_quality')==$i?'checked':'' }} required></td>
                    @endfor
                </tr>
                <tr>
                    <td class="cell-label">Harga</td>
                    @for($i=1;$i<=5;$i++)
                        <td><input type="radio" name="rating_price" class="radio" value="{{ $i }}" {{ old('rating_price')==$i?'checked':'' }} required></td>
                    @endfor
                </tr>
                <tr>
                    <td class="cell-label">Nilai</td>
                    @for($i=1;$i<=5;$i++)
                        <td><input type="radio" name="rating_value" class="radio" value="{{ $i }}" {{ old('rating_value')==$i?'checked':'' }} required></td>
                    @endfor
                </tr>
                </tbody>
            </table>
            @error('rating_quality')<small class="text-danger d-block">{{ $message }}</small>@enderror
            @error('rating_price')<small class="text-danger d-block">{{ $message }}</small>@enderror
            @error('rating_value')<small class="text-danger d-block">{{ $message }}</small>@enderror
        </div>
    </div>

    <div class="action text-right">
        <button class="btn btn-primary btn-upper" type="submit">SUBMIT REVIEW</button>
    </div>
</form>

												</div><!-- /.form-container -->
											</div><!-- /.review-form -->

										</div><!-- /.product-add-review -->										
										
							        </div><!-- /.product-tab -->
								</div><!-- /.tab-pane -->

	

							</div><!-- /.tab-content -->
						</div><!-- /.col -->
					</div><!-- /.row -->
				</div><!-- /.product-tabs -->





</div>


				<!-- ====================== UPSELL PRODUCTS ================================= -->
<section class="section featured-product wow fadeInUp">
	<h3 class="section-title">Produk Terkait</h3>
	<div class="owl-carousel home-owl-carousel upsell-product custom-carousel owl-theme outer-top-xs">
	    



		@foreach($relatedProduct as $product)
		<div class="item item-carousel">
			<div class="products">
				
	<div class="product">		
		<div class="product-image">
			<div class="image">
				<a href="{{ url('/detail/'.$product->id.'/'.$product->product_slug_en) }}"><img  src="{{ asset($product->product_thambnail) }}" alt=""></a>
			</div><!-- /.image -->			

			       @php
                            $amount = $product->selling_price - $product->discount_price;
                            $discount = ($amount/$product->selling_price) * 100;

                          @endphp
                          
                          @if($product->discount_price == NULL)
                          <div class="tag new"><span>new</span></div>
                          @else
                          <div class="tag new"><span>{{ round($discount) }}%</span></div>
                          @endif


		</div><!-- /.product-image -->
			
		
		<div class="product-info text-left">
			<h3 class="name"><a href="{{ url('/detail/'.$product->id.'/'.$product->product_slug_en) }}">@if(session()->get('language') == 'ind') {{ $product->product_name_ind }} @else {{ $product->product_name_en }} @endif</a></h3>
			<div class="rating rateit-small"></div>
			<div class="description"></div>

			@if($product->discount_price == NULL)
                            <div class="product-price"> <span class="price"> {{ $product->selling_price }} </span> </div>
                          @else
                            <div class="product-price"> <span class="price"> {{ $product->discount_price }} </span> <span class="price-before-discount">{{ $product->selling_price }}</span> </div>
                          @endif
			<!-- /.product-price -->
			
		</div><!-- /.product-info -->
					<div class="cart clearfix animate-effect">
				<div class="action">
					<ul class="list-unstyled">
						<li class="add-cart-button btn-group">
							<button class="btn btn-primary icon" data-toggle="dropdown" type="button">
								<i class="fa fa-shopping-cart"></i>													
							</button>
							<button class="btn btn-primary cart-btn" type="button">Tambahkan Ke Keranjang</button>
													
						</li>
	                   
		                <li class="lnk wishlist">
							<a class="add-to-cart" href="detail.html" title="Wishlist">
								 <i class="icon fa fa-heart"></i>
							</a>
						</li>

						<li class="lnk">
							<a class="add-to-cart" href="detail.html" title="Compare">
							    <i class="fa fa-signal"></i>
							</a>
						</li>
					</ul>
				</div><!-- /.action -->
			</div><!-- /.cart -->
			</div><!-- /.product -->
      
			</div><!-- /.products -->
		</div><!-- /.item -->
		@endforeach



			</div><!-- /.home-owl-carousel -->
</section><!-- /.section -->
<!-- ============================================== UPSELL PRODUCTS : END ============================================== -->
			
			</div><!-- /.col -->
			<div class="clearfix"></div>
		</div><!-- /.row -->
	</div>

@endsection()