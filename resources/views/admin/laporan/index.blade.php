@extends('admin.template.admin')

@section('title', 'Laporan')

@section('main-content')
<button class="btn btn-primary mx-3" data-toggle="modal" data-target="#modalAdmin"><i class="fa fa-plus"></i> Buat Laporan</button>
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
                    <th>File</th>
                    <th>Bulan</th>
                    <th>Tanggal Pembuatan</th>
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
                    <td class="text-center">
                        <a href="{{ Storage::url($dt->name) }}" target="_blank" class="mx-2">
                            <button class="btn btn-sm btn-success"><i class="fas fa-file-excel"></i></button>
                        </a>
                    </td>
                    <td>{{ date('F y', strtotime($dt->bulan)) }}</td>
                    <td>{{ date('d/m/y h:i A', strtotime($dt->updated_at)) }}</td>
                    <td class="text-center">
                        <div class="row justify-content-center" style="min-width: 100px">
                            <form action="{{ route('admin.laporan.delete', $dt->id) }}" method="POST" class="deleted">
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

<div class="modal fade" id="modalAdmin" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Laporan Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.laporan.post') }}" method="POST" class="rekap">
                @csrf
                <div class="modal-body form-group">
                    <label for="bulan">Bulan</label>
                    <div class="input-group">
                        <input type="text" id="tgl" name="tanggal" class="form-control datepicker"
                            value="{{ date('Y-m') }}">
                        <div class="input-group-append">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Buat</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    $(document).ready(function(){
        $('.bulan').select2({
            theme: "bootstrap"
        });
    })
    $(".datepicker").datepicker({
        format: 'yyyy-mm',
        todayBtn: "linked",
        startView: "months", 
        minViewMode: "months",
        // daysOfWeekDisabled: "0,6",
        autoclose: true,
        endDate: "+0d",
        todayHighlight: true
    });
    let rekap = $(".rekap");
    $(rekap).submit(function(e){
        e.preventDefault()
        Swal.fire({
            title: 'Laporan Transaksi',
            text: 'Sedang di Proses',
            timer: 1000,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading()
                Swal.stopTimer()
                $.ajax({
                    url: $(rekap).attr("action"),
                    method: 'POST',
                    data: $(rekap).serialize(),
                    dataType: 'json',
                    success: function(msg){
                        if (msg == "Success"){
                            Swal.resumeTimer()
                        }else if(msg == "Ada"){
                            Swal.close()
                            Swal.fire("Oops", "Pada Bulan tersebut sudah dibuat", "warning");
                        }
                    },
                    error: (res) => {
                        Swal.close()
                        Swal.fire("Oops", "Something Wrong!", "error");
                        console.log(res.responseJSON)
                    }
                })
            }
        }).then((result) => {
            if(result.dismiss){
                Swal.fire({
                    title: "Success!",
                    text: 'Laporan berhasil dibuat',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false,
                }).then((res) => {
                    if (res.dismiss) window.location.href = ""
                })
            }
        });
    })
</script>
@endsection