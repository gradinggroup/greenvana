@extends('frontend.main_master')
@section('content')


<div class="body-content">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                @include('frontend.common.user_sidebar')
            </div>
            <div class="col-md-2">
                
            </div>
            <div class="col-md-6">
                <div class="card">
                    <h3 class="text-center"><span class="text-danger">Hallo,</span><strong>{{ Auth::user()->name }}</strong> Selamat Datang di Marketplace Greenvana</h3>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection