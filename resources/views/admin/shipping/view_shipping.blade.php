@extends('admin.admin_master')
@section('content')

		<section class="content">
		  <div class="row">

			<div class="col-8">

			 <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Shipping List</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
					  <table id="example1" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Province</th>
								<th>Regency</th>
								<th>District</th>
								<th>Village</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($area as $item)
							<tr>
								<td>{{ $item->province->name }}</td>
								<td>{{ $item->regency->name }}</td>
								<td>{{ $item->district->name }}</td>
								<td>{{ $item->village->name }}</td>
								<td>
									<a href="{{ route('shipping.edit',$item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
									<a href="{{ route('shipping.delete',$item->id) }}" class="btn btn-danger btn-sm" id="delete"><i class="fa fa-trash"></i></a>
								</td>
							</tr>
							@endforeach
						</tbody>
						
					  </table>
					</div>
				</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->

			        
			</div>
			<!-- /.col -->


			<div class="col-4">

			 <div class="box">
				<div class="box-header with-border">
				  <h3 class="box-title">Add Shipping</h3>
				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="table-responsive">
					  
						<form method="post" action="{{ route('shipping.store') }}">
							@csrf
							<div class="col-12">

									<div class="form-group">
										<h5>Province <span class="text-danger">*</span></h5>
										<div class="controls">
											<select class="form-control" name="province" id="province" required="">
												<option disabled selected>Pilih Provinsi</option>
												@foreach($provinces as $province)
												<option value="{{ $province->id }}">{{ $province->name }}</option>
												@endforeach
											</select>
										</div>
									</div>

									<div class="form-group">
										<h5>Regency <span class="text-danger">*</span></h5>
										<div class="controls">
											<select class="form-control" name="regency" id="regency" required="">
											</select>
										</div>
									</div>

									<div class="form-group">
										<h5>Districts <span class="text-danger">*</span></h5>
										<div class="controls">
											<select class="form-control" name="district" id="district" required="">
											</select>
										</div>
									</div>

									<div class="form-group">
										<h5>Village <span class="text-danger">*</span></h5>
										<div class="controls">
											<select class="form-control" name="village" id="village" required="">
												
											</select>
										</div>
									</div>

									

									<div class="text-xs-right">
							<input type="submit" class="btn btn-rounded btn-primary mb-5" value="Add Shipping">
						</div>
								</div>

						</form>

					</div>
				</div>
				<!-- /.box-body -->
			  </div>
			  <!-- /.box -->

			        
			</div>
			<!-- /.col -->
		  </div>
	  </div>
  </div>
  <!-- /.content-wrapper -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  	<script type="text/javascript">
  		$(document).ready(function(){
  			$('#province').on('change',function(){
  				let id_province = $(this).val();

  				$.ajax({
  					type : 'POST',
  					url : "{{ route('get.regency') }}",
  					data : {id_province:id_province},
  					cahce : 'false',

  					success:function(response){
  						$('#regency').html(response);
  						$('#district').html('');
  						$('#village').html('');
  					},
  					error:function(data){
  						console.log(data)
  					}
  				})
  			})


  			$('#regency').on('change',function(){
  				let id_regency = $(this).val();

  				$.ajax({
  					type : 'POST',
  					url : "{{ route('get.district') }}",
  					data : {id_regency:id_regency},
  					cahce : 'false',

  					success:function(response){
  						$('#district').html(response);
  						$('#village').html('');
  					},
  					error:function(data){
  						console.log(data)
  					}
  				})
  			})


  			$('#district').on('change',function(){
  				let id_district = $(this).val();

  				$.ajax({
  					type : 'POST',
  					url : "{{ route('get.village') }}",
  					data : {id_district:id_district},
  					cahce : 'false',

  					success:function(response){
  						$('#village').html(response);
  					},
  					error:function(data){
  						console.log(data)
  					}
  				})
  			})
  		});
  	</script>
  		



@endsection