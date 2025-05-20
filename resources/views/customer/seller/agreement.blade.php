@extends('customer.dashboard')

@section('content')

<div class="d-flex justify-content-center mt-5">
    <div style="width: 1200px">
        <div class="bg-white rounded-xl p-5">

            <h2 class="text-lg font-bold mb-2 text-center">Perjanjian Menjadi Penjual</h2>

            <div class="mb-5 text-center">
                <p class="text-muted">
                    Selamat datang di langkah pertama untuk menjadi bagian dari komunitas penjual Memorelic!
                </p>
                <p style="max-width: 900px; margin: 0 auto;" class="text-muted">
                    Sebagai penjual, kamu dapat menjangkau ribuan kolektor dan penggemar barang antik dari seluruh Indonesia.
                    Pastikan kamu membaca dan memahami syarat & ketentuan berikut sebelum melanjutkan.
                </p>
            </div>

            <div class="p-4 border rounded-lg mb-3 bg-light" style="max-height: 300px; overflow-y: auto;">
                <p><strong>Syarat & Ketentuan Menjadi Penjual:</strong></p>

                <li>Barang yang dijual harus asli dan bukan replika tanpa keterangan.</li>
                <li>Penjual wajib memberikan informasi yang jujur dan lengkap tentang barang.</li>
                <li>Transaksi harus dilakukan melalui sistem Memorelic untuk menjamin keamanan.</li>
                <li>Dilarang menjual barang yang dilarang oleh hukum atau melanggar etika publik.</li>
                <li>Penjual harus bertanggung jawab terhadap pengiriman dan kondisi barang.</li>
            </div>

            <div class="alert alert-danger text-sm mb-3">
                <i class="bi bi-info-circle me-2"></i> 
                Tips: Gambar yang jelas, deskripsi detail, dan harga wajar akan meningkatkan peluang barangmu terjual lebih cepat!
            </div>

            <form action="{{ route('seller.verification.confirm') }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menjadi penjual?');">
                @csrf
                <div class="form-check mb-3">
                    <input type="checkbox" name="agree" id="agree" class="form-check-input" required>
                    <label for="agree" class="form-check-label"><p>Saya menyetujui semua ketentuan di atas</p></label>
                </div>
                <div class="text-center mt-5">
                    <button type="submit" class="btn btn_maroon">Confirm</button>
                </div>
            </form>

            <div class="bg_cream mt-5 p-3 text-white rounded-xl">
                <div class="d-flex justify-content-between align-items-end">
                    <div>
                        <p class="fs-1 fw-bold color_maroon mb-3">Mulai Perjalanan <br> Jualanmu di Memorelic!</p>
                        
                        <p style="width: 700px" class="color_dark">
                            Jadikan hobi mengoleksi menjadi peluang bisnis nyata. Tawarkan barang-barang antik favoritmu, ikuti lelang, dan temukan kolektor yang tepat. 
                            <span class="color_maroon fw-bold">Ayo mulai langkah pertamamu hari ini!</span>
                        </p>
                    </div>
                    <img style="position: relative; top: 17px; width: 250px; !important;" src="/image/hootbert/hootbert_half.png" alt="Mulai jualan">
                </div>
            </div>

        </div>
    </div>
</div>

<div style="height: 800px"></div>

@endsection
