@component('mail::message')
# Pembayaran Tidak Diterima!

Dear, {{ $data->nama }} <br>
Pembayaran dengan nomor Invoice <strong style="color: #0c62e2;">{{ $data->inv }}</strong> Telah tidak diterima!<br>
Pembayaran yang anda lakukan tidak sesuai dengan prosedur kami.
Thanks,<br>
{{ config('app.name') }}
@endcomponent