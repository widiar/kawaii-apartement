@extends('admin.template.admin')

@section('title', 'Edit Voucher')

@section('main-content')
<div class="card shadow mx-3">
    <div class="card-body">
        <form action="{{ route('admin.voucher.update', $data->id) }}" method="post" enctype="multipart/form-data" id="form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" required name="name" class="form-control  @error('name') is-invalid @enderror"
                    value="{{ old('name', $data->name) }}">
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="type">Type</label>
                <select name="type" class="form-control @error('type') is-invalid @enderror">
                    <option value="" selected disabled>Type Voucher</option>
                    <option {{ $data->type == 'percentage' ? 'selected' : '' }} value="percentage">Percentage</option>
                    <option {{ $data->type == 'fixed' ? 'selected' : '' }} value="fixed">Fixed</option>
                </select>
                @error('type')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="code">Code</label>
                <div class="input-group">
                    <input type="text" readonly required name="code" class="form-control  @error('code') is-invalid @enderror"
                    value="{{ old('code', $data->code) }}">
                    <div class="input-group-append">
                        <button class="btn btn-secondary btn-sm" id="reload-code" type="button"><i class="fas fa-redo-alt"></i></button>
                    </div>
                </div>
                @error('code')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="value">Value</label>
                <input type="text" required name="value" class="form-control  @error('value') is-invalid @enderror"
                    value="{{ old('value', $data->value) }}">
                @error('value')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="max">Max Used</label>
                <input type="text" required name="max" class="form-control  @error('max') is-invalid @enderror"
                    value="{{ old('max', $data->max_use) }}">
                @error('max')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="start">Date Start</label>
                <input type="date" required name="start" class="form-control  @error('start') is-invalid @enderror"
                    value="{{ old('start', $data->start_date) }}">
                @error('start')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="end">Date End</label>
                <input type="date" required name="end" class="form-control  @error('end') is-invalid @enderror"
                    value="{{ old('end', $data->end_date) }}">
                @error('end')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="type">Status</label>
                <select name="status" class="form-control @error('status') is-invalid @enderror">
                    <option {{ $data->type == 1 ? 'selected' : '' }} value="1">Aktif</option>
                    <option {{ $data->type == 0 ? 'selected' : '' }} value="0">Tidak Aktif</option>
                </select>
                @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-block btn-primary">Update</button>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    $('#form').validate({
        rules: {
            name: 'required',
            type: 'required',
            code: 'required',
            value: {
                required: true,
                number: true
            },
            max: {
                required: true,
                digits: true
            },
            start: 'required',
            end: 'required',
            status: 'required'
        }
    })
    $('#reload-code').click(function() {
        $.ajax({
            url: `{{ route('admin.voucher.generate') }}`,
            method: 'POST',
            beforeSend : () => {
                $(this).html('<i class="fas fa-spinner fa-spin"></i>')
                $(this).attr('disabled', 'disabled')
            },
            success: (data) => {
                $('input[name="code"]').val(data.code)
            },
            complete: () => {
                $(this).html('<i class="fas fa-redo-alt"></i>')
                $(this).removeAttr('disabled')
            }
        })
    })
</script>
@endsection