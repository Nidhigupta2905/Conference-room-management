@extends('layouts.employee.app')

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
                    <div class="card">

                        <div class="card-header card-header-primary">

                            <a class="btn btn-info pull-right" href="{{ route('employee.meeting.index') }}">See Today's
                                Meetings</a>
                            <h4 class="card-title ">Meeting List</h4>
                            <p class="card-category"> Here is a subtitle for this table</p>
                        </div>
                        <div class="card-body" id="table_data">

                            <select name="" id="" onchange="filterDay(this.value)" class="form-control">
                                <option value="1">1</option>
                                <option value="3">3</option>
                                <option value="5">5</option>
                                <option value="7">7</option>
                            </select>

                            @include('employee.meeting.paginate_data')

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
            $('body').on('click', '.pagination a', function(e) {
                e.preventDefault();
                var page = $(this).attr('href').split('page=')[1];

                $.ajax({
                    url: "/employee/meeting-history?page=" + page,
                    success: function(response) {
                        $('#table_data').html(response);
                    }
                });
            });



        });

        function filterDay(value) {
            window.location.assign(`/employee/meeting-history/${value}`);
        }

    </script>
@endpush
