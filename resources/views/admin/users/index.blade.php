@extends('admin.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('user.create') }}" class="btn btn-primary">Add User</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">



            <div class="card">
                <form action="{{ route('user.index') }}" method="GET">
                    <div class="card-header">
                        {{-- @include('mesage') --}}
                        {{-- <div class="card-title">
                            <button type="button" onclick="window.location.href='{{ route('purchaseOrder.index') }}'"
                                class="btn btn-primary">Reset</button>
                        </div>
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" value="{{ Request::get('keyword') }}" name="keyword"
                                    class="form-control float-right" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </form>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Capital</th>
                                <th>Balance</th>
                                <th>Profit</th>
                                <th>Loss</th>
                                <th>Add Profit</th>
                                <th>Add Loss</th>



                                <th width="100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->isNotEmpty())
                                @foreach ($users as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item->name ?? 'N/A' }}</td>
                                        <td>{{ $item->email ?? 'N/A' }}</td>
                                        <td>{{ $item->capital ?? 'N/A' }}</td>
                                        <td>{{ $item->balance ?? 'N/A' }}</td>
                                        <td>{{ $item->profit ?? 'N/A' }}</td>
                                        <td>{{ $item->loss ?? 'N/A' }}</td>
                                        <td>
                                            <button class="btn btn-primary add-profit-btn" data-id="{{ $item->id }}"
                                                data-toggle="modal" data-target="#profitModal">
                                                Add Profit
                                            </button>
                                        </td>
                                        <td>
                                            <button class="btn btn-danger add-loss-btn" data-id="{{ $item->id }}"
                                                data-toggle="modal" data-target="#lossModal">
                                                Add Loss
                                            </button>
                                        </td>


                                        <td class="d-flex">
                                            <!-- Edit Button -->
                                            <a href="{{ route('user.edit', $item->id) }}" class="mr-2">
                                                <svg class="filament-link-icon w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path
                                                        d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                    </path>
                                                </svg>
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('user.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this item?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-danger border-0 bg-transparent p-0">
                                                    <svg class="filament-link-icon w-4 h-4"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                        fill="currentColor" aria-hidden="true">
                                                        <path fill-rule="evenodd"
                                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-danger text-center">
                                        <h1>Rcords not found</h1>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer clearfix">
                    {{ $users->links('pagination::bootstrap-5') }}

                </div>


                <!-- Profit Modal -->
                <div class="modal fade" id="profitModal" tabindex="-1" aria-labelledby="profitModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="profitModalLabel">Update Profit</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="profitForm" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <input type="hidden" id="user_id" name="user_id">
                                    <div class="form-group">
                                        <label for="profit">Profit Amount</label>
                                        <input type="number" class="form-control" id="profit" name="profit" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Profit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                {{-- loss model  --}}
                <!-- Loss Modal -->
                <div class="modal fade" id="lossModal" tabindex="-1" aria-labelledby="lossModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="lossModalLabel">Update Loss</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="lossForm" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body">
                                    <input type="hidden" id="loss_user_id" name="user_id">
                                    <div class="form-group">
                                        <label for="loss">Loss Amount</label>
                                        <input type="number" class="form-control" id="loss" name="loss"
                                            required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger">Update Loss</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
    </div>

@endsection

@section('customjs')
    <script>
        $(document).ready(function() {
            // Close modal when close button is clicked
            $('.close, [data-dismiss="modal"]').on('click', function() {
                $('#profitModal').modal('hide');
            });
            $('.close, [data-dismiss="modal"]').on('click', function() {
                $('#lossModal').modal('hide');
            });
        });

        $(document).on('click', '.add-profit-btn', function() {
            let userId = $(this).data('id');
            $('#user_id').val(userId);
            $('#profitModal').modal('show'); // Force open the modal
        });

        $(document).on('click', '.add-loss-btn', function() {
            let userId = $(this).data('id');
            $('#loss_user_id').val(userId);
            $('#lossModal').modal('show'); // Force open the loss modal
        });

        $(document).ready(function() {
            // Submit Profit Form via AJAX
            $('#profitForm').submit(function(e) {
                e.preventDefault();
                let userId = $('#user_id').val();
                let profitAmount = $('#profit').val();
                let url = "{{ url('user/update-profit') }}/" + userId;

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: {
                        _token: "{{ csrf_token() }}",
                        profit: profitAmount
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function() {
                        alert("Error updating profit.");
                    }
                });
            });

            // Submit Loss Form via AJAX
            $('#lossForm').submit(function(e) {
                e.preventDefault();
                let userId = $('#loss_user_id').val();
                let lossAmount = $('#loss').val();
                let url = "{{ url('user/update-loss') }}/" + userId;

                $.ajax({
                    url: url,
                    type: 'PUT',
                    data: {
                        _token: "{{ csrf_token() }}",
                        loss: lossAmount
                    },
                    success: function(response) {
                        alert(response.message);
                        location.reload();
                    },
                    error: function() {
                        alert("Error updating loss.");
                    }
                });
            });
        });
    </script>
@endsection
