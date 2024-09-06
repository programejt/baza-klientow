@extends('layout')

@section('content')
  <h1>Dane klienta</h1>
  <p class="client-id">#{{$id}}</p>
  <section>
    <div class="section-title">Status prawny</div>
    <div class="section-value">{{$law_status}}</div>
  </section>
  @if (isset($person_name))
  <section>
    <div class="section-title">Imię i nazwisko</div>
    <div class="section-value">{{$person_name}}</div>
  </section>
  @endif
  @if (isset($company_name))
  <section>
    <div class="section-title">Nazwa firmy</div>
    <div class="section-value">{{$company_name}}</div>
  </section>
  @endif
  <section>
    <div class="section-title">Ulica, nr domu</div>
    <div class="section-value">{{$street}} {{$local}}</div>
  </section>
  <section>
    <div class="section-title">Miasto, kod pocztowy</div>
    <div class="section-value">{{$city}}, {{$zip_code}}</div>
  </section>
  <section>
    <div class="section-title">Województwo</div>
    <div class="section-value">{{$region}}</div>
  </section>
  <section>
    <div class="section-title">Telefon</div>
    <div class="section-value">{{$phone_start}} {{$phone}}</div>
  </section>
  <section>
    <div class="section-title">Email</div>
    <div class="section-value">{{$email}}</div>
  </section>
  @if (isset($person_id))
  <section>
    <div class="section-title">Pesel</div>
    <div class="section-value">{{$person_id}}</div>
  </section>
  @endif
  @if (isset($company_id))
  <section>
    <div class="section-title">NIP</div>
    <div class="section-value">{{$company_id}}</div>
  </section>
  @endif
  @if (session('admin') != null)
    <form action="/client/delete" method="post">
      @csrf
      <input type="hidden" name="id" value="{{$id}}">
      <div class="form-buttons">
        <a href="/client/edit/{{$id}}" class="btn">Edytuj</a>
        <button type="submit" class="btn">Usuń</button>
      </div>
    </form>
  @endif
@endsection