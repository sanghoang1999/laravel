@extends('backend.master')

@section('main')
 <style>
	 .fade{
		 opacity: 1;
    -webkit-transition: opacity .15s linear;
    -o-transition: opacity .15s linear;
		transition: opacity .15s linear;
		background: #000000b0;
	 }
 </style>
	@php
	@endphp
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Sản phẩm</h1>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				
				<div class="panel panel-primary">
					<div class="panel-heading">Danh sách sản phẩm</div>
					<div class="panel-body">
						<div class="bootstrap-table">
							<div class="table-responsive">
							<a href="{{route('product.create')}}" class="btn btn-primary">Thêm sản phẩm</a>
								<table class="table table-bordered" style="margin-top:20px;">	
											
									<thead>
										<tr class="bg-primary">
											<th>ID</th>
											<th width="30%">Tên Sản phẩm</th>
											<th>Giá sản phẩm</th>
											<th width="20%">Ảnh sản phẩm</th>
											<th>Danh mục</th>
											<th>Tùy chọn</th>
										</tr>
									</thead>
								
									<tbody>
										@php
											$i=1;
										@endphp
										@foreach ($datas as $data)
										<tr>
											<td>{{ $i++ }}</td>
											<td>{{ $data->prod_name }}</td>
											<td>{{ number_format( $data->prod_price ,0,',','.')."₫" }}</td>
											<td>
												<img height="150px" src="{{asset('storage/'.$data->prod_img)}}" class="thumbnail">
											</td>
											<td>{{ $data->cate_name }}</td>
											<td>
												<a href="{{url('admin/product/'.$data->prod_id.'/edit')}}" class="btn btn-warning"><i class="fa fa-pencil" aria-hidden="true"></i> Sửa</a>
											<button class="btn btn-danger" data-id="{{$data->prod_id}}" id="btn-del"><i class="fa fa-trash" aria-hidden="true"></i> Xóa</button>
											</td>
										</tr>
										@endforeach	
									</tbody>
								</table>							
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
		<!-- Button trigger modal -->
		
		<!-- Modal -->
		<div class="modal fade" id="modelDel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" style="top:25%" role="document">
					<div class="modal-content">
						<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<h5 class="modal-title" style="color:red;font-size: 2rem;">Xóa Sản Phẩm</h5>
						</div>
						<div class="modal-body">
							<h5 class="modal-title" style="color:#000000;font-size: 1.8rem;margin-bottom:3rem">Bạn có chắc muốn xóa</h5>
						 	<h4 id="prod_name" style="font-size:1.7rem"> </h4>
						</div>
						<div class="modal-footer " style="padding:1rem">
							<button type="button" class="btn btn-secondary"  data-dismiss="modal">Hủy</button>
							<button type="button" class="btn btn-primary" id="check_id" >Xóa</button>
						</div>
					</div>
				</div>
			</div>
		<!-- Button trigger modal -->
		
		<!-- Modal -->
			<div class="modal fade" id="modelSuccess" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
					<div class="modal-dialog" style="top:30%;left:12.5%;text-align:center;" role="document">
						<div class="modal-content" style="width:50%;padding: 5rem 0;color: red;font-size: 2rem;">
							<div class="modal-body">
								Bạn đã xóa thành công
								<i class="fa fa-check" aria-hidden="true"></i>
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
	</div>	<!--/.main-->
@endsection
@section('script')
	<script>
	$(document).ready(function() {
		var id;
		var current;
		$('tbody').on('click','#btn-del',function() {
		id=$(this).attr('data-id');
		current= $(this);
		$.ajax({
			type:"get",
			dataType:"json",
			url:"{{url('admin/product')}}" +"/" +id,
			success:function(data) {
				$('#prod_name').html(data.prod_name);
				$('#modelDel').modal('show');
			}
		});
		})//het show
		$('#check_id').click(function() {
			console.log("cc");
			$.ajax({
				type:"post",
				dataType:"json",
				data: {
				 "_method":"delete",
				},
				
				url:"{{url('admin/product')}}" +"/" +id,
				success:function(data) {
					console.log("dddd");
					$(`button[data-id=`+id +`]`).parent().parent().remove();
					$('#modelDel').modal('hide');
					$('#modelSuccess').modal('show');
					setTimeout(() => {
						$('#modelSuccess').modal('hide');
					}, 1000);
				}
			});
		});//het delete $('button[data-id="' +id +'"]')
	})
		
	</script>
@endsection
