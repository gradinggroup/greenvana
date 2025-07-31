@extends('admin.admin_master')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="container-full">
		<!-- Content Header (Page header) -->
		

		<!-- Main content -->
		<section class="content">

		 <!-- Basic Forms -->
		  <div class="box">
			<div class="box-header with-border">
			  <h4 class="box-title">Edit Product</h4>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
			  <div class="row">
				<div class="col">

					<form method="post" action="{{ route('product.data.update',$products->id) }}" >
						@csrf
					  <div class="row">
						<div class="col-12">						
							
							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<h5>Brand<span class="text-danger">*</span></h5>
										<div class="controls">
											<select name="brand_id" class="form-control" required="">
												<option selected="" disabled="">-- Pilih Brand --</option>
												@foreach($brands as $brand)
												<option value="{{ $brand->id }}" {{ $brand->id == $products->brand_id ? 'selected' : '' }}>{{ $brand->brand_name_en }}</option>
												@endforeach
											</select>
											@error('brand_id')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<h5>Category<span class="text-danger">*</span></h5>
										<div class="controls">
											<select name="category_id" class="form-control" required="">
												<option selected="" disabled="">-- Pilih Category --</option>
												@foreach($categories as $category)
												<option value="{{ $category->id }}" {{ $category->id == $products->category_id ? 'selected' : '' }}>{{ $category->category_name_en }}</option>
												@endforeach
											</select>
											@error('category_id')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<h5>SubCategory<span class="text-danger">*</span></h5>
										<div class="controls">
											<select name="subcategory_id" class="form-control" required="">
												<option selected="" disabled="">-- Pilih SubCategory --</option>
												@foreach($subcategories as $sub)
												<option value="{{ $sub->id }}" {{ $sub->id == $products->subcategory_id ? 'selected' : '' }}>{{ $sub->subcategory_name_en }}</option>
												@endforeach
											</select>
											@error('subcategory_id')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<h5>Sub-SubCategory<span class="text-danger">*</span></h5>
										<div class="controls">
											<select name="subsubcategory_id" class="form-control" required="">
												<option selected="" disabled="">-- Pilih Sub-SubCategory --</option>
												@foreach($subsubcategories as $subsub)
												<option value="{{ $subsub->id }}" {{ $subsub->id == $products->subsubcategory_id ? 'selected' : '' }}>{{ $subsub->subsubcategory_name_en }}</option>
												@endforeach
											</select>
											@error('subsubcategory_id')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<h5>Product Name En<span class="text-danger">*</span></h5>
										<div class="controls">
											<input type="text" name="product_name_en" class="form-control" value="{{ $products->product_name_en }}" required="">
											@error('product_name_en')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<h5>Product Name Ind<span class="text-danger">*</span></h5>
										<div class="controls">
											<input type="text" name="product_name_ind" class="form-control" value="{{ $products->product_name_ind }}" required="">
											@error('product_name_ind')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<h5>Product Code<span class="text-danger">*</span></h5>
										<div class="controls">
											<input type="text" name="product_code" class="form-control" value="{{ $products->product_code }}" required="" >
											@error('product_code')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<h5>Product Quantity<span class="text-danger">*</span></h5>
										<div class="controls">
											<input type="text" name="product_qty" class="form-control" value="{{ $products->product_qty }}" required="">
											@error('product_qty')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<h5>Product Selling Price<span class="text-danger">*</span></h5>
										<div class="controls">
											<input type="text" name="selling_price" class="form-control" value="{{ $products->selling_price }}" required="">
											@error('selling_price')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<h5>Product Discount Price<span class="text-danger">*</span></h5>
										<div class="controls">
											<input type="text" name="discount_price" class="form-control" value="{{ $products->discount_price }}">
											@error('discount_price')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<h5>Short Description English<span class="text-danger">*</span></h5>
										<div class="controls">
											<textarea name="short_descp_en" id="textarea" class="form-control" required placeholder="Textarea text">
												{!! $products->short_descp_en !!}
											</textarea>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<h5>Short Description Indonesia<span class="text-danger">*</span></h5>
										<div class="controls">
											<textarea name="short_descp_ind" id="textarea" class="form-control" required placeholder="Textarea text">
												{!! $products->short_descp_ind !!}
											</textarea>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<h5>Long Description English<span class="text-danger">*</span></h5>
										<div class="controls">
											<textarea id="editor1" name="long_descp_en" rows="10" cols="80"required="">
												{!! $products->long_descp_en !!}
											</textarea>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<h5>Long Description Indonesia<span class="text-danger">*</span></h5>
										<div class="controls">
											<textarea id="editor2" name="long_descp_ind" rows="10" cols="80" required="">
												{!! $products->long_descp_ind !!}
											</textarea>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<h5>Product Tags En<span class="text-danger">*</span></h5>
										<div class="controls">
											<input type="text" name="product_tags_en" class="form-control" value="{{ $products->product_tags_en }}" data-role="tagsinput" placeholder="add tags" />
											@error('product_tags_en')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<h5>Product Tags Ind<span class="text-danger">*</span></h5>
										<div class="controls">
											<input type="text" name="product_tags_ind" class="form-control" value="{{ $products->product_tags_ind }}" data-role="tagsinput" placeholder="add tags" />
											@error('product_tags_ind')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<h5>Product Size En<span class="text-danger">*</span></h5>
										<div class="controls">
											<input type="text" name="product_size_en" class="form-control" value="{{ $products->product_size_en }}" data-role="tagsinput" placeholder="add tags" />
											@error('product_size_en')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-md-4">
									<div class="form-group">
										<h5>Product Size Ind<span class="text-danger">*</span></h5>
										<div class="controls">
											<input type="text" name="product_size_ind" class="form-control" value="{{ $products->product_size_ind }}" data-role="tagsinput" placeholder="add tags" />
											@error('product_size_ind')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<h5>Product Color En<span class="text-danger">*</span></h5>
										<div class="controls">
											<input type="text" name="product_color_en" class="form-control" value="{{ $products->product_color_en }}" data-role="tagsinput" placeholder="add tags" />
											@error('product_color_en')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
								<div class="col-md-4">
									<div class="form-group">
										<h5>Product Color Ind<span class="text-danger">*</span></h5>
										<div class="controls">
											<input type="text" name="product_color_ind" class="form-control" value="{{ $products->product_color_ind }}" data-role="tagsinput" placeholder="add tags" />
											@error('product_color_ind')
												<span class="text-danger">{{ $message }}</span>
											@enderror
										</div>
									</div>
								</div>
							</div>

						</div>

						<hr>

					  </div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<div class="controls">
										<fieldset>
											<input type="checkbox" id="checkbox_2" name="hot_deals" value="1" {{ $products->hot_deals == 1 ? 'checked' : ''}} >
											<label for="checkbox_2">Hot Deals</label>
										</fieldset>
										<fieldset>
											<input type="checkbox" id="checkbox_3" name="featured" value="1" {{ $products->featured == 1 ? 'checked' : ''}}>
											<label for="checkbox_3">Featured</label>
										</fieldset>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<div class="controls">
										<fieldset>
											<input type="checkbox" id="checkbox_4" name="special_offer" value="1" {{ $products->special_offer == 1 ? 'checked' : ''}}>
											<label for="checkbox_4">Special Offer</label>
										</fieldset>
										<fieldset>
											<input type="checkbox" id="checkbox_5" name="special_deals" value="1" {{ $products->special_deals == 1 ? 'checked' : ''}}>
											<label for="checkbox_5">Special Deals</label>
										</fieldset>
									</div>
								</div>
							</div>
						</div>
						
						<div class="text-xs-right">
							<input type="submit" class="btn btn-rounded btn-primary mb-5" value="Update Product">
						</div>
					</form>

				</div>
				<!-- /.col -->
			  </div>
			  <!-- /.row -->
			</div>
			<!-- /.box-body -->
		  </div>
		  <!-- /.box -->

		  <div class="content">
		  	<div class="row">
		  		<div class="col-md-12">
		  			<div class="box bt-3 border-info">
		  				<div class="box-header">
		  					<h4 class="box-title">Product Multiple Image Update</h4>
		  				</div>

		  				<div class="box-body">
		  					<form method="post" action="{{ route('images.update') }}" enctype="multipart/form-data">
		  						@csrf	
		  						<div class="row">
		  						@foreach($multipleImg as $img)
		  							<div class="col-md-3">
				  						<div class="card">
				  							<img src="{{ asset($img->photo_name) }}" class="card-img-top" style="width: 300px;">
				  							<div class="card-body">
				  								<div class="card-text">
				  									<a href="{{ route('product.imgs.delete',$img->id) }}" class="btn btn-sm btn-danger" id="delete" title="Delete Data"><i class="fa fa-trash"></i></a>
				  									<div class="form-group">
				  										<label class="form-control-label">Change Image <span class="tx-danger">*</span></label>
				  										<input type="file" name="multiple_img[{{ $img->id }}]">
				  									</div>
				  								</div>
				  							</div>
				  						
				  							<div class="card-footer">
				  								
				  							</div>
				  						</div>
			  						</div>
		  						@endforeach
		  						</div>

		  						<div class="text-xs-right">
										<input type="submit" class="btn btn-rounded btn-primary mb-5" value="Update Multiple Image">
									</div>
		  					</form>
		  				</div>
		  			</div>
		  		</div>
		  	</div>
		  </div>


		  <div class="content">
		  	<div class="row">
		  		<div class="col-md-12">
		  			<div class="box bt-3 border-info">
		  				<div class="box-header">
		  					<h4 class="box-title">Product Thambnail Update</h4>
		  				</div>

		  				<div class="box-body">
		  					<form method="post" action="{{ route('thambnail.update',$products->id) }}" enctype="multipart/form-data">
		  						@csrf	
		  						<div class="row">
		  							<div class="col-md-3">
				  						<div class="card">
				  							<img src="{{ asset($products->product_thambnail) }}" class="card-img-top" style="width: 300px;">
				  							<div class="card-body">
				  								<div class="card-text">
				  									
				  									<div class="form-group">
				  										<label class="form-control-label">Change Thambnail <span class="tx-danger">*</span></label>
				  										<input type="hidden" name="old_image" value="{{ $products->product_thambnail }}">
				  										<input type="file" name="product_thambnail" class="form-control" onChange="mainThamUrl(this)">
				  										<img src="" id="mainThmb">
				  									</div>
				  								</div>
				  							</div>
				  						
				  							<div class="card-footer">
				  								
				  							</div>
				  						</div>
			  						</div>
		  						</div>

		  						<div class="text-xs-right">
										<input type="submit" class="btn btn-rounded btn-primary mb-5" value="Update Thambnail">
									</div>
		  					</form>
		  				</div>
		  			</div>
		  		</div>
		  	</div>
		  </div>

		</section>
		<!-- /.content -->
	  </div>


<script type="text/javascript">
  	$(document).ready(function(){
  		$('select[name="category_id"]').on('change', function(){
  			var category_id = $(this).val();
  			if(category_id){
  				$.ajax({
  					url: "{{ url('/category/subcategory/ajax') }}/"+category_id,  				
  					type:"GET",
  					dataType:"json",
  					success:function(data){
  						$('select[name="subsubcategory_id"]').html('');
  						var d = $('select[name="subcategory_id"]').empty();
  						$.each(data, function(key, value){
  							$('select[name="subcategory_id"]').append('<option value="'+ value.id +'">'+value.subcategory_name_en +'</option>');
  						});
  					},
  				});
  			}else{
  				alert('danger');
  			} 
  		});

  		$('select[name="subcategory_id"]').on('change', function(){
  			var subcategory_id = $(this).val();
  			if(subcategory_id){
  				$.ajax({
  					url: "{{ url('/category/subsubcategory/ajax') }}/"+subcategory_id,  				
  					type:"GET",
  					dataType:"json",
  					success:function(data){
  						var d = $('select[name="subsubcategory_id"]').empty();
  						$.each(data, function(key, value){
  							$('select[name="subsubcategory_id"]').append('<option value="'+ value.id +'">'+value.subsubcategory_name_en +'</option>');
  						});
  					},
  				});
  			}else{
  				alert('danger');
  			} 
  		});
  	});
  </script>

  <script type="text/javascript">
  	function mainThamUrl(input){
  		if(input.files && input.files[0]){
  			var reader = new FileReader();
  			reader.onload = function(e){
  				$('#mainThmb').attr('src',e.target.result).width(80).height(80);
  			};
  			reader.readAsDataURL(input.files[0]);
  		}
  	}
  </script>

  <script>
  	$(document).ready(function(){
  		$('#multiImg').on('change',function(){
  			if(window.File && window.FileReader && window.FileList && window.Blob){
  				var data = $(this)[0].files;
  				$.each(data, function(index, file){
  					if(/(\.|\/)(gif|jpe?g|png)$/i.test(file.type)){
  						var fRead = new FileReader();
  						fRead.onload = (function(file){
  							return function(e){
  								var img = $('<img/>').addClass('thumb').attr('src', e.target.result).width(80).height(80);
  								$('#preview_img').append(img);
  							};
  						})(file);
  						fRead.readAsDataURL(file);
  					}
  				});
  			}else{
  				alert("Your Browser doesn't support file API!");
  			}
  		});
  	});
  </script>

@endsection