@extends('layout')

@section('content')
  <header>Panel Admina <a href="/logout" class="btn">Wyloguj</a></header>
  <section class="clients">
  @foreach ($clients as $c)
    <div class="client">Klient #{{$c}} <a href="/client/{{$c}}" class="btn" title="Edytuj dane klienta">Podgląd</a> <a href="/client/edit/{{$c}}" class="btn" title="Edytuj dane klienta">Edytuj</a></div>
  @endforeach
  </section>
@endsection