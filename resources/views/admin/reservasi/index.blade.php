@extends('admin.template.admin')

@section('title', 'Reservasi')

@section('main-content')
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
                    <th>Jenis Kamar</th>
                    <th>No. Tlp</th>
                    <th>Checkin</th>
                    <th>Checkout</th>
                    <th>Total Harga</th>
                    <th>Status</th>
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
                    <td>{{ $dt->room->jenis }}</td>
                    <td>{{ $dt->no_telepon }}</td>
                    <td>{{ date('d F Y', strtotime($dt->checkin)) }}</td>
                    <td>{{ date('d F Y', strtotime($dt->checkout)) }}</td>
                    <td>
                        Rp {{ number_format($dt->total_harga, '0', '.', '.') }} 
                        <button data-id="{{ $dt->id }}" class="btn btn-sm btn-primary mx-3 info-harga">
                            <i class="fas fa-info-circle"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        @if($dt->is_approve == 0)
                        <h3 class="badge badge-secondary">Not Paid</h3>
                        @elseif($dt->is_approve == 1)
                        <h3 class="badge badge-success">Paid</h3>
                        @else
                        <h3 class="badge badge-danger">Rejected</h3>
                        @endif
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="buktiModal" tabindex="-1" role="dialog" aria-labelledby="pembayaranModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="pembayaranModal">Bukti Bayar</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="" alt="" class="img-thumbnail bukti-img" style="width: 100%">
            </div>
            <div class="modal-footer btn-bukti-aksi">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="pembayaranModal"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="pembayaranModal">Info Pembayaran</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center"><b>Harga: </b><span id="harga"></span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><b>Diskon: </b><span id="diskon"></span></li>
                    <li class="list-group-item d-flex justify-content-between align-items-center"><b>Total Harga: </b><span id="total-harga"></span></li>
                </ul>
            </div>
            <div class="modal-footer btn-bukti-aksi">

            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    const formURL = `{{ route('admin.reservasi.status') }}`

    const formSubmit = (urlForm, id, text) => {
        let value = 0
        if(text == 'approved'){
            value = 1
        }  else {
            value = 2
        }
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
                  url: urlForm,
                  method: 'POST',
                  data: {
                      id: id,
                      status: value
                  },
                  beforeSend: () => {
                    Swal.fire({
                        text: 'Procesing',
                        timer: 2000,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading()
                            Swal.stopTimer()
                        }
                    })
                  },
                  success: function(res){
                    Swal.close()
                    Swal.fire({
                        title: 'Success!',
                        text: `The data has been ${text}.`,
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
    }

    $(document).on('click', '.bukti', function(e){
        e.preventDefault()
        $('.bukti-img').attr('src', $(this).attr('href'))
        const status = $(this).data('status')
        const id = $(this).data('id')
        let element = ''
        if (status == '0') {
            element = `
                <form action="${formURL}" method="POST" id="form-reject" data-id="${id}">
                    <button type="submit" class="btn btn-danger">Reject</button>
                </form>
                <form action="${formURL}" method="POST" id="form-verif" data-id="${id}">
                    <button type="submit" class="btn btn-success">Approve</button>
                </form>
            `
        } else {
            element = `
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            `
        }
        $('.btn-bukti-aksi').html(element)
        $('#buktiModal').modal('show')
    })

    $('body').on('click', '.info-harga', function(e){
        e.preventDefault()
        const id = $(this).data('id')
        $.ajax({
            url: `{{ route('admin.check.detail.harga') }}`,
            method: 'GET',
            data: {
                id: id
            },
            success: (res) => {
                $('#harga').text('Rp ' + toRupiah(res.harga))
                $('#diskon').text('Rp ' + toRupiah(res.diskon))
                $('#total-harga').text('Rp ' + toRupiah(res.total_harga))
                $('#infoModal').modal('show')
            }
        })
    })

    $(document).on('submit', '#form-reject', function(e){
        e.preventDefault()
        const id = $(this).data('id')
        formSubmit($(this).attr('action'), id, 'rejected')
    })

    $(document).on('submit', '#form-verif', function(e){
        e.preventDefault()
        const id = $(this).data('id')
        formSubmit($(this).attr('action'), id, 'approved')
    })
</script>
@endsection