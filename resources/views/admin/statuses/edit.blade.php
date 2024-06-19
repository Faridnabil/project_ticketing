@extends('layouts.admin')
@section('content')
    <div style="padding-top: 20px" class="content">
        <div style="margin-top: 50px" class="card">
            <div class="card-header">
                {{ trans('global.edit') }} {{ trans('cruds.status.title_singular') }}
            </div>

            <div class="card-body">
                <form action="{{ route('admin.statuses.update', [$status->id]) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label for="name">{{ trans('cruds.status.fields.name') }}*</label>
                        <input type="text" id="name" name="name" class="form-control"
                            value="{{ old('name', isset($status) ? $status->name : '') }}" required>
                        @if ($errors->has('name'))
                            <em class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </em>
                        @endif
                        <p class="helper-block">
                            {{ trans('cruds.status.fields.name_helper') }}
                        </p>
                    </div>
                    <div>
                        <input class="btn btn-danger" type="submit" value="{{ trans('global.save') }}">
                    </div>
                </form>


            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css"
        rel="stylesheet">
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js">
    </script>
    <script>
        $('.colorpicker').colorpicker();
    </script>
@endsection
