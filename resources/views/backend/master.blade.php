@extends('layouts.negivation')
@section('title','Trang chủ quản trị')
@section('content')
<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <ul class="nav menu">
        <li role="presentation" class="divider"></li>
        <li class=""><a href="{{route('home')}}"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Trang chủ</a></li>
        <li><a href="{{route('product.index')}}"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"></use></svg> Sản phẩm</a></li>
        <li class=""><a href="{{route('category.index')}}"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> Danh mục</a></li>
        <li role="presentation" class="divider"></li>
    </ul>
</div><!--/.sidebar-->
@yield('main')
@endsection