@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Admin Dashboard</h1>
    <span class="badge bg-danger fs-6">Admin</span>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Users</h5>
                <p class="card-text display-6">--</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Total Orders</h5>
                <p class="card-text display-6">--</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h5 class="card-title">Total Products</h5>
                <p class="card-text display-6">--</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Revenue</h5>
                <p class="card-text display-6">--</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Welcome, {{ auth()->user()->name }}!</h5>
    </div>
    <div class="card-body">
        <p class="card-text">You are logged in as an <strong>Administrator</strong>.</p>
        <p class="card-text">From here you can manage products, categories, orders, and users.</p>
    </div>
</div>
@endsection
