@extends('customer.dashboard')

@section('content')

<div class="d-flex justify-content-center mt-5">
    <div style="width: 1200px">
        <div class="bg-white rounded-xl p-5">

            <div class="flex items-center mb-4">
                <svg class="w-5 h-5 color_maroon mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ __("Verifikasi berhasil!") }}</span>
            </div>

            <div class="mb-5 d-flex align-items-center d-flex justify-content-between">
                <div>
                    <p class=""><span class="color_maroon fs-4 fw-bold">Selamat!</span> Kamu kini terverifikasi sebagai <span class="italic fw-bold">penjual</span>.</p>
                    <p class="">Kamu akan diarahkan ke halaman jual barang dalam beberapa saat.</p>
                </div>
            </div>

            <div class="flex items-center mb-6">
                <div class="mr-3">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 loadginCircleMaroon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
                <div id="countdown">Mengalihkan ke halaman dalam <span id="timer">5</span> detik...</div>
            </div>

            <div class="mt-4">
                <div class="relative">
                    <div class="w-full bg-gray-200 rounded-full h-2">
                        <div id="progress-bar" class="loadingProgressMaroon h-2 rounded-full w-0 transition-all duration-1000"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let timeLeft = 5;
        const timerElement = document.getElementById('timer');
        const progressBar = document.getElementById('progress-bar');

        const interval = setInterval(function () {
            timeLeft--;
            timerElement.textContent = timeLeft;

            const progress = (3 - timeLeft) * 33.33;
            progressBar.style.width = progress + '%';

            if (timeLeft <= 0) {
                clearInterval(interval);
                window.location.href = "{{ route('customer.items.index') }}";
            }
        }, 1000);
    });
</script>

<div style="height: 800px"></div>

@endsection
