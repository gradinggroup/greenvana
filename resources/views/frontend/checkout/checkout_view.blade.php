@extends('frontend.main_master')
@section('content')

@section('title')
    Checkout Page
@endsection()

<div class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-inner">
            <ul class="list-inline list-unstyled">
                <li><a href="home.html">Home</a></li>
                <li class='active'>Checkout</li>
            </ul>
        </div><!-- /.breadcrumb-inner -->
    </div><!-- /.container -->
</div><!-- /.breadcrumb -->

<div class="body-content">
    <div class="container">
        <div class="checkout-box ">
            <div class="row">
                <div class="col-md-8">
                    <div class="panel-group checkout-steps" id="accordion">

                        <!-- checkout-step-01  -->
                        <div class="panel panel-default checkout-step-01">
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <!-- panel-body  -->
                                <div class="panel-body">
                                    <div class="row">		
                                        <!-- guest-login -->			
                                        <div class="col-md-6 col-sm-6 guest-login">
                                            <h4 class="checkout-subtitle"><b>Alamat Pembeli</b></h4>

                                            <!-- radio-form  -->
                                            <form class="register-form" role="form" method="post" action="{{ route('checkout.detil') }}">
                                                @csrf

                                                <div class="form-group">
                                                    <label class="info-title" for="exampleInputEmail1">Your Name <span>*</span></label>
                                                    <input type="text" class="form-control unicase-form-control text-input" id="exampleInputEmail1" placeholder="Input Your Name" name="name" value="{{ Auth::user()->name }}" required>
                                                </div>

                                                <div class="form-group">
                                                    <label class="info-title" for="email">Email <span>*</span></label>
                                                    <input type="email" class="form-control unicase-form-control text-input" id="email" placeholder="Input Your Email" name="email" value="{{ Auth::user()->email }}" required>
                                                </div>

                                                <div class="form-group">
                                                    <label class="info-title" for="phone">Phone <span>*</span></label>
                                                    <input type="number" class="form-control unicase-form-control text-input" id="phone" placeholder="Input Your Phone" name="phone" value="{{ Auth::user()->phone }}" required>
                                                </div>

                                                <div class="form-group">
                                                    <label class="info-title" for="postcode">Post Code</label>
                                                    <input type="text" class="form-control unicase-form-control text-input" id="postcode" name="post_code" placeholder="Input Your Post Code">
                                                </div>

                                                <!-- Payment Type -->
                                                <div class="form-group">
                                                    <h5><b>Metode Pembayaran</b> <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <select class="form-control" name="payment_type" required>
                                                            <option value="" disabled selected>Pilih Bank</option>
                                                            <option value="BCA">BCA</option>
                                                            <option value="BRI">BRI</option>
                                                            <option value="Mandiri">Mandiri</option>
                                                        </select>
                                                    </div>
                                                </div>
                                        </div>
                                        <!-- guest-login -->

                                        <!-- already-registered-login -->
                                        <div class="col-md-6 col-sm-6 already-registered-login">
                                            <br><br>
                                            <div class="form-group">
                                                <h5><b>Provinsi</b> <span class="text-danger">*</span></h5>
                                                <select class="form-control" name="province_id" id="province" required>
                                                    <option disabled selected>Pilih Provinsi</option>
                                                </select>
                                                <input type="hidden" name="provinsi" id="provinsi_name" />
                                            </div>

                                            <div class="form-group">
                                                <h5><b>Kabupaten/Kota</b> <span class="text-danger">*</span></h5>
                                                <select class="form-control" name="regency_id" id="regency" required>
                                                </select>
                                                <input type="hidden" name="kabupaten_kota" id="kabupaten_kota_name" />
                                            </div>

                                            <div class="form-group">
                                                <h5><b>Kecamatan</b> <span class="text-danger">*</span></h5>
                                                <select class="form-control" name="district_id" id="district" required>
                                                </select>
                                                <input type="hidden" name="kecamatan" id="kecamatan_name" />
                                            </div>

                                            <div class="form-group">
                                                <h5><b>Kelurahan/Desa</b> <span class="text-danger">*</span></h5>
                                                <select class="form-control" name="village_id" id="village" required>
                                                </select>
                                                <input type="hidden" name="kelurahan_desa" id="kelurahan_desa_name" />
                                            </div>

                                            <div class="form-group">
                                                <h5><b>Notes</b></h5>
                                                <div class="controls">
                                                    <textarea class="form-control" name="notes"></textarea>
                                                </div>
                                            </div>
                                        </div>	
                                        <!-- already-registered-login -->		
                                    </div>			
                                </div>
                                <!-- panel-body  -->
                            </div><!-- row -->
                        </div>
                        <!-- checkout-step-01  -->

                    </div><!-- /.checkout-steps -->
                </div>
                <div class="col-md-4">
                    <!-- checkout-progress-sidebar -->
                    <div class="checkout-progress-sidebar ">
                        <div class="panel-group">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="unicase-checkout-title">Your Checkout Progress</h4>
                                </div>
                                <div class="">
                                    <ul class="nav nav-checkout-progress list-unstyled">
                                        @foreach($carts as $item)
                                        <li>
                                            <strong>Image: </strong>
                                            <img src="{{ asset($item->options->image) }}" style="height: 50px; width: 50px;">
                                        </li>
                                        <li>
                                            <strong>Qty: </strong>
                                            ( {{ $item->qty }} )
                                            <strong>Color: </strong>
                                            {{ $item->options->color }}
                                            <strong>Size: </strong>
                                            {{ $item->options->size }}
                                        </li>
                                        @endforeach

                                        @if(Session::has('coupon'))
                                            <hr>
                                            <strong>Subtotal: </strong>Rp. {{ $total }}
                                            <hr>
                                            <strong>Coupon Name: </strong>{{ session()->get('coupon')['coupon_name'] }}
                                            ( {{ session()->get('coupon')['coupon_discount'] }} % )
                                            <hr>
                                            <strong>Coupon Discount: </strong>Rp. {{ session()->get('coupon')['discount_amount'] }}
                                            <hr>
                                            <strong>Grand Total: </strong>Rp. {{ session()->get('coupon')['total_amount'] }}
                                            <hr>
                                        @else
                                            <hr>
                                            <strong>Subtotal: </strong>Rp. {{ $total }} <hr>
                                            <strong>Grand Total: </strong>Rp. {{ $total }} <hr>					
                                        @endif

                                        <hr>
                                        <button type="submit" class="btn btn-primary">Lanjutkan Checkout</button>
                                    </form>
                                    <!-- end form action -->
                                    </ul>		
                                </div>
                            </div>
                        </div>
                    </div> 
                    <!-- checkout-progress-sidebar -->				
                </div>
            </div><!-- /.row -->
        </div><!-- /.checkout-box -->
    </div><!-- /.container -->
</div><!-- /.body-content -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){

    // Load Provinsi dari Laravel API
    function loadProvinces() {
        $.ajax({
            url: '/api/provinsi',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                console.log('Provinsi response:', res);
                if(res.code == 200 && Array.isArray(res.data)) {
                    let options = '<option disabled selected>Pilih Provinsi</option>';
                    $.each(res.data, function(i, provinsi){
                        options += `<option value="${provinsi.id}">${provinsi.name}</option>`;
                    });
                    $('#province').html(options);
                } else {
                    alert('Data provinsi tidak ditemukan');
                    $('#province').html('<option disabled selected>Data tidak ditemukan</option>');
                }
            },
            error: function() {
                alert('Gagal load provinsi');
            }
        });
    }

    // Saat pilih provinsi, load kota
    $('#province').on('change', function(){
        let provinsiId = $(this).val();
        let provinsiName = $("#province option:selected").text();
        $('#provinsi_name').val(provinsiName);

        $('#regency').html('<option disabled selected>Loading...</option>');
        $('#district').html('<option disabled selected>Pilih Kecamatan</option>');
        $('#village').html('<option disabled selected>Pilih Kelurahan/Desa</option>');

        $.ajax({
            url: `/api/kota/${provinsiId}`,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                console.log('Kota response:', res);
                if(res.code == 200 && Array.isArray(res.data)) {
                    let options = '<option disabled selected>Pilih Kabupaten/Kota</option>';
                    $.each(res.data, function(i, kota){
                        options += `<option value="${kota.id}">${kota.name}</option>`;
                    });
                    $('#regency').html(options);
                } else {
                    $('#regency').html('<option disabled selected>Data tidak ditemukan</option>');
                }
            },
            error: function() {
                alert('Gagal load kabupaten/kota');
            }
        });
    });

    // Saat pilih kota, load kecamatan
    $('#regency').on('change', function(){
        let kotaId = $(this).val();
        let kotaName = $("#regency option:selected").text();
        $('#kabupaten_kota_name').val(kotaName);

        $('#district').html('<option disabled selected>Loading...</option>');
        $('#village').html('<option disabled selected>Pilih Kelurahan/Desa</option>');

        $.ajax({
            url: `/api/kecamatan/${kotaId}`,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                console.log('Kecamatan response:', res);
                if(res.code == 200 && Array.isArray(res.data)) {
                    let options = '<option disabled selected>Pilih Kecamatan</option>';
                    $.each(res.data, function(i, kecamatan){
                        options += `<option value="${kecamatan.id}">${kecamatan.name}</option>`;
                    });
                    $('#district').html(options);
                } else {
                    $('#district').html('<option disabled selected>Data tidak ditemukan</option>');
                }
            },
            error: function() {
                alert('Gagal load kecamatan');
            }
        });
    });

    // Saat pilih kecamatan, load desa
    $('#district').on('change', function(){
        let kecamatanId = $(this).val();
        let kecamatanName = $("#district option:selected").text();
        $('#kecamatan_name').val(kecamatanName);

        $('#village').html('<option disabled selected>Loading...</option>');

        $.ajax({
            url: `/api/desa/${kecamatanId}`,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                console.log('Desa response:', res);
                if(res.code == 200 && Array.isArray(res.data)) {
                    let options = '<option disabled selected>Pilih Kelurahan/Desa</option>';
                    $.each(res.data, function(i, desa){
                        options += `<option value="${desa.id}">${desa.name}</option>`;
                    });
                    $('#village').html(options);
                } else {
                    $('#village').html('<option disabled selected>Data tidak ditemukan</option>');
                }
            },
            error: function() {
                alert('Gagal load kelurahan/desa');
            }
        });
    });

    // Saat pilih desa, set nama desa ke hidden input
    $('#village').on('change', function(){
        let desaName = $("#village option:selected").text();
        $('#kelurahan_desa_name').val(desaName);
    });

    // Load provinsi saat awal halaman dibuka
    loadProvinces();

});
</script>

@endsection
