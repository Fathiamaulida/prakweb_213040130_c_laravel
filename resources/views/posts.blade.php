@extends('layouts.main')

@section('container')
<article class="mb-3">
@foreach ($posts as @post)
<h2>
     <a href="/posts/">{{$post["title"]}}</a>
     </h2>
     
<h5>{{$post["title"]}}</h5>
<p>{{$post["body"]}}</p>
</article>
@endforeach

@endsection

