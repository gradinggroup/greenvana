@extends('admin.admin_master')
@section('content')

<div class="container">
    <h3>Alamat Toko</h3>

    {{-- Tampilkan data existing jika ada --}}
    @if($existingAddress)
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Alamat Toko Anda</h5>
                <div>
                    <button type="button" id="editBtn" class="btn btn-warning btn-sm">Edit</button>
                    <button type="button" id="deleteBtn" class="btn btn-danger btn-sm" onclick="confirmDelete()">Hapus</button>
                </div>
            </div>
            <div class="card-body">
                <div id="viewMode">
                    <div class="row">
                        <div class="col-md-8">
                            <p><strong>Alamat:</strong> {{ $existingAddress->alamat_lengkap }}</p>
                            <p><strong>Koordinat:</strong> {{ $existingAddress->latitude }}, {{ $existingAddress->longitude }}</p>
                            <p><strong>Ongkir per KM:</strong> Rp {{ number_format($existingAddress->ongkir_per_km, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-4">
                            <div id="map" style="height: 200px; background: #e9ecef; border-radius: 5px; display: flex; align-items: center; justify-content: center;">
                                <small class="text-muted">Map akan ditampilkan di sini</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                {{-- Edit Mode (Hidden by default) --}}
                <div id="editMode" style="display: none;">
                    <form id="updateAddressForm" action="{{ route('store-address.update', $existingAddress->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label>Alamat Lengkap</label>
                            <textarea id="edit_alamat_lengkap" name="alamat_lengkap" class="form-control" required>{{ $existingAddress->alamat_lengkap }}</textarea>
                            <div id="edit_suggestions" class="list-group mt-2"></div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Latitude</label>
                                    <input type="text" id="edit_latitude" name="latitude" class="form-control" value="{{ $existingAddress->latitude }}" readonly required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Longitude</label>
                                    <input type="text" id="edit_longitude" name="longitude" class="form-control" value="{{ $existingAddress->longitude }}" readonly required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Ongkir per 1 km (Rp)</label>
                            <input type="number" name="ongkir_per_1km" class="form-control" value="{{ $existingAddress->ongkir_per_km }}" required>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="button" id="editGpsButton" class="btn btn-info btn-sm">Gunakan GPS Saya</button>
                            </div>
                            <div>
                                <button type="button" id="cancelEditBtn" class="btn btn-secondary">Batal</button>
                                <button type="button" id="updateBtn" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Form Delete (Hidden) --}}
        <form id="deleteForm" action="{{ route('store-address.destroy', $existingAddress->id) }}" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>

    @else
        {{-- Form tambah baru jika belum ada data --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tambah Alamat Toko</h5>
            </div>
            <div class="card-body">
                <form id="storeAddressForm" action="{{ route('store-address.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <textarea id="alamat_lengkap" name="alamat_lengkap" class="form-control" placeholder="Ketik alamat..." required></textarea>
                        <div id="suggestions" class="list-group mt-2"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Latitude</label>
                                <input type="text" id="latitude" name="latitude" class="form-control" readonly required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Longitude</label>
                                <input type="text" id="longitude" name="longitude" class="form-control" readonly required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Ongkir per 1 km (Rp)</label>
                        <input type="number" name="ongkir_per_1km" class="form-control" placeholder="Contoh: 5000" required>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" id="gpsButton" class="btn btn-info">Gunakan GPS Saya</button>
                        <button type="button" id="submitBtn" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Alert Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
    console.log('🚀 JavaScript loaded - Store Address Management');

    // Initialize map jika ada data existing
    @if($existingAddress)
        initializeMap({{ $existingAddress->latitude }}, {{ $existingAddress->longitude }});
    @endif

    // === AUTOCOMPLETE FUNCTIONS ===
    function setupAutocomplete(inputSelector, suggestionsSelector) {
        $(inputSelector).on("input", function() {
            let query = $(this).val();
            if(query.length > 3) {
                $.get("https://nominatim.openstreetmap.org/search", {
                    q: query,
                    format: "json",
                    addressdetails: 1,
                    limit: 5,
                    countrycodes: "id"
                }, function(data) {
                    $(suggestionsSelector).empty();
                    data.forEach(function(item) {
                        $(suggestionsSelector).append(
                            `<a href="#" class="list-group-item list-group-item-action suggestion" data-input="${inputSelector}" data-lat="${item.lat}" data-lon="${item.lon}">
                                ${item.display_name}
                            </a>`
                        );
                    });
                });
            }
        });
    }

    // Setup autocomplete untuk form baru
    @if(!$existingAddress)
        setupAutocomplete("#alamat_lengkap", "#suggestions");
    @endif

    // Setup autocomplete untuk edit form
    setupAutocomplete("#edit_alamat_lengkap", "#edit_suggestions");

    // Handle suggestion click
    $(document).on("click", ".suggestion", function(e) {
        e.preventDefault();
        let inputSelector = $(this).data("input");
        let text = $(this).text().trim();
        
        $(inputSelector).val(text);
        
        if(inputSelector === "#alamat_lengkap") {
            $("#latitude").val($(this).data("lat"));
            $("#longitude").val($(this).data("lon"));
            $("#suggestions").empty();
        } else {
            $("#edit_latitude").val($(this).data("lat"));
            $("#edit_longitude").val($(this).data("lon"));
            $("#edit_suggestions").empty();
        }
    });

    // === GPS FUNCTIONS ===
    function handleGPS(latSelector, lonSelector, addressSelector) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                let lat = position.coords.latitude;
                let lon = position.coords.longitude;
                console.log('GPS coordinates:', {lat, lon});
                
                $(latSelector).val(lat);
                $(lonSelector).val(lon);

                $.get("https://nominatim.openstreetmap.org/reverse", {
                    lat: lat,
                    lon: lon,
                    format: "json"
                }, function(data) {
                    console.log('Reverse geocoding response:', data);
                    if (data && data.display_name) {
                        $(addressSelector).val(data.display_name);
                    }
                });
            });
        } else {
            alert("Browser tidak mendukung GPS");
        }
    }

    // GPS untuk form baru
    $("#gpsButton").click(function() {
        console.log('GPS button clicked - New form');
        handleGPS("#latitude", "#longitude", "#alamat_lengkap");
    });

    // GPS untuk edit form
    $("#editGpsButton").click(function() {
        console.log('GPS button clicked - Edit form');
        handleGPS("#edit_latitude", "#edit_longitude", "#edit_alamat_lengkap");
    });

    // === FORM SUBMISSION ===
    @if(!$existingAddress)
    // Submit form baru
    $("#submitBtn").click(function() {
        console.log('🚀 Manual submit initiated');
        
        $(this).prop('disabled', true).text('Menyimpan...');
        
        let alamat = $("#alamat_lengkap").val().trim();
        let lat = $("#latitude").val().trim();
        let lon = $("#longitude").val().trim();
        let ongkir = $("input[name='ongkir_per_1km']").val().trim();
        
        console.log('📋 Data untuk submit:', {alamat, lat, lon, ongkir});
        
        if (!alamat || !lat || !lon || !ongkir) {
            console.error('❌ Validation failed');
            alert('Semua field harus diisi!');
            $(this).prop('disabled', false).text('Simpan');
            return;
        }
        
        console.log('✅ Validation passed, submitting form...');
        
        try {
            document.getElementById('storeAddressForm').submit();
            console.log('📤 Form submitted successfully');
        } catch (error) {
            console.error('❌ Submit error:', error);
            $(this).prop('disabled', false).text('Simpan');
        }
    });
    @endif

    // === EDIT/UPDATE FUNCTIONS ===
    $("#editBtn").click(function() {
        $("#viewMode").hide();
        $("#editMode").show();
        $(this).hide();
        $("#deleteBtn").hide();
    });

    $("#cancelEditBtn").click(function() {
        $("#editMode").hide();
        $("#viewMode").show();
        $("#editBtn").show();
        $("#deleteBtn").show();
    });

    $("#updateBtn").click(function() {
        console.log('🔄 Update submit initiated');
        
        $(this).prop('disabled', true).text('Mengupdate...');
        
        let alamat = $("#edit_alamat_lengkap").val().trim();
        let lat = $("#edit_latitude").val().trim();
        let lon = $("#edit_longitude").val().trim();
        let ongkir = $("input[name='ongkir_per_1km']", "#updateAddressForm").val().trim();
        
        console.log('📋 Data untuk update:', {alamat, lat, lon, ongkir});
        
        if (!alamat || !lat || !lon || !ongkir) {
            console.error('❌ Update validation failed');
            alert('Semua field harus diisi!');
            $(this).prop('disabled', false).text('Update');
            return;
        }
        
        console.log('✅ Update validation passed, submitting...');
        
        try {
            document.getElementById('updateAddressForm').submit();
            console.log('📤 Update form submitted successfully');
        } catch (error) {
            console.error('❌ Update submit error:', error);
            $(this).prop('disabled', false).text('Update');
        }
    });

    // === DELETE FUNCTION ===
    window.confirmDelete = function() {
        if (confirm('Apakah Anda yakin ingin menghapus alamat toko ini?')) {
            document.getElementById('deleteForm').submit();
        }
    };

    // === MAP FUNCTION ===
    function initializeMap(lat, lng) {
        // Simple map placeholder - bisa diganti dengan Google Maps atau Leaflet
        $("#map").html(`
            <div class="text-center">
                <small class="text-muted">Koordinat: ${lat}, ${lng}</small><br>
                <a href="https://maps.google.com/?q=${lat},${lng}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                    Lihat di Google Maps
                </a>
            </div>
        `);
    }
});
</script>

@endsection