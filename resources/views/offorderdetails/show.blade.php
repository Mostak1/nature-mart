@extends('layouts.main')


@section('content')
    <div class="card card-hover shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h4 class="m-0 font-weight-bold text-info">Subject Details</h4>
            <a href="{{ url('subcategory') }}" class="btn btn-info  btn-sm" title="Back to Subject">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <div class="card-body">
            <table class="table table-responsive">
                <tr class="table-bordered">
                    <th>Id</th>
                    <td>{{ $subcategory->id }}</td>
                </tr>
                <tr class="table-bordered">
                    <th>Name</th>
                    <td>{{ $subcategory->name }}</td>
                </tr>
                <tr class="table-bordered">
                    <th>Class</th>
                    <td>{{ $subcategory->category->name }}</td>
                </tr>
                <tr class="table-bordered">
                    <th>Active</th>
                    <td>{{ $subcategory->active }}</td>
                </tr>
                <tr class="table-bordered">
                    <th>Description</th>
                    <td>{{ $subcategory->description }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection
