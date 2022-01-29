@extends('admin.template.admin')

@section('title', 'Banner')

@section('main-content')
<a href="{{ route('admin.banner.create') }}" class="m-3">
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
                    <th>Title</th>
                    <th>Foto</th>
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
                    <td>
                        @foreach (json_decode($dt->title) as $key => $title)
                            <span class="badge badge-info">{{ $key }}</span> {{ $title }}
                            <br>
                        @endforeach
                    </td>
                    <td class="text-center">
                        <a href="{{ Storage::url('banner/') . $dt->foto }}" class="btn-detail">
                            <button class="btn btn-sm btn-primary"><i class="fas fa-eye"></i></button>
                        </a>
                    </td>
                    <td class="text-center">
                        <div class="row justify-content-center" style="min-width: 100px">
                            <a href="{{ route('admin.banner.edit', $dt->id) }}" class="mx-3">
                                <button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></button>
                            </a>
                            <form action="{{ route('admin.banner.destroy', $dt->id) }}" method="POST" class="deleted">
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

<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Detail Gambar</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" alt="" class="img-thumbnail img-detail" style="width: 100%">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $('body').on('click', '.btn-detail', function(e){
        e.preventDefault()
        const url = $(this).attr('href')
        $('.img-detail').attr('src', url)
        $('#imageModal').modal('show')
    })
</script>
@endsection