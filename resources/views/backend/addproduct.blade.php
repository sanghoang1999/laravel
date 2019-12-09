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
				<h1 class="page-header">Sản phẩm</h1>
			</div>
		</div><!--/.row-->
		<div class="row">
			<div class="col-sm-5">
				<div class="msgSuccess">
					@if(Session::has('success'))
							<div class="alert alert-primary"  style="background:#30a5ff;color:white;" role="alert">
								<strong>Bạn đã thêm sản phẩm thành công</strong>
							</div>
					@endif
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function() {
				setTimeout(function() {
					$('.msgSuccess').find('div').remove();
				},2000)
			})
		
		</script>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12">
				
				<div class="panel panel-primary">
					<div class="panel-heading">Thêm sản phẩm</div>
					<div class="panel-body">
					<form method="post" enctype="multipart/form-data" action="{{route('product.store')}}" >
							@csrf
							<div class="row" style="margin-bottom:40px">
								<div class="col-xs-8">
									<div class="form-group" >
										<label>Tên sản phẩm</label>
									<input  type="text" name="name" class="form-control" required " >
										@if($errors->has('name'))
											<div class="alert alert-danger" style="margin-top:1rem">
													<h5 class="color:red">{{ $errors->first('name') }}</h5>
											</div>
										@endif
									</div>
									<div class="form-group" >
										<label>Giá sản phẩm</label>
										<input  type="number" name="price" class="form-control" required>
									</div>
									<div class="form-group" >
										<label>Ảnh sản phẩm</label>
										<input required id="img" type="file" name="img" class="form-control hidden" onchange="changeImg(this)">
									<img id="avatar" class="thumbnail" width="300px" src="img/new_seo-10-512.png">
										 @if($errors->has('img'))
										 <div class="alert alert-danger style="margin-top:1rem>
												 <h5 class="color:red">{{ $errors->first('img') }}</h5>
										 </div>
									 	@endif
									</div>
									<div class="form-group" >
										<label>Phụ kiện</label>
										<input  type="text" name="accessories" class="form-control" required>
									</div>
									<div class="form-group" >
										<label>Bảo hành</label>
										<input  type="text" name="warranty" class="form-control"   required>
									</div>
									<div class="form-group" >
										<label>Khuyến mãi</label>
										<input  type="text" name="promotion" class="form-control"  required>
									</div>
									<div class="form-group" >
										<label class="">Tình trạng</label>
										<input  type="text" name="condition"  class="form-control is-invalid">
									</div>
									<div class="form-group" >
										<label>Trạng thái</label>
										<select  name="status" class="form-control" required>
											<option   value="1" >Còn hàng</option>
											<option    value="0">Hết hàng</option>
					                    </select>
									</div>
									<div class="form-group" >
										<label>Miêu tả</label>
										<textarea class="ckeditor"  name="description" ></textarea>
										<script type="text/javascript">
											var editor = CKEDITOR.replace('description',{
												language:'vi',
												filebrowserImageBrowseUrl: '../../editor/ckfinder/ckfinder.html?Type=Images',
												filebrowserFlashBrowseUrl: '../../editor/ckfinder/ckfinder.html?Type=Flash',
												filebrowserImageUploadUrl: '../../editor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
												filebrowserFlashUploadUrl: '../../editor/public/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
											});
										</script>										
									</div>
									<div class="form-group" >
										<label>Danh mục</label>value
										<select  name="cate" class="form-control">
											@foreach ($cates as $cate)
												<option  value="{{ $cate->cate_id}}">{{ $cate->cate_name}}</option>
											@endforeach
										</select>
									</div>
									<div class="form-group" >
										<label>Sản phẩm nổi bật</label><br>
										Có: <input type="radio"  name="featured"  value="1">
										Không: <input type="radio" checked name="featured"  value="0">
									</div>
									<input type="submit" name="submit" value="Thêm" class="btn btn-primary">
								<a href="{{route('product.index')}}" class="btn btn-danger">Hủy bỏ</a>
								</div>
							</div>
						</form>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
		</div><!--/.row-->
	</div>	<!--/.main-->
@endsection
@section('script')
	<script>

	function changeImg(input){
		    //Nếu như tồn thuộc tính file, đồng nghĩa người dùng đã chọn file mới
		    if(input.files && input.files[0]){
		        var reader = new FileReader();
		        //Sự kiện file đã được load vào website
		        reader.onload = function(e){
		            //Thay đổi đường dẫn ảnh
		            $('#avatar').attr('src',e.target.result);
		        }
		        reader.readAsDataURL(input.files[0]);
		    }
		}
		$(document).ready(function() {
		    $('#avatar').click(function(){
		        $('#img').click();
		    });
		});
	
	
	</script>
@endsection