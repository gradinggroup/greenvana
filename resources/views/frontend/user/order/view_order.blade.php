@extends('frontend.main_master')
@section('content')

@if(session('error'))
<script>
    alert("{{ session('error') }}");
</script>
@endif

<div class="body-content">
    <div class="container">
        <div class="row">
            <div class="col-md-2">
                @include('frontend.common.user_sidebar')
            </div>
            <div class="col-md-2">
                
            </div>
            <div class="col-md-10 mt-3">
                <br>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Total</th>
                                <th>Payment</th>
                                <th>Invoice</th>
                                <th>Order</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>{{ $order->order_date }}</td>
                                <td>Rp. {{ $order->amount }}</td>
                                <td>{{ $order->payment_type }}</td>
                                <td>{{ $order->invoice_no }}</td>
                                <td>
                                    @if($order->status == 'Pending')
                                    <span class="badge badge-pill badge-danger">Pending</span>
                                    @else
                                    <span class="badge badge-pill badge-success">Success</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('order.detil',$order->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i> View</a>
                                    <a href="{{ route('invoice',$order->id) }}" class="btn btn-sm btn-danger" target="_blank"><i class="fa fa-download"></i> Invoice</a>
    @if($order->amount >= 20000)
        <a href="{{ route('game.page', ['order_id' => $order->id]) }}" class="btn btn-success mt-2">
            🎮 Game
        </a>
    @endif




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



@endsection