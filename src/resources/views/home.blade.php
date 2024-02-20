@extends('layouts.app')

@section('content')
    @if ($user_is_admin)
        @include('dashboard.admin.users')
        @include('dashboard.admin.clients')
    @else
        @include('dashboard.final_user.all')
    @endif
@endsection
