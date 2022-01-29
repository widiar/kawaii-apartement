@extends('admin.template.admin')

@section('title', 'Rooms')

@section('main-content')
<a href="{{ route('admin.room.create') }}" class="m-3">
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
                    <th>Jenis Kamar</th>
                    <th>Harga Kamar</th>
                    <th>Foto Kamar</th>
                    <th class="text-center">Aksi</th>
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
                    <td>{{ $dt->jenis }}</td>
                    <td>{{ number_format($dt->harga, '0', '.') }}</td>
                    <td class="text-center">
                        <button data-id="{{ $dt->id }}" class="btn btn-sm btn-primary btn-detail"><i class="fas fa-eye"></i></button>
                    </td>
                    <td class="text-center">
                        <div class="row justify-content-center" style="min-width: 100px">
                            <a href="{{ route('admin.room.edit', $dt->id) }}" class="mx-3">
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                            </a>
                            <form action="{{ route('admin.room.destroy', $dt->id) }}" method="POST"
                                class="deleted">
                                @method("DELETE")
                                @csrf
                                <button class="btn btn-sm btn-danger" type="submit"><i
                                        class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="fotoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Foto Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body foto">
        
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    let urlShow = `{{ route('admin.room.show', '#id') }}`
    let urlImage = `{{ Storage::url('rooms/image/') }}`

    $('body').on('click', '.btn-detail', function(e){
        $('.foto').empty()
        let ul = urlShow.replace('#id', $(this).data('id'))
        $.ajax({
            url: ul,
            success: (res) => {
                res.image.forEach(fil => {
                    let html = `<div class="col-12 my-2">
                                    <img src="${urlImage + fil.image}" alt="" class="img-thumbnail">
                                </div>`
                    $('.foto').append(html)
                })
            }
        })
        $('#fotoModal').modal('show')
    })
</script>
@endsection