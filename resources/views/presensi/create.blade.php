@extends('layouts.presensi')

@section('header')
<!-- App Header -->
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Presensi</div>
    <div class="right"></div>
</div>
<!-- * App Header -->

<style>
    .webcam-capture,
    .webcam-capture video {
        display: inline-block;
        width: 100% !important;
        margin: auto;
        height: auto !important;
        border-radius: 15px;
    }

    #map {
        height: 250px;
    }
</style>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endsection

@section('content')
<div class="row" style="margin-top: 70px;">
    <div class="col">
        <input type="text" id="lokasi" class="form-control" readonly>
        <div class="webcam-capture"></div>
    </div>
</div>
<div class="row mt-3">
    <div class="col">
        @if ($cek > 0)
            <button id="takeabsen" class="btn btn-danger btn-block">
                <ion-icon name="camera-outline"></ion-icon>
                Absen Pulang
            </button>
        @else
            <button id="takeabsen" class="btn btn-success btn-block">
                <ion-icon name="camera-outline"></ion-icon>
                Absen Datang
            </button>
        @endif
    </div>
</div>
<div class="row mt-2 mb-6">
    <div class="col">
        <div id="map"></div>
    </div>
</div>
@endsection

@push('myscript')
    <script>
        Webcam.set({
            height: 480,
            width: 640,
            image_format: 'jpeg',
            jpeg_quality: 80
        });

        Webcam.attach('.webcam-capture');

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) {
            const lokasi = document.getElementById('lokasi');
            const latitude = position.coords.latitude;
            const longitude = position.coords.longitude;
            lokasi.value = `${latitude},${longitude}`;

            const map = L.map('map').setView([latitude, longitude], 17);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            L.marker([latitude, longitude]).addTo(map);
            L.circle([-7.929872548857881, 112.64928946236074], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 45
            }).addTo(map);
        }

        function errorCallback(error) {
            console.error("Error occurred while retrieving location: ", error);
        }

        $("#takeabsen").click(function () {
            Webcam.snap(function (uri) {
                const image = uri;
                const lokasi = $("#lokasi").val();

                $.ajax({
                    type: 'POST',
                    url: '/presensi/store',
                    data: {
                        _token: "{{ csrf_token() }}",
                        image: image,
                        lokasi: lokasi
                    },
                    cache: false,
                    success: function (respond) {
                        if (respond.status === 0) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Absen Datang Anda Berhasil',
                                icon: 'success',
                                showConfirmButton: false, // Hilangkan tombol konfirmasi
                                timer: 3000 // Tampilkan pesan selama 3 detik
                            }).then(() => {
                                location.href = '/dashboard';
                            });
                        } else if (respond.status === 1) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Absen Datang Anda Gagal',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        } else if (respond.status === 2) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Absen Pulang Anda Berhasil',
                                icon: 'success',
                                showConfirmButton: false, // Hilangkan tombol konfirmasi
                                timer: 3000 // Tampilkan pesan selama 3 detik
                            }).then(() => {
                                location.href = '/dashboard';
                            });
                        } else if (respond.status === 3) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: 'Absen Pulang Anda Gagal',
                                icon: 'error',
                                confirmButtonText: 'OK' 
                            });
                        } else if (respond.status === 4) {
                            Swal.fire({
                                title: 'Gagal!',
                                text: `Absen Pulang Gagal, Anda di Luar Pengadilan Negeri Kota Malang Dengan Jarak ${respond.radius} meter`,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    }
                });
            });
        });
    </script>
@endpush