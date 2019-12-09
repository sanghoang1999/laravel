@extends('frontend.master')
@section('main')
<div id="wrap-inner">
		<div class="products">
			<h3>SamSung</h3>
			<div class="product-list row">
				@foreach ($prods as $prod)
					<div class="product-item col-md-3 col-sm-6 col-xs-12" >
						<img src="{{asset('storage/'.$prod->prod_img)}}" style="" class="img-thumbnail">
						<p><a href="#">{{ $prod->prod_name }}</a></p>
						<p class="price">{{ number_format( $prod->prod_price ,0,',','.')."₫"}}</p>	  
						<div class="marsk">
						<a href="{{url('detail/'.$prod->prod_id.'/'.$prod->prod_slug.'.html')}}">Xem chi tiết</a>
						</div>                                    
					</div>    
				@endforeach	                	
			</div>
		</div>
		<div id="pagination">
			<ul class="pagination pagination-lg justify-content-center">
				<li class="page-item">
					<a class="page-link" href="#" aria-label="Previous">
						<span aria-hidden="true">&laquo;</span>
						<span class="sr-only">Previous</span>
					</a>
				</li>
				<li class="page-item disabled"><a class="page-link" href="#">1</a></li>
				<li class="page-item"><a class="page-link" href="#">2</a></li>
				<li class="page-item"><a class="page-link" href="#">3</a></li>
				<li class="page-item">
					<a class="page-link" href="#" aria-label="Next">
						<span aria-hidden="true">&raquo;</span>
						<span class="sr-only">Next</span>
					</a>
				</li>
			</ul>
		</div>
	</div>
@endsection
					

					
			