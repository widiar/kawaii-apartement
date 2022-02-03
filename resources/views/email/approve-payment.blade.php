@component('mail::message')
# Pembayaran Berhasil !

Pembayaran Sudah di Terima!<br>
Terimakasih sudah melakukan reservasi di Kawaii Apartemen.

No. Invoice :
@component('mail::panel')
<a href="{{ route('mail.invoice', ['nomor'=>$data->inv]) }}" target="_blank">{{ $data->inv }}</a>
@endcomponent

@component('mail::table')
| Kamar | Checkin | Checkout | Hari | Total Harga |
| :------------- | :------------: | :------------: | :--------:| -------: |
| {{ $data->room->jenis }} | {{ date('j F Y', strtotime($data->checkin)) }} | {{ date('j F Y', strtotime($data->checkout)) }} | {{ $data->hari }} | Rp {{ number_format($data->total_harga, 0, ',', '.') }} |
@endcomponent

Bukti pembayaran ini merupakan bukti yang sah.

Thanks,<br>
{{ config('app.name') }}
@endcomponent