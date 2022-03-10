@extends('layouts.master')
@section('title')
    Payment
@endsection

@section('content')

    <div class="card card-primary w-50 my-5 mx-auto">

        <div class="card-header bg-success">
            <h3 class="card-title">Buy Package</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body ">
            <form class="mt-5 w-50 mx-auto" action="{{ route('payment.store') }}" method="post">
                @csrf
                <!-- Select City -->
                @role('admin')
                    <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <select class="form-control" name="city" id="citySelector">
                            <option value="0" disabled selected>Choose City</option>

                            @foreach ($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach

                        </select>
                    </div>
                @endrole

                <!-- Select Gym -->
                @hasanyrole('admin|cityManager')
                    <div class="mb-3">
                        <label for="gym" class="form-label">gym</label>
                        <select class="form-control" name="gym_id" id="gymSelector">
                            @hasanyrole('cityManager')
                            <option value="0" disabled selected>Choose Gym</option>

                            @foreach ($gyms as $gym)
                                <option value="{{ $gym->id }}">{{ $gym->name }}</option>
                            @endforeach
                            @endhasanyrole
                        </select>
                    </div>
                @endhasanyrole

                <!-- Select User -->
                @hasanyrole('admin|cityManager|gymManager')
                @hasanyrole('cityManager|gymManager')
                <input type="text" hidden name="city"  value="{{ $cities}}" id="citySelector" />
                @endhasanyrole
                @hasanyrole('gymManager')
                <input type="text" hidden name="gym_id"  value="{{ $gyms }}" />
                @endhasanyrole
                    <div class="form-group">
                        <label>Select User</label>
                        <select id="selectedUser" name="user_id" class="form-control">
                            <option value="0" disabled selected>Choose User</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endhasanyrole

                <!-- Select Package -->
                <div class="mb-3">
                    <label>Select Package</label>
                    <select id="selectedPackage" name="package_id" class="form-control">
                        <option value="0" disabled selected>Choose Package</option>
                        @foreach ($packages as $package)
                            <option value="{{ $package->id }}">{{ $package->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="d-flex justify-content-end">

                    <button type="submit" class="btn btn-success bg-success py-2 px-4">Buy</button>
                </div>
            </form>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

     @endsection

     @section('script')
     <script src="http://code.jquery.com/jquery-3.4.1.js"></script>
    @role('admin')
    <script>
        $(document).ready(function() {
            $('#citySelector').on('change', function() {
                let id = $(this).val();
                $('#gymSelector').empty();
                // $('#gymSelector').append('<option value="0" disabled selected>Processing</option>');
                $.ajax({
                    url: '/getGymsBelongsToCity/' + id,

                    type: "GET",


                    success: function(response) {
                        var response = JSON.parse(response);

                        $('#gymSelector').empty();
                        $('#gymSelector').append(
                            '<option value="0" disabled selected>Select Sub Category</option>'
                            );
                        response.forEach(element => {
                            $('#gymSelector').append(
                                `<option value="${element['id']}">${element['name']}</option>`
                                );
                        });
                    }

                });
            });
        });
    </script>
     @endrole
     
@error('message')

<script type="text/javascript">
$(document).ready(function() {
    $(window).on('load', function() {

    swal({
            title: "You can't buy this package",
            text:"Complete your form Data",
            icon: "error",
            type: "error",
            confirmButtonColor: '#8CD4F5',
            confirmButtonText: 'Ok',

        });

});
});
</script>
@enderror
@stop



