@extends('frontend.master')
@section('main')
@php
	
@endphp
<div id="wrap-inner">
		<div class="products">
			<h3>sản phẩm nổi bật</h3>
			<div class="product-list row">
				@foreach ($featured as $ft)
					<div class="product-item col-md-3 col-sm-6 col-xs-12" style="margin-bottom:1rem" >
						<img src="{{asset('storage/'.$ft->prod_img)}}" style="width:170px;height:170px" class="img-thumbnail">
						<p><a href="{{url('detail/'.$ft->prod_id.'/'.$ft->prod_slug.'.html')}}">{{ $ft->prod_name }}</a></p>
						<p class="price">{{ number_format( $ft->prod_price ,0,',','.')."₫"}}</p>	  
						<div class="marsk">
						<a href="{{url('detail/'.$ft->prod_id.'/'.$ft->prod_slug.'.html')}}">Xem chi tiết</a>
						</div>                                    
					</div>
				@endforeach
				
			</div>                	                	
		</div>

		<div class="products">
			<h3>sản phẩm mới</h3>
			<div class="product-list row">
				@foreach ($news as $new)
					<div class="product-item col-md-3 col-sm-6 col-xs-12" style="margin-bottom:1rem	" >
						<img src="{{asset('storage/'.$new->prod_img)}}"  class="img-thumbnail">
						<p><a href="{{url('detail/'.$new->prod_id.'/'.$new->prod_slug.'.html')}}">{{ $new->prod_name }}</a></p>
						<p class="price">{{ number_format( $new->prod_price ,0,',','.')."₫"}}</p>	  
						<div class="marsk">
							<a href="{{url('detail/'.$new->prod_id.'/'.$new->prod_slug.'.html')}}">Xem chi tiết</a>
						</div>                                    
					</div>
				@endforeach
				
			</div>    
		</div>
	</div>	
@endsection
					
