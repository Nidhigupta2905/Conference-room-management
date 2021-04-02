@extends('layouts.app')

@section('content')
    <section>
        <div
            class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="row">
                <div class="col-md-4 col-centered col-md-offset-5">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <td>S.No</td>
                                <td>Conference Room List</td>
                                <td>Action</td>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($conferenceRooms as $conferenceRoom)
                                <tr>
                                    <td>{{ ++$i }}</td>
                                    <td>{{ $conferenceRoom }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                            data-target="#book_cr" data-whatever="@mdo">Book CR</button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="book_cr" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Book CR</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <input type="hidden" name="cr_id" id="cr_id" value="">
                        <div class="form-group">
                            <label for="cr_name">Conference Room Name</label>
                            <input type="text" name="cr_name" id="cr_name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="datepicker">Choose Date</label>
                            <input type="text" name="datepicker" id="datepicker" class="form-control">
                        </div>
                        <div class="form-row">
                            <div class="col">
                                <label for="from_time">From Time</label>
                                <input type="text" name="from_time" id="from_time" class="form-control">
                            </div>

                            <div class="col">
                                <label for="to_time">To Time</label>
                                <input type="text" name="to_time" id="to_time" class="form-control">
                            </div>


                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript">
        $(function() {
            $("#datepicker").datepicker();
        });

        $(document).ready(function() {
            $('#from_time').timepicker();
        });

        $(document).ready(function() {
            $('#to_time').timepicker();
        });


        function getValue(id, name) {
            document.getElementById('cr_name').value = name;
        }

    </script>
@endsection
