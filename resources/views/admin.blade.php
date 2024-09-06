@extends('layout')

@section('content')
<h1>Logowanie</h1>
<form method="post" action="/auth" id="form-admin">
  @csrf
  <section>
    <div class="form-section-title">Login</div>
    <div class="form-section-input-container">
      <div class="form-section-input"><input type="text" name="login" value="{{session('login')}}" placeholder="Login"></div>
    </div>
  </section>
  <section>
    <div class="form-section-title">Hasło</div>
    <div class="form-section-input-container">
      <div class="form-section-input"><input type="password" name="password" value="{{session('password')}}" placeholder="Hasło"></div>
    </div>
  </section>
  @if (session('loginError'))
    <section class="error">{{session('loginError')}}</section>
  @endif
  <section class="form-buttons">
    <button type="submit" class="btn primary">Zaloguj</button>
  </section>
</form>
@endsection