
@extends('frontend.master')
@section('main')
<link rel="stylesheet" href="css/details.css">		
<div id="wrap-inner">
		<div id="product-info">
			<div class="clearfix"></div>
			<h3>{{ $prod->prod_name }}</h3>
			<div class="row">
				<div id="product-img" class="col-xs-12 col-sm-12 col-md-6 text-center">
					<img src="{{asset('storage/'.$prod->prod_img)}}">
				</div>
				<div id="product-details" class="col-xs-12 col-sm-12 col-md-6">
					<p>Giá: <span class="price">{{ number_format( $prod->prod_price ,0,',','.')."₫"}}</span></p>
					<p>Bảo hành: {{ $prod->prod_warranty }}</p> 
					<p>Phụ kiện: {{ $prod->prod_accessories }}</p>
					<p>Tình trạng: {{ $prod->prod_condition }}</p>
					<p>Khuyến mại: {{ $prod->prod_promotion }}</p>
					<p>Còn hàng: {{ $prod->prod_status==1 ? 'Còn hàng' :'Hết hàng' }}</p>
				{{-- <form action="{{url('cart')}}" method="post">
					@csrf
					<input type="text" name='id'> --}}
					{{-- <button type="submit" >submit</button> --}}
					<div class="row">
						<div class="col-sm-6 p-0">
							<p  class="add-cart text-center" style="cursor:pointer"><button id="add_cart" data-idprod="{{ $prod->prod_id }}  " data-sending=false  style="    background: #f1c471;border: 1px solid #e04e4e;font-size: 19px;width: 100%;color: white;font-weight: bolder;" >Thêm vào giỏ hàng</button></p>
						</div>
						<div class="col-sm-6">
						<p  class=" text-center" id="online"  data-idprod="{{ $prod->prod_id }}"   style="cursor:pointer;color:white">Đặt hàng online</p>
						</div>
					</div>
				</form>
				</div>
			</div>							
		</div>
		<div id="product-detail" style="height:800px;overflow:hidden">
			<h3>Chi tiết sản phẩm</h3>
			<p class="text-justify">{!! $prod->prod_description !!}</p>
		</div>
		<div class="showmore text-center" style="  color: blue;padding: 10px;cursor: pointer">Đọc thêm
				<i class="fa fa-caret-down" aria-hidden="true"></i></div>

		<div id="comment" style="    border-top: 1px solid #00000033;">
			<h3>Bình luận</h3>
			<div class="col-md-9 comment">
				
					</div>
					<form>
					<div class="form-group">
						
						<label for="cm">Bình luận:</label>
						<textarea  rows="4" id="cm" class="form-control"  style="border-radius: 5px;" name="content" required></textarea>
					
					</div>
					<div class="form-group text-right" style="border-bottom: 1px solid #00000021;
					padding-bottom: 0.6rem;">
						<button type="button" class="btn btn-default" data-idpord="{{$prod->prod_id}}" id="submitCm" style="border-radius: 5px;padding:0.3rem 1.2rem;display:none">Gửi</button>
					</div>
				</form>
				
			</div>
		</div>
		<div id="comment-list">
			@foreach ($comments as $comment)
			<ul>
				<li class="com-title">
					{{ $comment->name }}
					<br>
					<span>{{ $comment->created_at }}</span>	
				</li>
				<li class="com-details">
						{{ $comment->content }}
				</li>
			</ul>
			@endforeach
		
		</div>
	</div>

	<!-- Modal -->
	

	

	
	<script>
		$('#exampleModal').on('show.bs.modal', event => {
			var button = $(event.relatedTarget);
			var modal = $(this);
			// Use above variables to manipulate the DOM
			
		});
	</script>


	<div class="modal fade" id="modelSuccess" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
			<div class="modal-dialog" style="left:10%;top:25%" role="document">
				<div class="modal-content" style="width:50%">
					<div class="modal-body text-center">
						Bạn đã gữi bình luận thành công
						<div class="text-center">
								<i class="fa fa-check " style="font-size:5rem" aria-hidden="true"></i>
						</div>
					</div>
				</div>
			</div>
	</div>


	
	<!-- Modal -->
	<div class="modal fade" id="running" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog" style="top: 25%;" role="document">
			<div class="modal-content" style="    width: 50%;left: 25%;padding: 30px;color: #ff0000c4;">

				<div class="modal-body">
					<div class="text-center">
						<div class="spinner-border" role="status">
						  <span class="sr-only">Loading...</span>
						</div>
					  </div>
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
		var cc;
		$('.showmore').click(function() {
			$('#product-detail').css({'overflow':'initial','height':'auto'})
			$(this).remove();
		})
		$('#cm').one('input',function(){
			$('#submitCm').css("display","initial");
		})
		$('#submitCm').click(function() {
			if($('#cm').val()!='') {
				var id_prod=$(this).attr('data-idpord');
			var cm=$('#cm').val();
			$.ajax({
				type:'post',
				dataType:'json',
				url:'{{url('comment')}}'+'/' +id_prod,
				data: {
					cm:cm
				},
				success:function(data) {
					if($.isEmptyObject(data.error)) {
					
						$('#submitCm').html('Đang xử lý....');	
						
						var cm=`
								<ul>
									<li class="com-title">
										 ` + data[0].name +`
										<br>
										<span> `+ data[0].created_at +`</span>	
									</li>
									<li class="com-details">
											`+ data[0].content +`
									</li>
								</ul>
						`;
						
						$('#submitCm').html('Gữi');	
						$('#modelSuccess').modal('show');
						setTimeout(function() {
							$('#modelSuccess').modal('hide');
						},1000)
						$('#comment-list').prepend(cm);
					}
					else {
						$('#modelCm').modal('show')
					}
				}
			})
			}
		})
		$('#btn_submit').click(function() {
			$.ajax({
				type:'post',
				dataType:'json',
				url:'{{url('loginToComment')}}',
				data: $('#form').serialize(),
				
				success:function(data) {
					if($.isEmptyObject(data.error)) {
						
						 location.href='{{url()->current()}}';
					}
					else {
						
						var msg=`<div class="alert alert-danger" role="alert">
							`+ data.error +`
						</div>`;
						$('.error').find('div').remove();
						setTimeout(() => {
							$('.error').append(msg);
						}, 50);
					}	
				}
			}) 
		})
		$('#add_cart').click(function() {
			
			var idprod=$(this).attr('data-idprod');
			var me=$(this);
			me.prop('disabled',true);
			me.off('dbclick');
			$.ajax({
				type:'get',	
				dataType:'json',
				url:'{{url('cart')}}',
				success: function(data=null) {
					if(!$.isEmptyObject(data.error)) {
						
						$('#modelCm').modal('show')
					}
					else {
						orderProduct(idprod);
					}	
				},
				complete: function() {
					me.prop('disabled',false);
					$('#modelSuccess').modal('show');
					setTimeout(function() {
						$('#modelSuccess').modal('hide');
					},1000)	
				}
				
			})
		})
		var cc;
		function orderProduct(id) {
			$.ajax({
				type:'post',	
				dataType:'json',
				url:'{{url('cart')}}',
				data: {
					id:id
				},
				success: function(data) {
				$('#down').html(data['count']);

					var check=false;
					var list=$('.show_cart').find('p');
					var check=false;
					var no_cart=$('.card-title');
					if(no_cart.length!=0) {
						var see=`<div class="row pb" id='see'>
								<div class="col-sm-12">
									<a type="button" class="btn" href="{{url('cart/detail')}}"  style=" border-radius: 5px; float: right;color: white;">Xem Giỏ Hàng</a>
								</div>
							</div>`
						$('#card_body').find('h5').remove();
						$('#card_body').append(see);
					}
					Object.keys(list).forEach(function(value) {
							
							if(list[value].innerHTML==data['cart'][0].prod_name) {
							list[value].parentElement.parentElement.querySelector('.cart_qt').innerHTML=data['cart'][0].quanity ;
							check=true;
						}
					})
					if(!check) {
						var show_cart=
							`<div class="row pb-3">
								<div class="col-sm-2 p-0">
									<img style="height:50px;with:100%" src="https://sanghoangweb.000webhostapp.com/storage/`+ data['cart'][0].prod_img+`">
								</div>
								<div class="col-sm-10 p-0 ">
									<div class="row" style="height: 22px;">
										<div class="col-sm-8 p-0" style="padding: 0;font-size:16px">
												<p>`+ data['cart'][0].prod_name   +`</p>
											</div>
											<div class="col-sm-4 p-0">
												<div class="cart_price float-left mr-1" style="color: red;">`+ parseInt(data['cart'][0].prod_price).toLocaleString('vi', {style : 'currency', currency : 'VND'}) +`</div>
												<div class="x float-left mr-1" style="font-size: 10px;line-height: 2.3;">x</div>
												<div class="cart_qt float-left mr-1" style="font-size: 11px;line-height: 2.1;">`+ data['cart'][0].quanity    +`</div>
											</div>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="card_del float-right" data-cart="`+ data['cart'][0].id +`" style="font-size: 16px;margin-right: 10px;cursor: pointer;">xóa</div>
										</div>
									</div>
								</div>
						</div>`;
						
						$('#card_body').prepend(show_cart);
						
					}
					
				}
			})
		};

		
		$('#online').click(function() {
			var idprod=$(this).attr('data-idprod');
			$.ajax({
				type:'get',	
				dataType:'json',
				url:'{{url('cart')}}',
				beforeSend: function() {
					
				},
				success: function(data) {
					if(!$.isEmptyObject(data.error)) {
						
						$('#modelCm').modal('show')
					}
					else {
						$('#running').modal('show');
						$.ajax({
							type:'post',	
							dataType:'json',
							url:'{{url('cart')}}',
							data: {
								id:idprod
							},
							success: function(data) {
								location.href='{{url('cart/detail')}}';
							}
						})
					}	
				},
				
			})
		})
	</script>
@endsection