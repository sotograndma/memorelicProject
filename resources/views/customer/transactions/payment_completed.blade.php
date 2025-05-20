@extends('customer.dashboard')

@section('content')

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            
            <div class="bg_category p-4">

                <div class="bg-white rounded-xl p-4 mb-4">
                    <p class="fw-bold mb-2 fs-5">Pembayaran Berhasil!</p>
                    <p class="">Terima kasih telah berbelanja di <strong>Memorelic</strong>.</p>
                    <p class="">Pembayaran Anda telah berhasil diproses.</p>
                </div>

                <div class="bg-white p-4 rounded-xl d-flex justify-content-around">
                    <div class="">
                        <p class="">Total Pembayaran:</p>
                        <p style="font-style: italic" class="fw-bold fs-5">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</p>
                    </div>

                    <div class="">
                        <p class="">Kode Pembayaran:</p>
                        <p class="fs-5 fw-bold color_maroon">{{ $transaction->payment_code }}</p>
                    </div>
                </div>

                <div class="mt-5">
                    
                    <p class="color_dark">Anda dapat melihat status pesanan di halaman <span class="fw-bold">Riwayat Transaksi</span>.</p>
                    
                    <div class="d-flex justify-content-between mt-2">
                        <a href="{{ route('customer.transactions.history') }}"
                            class="btn btn-primary me-3" style="width: 100%">
                            Lihat Riwayat Transaksi
                        </a>
                        <a href="{{ route('customer.dashboard') }}"
                            class="btn btn_maroon" style="width: 100%">
                            Kembali ke Beranda
                        </a>
                    </div>
                

                </div>

                @if (session('error'))
                    <div class="alert alert-danger mt-3">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($transaction->status == 'waiting_review' && ($transaction->item || $transaction->auction))
                    @php
                        $itemId = $transaction->item->id ?? null;
                        $hasReviewed = \App\Models\ItemReview::where('transaction_id', $transaction->id)->exists();
                    @endphp

                    @if (!$hasReviewed && $transaction->item)
                        <div class="bg-white rounded-xl p-4 mt-4">
                            <p class="fw-bold fs-5 mb-3">Beri Rating & Komentar untuk Barang</p>
                            <form action="{{ route('customer.items.review', $transaction->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="rating" class="form-label">Rating (1-5)</label>
                                    <select name="rating" id="rating" class="form-select" required>
                                        <option value="">Pilih Rating</option>
                                        @for ($i = 1; $i <= 5; $i++)
                                            <option value="{{ $i }}">{{ $i }} Bintang</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="comment" class="form-label">Komentar</label>
                                    <textarea name="comment" id="comment" class="form-control" rows="3" placeholder="Tulis komentar Anda..."></textarea>
                                </div>
                                <button type="submit" class="btn btn_maroon">Kirim Ulasan</button>
                            </form>
                        </div>
                    @endif
                @endif

            </div>
        </div>
    </div>

    <div style="height: 800px"></div>

    @if (session('review_submitted'))
        <!-- Modal -->
    <div style="margin-top: 500px" class="modal fade" id="thankYouModal" tabindex="-1" aria-labelledby="thankYouModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="thankYouModalLabel">Terima Kasih!</h5>
                </div>
            <div class="modal-body">
                Terima kasih sudah memberikan ulasan. Kami sangat mengapresiasi kontribusi Anda.
            </div>
            <div class="modal-footer">
                <a href="{{ route('customer.transactions.history') }}" class="btn btn-success">Kembali ke Riwayat</a>
            </div>
            </div>
        </div>
    </div>

    <script>
        // Aktifkan modal saat halaman dimuat
        window.addEventListener('DOMContentLoaded', function () {
            const modal = new bootstrap.Modal(document.getElementById('thankYouModal'));
            modal.show();
        });
    </script>
    @endif


@endsection

