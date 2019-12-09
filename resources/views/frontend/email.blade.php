

<div id="wrap-inner">
		<div id="khach-hang">
			<h3>Thông tin khách hàng</h3>
			<p>
				<span class="info">Khách hàng: </span>
				{{ $info['name'] }}
			</p>
			<p>
				<span class="info">Email: </span>
				{{ $info['email'] }}
			</p>
			<p>
				<span class="info">Điện thoại: </span>
				{{ $info['phone'] }}
			</p>
			<p>
				<span class="info">Địa chỉ: </span>
				{{ $info['add'] }}
			</p>
		</div>						
		<div id="hoa-don">
			<h3>Hóa đơn mua hàng</h3>							
			<table class="table-bordered table-responsive">
				<tr>
					<td width="25%">Tên sản phẩm</td>
					<td width="20%">Số lượng</td>
					<td width="15%">Đơn giá</td>
					<td width="15%">Thành tiền</td>
				</tr>
				@foreach ($listCarts as $cart)
					<tr>
						<td>{{ $cart->prod_name }}</td>
						<td>{{ $cart->quanity }}</td>
						<td>{{ number_format( $cart->prod_price ,0,',','.')."₫"}}</td>
						<td>{{ number_format( $cart->prod_price* $cart->quanity ,0,',','.')."₫"}}</td>
					</tr>
				@endforeach
				<tr>
					<td colspan="3">Tổng tiền:</td>
					<td class="total-price">{{ number_format( $totalMoney ,0,',','.')."₫"}}</td>
				</tr>
			</table>
		</div>
		<div id="xac-nhan">
			<br>
			<p align="justify">
				<b>Quý khách đã đặt hàng thành công!</b><br />
				• Sản phẩm của Quý khách sẽ được chuyển đến Địa chỉ có trong phần Thông tin Khách hàng của chúng Tôi sau thời gian 2 đến 3 ngày, tính từ thời điểm này.<br />
				• Nhân viên giao hàng sẽ liên hệ với Quý khách qua Số Điện thoại trước khi giao hàng 24 tiếng.<br />
				<b><br />Cám ơn Quý khách đã sử dụng Sản phẩm của Công ty chúng Tôi!</b>
			</p>
		</div>
	</div>					
