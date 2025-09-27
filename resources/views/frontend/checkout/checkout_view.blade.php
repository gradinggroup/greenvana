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
                                    <div cla    ss="row">		
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

                                                <!-- Alamat lengkap dengan API -->
<div class="form-group">
    <label>Alamat Lengkap</label>
    <textarea id="alamat_lengkap" name="alamat_lengkap" class="form-control"  placeholder="Ketik alamat..." required></textarea>
    <div id="suggestions" class="list-group mt-2"></div>
</div>


<div class="form-group">
    <input type="hidden" id="latitude" name="latitude" class="form-control" placeholder="Latitude" >
</div>

<div class="form-group">
    <input type="hidden" id="longitude" name="longitude" class="form-control" placeholder="Longitude" >
</div>


<button type="button" id="gpsButton" class="btn btn-info mt-2">Isi dengan GPS Saya</button>

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
<!-- Bagian ringkasan checkout -->
<div class="">
    <ul class="nav nav-checkout-progress list-unstyled">
        @foreach($carts as $item)
        <li>
            <strong>Image: </strong>
            <img src="{{ asset($item->options->image) }}" style="height: 50px; width: 50px;">
        </li>
        <li>
            <strong>Qty: </strong> ( {{ $item->qty }} )
            <strong>Color: </strong> {{ $item->options->color }}
            <strong>Size: </strong> {{ $item->options->size }}
        </li>
        @endforeach

        <!-- Hidden data koordinat toko -->
        <input type="hidden" id="store_lat" value="{{ $store->latitude }}">
        <input type="hidden" id="store_lon" value="{{ $store->longitude }}">
        <input type="hidden" id="ongkir_per_km" value="{{ $store->ongkir_per_km }}">


        <input type="hidden" name="jarak" id="jarak_hidden">

        <hr>
<p><strong>Subtotal: </strong>Rp 
    <span id="subtotal_text">{{ number_format((float)$total, 0, ',', '.') }}</span>
</p>
<input type="hidden" id="subtotal_hidden" value="{{ (float)$total }}">

                <!-- Tempat tampilkan jarak -->
        <p id="jarak" class="mt-2 text-success"></p>
        <p id="ongkir" class="text-info"><strong>Ongkir: </strong>Rp 0</p>
        <input type="hidden" name="ongkir" id="ongkir_hidden" value="0">

<select class="form-control" id="voucher_select" name="voucher_id">
    <option value="" data-diskon="0">-- Tidak pakai voucher --</option>
    @foreach($vouchers as $voucher)
        <option value="{{ $voucher->id }}" data-diskon="{{ $voucher->nominal }}">
            {{ $voucher->code }} - Potongan Rp {{ number_format($voucher->nominal, 0, ',', '.') }}
        </option>
    @endforeach
</select>

<p id="voucher_info" class="text-success"></p>
<input type="hidden" id="diskon_hidden" value="0">

<div class="form-group mt-2">
    <label class="d-block mb-1">Total Poin Anda :</label>
    <input type="text" id="user_poin" value="{{ $poin_user }}" class="form-control" disabled>

    <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" id="use_points_toggle">
        <label class="form-check-label" for="use_points_toggle">
            Tukarkan poin untuk potongan
        </label>
    </div>

    <p id="poin_info" class="text-primary mt-2"></p>

    
    <input type="hidden" id="poin_rate" value="{{ $poin_rate ?? 0 }}">

    {{-- kirim ke backend --}}
    <input type="hidden" name="use_poin"   id="use_poin"   value="0">
    <input type="hidden" name="poin_used"  id="poin_used"  value="0">
    <input type="hidden" name="poin_cut"   id="poin_cut"   value="0">
</div>

<div class="mt-2">
    <p id="bonus_poin" class="text-success"></p>
    <small id="bonus_poin_note" class="text-muted d-block">
        *Bonus poin yang akan anda dapat karena sudah pernah berbelanja dan bermain game disini.
    </small>
    <span id="bonus_poin_value">0</span>
</div>
<input type="hidden" name="expected_bonus_poin" id="expected_bonus_poin" value="0">

        <hr>
        <p><strong>Grand Total: </strong>Rp <span id="grand_total">{{ number_format((float)$total, 0, ',', '.') }}
</span></p>
        <input type="" name="grand_total" id="grand_total_hidden" value="{{ $total }}">
        <hr>

        <button type="submit" class="btn btn-primary btn-block">Lanjutkan Checkout</button>
    </ul>
</div>

                            </div>
                        </div>
                    </div> 
                   			
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){

    // Autocomplete dari Nominatim (OpenStreetMap)
    $("#alamat_lengkap").on("input", function() {
        let query = $(this).val();
        if(query.length > 3) {
            $.get("https://nominatim.openstreetmap.org/search", {
                q: query,
                format: "json",
                addressdetails: 1,
                limit: 5,
                countrycodes: "id" // hanya Indonesia
            }, function(data) {
                $("#suggestions").empty();
                data.forEach(function(item) {
                    $("#suggestions").append(
                        `<a href="#" class="list-group-item list-group-item-action suggestion" 
                            data-lat="${item.lat}" 
                            data-lon="${item.lon}">
                            ${item.display_name}
                        </a>`
                    );
                });
            });
        }
    });

// Klik salah satu suggestion
$(document).on("click", ".suggestion", function(e) {
    e.preventDefault();
    let text = $(this).text().trim(); // 🔥 hapus spasi/tab di awal & akhir
    $("#alamat_lengkap").val(text);
    $("#latitude").val($(this).data("lat"));
    $("#longitude").val($(this).data("lon"));
    $("#suggestions").empty();
});


    // Tombol GPS
    $("#gpsButton").click(function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                let lat = position.coords.latitude;
                let lon = position.coords.longitude;
                $("#latitude").val(lat);
                $("#longitude").val(lon);

                // Reverse geocode untuk alamat
                $.get("https://nominatim.openstreetmap.org/reverse", {
                    lat: lat,
                    lon: lon,
                    format: "json"
                }, function(data) {
                    if (data && data.display_name) {
                        $("#alamat_lengkap").val(data.display_name);
                    }
                });
            });
        } else {
            alert("Browser tidak mendukung GPS");
        }
    });

});
</script>


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
<script>
$(document).ready(function(){

    // Ambil koordinat toko dari hidden input
    const storeLat = parseFloat($("#store_lat").val());
    const storeLon = parseFloat($("#store_lon").val());

    function haversine(lat1, lon1, lat2, lon2) {
        const R = 6371; // radius bumi (km)
        const dLat = (lat2 - lat1) * Math.PI / 180;
        const dLon = (lon2 - lon1) * Math.PI / 180;

        const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                  Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                  Math.sin(dLon/2) * Math.sin(dLon/2);

        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
        return (R * c).toFixed(2);
    }

    // Klik suggestion
    $(document).on("click", ".suggestion", function(e) {
        e.preventDefault();
        let lat = parseFloat($(this).data("lat"));
        let lon = parseFloat($(this).data("lon"));

        $("#alamat_lengkap").val($(this).text().trim());
        $("#latitude").val(lat);
        $("#longitude").val(lon);

        let jarak = haversine(storeLat, storeLon, lat, lon);
        $("#jarak").text(`Jarak ke toko: ${jarak} km`);
        $("#jarak_hidden").val(jarak);

        // hitung ongkir + update total
        updateOngkir(jarak);


        $("#suggestions").empty();
    });

    // Gunakan GPS
    $("#gpsButton").click(function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                let lat = position.coords.latitude;
                let lon = position.coords.longitude;

                $("#latitude").val(lat);
                $("#longitude").val(lon);

                let jarak = haversine(storeLat, storeLon, lat, lon);
                $("#jarak").text(`Jarak ke toko: ${jarak} km`);
                $("#jarak_hidden").val(jarak);

                // hitung ongkir + update total
                updateOngkir(jarak);


                $.get("https://nominatim.openstreetmap.org/reverse", {
                    lat: lat, lon: lon, format: "json"
                }, function(data) {
                    if (data && data.display_name) {
                        $("#alamat_lengkap").val(data.display_name);
                    }
                });
            });
        } else {
            alert("Browser tidak mendukung GPS");
        }
    });

});
function formatRupiah(angka) {
    return new Intl.NumberFormat('id-ID', {
        style: 'decimal',
        maximumFractionDigits: 0
    }).format(angka);
}

function updateOngkir(jarak) {
    const ongkirPerKm = parseFloat($("#ongkir_per_km").val());
    let ongkir = Math.round(jarak * ongkirPerKm);

    $("#ongkir").html(`<strong>Ongkir: </strong>Rp ${formatRupiah(ongkir)}`);
    $("#ongkir_hidden").val(ongkir);

    // hitung ulang semua (voucher + poin)
    hitungGrandTotal();
}



$(document).ready(function(){

    // 🔹 Event pilih voucher
    $("#voucher_select").on("change", function(){
        let diskon = parseFloat($("#voucher_select option:selected").data("diskon")) || 0;
        $("#diskon_hidden").val(diskon);

        if (diskon > 0) {
            $("#voucher_info").text(`Voucher terpakai, potongan Rp ${formatRupiah(diskon)}`);
        } else {
            $("#voucher_info").text("");
        }

        hitungGrandTotal();
    });

    // 🔹 Hitung total pertama kali saat halaman diload
    hitungGrandTotal();
});

$(document).ready(function () {
    // Saat user centang/uncentang "Tukarkan poin"
    $("#use_points_toggle").on("change", function () {
        hitungGrandTotal();
    });
});

function hitungGrandTotal() {
    let subtotal = parseFloat($("#subtotal_hidden").val()) || 0;
    let ongkir   = parseFloat($("#ongkir_hidden").val())   || 0;
    let diskon   = parseFloat($("#diskon_hidden").val())   || 0; // dari voucher

    // total sebelum poin
    let beforePoints = subtotal + ongkir - diskon;
    if (beforePoints < 0) beforePoints = 0;

    // saldo & rate poin
    let userPoin = parseInt($("#user_poin").val()) || 0;
    let poinRate = 1; // ⬅️ 1 poin = Rp1

    // apakah user ingin menukarkan poin?
    let usePoints = $("#use_points_toggle").is(":checked");

    let poinUsed = 0;
    let poinCut  = 0;

    if (usePoints && userPoin > 0 && poinRate > 0) {
        // pakai poin sebanyak yang dibutuhkan (maks saldo)
        let maxPoinNeeded = Math.floor(beforePoints / poinRate);
        poinUsed = Math.min(userPoin, Math.max(0, maxPoinNeeded));
        poinCut  = poinUsed * poinRate;

        $("#poin_info").text(`Poin dipakai: ${poinUsed} (potongan Rp ${formatRupiah(poinCut)})`);
        $("#use_poin").val(1);
    } else {
        $("#poin_info").text(userPoin > 0 ? `Anda memiliki ${userPoin} poin (tidak dipakai).` : `Anda tidak memiliki poin.`);
        $("#use_poin").val(0);
    }

    let grandTotal = beforePoints - poinCut;
    if (grandTotal < 0) grandTotal = 0;

    // tampilkan & simpan
    $("#grand_total").text(`Rp ${formatRupiah(grandTotal)}`);
    $("#grand_total_hidden").val(grandTotal);

    // kirim ke backend
    $("#poin_used").val(poinUsed);
    $("#poin_cut").val(poinCut);
    // === Bonus poin (setiap Rp100.000 => +20 poin), tampilkan angka saja ===
const unitAmount    = 100000;   // 100 ribu
const pointsPerUnit = 20;       // 20 poin per kelipatan
const gt            = Math.floor(grandTotal);

const bonusPoin = Math.floor(gt / unitAmount) * pointsPerUnit;

$("#bonus_poin_value").text(bonusPoin);
$("#expected_bonus_poin").val(bonusPoin); // kalau mau kirim ke backend
}


function formatRupiah(angka) {
    return (angka || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}








</script>




@endsection
