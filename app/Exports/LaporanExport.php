<?php

namespace App\Exports;

use App\Models\Reservasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LaporanExport implements FromCollection, WithMapping, WithHeadings
{
    protected $bulan;
    protected $tahun;
    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Reservasi::with('promo', 'room')->whereMonth('updated_at', $this->bulan)
            ->whereYear('updated_at', $this->tahun)
            ->where('is_approve', 1)
            ->get();
    }

    public function map($data): array
    {
        return [
            $data->nama,
            $data->email,
            $data->no_telepon,
            date('d F Y', strtotime($data->checkin)),
            date('d F Y', strtotime($data->checkout)),
            $data->harga * $data->hari,
            is_null($data->promo) ? '0' : ($data->promo->type == 'percentage' ? ($data->harga * $data->hari) * ($data->promo->value / 100) : $data->promo->value),
            $data->total_harga,
            $data->room->jenis,
            is_null($data->promo) ? '-' : $data->promo->code,
        ];

    }

    public function headings(): array
    {
        return [
            'Nama',
            'Email',
            'No. Telp',
            'Check In',
            'Check Out',
            'Harga',
            'Diskon',
            'Total Harga',
            'Room',
            'Voucher',
        ];
    }
}
