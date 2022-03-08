@extends('admin.template.admin')

@section('title', 'Vocuher')

@section('main-content')
<a href="{{ route('admin.voucher.create') }}" class="m-3">
    <button class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Data</button>
</a>
<div class="card shadow mx-3">
    <div class="card-body table-responsive">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-check"></i> BERHASIL!</h5>
            {{session('success')}}
        </div>
        @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h5><i class="icon fas fa-exclamation-triangle"></i> GAGAL!</h5>
            {{session('error')}}
        </div>
        @endif
        <table id="adminTable" class="table table-bordered dt-responsive nowrap" style="width: 100%;">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Nama</th>
                    <th>Type</th>
                    <th>Code</th>
                    <th>Maximum Used</th>
                    <th>Used</th>
                    <th>Date</th>
                    <th class="text-center">Aksi</th>
                    <th class="text-center">Status</th>
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
                    <td>
                        {{ $dt->name }}
                    </td>
                    <td>
                        {{ $dt->type }}
                    </td>
                    <td>{{ $dt->code }}</td>
                    <td>{{ $dt->max_use }}</td>
                    <td>{{ $dt->max_use }}</td>
                    <td>{{ $dt->start_date }}</td>
                    <td class="text-center">
                        <div class="row justify-content-center" style="min-width: 100px">
                            <form action="{{ route('admin.banner.destroy', $dt->id) }}" method="POST" class="deleted">
                                @method("DELETE")
                                @csrf
                                <button class="btn btn-sm btn-danger" type="submit"><i
                                        class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                    <td>
                        @if ($dt->status == 1)
                        <span class="badge badge-success">Aktif</span>
                        @else
                        <span class="badge badge-danger">Tidak Aktif</span>
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>


@endsection

@section('script')
@endsection