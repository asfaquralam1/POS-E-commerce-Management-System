@extends('admin.master')
@section('page_title', 'Dashboard')
@section('dashboard_select', 'active')
@section('content')
<div class="layout-wrapper sidebar-open">
    @include('admin.partials.sidebar')
    <div class="dashboard-content">
        <div class="item_card">
            <p>{{ $total_users }} <br> Customers</p>
            <i class="fas fa-users"></i>
        </div>
        <div class="item_card">
            <p>{{ $total_products }} <br> Products</p>
            <i class="fas fa-tshirt"></i>
        </div>
        <div class="item_card">
            <p>{{ $total_categories }} <br> Categories</p>
            <i class="fas fa-tag"></i>
        </div>
    </div>
    <div class="dashboard_footer">
        <div class="table_area">
            <div class="dashboard_table_header">
                <h4>Top Selling</h4>
                <a href="{{ route('admin.order') }}" class="view-btn">View All</a>
            </div>
            <div class="table-responsive">
                <table id="table" class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center">Date</th>
                            <th class="text-center">Customer Name</th>
                            <!-- <th class="text-center">Address</th> -->
                            <th class="text-center">Grand Total</th>
                            <!-- <th class="text-center">Status</th> -->
                        </tr>
                    </thead>
                    <tbody>
                       
                    </tbody>
                </table>
            </div>
        </div>
        <div class="table_area">
            <div class="dashboard_table_header">
                <h4>Users</h4>
                <a href="#" class="view-btn">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td class="text-center">{{ $user->name }}</td>
                            <td class="text-center">{{ $user->email }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection