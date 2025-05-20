@extends('customer.dashboard')

@section('content')

    <div class="d-flex justify-content-center mt-5">
        <div style="width: 1200px">
            
            <div class="bg-white p-4 rounded-xl">
                <p class="fw-bold">Riwayat Transaksi</p>
                <p class="mb-4">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ad, sapiente!</p>

                @if (session('error'))
                    <p class="text-red-500 mt-4">{{ session('error') }}</p>
                @endif

                @if ($transactions->isEmpty())
                    <p class="text-neutral-500 mt-4">Anda belum memiliki transaksi.</p>
                @else
                    <table class="w-full mt-4 border-collapse border border-neutral-200">
                        <thead>
                            <tr class="bg-neutral-100">
                                <th class="border border-neutral-300 px-4 py-2 text-center fw-normal">Gambar</th>
                                <th class="border border-neutral-300 px-4 py-2 text-center fw-normal">Nama Barang</th>
                                <th class="border border-neutral-300 px-4 py-2 text-center fw-normal">Jenis Transaksi</th>
                                <th class="border border-neutral-300 px-4 py-2 text-center fw-normal">Total Harga</th>
                                <th class="border border-neutral-300 px-4 py-2 text-center fw-normal">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <!-- Kolom Gambar -->
                                    <td class="border border-neutral-300 px-4 py-2 text-center">
                                        @if ($transaction->auction)
                                            <img src="{{ asset('storage/' . $transaction->auction->image_path) }}" class="w-20 h-20 object-cover rounded mx-auto">
                                        @elseif ($transaction->item)
                                            <img src="{{ asset('storage/' . $transaction->item->image_path) }}" class="w-20 h-20 object-cover rounded mx-auto">
                                        @else
                                            <span class="text-neutral-500">Tidak tersedia</span>
                                        @endif
                                    </td>

                                    <!-- Kolom Nama Barang -->
                                    <td class="border border-neutral-300 px-4 py-2 text-center">
                                        @if ($transaction->auction)
                                            {{ $transaction->auction->name }}
                                        @elseif ($transaction->item)
                                            {{ $transaction->item->name }}
                                        @else
                                            <span class="text-neutral-500">Tidak diketahui</span>
                                        @endif
                                    </td>

                                    <!-- Kolom Jenis Transaksi -->
                                    <td class="border border-neutral-300 px-4 py-2 text-center">
                                        @if ($transaction->auction)
                                            Dibeli dari Lelang
                                        @elseif ($transaction->item)
                                            Dibeli Langsung
                                        @else
                                            Tidak diketahui
                                        @endif
                                    </td>

                                    <!-- Kolom Total Harga -->
                                    <td class="border border-neutral-300 px-4 py-2 text-center">
                                        Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                    </td>

                                    <!-- Kolom Status -->
                                    <td class="border border-neutral-300 px-4 py-2 text-center">
                                        @switch($transaction->status)
                                            @case('waiting_payment')
                                                <span class="text-yellow-500">Menunggu Pembayaran</span>
                                                @break

                                            @case('processing')
                                                <span class="text-blue-500">Sedang Diproses</span>
                                                @break

                                            @case('shipping_in_progress')
                                                <span class="text-cyan-600">Barang Sedang Dikirim</span>
                                                @break

                                            @case('shipped')
                                                <button onclick="showConfirmModal({{ $transaction->id }})" class="text-blue-500 underline">
                                                    Barang Sudah Dikirim - Konfirmasi?
                                                </button>
                                                @break

                                            @case('waiting_review')
                                                <a href="{{ route('customer.payment.completed', $transaction->id) }}" class="text-orange-500 underline">
                                                    Menunggu Review
                                                </a>
                                                @break

                                            @case('completed')
                                                @php
                                                    $hasReviewed = \App\Models\ItemReview::where('item_id', $transaction->item_id)
                                                                    ->where('customer_id', auth()->id())
                                                                    ->exists();
                                                @endphp
                                                @if ($hasReviewed)
                                                    <span class="text-green-600">Selesai (Sudah Diulas)</span>
                                                @else
                                                    <span class="text-green-500">Selesai</span>
                                                @endif
                                                @break

                                            @case('failed')
                                                <span class="text-red-500">
                                                    Gagal
                                                    @if ($transaction->failure_reason)
                                                        - {{ $transaction->failure_reason }}
                                                    @endif
                                                </span>
                                                @break

                                            @default
                                                <span class="text-neutral-500">Status Tidak Diketahui</span>
                                        @endswitch
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                @endif

                {{-- <a href="{{ route('customer.dashboard') }}" class="block text-start mt-2 text-neutral-500 hover:text-neutral-700">
                    Kembali ke Beranda
                </a> --}}
            </div>

        </div>
    </div>

    <div style="height: 300px"></div>

    <div style="margin-top: 500px" class="modal fade" id="confirmReceivedModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <form id="confirmReceivedForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Penerimaan Barang</h5>
                </div>
                <div class="modal-body">
                    Apakah Anda sudah menerima barang ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nanti Saja</button>
                    <button type="submit" class="btn btn-success">Ya, Saya Terima</button>
                </div>
            </form>
            </div>
        </div>
    </div>
@endsection

<!-- Modal Konfirmasi -->

<script>
    function showConfirmModal(transactionId) {
        const form = document.getElementById('confirmReceivedForm');
        form.action = `/customer/transactions/confirm-received/${transactionId}`;
        new bootstrap.Modal(document.getElementById('confirmReceivedModal')).show();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('confirmReceivedForm');

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const action = form.action;
            const token = form.querySelector('input[name="_token"]').value;

            fetch(action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({})
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload halaman agar status berubah jadi "Menunggu Review"
                    location.reload();
                } else {
                    alert('Gagal mengonfirmasi penerimaan.');
                }
            })
            .catch(error => {
                console.error(error);
                alert('Terjadi kesalahan saat mengonfirmasi.');
            });
        });
    });
</script>

