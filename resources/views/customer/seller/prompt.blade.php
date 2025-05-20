@extends('customer.dashboard')

@section('content')

<div class="d-flex justify-content-center mt-5">
    <div style="width: 1200px">
        <div class="bg-white rounded-xl p-5 text-center">

            <p class="mb-2 fw-bold fs-5">Apakah kamu ingin menjadi penjual?</p>

            <p class="mb-5 text-muted" style="max-width: 700px; margin: 0 auto;">
                Dengan menjadi penjual di Memorelic, kamu bisa menjangkau kolektor barang antik dari seluruh Indonesia.
                Tingkatkan penghasilanmu dengan menjual barang-barang unik yang kamu miliki—mulai dari koleksi langka, elektronik vintage, furnitur antik, hingga senjata tradisional. 
                Jadilah bagian dari komunitas eksklusif pecinta sejarah dan benda-benda klasik!
            </p>

            <div class="d-flex justify-content-center gap-3 mb-5">
                <div class="card bg_cream p-3" style="width: 220px;">
                    <img src="/image/hootbert/hootbert_half.png" class="img-fluid mb-2" alt="Perluas Bisnis">
                    <p class="fw-semibold color_maroon fs-6">Jual Barang Antikmu dengan Mudah</p>
                </div>
                <div class="card bg_cream p-3" style="width: 220px;">
                    <img src="/image/hootbert/hootbert_half.png" class="img-fluid mb-2" alt="Perluas Bisnis">
                    <p class="fw-semibold color_maroon fs-6">Buka Lelang untuk Barang Spesial</p>
                </div>
                <div class="card bg_cream p-3" style="width: 220px;">
                    <img src="/image/hootbert/hootbert_half.png" class="img-fluid mb-2" alt="Perluas Bisnis">
                    <p class="fw-semibold color_maroon fs-6">Perluas Jangkauan dan Cuanmu!</p>
                </div>
            </div>

            <a href="{{ route('customer.home') }}" class="btn btn-primary me-3">Tidak, mungkin nanti</a>
            <a href="{{ route('seller.verification.agreement') }}" class="btn btn_maroon">Ya, saya tertarik!</a>

        </div>
    </div>
</div>

<div style="height: 800px"></div>

@endsection