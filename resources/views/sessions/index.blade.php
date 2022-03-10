@extends('layouts.master')

@section('title', 'Sessions')


@section('content')
<div class="container-fluid">
    <div class="px-4">
        @error('msg')
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="d-flex justify-content-center mb-3">
            <a href="{{ route('sessions.create') }}" class="btn btn-success my-3">Create session</a>
        </div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">All Sessions</h3>
            </div>
            <div class="card-body">
                <table id="table" class="table text-center table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Day</th>
                            <th>Coach</th>
                            <th>Start at</th>
                            <th>Finish at</th>
                            @role('gymManager|admin|cityManager')
                            <th>Actions</th>
                            @endrole
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sessions as $session)
                        <tr>
                            <td>{{ $session->name }}</td>
                            <td>{{ $session->day}}</td>
                            <td>
                                <ul style="list-style: none;" class="list-group list-group-flush">
                                    @foreach($session->coaches as $coach)
                                    <li>{{ $coach->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $session->started_at }}</td>
                            <td>{{ $session->finished_at }}</td>


                            @role('gymManager|admin|cityManager')
                            <td class="d-flex justify-content-center">

                                <a href="{{ route('sessions.show',  $session->id) }}" class="btn btn-md btn-info mr-2" title="show"><i class="fas fa-eye"></i></a>

                                @if (count($session->attendances)==0)
                                <a href="{{ route('sessions.edit', ['id' => $session->id]) }}" class="btn btn-md btn-warning mr-2" title="Edit"><i class="fas fa-edit"></i></a>
                                @endif

                                @if (count($session->attendances)==0)
                                <form method="POST" action="{{ route('sessions.destroy', ['id' => $session->id]) }}">
                                    @CSRF
                                    @method('delete')
                                    <input name="_method" type="hidden" value="DELETE">
                                    <button type="submit" class="btn btn-md btn-danger show-alert-delete-box" data-toggle="tooltip" title='Delete'><i class="fas fa-times" disabled></i></button>
                                </form> @endif
                            </td>
                            @endrole
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script>
    $(document).ready(function() {
        $('#table').DataTable();
    });
<<<<<<< HEAD


    $('.show-alert-delete-box').click(function(event){
        var form =  $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
            title: "Are you sure you want to delete this record?",
            text: "If you delete this, it will be gone forever.",
            icon: "warning",
            type: "warning",
            buttons: ["Cancel","Yes!"],
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((willDelete) => {
            if (willDelete) {

                form.submit();
            }
        });
    });

=======
>>>>>>> 44c0ff59e95f1c9bb18c98449b7be8917f9edd61
</script>

@include('layouts.alertScript')
@stop
