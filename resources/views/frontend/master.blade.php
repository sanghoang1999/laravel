<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">	
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>Vietpro Shop - Home</title>
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<base href="{{asset('layout/frontend')}}/">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/home.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<style> 
		.user {
			position: absolute;
			top:4px;
			right: 0;
			z-index:1000;
		}
				@media screen and  (max-width: 480px) {
			.user {
				position: absolute;
				top:6px;
					right:15px;
					z-index:1000;
				}
		}
		.user li {
			float:left;
			list-style: none;
			color:white;
			margin-left:20px;
		}
		.user li a {
			color:white;
		}

		.header {
			padding-top:0;
			margin-top: 17px;
		}
		.card_del:hover {
			color:red;
		}
		.product-detail img {
            max-width: 100%;
            height: auto !important;
        }
        .user_auth {
        	position: absolute;
			top: -5px;
			right: -30px;
			}
	</style>
</head>
<body>    
	<!-- header -->
	<header id="header">
		<div class="container">
			<div class="row" class="header">
				<div class="col-sm-12">
					<ul class="user">
						@guest('customer')
						<li id='register' style="cursor:pointer">Đăng ký</li>
						<li id='lg' style="cursor:pointer">Đăng nhập</li>
						<style>
						.user li:first-child {
						border-right: 1px solid white;
						padding-right: 20px;
						height: 17px;
					}
						</style>
						@else 
						<ul class="user-menu">
                                <li class="dropdown pull-right">
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle user_auth" href="{{url('/')}}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::guard('customer')->user()->name }} <span class="caret"></span>
                                    </a>
    
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item hover" style="color:black;display:block;text-align:center"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
    
                                        <form id="logout-form" action="{{ url('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
							</ul>
						@endguest
					</ul>
				</div>
			</div>
			<div class="row header">
				<div id="logo" class="col-md-3 col-sm-12 col-xs-12">
					<h1>
					<a href="{{url('/')}}"><img src="img/home/logo.png"></a>						
						<nav><a id="pull" class="btn btn-danger" href="#">
							<i class="fa fa-bars"></i>
						</a></nav>			
					</h1>
				</div>
				<div id="search" class="col-md-7 col-sm-12 col-xs-12">
					<form action="{{route('tiem-kiem')}}" method="get">
						<input type="text" name="text" >
						<input type="submit" value="Tìm Kiếm">
					</form>
				</div>
			
				<div id="cart" style="padding:0"  class="col-md-2 col-sm-12 col-xs-12">
					<a href="{{url('cart/detail')}}">Giỏ hàng</a>
					@auth('customer')
						@if ($count==0) 
						<a href="#" id="down" style="margin-left: 40px;color: #FF9600;padding: 29px;padding-top: 8px;" data-toggle="dropdown"></a>
						@else
						<a href="{{url('/')}}" id="down" style="margin-left: 40px;color: #FF9600;padding: 29px;padding-top: 8px;" data-toggle="dropdown">{{ $count }}</a>
						@endif
					@else 
					<a href="{{url('/')}}" id="down" style="margin-left: 40px;color: #FF9600;padding: 29px;padding-top: 8px;" data-toggle="dropdown"></a>
					@endauth
					<div class="triangle" ></div>			    
				</div>
				
				<style>
					.cc {
						position: absolute;
					}
				.triangle {
					border: .625rem solid transparent;
					border-bottom-color: #fff;
					content: "";
					display: inline-block;
					position: absolute;
					bottom: 17%;
					left: 74%;
					-webkit-transform: translateX(-50%);
					transform: translateX(-50%);
					border-left-width: .875rem;
					border-right-width: .875rem;
					display: none;
					z-index: 400;
				}
				
				
				</style>		
				@auth('customer')
				<div class="col-sm-4 show_cart"  style="position: absolute;z-index: 100000;top: 35%;right: 8%;display:none">
						<div class="card">
							<div class="card-header" style="padding:0.5rem;border:none">
							  Sảm phẩm mới thêm
							</div>
							<div class="card-body" id="card_body">
									@if ($count>0) 
										@foreach ($carts as $cart)
											<div class="row pb-3">
													<div class="col-sm-2 p-0">
														<img style="height:50px;with:100%" src="{{asset('storage/'.$cart->prod_img)}}">
													</div>
													<div class="col-sm-10 p-0 ">
														<div class="row" style="height: 22px;">
															<div class="col-sm-8 p-0" style="padding: 0;font-size:16px">
																	<p>{{ $cart->prod_name }}</p>
																</div>
																<div class="col-sm-4 p-0">
																
																	<div class="cart_price float-left mr-1" style="color: red;">{{ number_format( $cart->prod_price ,0,',','.')."₫"}}</div>
																	<div class="x float-left mr-1" style="font-size: 10px;line-height: 2.3;">x</div>
																	<div class="cart_qt float-left mr-1" style="font-size: 11px;line-height: 2.1;">{{$cart->quanity }}</div>
																</div>
														</div>
														<div class="row">
															<div class="col-sm-12">
																<div class="card_del float-right" data-cart='{{$cart->id}}' style="font-size: 16px;margin-right: 10px;cursor: pointer;">xóa</div>
															</div>
														</div>
													</div>
												</div>
										@endforeach
										<div class="row pb" id='see'>
											<div class="col-sm-12">
											<button type="button" class="btn  float-right" style="border-radius: 5px;"><a href="{{url('cart/detail')}}">Xem giỏ hàng</a></button>
											</div>
										</div>		
									@else 
										<h5 class="card-title" style="    text-align: center; padding: 2rem;font-size: 1rem;">Chưa có sản phẩm
										<i class="fa fa-cart-arrow-down" style="display: block;font-size: 5rem;color:#FF9600"></i>
									@endif
												
							</div>
						</div>
				</div>
				@else
				<div class="col-sm-4 show_cart"  style="position: absolute;z-index: 100000;top: 35%;right: 8%;display:none">
						<div class="card">
							<div class="card-body">
							  <h5 class="card-title" style="    text-align: center; padding: 2rem;font-size: 1rem;">Chưa có sản phẩm
							  <i class="fa fa-cart-arrow-down" style="display: block;font-size: 5rem;color:#FF9600"></i>
							  </h5>
							</div>
							
						</div>
					</div>
				@endguest
	</header><!-- /header -->
	<!-- endheader -->

	<!-- main -->
	<section id="body">
		<div class="container">
			<div class="row">
				<div id="sidebar" class="col-md-3">
					<nav id="menu">
						<ul>
						<li class="menu-item">danh mục sản phẩm</li>
						@foreach ($cates as $cate)
						<li class="menu-item"><a href="{{url('category/'.$cate->cate_id.'/'.$cate->cate_slug.'.html')}}" title="">{{ $cate->cate_name }}</a></li>
						@endforeach				
						</ul>
						<!-- <a href="{{url('/')}}" id="pull">Danh mục</a> -->
					</nav>

					<div id="banner-l" class="text-center">
						<div class="banner-l-item">
							<a href="{{url('/')}}"><img src="img/home/banner-l-1.png" alt="" class="img-thumbnail"></a>
						</div>
						<div class="banner-l-item">
							<a href="{{url('/')}}"><img src="img/home/banner-l-2.png" alt="" class="img-thumbnail"></a>
						</div>
						<div class="banner-l-item">
							<a href="{{url('/')}}"><img src="img/home/banner-l-3.png" alt="" class="img-thumbnail"></a>
						</div>
						<div class="banner-l-item">
							<a href="{{url('/')}}"><img src="img/home/banner-l-4.png" alt="" class="img-thumbnail"></a>
						</div>
						<div class="banner-l-item">
							<a href="{{url('/')}}"><img src="img/home/banner-l-5.png" alt="" class="img-thumbnail"></a>
						</div>
						<div class="banner-l-item">
							<a href="{{url('/')}}"><img src="img/home/banner-l-6.png" alt="" class="img-thumbnail"></a>
						</div>
						<div class="banner-l-item">
							<a href="{{url('/')}}"><img src="img/home/banner-l-7.png" alt="" class="img-thumbnail"></a>
						</div>
					</div>
				</div>

				<div id="main" class="col-md-9">
					<!-- main -->
					<!-- phan slide la cac hieu ung chuyen dong su dung jquey -->
					<div id="slider">
						<div id="demo" class="carousel slide" data-ride="carousel">

							<!-- Indicators -->
							<ul class="carousel-indicators">
								<li data-target="#demo" data-slide-to="0" class="active"></li>
								<li data-target="#demo" data-slide-to="1"></li>
								<li data-target="#demo" data-slide-to="2"></li>
							</ul>

							<!-- The slideshow -->
							<div class="carousel-inner">
								<div class="carousel-item active">
									<img src="img/home/slide-1.png" alt="Los Angeles" >
								</div>
								<div class="carousel-item">
									<img src="img/home/slide-2.png" alt="Chicago">
								</div>
								<div class="carousel-item">
									<img src="img/home/slide-3.png" alt="New York" >
								</div>
							</div>

							<!-- Left and right controls -->
							<a class="carousel-control-prev" href="#demo" data-slide="prev">
								<span class="carousel-control-prev-icon"></span>
							</a>
							<a class="carousel-control-next" href="#demo" data-slide="next">
								<span class="carousel-control-next-icon"></span>
							</a>
						</div>
					</div>

					<div id="banner-t" class="text-center">
						<div class="row">
							<div class="banner-t-item col-md-6 col-sm-12 col-xs-12">
								<a href="{{url('/')}}"><img src="img/home/banner-t-1.png" alt="" class="img-thumbnail"></a>
							</div>
							<div class="banner-t-item col-md-6 col-sm-12 col-xs-12">
								<a href="{{url('/')}}"><img src="img/home/banner-t-1.png" alt="" class="img-thumbnail"></a>
							</div>
						</div>					
					</div>

                    @yield('main')
					
					<!-- end main -->
				</div>
			</div>
		</div>
	</section>
	<!-- endmain -->
	<div class="modal" id="modelCm" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog " style="top:12.5%" role="document">
			<div class="modal-content" style="    padding: 1rem;">
					<h3 class="modal-title" style="color:#000000b0;font-size: 1rem;">Đăng nhập</h5>
				<div class="row">
					<div class="col-sm-9" style="margin:10px auto">
					<div class="error">
						
					</div>
					<form role="form" id='form' >
						@csrf
							<fieldset>
								<div class="form-group">
								<input class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}" placeholder="E-mail" name="email" type="email">
									@if($errors->has('email')) 
									<span class="invalid-feedback">{{ $errors->first("email") }}</span>
									@endif
								</div>
								
								<div class="form-group">
								<input class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}" placeholder="Password" id='password' name="password"  autofocus type="password" value="{{old('password')}}">
									@if(!$errors->has('email') && $errors->has('password')) 
									<span class="invalid-feedback">{{ $errors->first("password") }}</span>
								@endif
								</div>
								
								<div class="checkbox">
									<label>
										<input name="remember" type="checkbox" value="Remember Me">Remember Me
									</label>
								</div>
								<div style="float:right;">
										<input type="button" id='btn_submit' class="btn btn-primary" style="padding: 0.3rem 1rem;
										border-radius: 4px;" value="Đăng nhập">
								</div>
							</fieldset>
						</form>
					</div>
				</div>
				<div class="modal-footer">
				<a href="{{url('facebook/redirect')}}" style="padding: 5px 10px;border-radius: 5px;background: rgb(58, 89, 152);color:white;text-decoration: none">
						<i class="fa fa-facebook" aria-hidden="true" style="1 margin-right: 13px;color: rgb(58, 89, 152);background: white;padding: 2px 5px;margin-right:10px"></i>
						<span> Tiếp tục với Facebook</span>
					</a>
				</div>

			</div>
		</div>
	</div>
	
	<div class="modal" id="modelReg" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog " style="top:12.5%" role="document">
			<div class="modal-content" style="    padding: 1rem;">
					<h3 class="modal-title" style="color:#000000b0;font-size: 1rem;">Đăng ký</h5>
				<div class="row">
					<div class="col-sm-9" style="margin:10px auto">
					<div class="error">
						
					</div>
							<fieldset>
								<div class="form-group">
										<input class="form-control" placeholder="Tên"  type="text">	
								</div>
								<div class="form-group">
								<input class="form-control" placeholder="E-mail"   type="email">	
								</div>
								
								<div class="form-group">
								<input class="form-control" placeholder="Password"   autofocus type="password">
								</div>
								<div class="form-group">
								<input class="form-control" placeholder="Nhập lại mật khẩu"   autofocus type="password">
								</div>
								<div style="float:right;">
										<input type="button" id='btn_submit' class="btn btn-primary" style="padding: 0.3rem 1rem;
										border-radius: 4px;" value="Đăng Ký">
								</div>
							</fieldset>
					</div>
				</div>
				<div class="modal-footer">
				<a href="{{url('facebook/redirect')}}" style="padding: 5px 10px;border-radius: 5px;background: rgb(58, 89, 152);color:white;text-decoration: none">
						<i class="fa fa-facebook" aria-hidden="true" style="1 margin-right: 13px;color: rgb(58, 89, 152);background: white;padding: 2px 5px;margin-right:10px"></i>
						<span> Tiếp tục với Facebook</span>
					</a>
				</div>

			</div>
		</div>
	</div>
	
	<!-- footer -->
	<footer id="footer">			
		<div id="footer-t">
			<div class="container">
				<div class="row">				
					<div id="logo-f" class="col-md-3 col-sm-12 col-xs-12 text-center">						
						<a href="{{url('/')}}"><img src="img/home/logo.png"></a>		
					</div>
					<div id="about" class="col-md-3 col-sm-12 col-xs-12">
						<h3>About us</h3>
						<p class="text-justify">Vietpro Academy thành lập năm 2009. Chúng tôi đào tạo chuyên sâu trong 2 lĩnh vực là Lập trình Website & Mobile nhằm cung cấp cho thị trường CNTT Việt Nam những lập trình viên thực sự chất lượng, có khả năng làm việc độc lập, cũng như Team Work ở mọi môi trường đòi hỏi sự chuyên nghiệp cao.</p>
					</div>
					<div id="hotline" class="col-md-3 col-sm-12 col-xs-12">
						<h3>Hotline</h3>
						<p>Phone Sale: (+84) 0988 550 553</p>
						<p>Email: sirtuanhoang@gmail.com</p>
					</div>
					<div id="contact" class="col-md-3 col-sm-12 col-xs-12">
						<h3>Contact Us</h3>
						<p>Address 1: B8A Võ Văn Dũng - Hoàng Cầu Đống Đa - Hà Nội</p>
						<p>Address 2: Số 25 Ngõ 178/71 - Tây Sơn Đống Đa - Hà Nội</p>
					</div>
				</div>				
			</div>
			<div id="footer-b">				
				<div class="container">
					<div class="row">
						<div id="footer-b-l" class="col-md-6 col-sm-12 col-xs-12 text-center">
							<p>Học viện Công nghệ Vietpro - www.vietpro.edu.vn</p>
						</div>
						<div id="footer-b-r" class="col-md-6 col-sm-12 col-xs-12 text-center">
							<p>© 2017 Vietpro Academy. All Rights Reserved</p>
						</div>
					</div>
				</div>
				<div id="scroll">
					<a href="{{url('/')}}"><img src="img/home/scroll.png"></a>
				</div>	
			</div>
		</div>
	</footer>

	<!-- endfooter -->
	<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
	<script type="text/javascript">
		$(function() {
			var pull        = $('#pull');
			menu        = $('nav ul');
			menuHeight  = menu.height();

			$(pull).on('click', function(e) {
				e.preventDefault();
				menu.slideToggle();
			});
		});

		$(window).resize(function(){
			var w = $(window).width();
			if(w > 320 && menu.is(':hidden')) {
				menu.removeAttr('style');
			}
		});
	</script>	
	<script>
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			}
		});
	</script>
	<script>
	$('#down').mouseenter(function(){
		$('.triangle').css('display','block');
		var posTop=$('.triangle').offset().top +$('.triangle').height() +20 ;
		var posLeft=$('.triangle').offset().left-$('.show_cart').width()+30;
		$('.show_cart').css({'top': posTop,'left': posLeft,'display':'block'});
	})
		$('#down').mouseleave(function(){
			$('.triangle').css('display','none');
			$('.show_cart').css('display','none');
		})
		$('.triangle').mouseenter(function(){
			$('.triangle').css('display','block');
			$('.show_cart').css('display','block');
		})
		$('.triangle').mouseleave(function(){
			$('.triangle').css('display','none');
			$('.show_cart').css('display','none');
		})
		$('.show_cart').mouseenter(function(){
			$('.triangle').css('display','block');
			$('.show_cart').css('display','block');
		})
		$('.show_cart').mouseleave(function(){
			$('.triangle').css('display','none');
			$('.show_cart').css('display','none');
		})
	</script>
	<script>
	$('.show_cart').on('click','.card_del',function() {
			var id_cart=$(this).attr('data-cart');
			var current=$(this);
			$.ajax({
				type:'post',	
				dataType:'json',
				data: {
				'_method':'delete'
				},
				url:"{{url('cart')}}" +'/'+id_cart,
				success: function(data) {
	
					current.parent().parent().parent().parent().remove()
					$('#down').html(data['count']);
					if($('#card_body').children().length==1) {
						var no_cart=`<h5 class="card-title" style="    text-align: center; padding: 2rem;font-size: 1rem;">Chưa có sản phẩm
							  <i class="fa fa-cart-arrow-down" style="display: block;font-size: 5rem;color:#FF9600"></i>`;
						 $('#card_body').children()[0].remove();
						 $('#card_body').append(no_cart);
						 $('#down').html('');
					}
				},
			});	
		})
	</script>
		<script>
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
	</script>
	<script>
	function number_format(number, decimals, decPoint, thousandsSep){
    decimals = decimals || 0;
    number = parseFloat(number);

    if(!decPoint || !thousandsSep){
        decPoint = '.';
        thousandsSep = ',';
    }

    var roundedNumber = Math.round( Math.abs( number ) * ('1e' + decimals) ) + '';
    var numbersString = decimals ? roundedNumber.slice(0, decimals * -1) : roundedNumber;
    var decimalsString = decimals ? roundedNumber.slice(decimals * -1) : '';
    var formattedNumber = "";

    while(numbersString.length > 3){
        formattedNumber += thousandsSep + numbersString.slice(-3)
        numbersString = numbersString.slice(0,-3);
    }

    return (number < 0 ? '-' : '') + numbersString + formattedNumber + (decimalsString ? (decPoint + decimalsString) : '');
}
	
	</script>
	<script>
	$('#lg').click(function(){
		
		$('#modelCm').modal('show');
	})
	$('#register').click(function(){
		$('#modelReg').modal('show');
	})
	
	
	
	</script>
	@yield('script')
</body>
</html>