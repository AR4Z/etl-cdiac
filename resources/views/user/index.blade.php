@extends('template.main')

@section('title', 'Inicio')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10">
            <div class="panel panel-default">
                <div class="panel-heading">Usuarios</div>
                <div class="panel-body">
                    <table class="table table-bordered" id="users_datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Email</th>
                                <th>Activo</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('javascript')
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        $('#users_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url('users/users-list') }}",
            columns: [{
                    data: 'identification_document',
                    name: 'id'
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'lastname',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                }, {
                    data: 'active',
                    name: 'active'
                }
            ]
        });
    });
</script>
@endsection