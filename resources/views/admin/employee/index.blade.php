@extends('layouts.admin.app')

@push('css')
    
@endpush

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

                    @if (session('success'))
                        <div class="alert alert-success ">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ session('success') }}</strong>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger ">
                            <button type="button" class="close" data-dismiss="alert">×</button>
                            <strong>{{ session('error') }}</strong>
                        </div>
                    @endif

                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                <strong>{{ $error }}</strong>
                            </div>
                        @endforeach
                    @endif
                    <div class="card mt-5" id="card">

                        <div class="card-header card-header-primary">

                            <a class="btn btn-info btn-lg float-right" href="{{ route('admin.employee.create') }}"><i
                                    class="fas fa-folder-plus"></i>Add</a>
                            <h4 class="card-title ">Employees</h4>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table">
                                    <thead class=" text-primary">
                                        <th>
                                            ID
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>Email</th>
                                        <th>
                                            Actions
                                        </th>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($employees as $employee)
                                            <tr>
                                                <td>
                                                    {{ ++$i }}
                                                </td>
                                                <td>
                                                    {{ $employee->name }}
                                                </td>
                                                <td>{{ $employee->email }}</td>
                                                <td>
                                                    <form action="{{ route('admin.employee.destroy', $employee->id) }}"
                                                        method="post" class="d-inline">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="btn btn-danger">
                                                            <i class="far fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('admin.employee.edit', $employee->id) }}"
                                                        class="btn btn-info"><i class="fas fa-edit"></i></a>
                                                    <a href="{{ route('admin.employee.show', $employee->id) }}"
                                                        class="btn btn-light"><i class="fas fa-info"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
