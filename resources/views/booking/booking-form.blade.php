@extends('layouts.app')

@section('content')

    <div
        class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="row">
            <div class="col-md-4 mx-auto">
                <form action="" method="post">
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
        </div>
    </div>

@endsection


@section('js')

    <script type="text/javascript">
        $(function() {
            console.log("date")
            $("#datepicker").datepicker();
        });

    </script>
@endsection
