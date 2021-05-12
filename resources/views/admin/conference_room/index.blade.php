@extends('layouts.admin.app')

@section('content')

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-header card-header-primary">

                            <a class="btn btn-info float-right" href="{{ route('admin.conference_room.create') }}"><i class="fas fa-folder-plus"></i>Add</a>
                            <h4 class="card-title ">Simple Table</h4>
                        </div>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table" id="table">
                                    <thead class=" text-primary">
                                    <th>
                                        ID
                                    </th>
                                    <th>
                                        Name
                                    </th>
                                    <th>
                                        Actions
                                    </th>
                                    </thead>
                                    <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($cr_rooms as $cr_room)
                                        <tr>
                                            <td>{{ ++$i }}</td>
                                            <td>{{ $cr_room->name }}</td>
                                            <td>
                                                <form
                                                        action="{{ route('admin.conference_room.destroy', $cr_room->id) }}"
                                                        class="d-inline" method="POST">
                                                    @method('DELETE')
                                                    @csrf
                                                    <button class="btn btn-danger"><i class="far fa-trash-alt"></i></button>
                                                </form>

                                                <a href="{{ route('admin.conference_room.edit', $cr_room->id) }}"
                                                   class="btn btn-info"><i class="fas fa-edit"></i></a>

                                                <a href="{{ route('admin.conference_room.show', $cr_room->id) }}"
                                                   class="btn btn-light" href=""><i class="fas fa-info"></i></a>
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
@push('js')

<script>
    $(document).ready(function () {
        $('#table').DataTable();
    });

</script>
@endpush
