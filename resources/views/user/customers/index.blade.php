@extends('user.master')
@section('title', 'Main Section')
@section('nav')
    @include('user.nav')
@endsection
@section('page', 'Customers')
@section('main')
    @include('user.main')

    <div class="container-fluid py-4">
        <a href="{{ route('user.customers.create') }}" class="btn btn-info mb-2">Add Customer</a>

        <div class="row">
            <div class="col-12">
                <div class="card mb-4">

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card-header pb-0">
                        <h6>CUSTOMERS</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Email Address</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Phone Number</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Address 1</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Address 2</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Address 3</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($customers as $index => $customer)
                                        <tr>
                                            <td>{{ $index + 1 . ". "}}</td>
                                            <td>{{ $customer->name }}</td>
                                            <td>{{ $customer->email }}</td>
                                            <td>{{ $customer->phone }}</td>
                                            <td>{{ $customer->address1 }}</td>
                                            <td>{{ $customer->address2 }}</td>
                                            <td>{{ $customer->address3 }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('user.customers.edit', $customer->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                                <form action="{{ route('user.customers.destroy', $customer->id) }}" method="POST" style="display: inline;" id="frmDeleteCustomer{{ $customer->id }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="deleteCustomer( '{{ $customer->id }}' )">Delete</button>
                                                </form>
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

        <!-- Footer -->
        <footer class="footer pt-5">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6 mb-lg-0 mb-4">
                        <div class="copyright text-center text-sm text-muted text-lg-start">
                            © <script>document.write(new Date().getFullYear())</script>,
                            made with <i class="fa fa-heart"></i> by
                            <a href="https://www.creative-tim.com" class="font-weight-bold" target="_blank">Creative Tim</a>
                            for a better web.
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com" class="nav-link text-muted" target="_blank">Creative Tim</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/presentation" class="nav-link text-muted" target="_blank">About Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/blog" class="nav-link text-muted" target="_blank">Blog</a>
                            </li>
                            <li class="nav-item">
                                <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-muted" target="_blank">License</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <input type="hidden" id="sts" class="form-control" value="{{ $status ?? '' }}" />
    <input type="hidden" id="psn" class="form-control" value="{{ $pesan ?? '' }}" />

    <!-- Success Message Update -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            const success = params.get('success');

            if (success === 'update') {
                // Show SweetAlert for successful update
                swal('Success', 'Customer has been updated!', 'success');
            } else if (success === 'delete') {
                // Show SweetAlert for successful delete
                swal('Success', 'Customer has been deleted successfully!', 'success');
            }
        });
    </script>

    <!-- Delete Messages -->
    <script>
        function deleteCustomer(id) {
            const form = document.getElementById('frmDeleteCustomer' + id);
            swal({
                title: "Are you sure?",
                text: "You will not be able to recover this data!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, I am sure!',
                cancelButtonText: "No, cancel it!",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    form.submit();
                    swal("Deleted", "Data has been successfully deleted!", "success");
                } else {
                    swal("Cancelled", "Your data is safe :)", "error");
                }
            });
        }
    </script>
@endsection
