@extends("layouts.template")

@section('content')

<h1>Bienvenu à vous ! {{ $title }}</h1>
<p>{{  $content  }}</p>

<p>Cet article a été crée le {{ $created_at }}</p>
@endsection