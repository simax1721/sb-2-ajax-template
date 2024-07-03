@extends('layouts.auth')

@section('main-content')
<img style="width: 100px;" class="" src="{{ url('img/uin.png') }}" alt="">
<h1 class="mt-5 text-dark display-4">Register </h1>

<div class="container">
    @if ($errors->any())
        <div class="alert alert-danger border-left-danger" role="alert">
            <ul class="pl-4 my-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('register') }}" class="user">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        @csrf
        <div class="main">
            <div class="w-100">
              <div class="text-field">
                <input type="text" placeholder="..." name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                <label>Name:</label>
              </div>
            </div>
            
            <div class="w-100">
              <div class="text-field">
                <input type="email" placeholder="..." name="email" value="{{ old('email') }}" required>
                <label>E-mail:</label>
              </div>
            </div>
          
            <div class="w-100">
              <div class="text-field">
                <input type="password" placeholder="..." name="password" placeholder="{{ __('Password') }}" required>
                <label>Password:</label>
              </div>
            </div>
            
            <div class="w-100">
              <div class="text-field">
                <input type="password" placeholder="..." name="password_confirmation" placeholder="{{ __('Password') }}" required>
                <label>Confirm Password:</label>
              </div>
            </div>
        </div>

        <div class="button-field">
            <button type="submit">
              REGISTER
            </button>
        </div>

        <div class="" style="margin-top: 40px">
            <span style="font-size: 16px; margin-top: 15px;">Already have an account? <a href="{{ route('login') }}" style="color: #bc032f">Login</a></span>
        </div>

    </form>
</div>
@endsection