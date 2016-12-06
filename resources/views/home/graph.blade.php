@extends('layouts.app')

@section('content')
<script type="text/javascript" src="http://use.typekit.com/mxh7kqd.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<link rel="stylesheet" href="/css/graph.css" type="text/css" charset="utf-8">
  <div id="some">
  <canvas id="sitemap" width="800" height="400"></canvas>  
  </div>  
<script src="/js/graph/js/jquery-1.6.1.min.js"></script>
<script src="/js/graph/js/jquery.address-1.4.min.js"></script>

<script src="/js/graph/js/lib/some.js"></script>
<script src="/js/graph/js/lib/some-tween.js"></script>
<script src="/js/graph/js/lib/some-graphics.js"></script>

<script src="/js/graph/data.js"></script>
<script src="/js/graph/main.js"></script>
@endsection

