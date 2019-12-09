<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title')</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<base href="{{asset('public/layout/backend')}}/">
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<script src="js/lumino.glyphs.js"></script>
<script type="text/javascript" src="../../editor/ckeditor/ckeditor.js"></script>


</head>

<body>
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    
                            @guest
                                <a class="navbar-brand" href="{{route('login')}}">Vietpro Admin</a>
                            <ul class="user-menu">
                                <li class="dropdown pull-right">
                            <li><a href="{{route('login')}}"><svg class="glyph stroked cancel"></svg> Login</a></li>
                            
                            @else
                            {{-- <a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg>{{Auth::user()->name}}<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
                            </ul> --}}
                            <a class="navbar-brand" href="{{route('home')}}">Vietpro Admin</a>
                            <ul class="user-menu">
                                <li class="dropdown pull-right">
                            <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>
    
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item hover" style="color:black;display:block;text-align:center" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>
    
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </li>
                    </ul>
                </div>
                                
            </div><!-- /.container-fluid -->
        </nav>
         @yield('content')  
         <script src="js/jquery-1.11.1.min.js"></script>
         <script src="js/bootstrap.min.js"></script>
         <script src="js/chart.min.js"></script>
         <script src="js/chart-data.js"></script>
         <script src="js/easypiechart.js"></script>
         <script src="js/easypiechart-data.js"></script>
         <script src="js/bootstrap-datepicker.js"></script>
        <script>
           	$('#calendar').datepicker({
		});

		!function ($) {
		    $(document).on("click","ul.nav li.parent > a > span.icon", function(){          
		        $(this).find('em:first').toggleClass("glyphicon-minus");      
		    }); 
		    $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		});
       
        </script>	
        <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        </script>
        @yield('script')
    </body>
    </html> 