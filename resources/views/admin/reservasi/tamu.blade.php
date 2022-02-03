@extends('admin.template.admin')

@section('title', 'Data Tamu')

@section('main-content')
<div class="card shadow mx-3">
    <div class="card-body table-responsive">
        <table id="adminTable" class="table table-bordered dt-responsive nowrap" style="width: 100%;">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>No. Tlp</th>
                    <th>Checkin</th>
                    <th>Checkout</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody class="actionz">
                @php
                $no=0;
                @endphp
                @if (!is_null($data))
                @foreach ($data as $dt)
                <tr>
                    <td>{{ ++$no }}</td>
                    <td>{{ $dt->nama }}</td>
                    <td>{{ $dt->nik }}</td>
                    <td>{{ $dt->no_telepon }}</td>
                    <td>{{ date('d F Y', strtotime($dt->checkin)) }}</td>
                    <td>{{ date('d F Y', strtotime($dt->checkout)) }}</td>
                    <td>Rp {{ number_format($dt->total_harga, '0', '.', '.') }}</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('script')
<script>
</script>
@endsection