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

                            <a class="btn btn-info float-right" href="{{ route('admin.conference_room.create') }}"><i
                                    class="fas fa-folder-plus"></i>Add</a>
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
                                            <tr id="meeting_data_{{ $cr_room->id }}">
                                                <td>{{ ++$i }}</td>
                                                <td>{{ $cr_room->name }}</td>
                                                <td>
                                                    {{-- <form
                                                        action="{{ route('admin.conference_room.destroy', $cr_room->id) }}"
                                                        class="d-inline" method="POST">
                                                        @method('DELETE')
                                                        @csrf
                                                        <button class="btn btn-danger"><i
                                                                class="far fa-trash-alt"></i></button>
                                                    </form> --}}

                                                    <button class="btn btn-danger loading_{{ $cr_room->id }}"
                                                        type="button" id="loading" style="display: none;">
                                                        <span class="spinner-border spinner-border-sm" role="status"
                                                            aria-hidden="true"></span>
                                                        <span class="sr-only">Loading...</span>
                                                    </button>

                                                    <button class="btn btn-danger delete_button_{{ $cr_room->id }}"
                                                        id="delete_button" data-id="{{ $cr_room->id }}"
                                                        data-token="{{ csrf_token() }}"><i
                                                            class="far fa-window-close"></i></button>

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
        $(document).ready(function() {

            $('body').on('click', '#delete_button', function(e) {
                e.preventDefault();

                var id = $(this).data("id");
                var token = $(this).data("token");


                const payLoad = {
                    'id': id,
                    '_method': 'DELETE',
                    '_token': token
                }

                if (confirm("Are you sure you want to delete the conference room!")) {

                    $('.loading_' + id).show();

                    $('.delete_button_' + id).hide();

                    $.ajax({
                        type: "DELETE",
                        url: "conference_room/" + id,
                        data: payLoad,

                        success: function(response) {
                            $('#meeting_data_' + id).fadeOut();

                            // setInterval(() => {
                            //     $('.loading_' + id).hide();
                            //     $('.edit_button_' + id).hide();


                            //     $('.delete_button_' + id).show();
                            //     $('.delete_button_' + id).prop('disabled', true);
                            //     $('#meeting_data_' + id).show();

                            // }, 2000);

                        },
                        error: function(response) {
                            console.log(response);
                        }
                    });
                }

            });


            $('#table').DataTable({
                "bInfo": false
            });
        });

    </script>
@endpush
