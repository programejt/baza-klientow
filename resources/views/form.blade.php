@extends('layout')

@section('content')
<form method="post" action="/client/add" id="form-client">
  <h1>Dane identyfikacyjne</h1>
  @csrf
  @if (isset($id))
    <input type="hidden" name="id" value="{{ $id }}">
  @endif
  <section>
    <div class="form-section-title">Status prawny</div>
    <div class="form-section-input-container">
      <div class="form-section-input">
        <label><input type="radio" name="law_status" value="person" class="law-status-radio" {{$law_status == 'person' ? 'checked' : ''}}>Osoba prywatna</label>
        <label><input type="radio" name="law_status" value="company" class="law-status-radio" {{$law_status == 'company' ? 'checked' : ''}}>Firma</label>
      </div>
    </div>
  </section>
  <section class="only-for-person">
    <div class="form-section-title">Imię i nazwisko</div>
    <div class="form-section-input-container">
      <div class="form-section-input"><input type="text" name="person_name" value="{{isset($person_name) ? $person_name : ''}}" placeholder="Imię i nazwisko"></div>
    </div>
  </section>
  <section class="only-for-company">
    <div class="form-section-title">Nazwa firmy</div>
    <div class="form-section-input-container">
      <div class="form-section-input"><input type="text" name="company_name" value="{{isset($company_name) ? $company_name : ''}}" placeholder="Nazwa firmy"></div>
    </div>
  </section>
  <section>
    <div class="form-section-title">Ulica, nr domu</div>
    <div class="form-section-input-container">
      <div class="form-section-input2"><input type="text" name="street" class="long" value="{{$street}}" placeholder="Ulica"><input type="text" name="local" class="short" value="{{$local}}" placeholder="Nr domu"></div>
    </div>
  </section>
  <section>
    <div class="form-section-title">Miasto, kod pocztowy</div>
    <div class="form-section-input-container">
      <div class="form-section-input2"><input type="text" name="city" class="long" value="{{$city}}" placeholder="Miasto"><input type="text" name="zip_code" class="short" value="{{$zip_code}}" placeholder="Kod pocztowy"></div>
    </div>
  </section>
  <section>
    <div class="form-section-title">Województwo</div>
    <div class="form-section-input-container">
      <div class="form-section-input">
        <select id="select-region" name="region" data-val="{{$region}}">
          <option value="">Wybierz...</option>
        </select>
      </div>
    </div>
  </section>
  <section>
    <div class="form-section-title">Telefon</div>
    <div class="form-section-input-container">
      <div class="form-section-input2"><input type="text" name="phone_start" class="short" placeholder="+48" value="{{$phone_start}}"><input type="text" name="phone" class="long" value="{{$phone}}" placeholder="Telefon"></div>
    </div>
  </section>
  <section>
    <div class="form-section-title">Email</div>
    <div class="form-section-input-container">
      <div class="form-section-input"><input type="email" name="email" value="{{$email}}" placeholder="Email"></div>
    </div>
  </section>
  <section class="only-for-person">
    <div class="form-section-title">Pesel</div>
    <div class="form-section-input-container">
      <div class="form-section-input"><input type="text" name="person_id" value="{{isset($person_id) ? $person_id : ''}}" placeholder="Pesel"></div>
    </div>
  </section>
  <section class="only-for-company">
    <div class="form-section-title">NIP</div>
    <div class="form-section-input-container">
      <div class="form-section-input"><input type="text" name="company_id" value="{{isset($company_id) ? $company_id : ''}}" placeholder="NIP"></div>
    </div>
  </section>
  <section class="form-buttons">
    <button type="button" class="btn secondary cancel-form">Anuluj</button>
    <button type="submit" class="btn primary">Zapisz</button>
  </section>
</form>
@endsection