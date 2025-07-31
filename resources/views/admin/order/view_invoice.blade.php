<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Invoice</title>

	<style type="text/css">
		*{
			font-family: Verdana, Arial, sans-serif;
		}

		table{
			font-size: x-small;
		}
		tfoot tr td{
			font-weight: bold;
			font-size: x-small;
		}
		.gray{
			background-color: lightgray;
		}
		.font{
			font-size: 15px;
		}
		.thanks p{
			color: blue;
			font-size: 16px;
			font-weight: normal;
			font-family: serif;
			margin-top: 20px;
		}

		.authority{
			margin-top: -10px;
			color: blue;
			margin-left: 35px;
		}

	</style>
</head>
<body>

	<table width="100%" style="background: #F7F7F7; padding: 0 20px 0 20px;">
		<tr>
			<td valign="top">
				<h2 style="color:blue; font-size: 26px;"><strong>MihapeStore</strong></h2>
			</td>
			<td align="right" style="margin-right: 20px;">
				<pre>
					MihapeStore Head Office
					Email: hi@mihapecode.com <br>
					Phone: 085322912294 <br>
				</pre>
			</td>
		</tr>
	</table>

	<hr>

	<table width="100%" style="background: #F7F7F7; padding: 0 5 0 5px;">
		<tr>
			<td width="50%">
				<p class="font" style="margin-left: 20px;">
					<strong>Name: </strong> {{ $order->name }}<br>
					<strong>Email: </strong> {{ $order->email }}<br>
					<strong>Phone: </strong> {{ $order->phone }}<br>
					<strong>Address: </strong> {{ $order->village->name }}, {{ $order->district->name }}, {{ $order->regency->name }}, {{ $order->province->name }}<br>
					<strong>Post Code: </strong> {{ $order->post_code }} 
				</p>
			</td>
			<td width="50%">
				<p class="font" style="margin-right: 20px;">
					<strong>Invoice: #{{ $order->invoice_no }}</strong><br>
					<strong>Order Date: </strong> {{ $order->order_date }}<br>
					<strong>Delivery Date: </strong> {{ $order->delivered_date }}<br>
					<strong>Payment Type: </strong> {{ $order->payment_type }}
				</p>
			</td>
		</tr>
	</table>
	<br>

	<h3>Products</h3>

	<table width="100%">
		<thead style="background-color: blue; color: #FFFFFF;">
			<tr class="font">
				<th>Image</th>
				<th>Product Name</th>
				<th>Size</th>
				<th>Color</th>
				<th>Quantity</th>
				<th>Unit Price</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			@foreach($orderItem as $item)
			<tr class="font">
				<td align="center">
					<img src="{{ public_path($item->product->product_thambnail) }}" height="60px;" width="60px;" alt="">
				</td>
				<td align="center">{{ $item->product->product_name_en }}</td>
				<td align="center">{{ $item->size }}</td>
				<td align="center">{{ $item->color }}</td>
				<td align="center">{{ $item->qty }}</td>
				<td align="center">Rp. {{ $item->price }}</td>
				<td align="center">Rp. {{ $item->price * $item->qty }}</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<br>

	<table width="100%" style="padding: 0 10px 0 10px;">
		<tr>
			<td align="right">
				<h2><span style="color:blue;"> Subtotal: Rp. {{ $order->amount }}</span></h2>
				<h2><span style="color:blue;"> Total: Rp. {{ $order->amount }}</span></h2>
				<h3><span style="color:green">Payment Status: {{ $order->status }}</span></h3>
			</td>
		</tr>
	</table>

	<div class="thanks mt-3">
		<p>Thanks For Buying Product!</p>
	</div>
	<div class="authority float-right mt-5">
		<p>-------------------------------</p>
		<h5>Authority Signature:</h5>
	</div>

</body>
</html>