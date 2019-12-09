
@extends('frontend.master')
@section('main')
<link rel="stylesheet" href="css/cart.css">
<style>
#cart {
	display: none;
}


</style>
<div id="wrap-inner">
	@if ($count)
	<div id="list-cart">
			<h3>Giỏ hàng</h3>		
				<table class="table table-bordered .table-responsive text-center">
					<tr>
						<td width="11.111%">Ảnh mô tả</td>
						<td width="22.222%">Tên sản phẩm</td>
						<td width="22.222%">Số lượng</td>
						<td width="16.6665%">Đơn giá</td>
						<td width="16.6665%">Thành tiền</td>
						<td width="11.112%">Xóa</td>
					</tr>
					@foreach ($listCarts as $cart)
						<tr>
							<td><img class="img-responsive" style="height:200px" src="{{asset('storage/'.$cart->prod_img)}}"></td>
							<td>{{ $cart->prod_name }}</td>
							<td>
								<div class="row quanity_container">
									<div class="left col-sm-4">-</div>
									<input class="quanity col-sm-4" id="cc" type="text" data-idorder={{$cart->id}} value="{{ $cart->quanity }}">
									 <div class="right col-sm-4">+</i></div>
								</div>
							</td>
							<td><span class="price">{{ number_format( $cart->prod_price ,0,',','.')."₫"}}</span></td>
							<td><span class="price">{{ number_format( $cart->prod_price* $cart->quanity ,0,',','.')."₫"}}</span></td>
							<td data-idorder='{{ $cart->id }}' data-idprod='{{ $cart->prod_id }}' class="del">Xóa</td>
						</tr>
					@endforeach
				
				</table>
				<div class="row" id="total-price">
					<div class="col-md-6 col-sm-12 col-xs-12">										
							Tổng thanh toán: <span class="total-price">{{ number_format( $totalMoney ,0,',','.')."₫"}}</span>
																									
					</div>
				</div>
             	                	
		</div>
	
		<div id="xac-nhan">
			<h3>Xác nhận mua hàng</h3>
		<form method="post">
			@csrf
				<div class="form-group">
					<label for="email">Email address:</label>
					<input required type="email" class="form-control" id="email" name="email">
				</div>
				<div class="form-group">
					<label for="name">Họ và tên:</label>
					<input required type="text" class="form-control" id="name" name="name">
				</div>
				<div class="form-group">
					<label for="phone">Số điện thoại:</label>
					<input required type="number" class="form-control" id="phone" name="phone">
				</div>
				<div class="form-group">
					<label for="add">Địa chỉ:</label>
					<input required type="text" class="form-control" id="add" name="add">
				</div>
				<div class="form-group text-right">
					<button type="submit" class="btn btn-default">Thực hiện đơn hàng</button>
				</div>
			</form>
		</div>


	@else
	<h5 class="card-title" style="text-align: center;padding: 2rem;font-size: 1rem;position: absolute;top: 40%;left: 30%;font-size: 3rem;">Chưa có sản phẩm
	<i class="fa fa-cart-arrow-down" style="display: block;font-size: 11rem;color:#FF9600;"></i>
	@endif
</div>
<div class="modal fade" id="modelDel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog " style="top:20%" role="document">
			<div class="modal-content">
				<div class="modal-header">
						<h5 class="modal-title" style="color:red;font-size: 2rem;">Xóa đơn hàng</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						
				</div>
				<div class="modal-body">
				 <h4 id="prodname"> </h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary"  data-dismiss="modal">Hủy</button>
					<button type="button" class="btn btn-primary" id="btn-del" >Xóa</button>
				</div>
			</div>
		</div>
	</div>

<script>
	$('#exampleModal').on('show.bs.modal', event => {
		var button = $(event.relatedTarget);
		var modal = $(this);
		// Use above variables to manipulate the DOM
		
	});
</script>
@endsection
@section('script')
	<script>

	$('tbody').on('click','.del',function() {
		var id_cart=$(this).attr('data-idorder');
		var id_prod=$(this).attr('data-idprod');
		var current=$(this);
		$.ajax( {
		type:'get',
		dataType:'json',
		url:"{{url('cart')}}" +'/'+id_prod +'/edit',
		success: function(data) {
			console.log(data);
			$('#prodname').html(data);
			$('#modelDel').modal('show');
			$('#btn-del').click(function() {
				$.ajax({
						type:'post',	
						dataType:'json',
						data: {
						    '_method':'delete'
						},
						url:"{{url('cart')}}" +'/'+id_cart,
						success: function(data) {
							$('#modelDel').modal('hide');
							current.parent().remove()
							if($('tbody').children().length==1) {
								var no_cart=`<h5 class="card-title" style="text-align: center;padding: 2rem;font-size: 1rem;position: absolute;top: 40%;left: 30%;font-size: 3rem;">Chưa có sản phẩm
										<i class="fa fa-cart-arrow-down" style="display: block;font-size: 11rem;color:#FF9600;"></i>`;
									$('#wrap-inner').find('div').remove();
									$('#wrap-inner').append(no_cart);
							}
						},
					});	
				})//het phan xoa
			}
		})
		})
		
	$('tbody').on('input','.quanity ',function() {
		this.value = this.value.replace(/[^0-9]/g, '');
	})//regex check input
	$('tbody').on('click','.left',function() {
		var quanity = $(this).next().val();
		var id_cart=$(this).next().attr('data-idorder');
		current=$(this).next();
		if(quanity==='1') {
			var id_prod=$(this).parent().parent().next().next().next().attr('data-idprod');
			$.ajax( {
			type:'get',
			dataType:'json',
			url:"{{url('cart')}}" +'/'+id_prod +'/edit',
			success: function(data) {
				console.log(data);
				$('#prodname').html(data);
				$('#modelDel').modal('show');
				$('#btn-del').click(function() {
					$.ajax({
							type:'post',	
							dataType:'json',
							data: {
							    '_method':'delete'
							    },
							url:"{{url('cart')}}" +'/'+id_cart,
							success: function(data) {
								$('#modelDel').modal('hide');
								current.parent().parent().parent().remove()
								if($('tbody').children().length==1) {
									var no_cart=`<h5 class="card-title" style="text-align: center;padding: 2rem;font-size: 1rem;position: absolute;top: 40%;left: 30%;font-size: 3rem;">Chưa có sản phẩm
											<i class="fa fa-cart-arrow-down" style="display: block;font-size: 11rem;color:#FF9600;"></i>`;
										$('#wrap-inner').find('div').remove();
										$('#wrap-inner').append(no_cart);
								}
							},
						});	
					})//het phan xoa
				}
			})
		}
		else {		
			current.val(quanity-1);
			quanity=$(this).next().val();
			update(quanity,id_cart,current);
		}

	})
	$('tbody').on('click','.right',function() {
		var quanity = $(this).prev().val();
		quanity=parseInt(quanity);
		$(this).prev().val(quanity+1);
		quanity=$(this).prev().val();
		id=$(this).prev().attr('data-idorder');
		current=$(this).prev();
		update(quanity,id,current);

	})
	function update(quanity, id, current) {
		$.ajax({
			type:'post',
			dataType:'json',
			data: {
			    quanity:quanity,
			    '_method':'put'
			    },
			url:"{{url('cart')}}" +'/'+id,
			success:function(data) {
				$('.total-price').html(parseInt(data.totalMoney).toLocaleString('vi', {style : 'currency', currency : 'VND'}));
				current.parent().parent().next().next().children().html(data.money.toLocaleString('vi', {style : 'currency', currency : 'VND'}));
				
			}
		})
	}
	$('tbody').on('change','.quanity ',function(e) {
		e.preventDefault();
		var quanity = $(this).val();
		var id =$(this).attr('data-idorder');
		var current=$(this);
		update(quanity,id,current);
	})

	</script>
@endsection


					
			