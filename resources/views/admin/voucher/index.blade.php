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
                    <td>{{ $dt->used->count() }}</td>
                    <td>
                        {{ date('d F Y', strtotime($dt->start_date)) }}
                        -   
                        {{ date('d F Y', strtotime($dt->end_date)) }}
                    </td>
                    <td class="text-center">
                        <div class="row justify-content-center" style="min-width: 100px">
                            <a href="{{ route('admin.voucher.edit', $dt->id) }}" class="mx-3">
                                <button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button>
                            </a>
                            <form action="{{ route('admin.voucher.status', $dt->id) }}" method="POST" class="change-status">
                                @method('PATCH')
                                @csrf
                                <input type="hidden" name="status" value="{{ $dt->status }}">
                                <button class="btn btn-sm btn-{{ $dt->status == 1 ? 'danger' : 'success'}}">
                                    @if($dt->status == 1)
                                    <i class="fas fa-times-circle"></i>
                                    @else
                                    <i class="fas fa-check-circle"></i>
                                    @endif
                                </button>
                            </form>
                            <form action="{{ route('admin.voucher.destroy', $dt->id) }}" method="POST" class="deleted mx-3">
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
<script>
    $('body').on('submit', '.change-status', function(e){
        e.preventDefault();
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes!'
            }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'PATCH',
                    success: (res) => {
                        Swal.fire({
                            title: 'Success!',
                            text: `The status data has been changed.`,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        }).then((result) => {
                            window.location.href = "";
                        }) 
                    },
                    error: (res) => {
                        Swal.fire("Oops", "Something Wrong!", "error");
                        console.log(res.responseJSON)
                    }
                })
            }
        })
    })
</script>
@endsection