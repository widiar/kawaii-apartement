@extends('admin.template.admin')

@section('title', 'Edit Kamar')

@section('css')
<style>
    .img-crop {
        height: 200px !important;
        width: 100%;
        object-fit: cover;
        object-position: center;
    }

    .img-frame {
        position: relative;
    }

    .img-frame:hover .delete-image {
        display: block;
    }

    .delete-image {
        position: absolute;
        bottom: 0;
        font-size: 18px;
        background: rgb(71, 71, 71);
        opacity: 0.8;
        width: 100%;
        text-align: center;
        height: 30px;
        color: #fff;
        cursor: pointer;
        display: none;
    }
</style>
@endsection

@section('main-content')
<div class="card shadow mx-3">
    <div class="card-body">
        <form action="{{ route('admin.room.update', $data->id) }}" method="post" enctype="multipart/form-data"
            id="form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="jenis">Jenis Kamar</label>
                <input type="text" required name="jenis" class="form-control  @error('jenis') is-invalid @enderror"
                    value="{{ old('jenis', $data->jenis) }}">
                @error('jenis')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="text" required name="harga" class="form-control  @error('harga') is-invalid @enderror"
                    value="{{ old('harga', $data->harga) }}">
                @error('harga')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah Kamar</label>
                <input type="number" required name="jumlah"
                    class="form-control  @error('jumlah') is-invalid @enderror" value="{{ old('jumlah', $data->jumlah) }}">
                @error('jumlah')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="limit">Fasilitas (ID) <span class="badge badge-pill badge-secondary" title="Pisahkan dengan tanda |"><i class="fa fa-question"></i></span></label>
                        <input type="text" required name="fasilitas_id" class="form-control  @error('fasilitas_id') is-invalid @enderror"
                            value="{{ old('fasilitas_id', json_decode($data->fasilitas)->id) }}">
                        @error('fasilitas_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="limit">Fasilitas (EN) <span class="badge badge-pill badge-secondary" title="Pisahkan dengan tanda |"><i class="fa fa-question"></i></span></label>
                        <input type="text" required name="fasilitas_en" class="form-control  @error('fasilitas_en') is-invalid @enderror"
                            value="{{ old('fasilitas_en', json_decode($data->fasilitas)->en) }}">
                        @error('fasilitas_en')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="text">Foto Kamar</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input foto" name="foto[]" accept="image/*" multiple>
                    <label class="custom-file-label label-foto">Select file</label>
                </div>
                @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <div class="row my-3">
                    @foreach ($data->image as $image)
                    <div class="col-3">
                        <div class="img-frame">
                            <img src="{{ Storage::url('rooms/image/') . $image->image }}" alt="" class="img-responsive img-crop">
                            <div class="delete-image hapus-image" data-id="{{ $image->id }}"><strong>Delete Image</strong></div>
                        </div> 
                    </div>
                    @endforeach
                </div>
                <div class="row image-foto my-3">
                    
                </div>
            </div>
            <button type="submit" class="btn btn-block btn-primary">Edit</button>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    let fotoData
    $('input[name="harga"]').simpleMoneyFormat()
    $('.foto').change(function(e){
        fotoData = Array.from(e.target.files)
        $('.image-foto').empty()
        let i = 0;
        Array.from(e.target.files).forEach(file => {
            let url = URL.createObjectURL(file)
            let image = `
            <div class="col-3">
                <div class="img-frame">
                    <img src="${url}" alt="" class="img-responsive img-crop">
                    <div class="delete-image delete-foto" data-id="${i}"><strong>Delete Image</strong></div>
                </div>      
            </div>`
            $('.image-foto').append(image)
            i++;
        })
    })

    const checkLengthFotoData = () => {
        let length = 0
        fotoData.forEach(elm => {
            if(elm !== null) length++
        })
        return length
    }

    const changeLabelFoto = () => {
        if($('.foto').val() == '' || $('.foto').val() == null){
            $('.label-foto').text('Select file')
        }
        else {
            let textLabel = ''
            fotoData.forEach(elm => {
                if(elm !== null) {
                    textLabel += `${elm.name}, `
                }
            })
            $('.label-foto').text(textLabel)
        }
    }

    $('body').on('click', '.delete-foto', function(e) {
        let id = $(this).data('id')
        fotoData[id] = null
        $(this).parent().parent().remove()
        if(checkLengthFotoData() <= 0) $('.foto').val(null)
        changeLabelFoto()
    })

    $('#form').validate({
        rules: {
            jenis: 'required',
            jumlah: {
                required: true,
                digits: true
            },
            harga: {
                required: true,
                number: true
            },
            fasilitas_id: 'required',
            fasilitas_en: 'required',
        },
        submitHandler: function(form, e) {
            e.preventDefault()

            let dataform = new FormData(form)
            if (fotoData !== undefined)
                fotoData.forEach(file => {
                    if(file !== null) {
                        dataform.append('fotofile[]', file)
                    }
                })

            $.ajax({
                url: $(form).attr('action'),
                data: dataform,
                type: 'POST',
                contentType: false, 
                processData: false, 
                success: (res) => {
                    if(res == 'Sukses') window.location.href = '{{ route("admin.room.index") }}'
                    else window.location.href = ''
                }, 
                error: (err) => {
                    console.log(err.responseJSON)
                }
            });

        }
    })
    $('body').on('click', '.hapus-image', function(e) {
        let id = $(this).data('id')
        let button = $(this)
        Swal.fire({
            title: 'Loading',
            timer: 20000,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading()
                Swal.stopTimer()
                $.ajax({
                    url: `{{ route('admin.room.delete.image') }}`,
                    method: 'DELETE',
                    data: {
                        id: id
                    },
                    success: (res) => {
                        button.parent().parent().remove()
                    },
                    complete: () => {
                        Swal.close()
                    },

                })
            }
        })
    })
</script>
@endsection