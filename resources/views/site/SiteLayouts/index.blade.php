<!DOCTYPE html>

<html dir="ltr" lang="vi"><!--<![endif]-->
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#FFFFFF">
    {!! \App\Library\AdminFunction\CGlobal::$extraMeta !!}

    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/css.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/owl_002.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/owl.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/font-awesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/base.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/module.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/jquery_002.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/responsive.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/stylesheet_002.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/styles_shop.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/stylesheet.css')}}">
    <link rel="stylesheet" type="text/css" href="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/stylesheet.css')}}">


    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/js/jquery.2.1.1.min.js')}}"></script>
    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/js/shopcuatui.js')}}"></script>
    {{\App\Library\AdminFunction\CGlobal::$extraHeaderCSS}}
    <script type="text/javascript">
        var WEB_ROOT = "{{url('', array(), Config::get('config.SECURE'))}}";
        var DEVMODE = "{{Config::get('config.DEVMODE')}}";
        var COOKIE_DOMAIN = "{{Config::get('config.DOMAIN_COOKIE_SERVER')}}";
    </script>
    {{\App\Library\AdminFunction\CGlobal::$extraHeaderJS}}

    <script type="text/javascript" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/jquery.js')}}"></script>
    <script src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/sdk_002.js')}}" async=""></script>
    <script id="facebook-jssdk" src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/sdk.js')}}"></script>
    @if(\Illuminate\Support\Facades\Config::get('config.DEVMODE') == false)
        <meta name="google-site-verification" content="lJpAlY8qAQ365SzwbRN9_UEySpftXGaB4zgKeZgwKyk" />
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-76848213-1', 'auto');
            ga('send', 'pageview');
        </script>

        <script rel="nofollow" type="application/ld+json">
		{
		  "@context": "http://schema.org/",
		  "@type": "Review",
		  "itemReviewed": {
			"@type": "Thing",
			"name": "Super Book"
		  },
		  "author": {
			"@type": "Person",
			"name": "Google"
		  },
		  "reviewRating": {
			"@type": "Rating",
			"ratingValue": "9",
			"bestRating": "10"
		  },
		  "publisher": {
			"@type": "Organization",
			"name": "Washington Times"
		  }
		}
		</script>
    @endif
    <script src="{{\Illuminate\Support\Facades\URL::asset('assets/frontend/shop/a_data/jquery-3.js')}}" async=""></script>
</head>

<body class="common-home">
<div class="hidden-md hidden-lg opacity_menu"></div>
<div class="opacity_filter"></div>

@yield('header')

@yield('content')

<!--Footer--->
@yield('footer')

</body>
</html>