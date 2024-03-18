@extends('layouts.main')


@section('content')
    <div class="card card-hover shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h4 class="m-0 font-weight-bold text-info">Update Material</h4>
            <a href="{{ url('material') }}" class="btn btn-info  btn-sm" title="Back to Subject">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <div class="card-body">
            {!! Form::model($material, [
                'method' => 'put',
                'enctype' => 'multipart/form-data',
                'class' => 'user',
                'route' => ['material.update', $material->id],
            ]) !!}

            <div class="form-group row">

                <div class="col-sm-3 mb-2">
                    {!! Form::text('name', null, [
                        'required',
                        'class' => 'form-control form-control-profile',
                        'id' => 'name',
                        'placeholder' => 'Name',
                    ]) !!}
                </div>

                <div class="col-sm-3 mb-2">
                    {!! Form::text('unit', null, [
                        'required',
                        'class' => 'form-control form-control-profile',
                        'id' => 'unit',
                        'placeholder' => 'Unit ',
                    ]) !!}
                </div>
                <div class="col-sm-3 mb-2">
                    {!! Form::text('quantity', null, [
                        'required',
                        'class' => 'form-control form-control-profile',
                        'id' => 'quantity',
                        'placeholder' => 'Quantity',
                    ]) !!}
                </div>
                <div class="col-sm-3 mb-2">
                    {!! Form::text('price', null, [
                        'required',
                        'class' => 'form-control form-control-profile',
                        'id' => 'price',
                        'placeholder' => 'Price',
                    ]) !!}
                </div>
            </div>


            <div class="form-group">
                {!! Form::submit('Update Material', ['class' => 'btn btn-info btn-profile btn-block']) !!}
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
