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
            
            <div class="fasilitas">
                <div class="isi-fasilitas">
                    @foreach(json_decode($data->fasilitas) as $fasilitas)
                    <div class="fasilitas-container">
                        <div class="icon">
                            <div class="form-group">
                                <label for="icon_fasilitas">Icon</label>
                                <select name="icon_fasilitas[]" class="form-control icon_fasilitas">
                                    <option value=""></option>
                                    <option {{ $fasilitas->icon == 'utensils' ? 'selected' : ''  }} value='utensils'>Food</option>
                                    <option {{ $fasilitas->icon == 'shower' ? 'selected' : ''  }} value="shower">Shower</option>
                                    <option {{ $fasilitas->icon == 'bed' ? 'selected' : ''  }} value="bed">Bed</option>
                                    <option {{ $fasilitas->icon == 'fan' ? 'selected' : ''  }} value="fan">AC</option>
                                    @if(!in_array($fasilitas->icon, ['utensils', 'shower', 'bed', 'fan']))
                                    <option selected value="{{ $fasilitas->icon }}">{{ $fasilitas->icon }}</option>
                                    @endif
                                </select>
                            </div>
                            <div class="icon-display text-center m-4">
                                <i class="fas fa-{{ $fasilitas->icon }}" style="font-size: 100px"></i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_fasilitas_id">Nama Fasilitas (ID)</label>
                                    <input type="text" name="nama_fasilitas_id[]" class="form-control nama_fasilitas_id"
                                        value="{{ old('nama_fasilitas_id', $fasilitas->title->id) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama_fasilitas_en">Nama Fasilitas (EN)</label>
                                    <input type="text" name="nama_fasilitas_en[]" class="form-control nama_fasilitas_en"
                                        value="{{ old('nama_fasilitas_en', $fasilitas->title->en) }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="deskripsi_fasilitas">Deskripsi (ID)</label>
                                    <textarea name="deskripsi_fasilitas_id[]" cols="30" rows="5" class="form-control">{{ $fasilitas->description->id }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="deskripsi_fasilitas">Deskripsi (EN)</label>
                                    <textarea name="deskripsi_fasilitas_en[]" cols="30" rows="5" class="form-control">{{ $fasilitas->description->en }}</textarea>
                                </div>
                            </div>
                        </div>
                        @if(!$loop->first)
                        <button type="button" class="btn btn-danger btn-sm btn-delete-fasilitas">Hapus</button>
                        @endif
                        <hr>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-primary btn-add-fasilitas">Tambah Fasilitas</button>
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

    const initiateIconFasilitas = () => {
        $('.icon_fasilitas').select2({
            placeholder: 'Pilih Icon',
            allowClear: true,
            width: '100%',
            tags: true,
            theme: 'bootstrap4'
        })
    }

    initiateIconFasilitas()

    $('body').on('change', '.icon_fasilitas', function(e) {
        $(this).parents('.icon').find('.icon-display').html(`<i class="fas fa-${$(this).val().toLowerCase()}" style="font-size: 100px"></i>`)
        $(this).parents('.icon').find('.icon-display').show(300)
    })

    $('body').on('click', '.btn-delete-fasilitas', function(e) {
        $(this).parent().remove()
    })

    $('.btn-add-fasilitas').click(function(){
        const htmlFas = `
        <div class="fasilitas-container">
            <div class="icon">
                <div class="form-group">
                    <label for="icon_fasilitas">Icon</label>
                    <select name="icon_fasilitas[]" class="form-control icon_fasilitas">
                        <option value=""></option>
                        <option value='utensils'>Food</option>
                        <option value="shower">Shower</option>
                        <option value="bed">Bed</option>
                        <option value="fan">AC</option>
                    </select>
                </div>
                <div class="icon-display text-center m-4" style="display: none">
                    <i class="fas fa-utensils" style="font-size: 100px"></i>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_fasilitas_id">Nama Fasilitas (ID)</label>
                        <input type="text" name="nama_fasilitas_id[]" class="form-control nama_fasilitas_id"
                            value="{{ old('nama_fasilitas_id') }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_fasilitas_en">Nama Fasilitas (EN)</label>
                        <input type="text" name="nama_fasilitas_en[]" class="form-control nama_fasilitas_en"
                            value="{{ old('nama_fasilitas_en') }}">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="deskripsi_fasilitas">Deskripsi (ID)</label>
                        <textarea name="deskripsi_fasilitas_id[]" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="deskripsi_fasilitas">Deskripsi (EN)</label>
                        <textarea name="deskripsi_fasilitas_en[]" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-danger btn-sm btn-delete-fasilitas">Hapus</button>
            <hr>
        </div>`
        $('.isi-fasilitas').append(htmlFas)
        initiateIconFasilitas()
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
            'icon_fasilitas[]': 'required',
            'nama_fasilitas_id[]': 'required',
            'nama_fasilitas_en[]': 'required',
            'deskripsi_fasilitas_id[]': 'required',
            'deskripsi_fasilitas_en[]': 'required',
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