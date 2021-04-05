@extends('layouts.admin.app')

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header card-header-primary">

                            <a class="btn btn-info pull-right" href="{{ route('admin.employee.create') }}"><i
                                    class="material-icons">
                                    add_circle_outline</i>Add</a>
                            <h4 class="card-title ">Employees</h4>
                            <p class="card-category"> Here is a subtitle for this table</p>
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
                                                            <i class="material-icons">
                                                                delete
                                                            </i>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('admin.employee.edit', $employee->id) }}" class="btn btn-info"><i
                                                            class="material-icons">
                                                            create
                                                        </i></a>
                                                    <a href="{{route('admin.employee.show', $employee->id)}}" class="btn btn-light"><i class="material-icons">
                                                            visibility
                                                        </i></a>
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
