@extends('layouts.app')

@section('content')
<div id="map"></div>
@endsection

@push('scripts')
<script>
    // Inisialisasi peta
    var map = L.map('map').setView([-7.797068, 110.370529], 13); // Koordinat Yogyakarta

    // Tambahkan tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Tambahkan marker
    L.marker([-7.797068, 110.370529]).addTo(map)
        .bindPopup('Yogyakarta')
        .openPopup();
</script>
@endpush
