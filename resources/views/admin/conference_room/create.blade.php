@extends('layouts.admin.app')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-2">

            @if (session('success'))
                <div class="alert alert-success ">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ session('success') }}</strong>
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
                    <h4 class="card-title">Add Conference Rooms</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.conference_room.store') }}" id="cr_form">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="bmd-label-floating">Conference Room Name</label>
                                    <input type="text" class="form-control" name="conference_room_name"
                                        id="conference_room_name">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary pull-right">Submit</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#cr_form').submit(function(e) {
                e.preventDefault();
                var _token = $('input[name=_token]').val();
                var cr_name = $('#conference_room_name').val();

                console.log(cr_name);

                const data = {
                    '_token': _token,
                    'conference_room_name': cr_name
                }

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.conference_room.store') }}",
                    data: data,
                    success: function(response) {
                        swal("Done", "Name Uploaded Successfully", "success");
                        $('#cr_form').trigger('reset');
                    },

                    error: function(response) {
                        var error = response.responseJSON.errors.join("\n");
                        swal("Cancelled", error, "error");
                    }
                });

            });
        });

    </script>
@endpush
