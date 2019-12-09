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
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Danh mục sản phẩm</h1>
			</div>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-xs-12 col-md-5 col-lg-5">
					<div class="panel panel-primary">
						<div class="panel-heading">
							Thêm danh mục
						</div>
						<div class="panel-body">
							<div class="form-group">
								<div id="message">
								</div>
								<label>Tên danh mục:</label>
									<input type="text" id="name" name="name" class="form-control" placeholder="Tên danh mục...">
									<button type="button" style="margin-top:1rem" id='add' class="btn btn-primary form-control mt-4">Thêm</button>
							</div>
						</div>
					</div>
			</div>
			<div class="col-xs-12 col-md-7 col-lg-7">
				<div class="panel panel-primary">
					<div class="panel-heading">Danh sách danh mục</div>
					<div class="panel-body">
						<div class="bootstrap-table">
							<table class="table table-bordered" id="table">
								<div id="editSuccess"></div>
				              	<thead>
					                <tr class="bg-primary">
					                  <th>Tên danh mục</th>
					                  <th style="width:30%">Tùy chọn</th>
					                </tr>
				              	</thead>
				              	<tbody>
									@foreach ($cates as $cate)	
									<tr>
									<td >{{ $cate->cate_name }}</td>
									<td>
											<button data-cateid="{{$cate->cate_id}}" id='edit' class="btn btn-warning" ><span class="glyphicon glyphicon-edit"></span> Sửa</button>
											<button  data-cateid="{{$cate->cate_id}}" id='del'  class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Xóa</button>
									</td>
									</tr>
									@endforeach
				                </tbody>
				            </table>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
	</div>	<!--/.main-->
	<!-- Button trigger modal -->
	<!-- Button trigger modal -->
	
	<!-- Modal -->
	<!-- Modal delete-->

	<div class="modal fade" id="modelDel" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" style="top:25%" role="document">
			<div class="modal-content">
				<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h5 class="modal-title" style="color:red;font-size: 2rem;">Xóa Danh Mục</h5>
				</div>
				<div class="modal-body">
				 <h4 id="catename"> </h4>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary"  data-dismiss="modal">Hủy</button>
					<button type="button" class="btn btn-primary" id="btn-del" >Xóa</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Button trigger modal -->
	
	<!-- Modal -->
	<div class="modal fade" id="modelEdit" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" style="top:25%" role="document">
			<div class="modal-content">
				<div class="modal-header">
						<h5 class="modal-title" style="color:red;font-size: 2rem;">Sửa danh mục</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
				</div>
				<div class="modal-body">
					<div id="messageEdit">

					</div>
					<div class="form-group">
						<label for="editcate">Tên danh mục</label>
						<input type="text" name="" id="editcate" class="form-control" placeholder="" aria-describedby="helpId">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
					<button type="button" class="btn btn-primary" id="btn-edit">Lưu</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('script')
<script>
		$(document).ready(function () {
			var cate_id;
			var current;
			$('#table').on('click','#del',function() {
				$('#catename').html('');
				cate_id= $(this).attr('data-cateid');
				current=$(this);
				$.ajax({
					type:'get',
					url: "{{ url('admin/category') }}" +"/"+cate_id,
					dataType:'json',
					success: function(data) {
						$('#catename').html(data.cate_name);
						$('#modelDel').modal('show');
					}
				});	
			});//het show
			$('#btn-del').click(function() {
				console.log(current);
				$.ajax({
					type:'post',
					url: "{{ url('admin/category') }}" +"/"+cate_id,
					data: {
					    "_method":"delete",
					    },
					dataType:'json',
					success: function(data) {
						current.parent().parent().remove();
						$('#modelDel').modal('hide');
					}
				});
			})//het delete
			$('#add').click(function() {
				 $cate_name=$('#name').val();
				 $.ajax({
					type:'post',
					dataType:'json',
					url: "{{ url('admin/category') }}",
					data: {
						name:$cate_name
					},
					success: function(data) {
						console.log(data);
						if($.isEmptyObject(data.error)) {
										var result=`
											<tr>
												<td >` + data.cate_name +`</td>
														<td>
														<button data-cateid="`+ data.cate_id +`" id='edit' class="btn btn-warning" ><span class="glyphicon glyphicon-edit"></span> Sửa</button>
														<button data-cateid="`+ data.cate_id +`" id='del'   class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> Xóa</button>
												</td>
											</tr>`;
										var cc=`
												<div class="alert alert-primary" style="background-color: #30a5ff;color:white " role="alert">
														<strong> Bạn đã thêm thành công </strong>
											</div>`;
										
										setTimeout(function(){
											$('#message').find('div').remove();

										},100);
										setTimeout(function(){;
												$('#message').append(cc);
										},200);
										setTimeout(function(){
											$('#message').find('div').remove();

										},4000);
									$('tbody').append(result);
							}
						else {
						console.log(data);
								var msg=`
									<div class="alert alert-primary " style="background-color: #c9302c;color:white" role="alert">
										<strong>` + data.error + `</strong>
									</div>
								`;
								setTimeout(function(){
									$('#message').find('div').remove();
								},100);
								setTimeout(function(){;
										$('#message').append(msg);
								},200);
								setTimeout(function(){
									$('#message').find('div').remove();
								},4000);
								$('#name').focus();
							}
						
					}
				 }) 
			})//het add
			var id_edit;
			var current_edit;
			$('#table').on('click','#edit',function() {
				 current_edit=$(this);
				 id_edit=$(this).attr('data-cateid');
				$('#messageEdit').find('div').remove();
				$.ajax({
					type:"get",
					url:"{{ url('admin/category') }}" +"/"+ id_edit +"/edit",
					dataType:"json",
					success: function(data) {
						console.log("cccc");
						$('#editcate').val(data.cate_name);
						$('#modelEdit').modal('show');
					}
				})
			});//het show edit
			
			$('#btn-edit').click(function() {
					var cate_name =$('#editcate').val();
					$.ajax({
						type:'post',
						dataType:'json',
						url:"{{ url('admin/category') }}" +"/"+ id_edit,
						data: {
							name:cate_name,
							"_method":"put",
						},
						success: function(data) {
							console.log('success');
							if($.isEmptyObject(data.error)) {
								var cc=`
												<div class="alert alert-primary" style="background-color: #30a5ff;color:white " role="alert">
														<strong> Bạn đã thay đổi thành công </strong>
											</div>`;
									$('#editSuccess').append(cc);
									setTimeout(function() {
										$('#editSuccess').find('div').remove();
									},2000)
									$(this).html('sending.....');
									current_edit.parent().prev().html(data.cate_name);
									$('#modelEdit').modal('hide');
							}
							else {
									var msg=`
										<div class="alert alert-primary " style="background-color: #c9302c;color:white" role="alert">
											<strong>` + data.error + `</strong>
										</div>
									`;
									setTimeout(function(){
										$('#messageEdit').find('div').remove();
									},100);
									setTimeout(function(){;
											$('#messageEdit').append(msg);
									},200);
									$('#editcate').focus();
							}
						}
					})	
			})//het edit
			});//het document

		
</script>
@endsection