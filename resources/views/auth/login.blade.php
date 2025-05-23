@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Mot de passe') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Se souvenir de moi') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Connexion') }}
                                </button>

                                <!-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot ?') }}
                                    </a>
                                @endif -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #6b7280;
            --accent-color: #10b981;
            --light-color: #f9fafb;
            --dark-color: #1f2937;
            --error-color: #ef4444;
            --border-radius: 0.375rem;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f3f4f6;
            color: var(--dark-color);
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        
        #app {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        main {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        
        .auth-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 28rem;
            padding: 2.5rem;
            margin: 1rem;
        }
        
        .auth-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .auth-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }
        
        .auth-subtitle {
            color: var(--secondary-color);
            font-size: 0.875rem;
        }
        
        .form-group {
            margin-bottom: 1.25rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--dark-color);
            font-size: 0.875rem;
        }
        
        .form-input {
            width: 100%;
            padding: 0.625rem 0.875rem;
            border: 1px solid #d1d5db;
            border-radius: var(--border-radius);
            font-size: 0.875rem;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.625rem 1.25rem;
            border-radius: var(--border-radius);
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.15s ease-in-out;
            border: none;
            width: 100%;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: #4338ca;
        }
        
        .auth-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 0.875rem;
            color: var(--secondary-color);
        }
        
        .auth-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }
        
        .auth-link:hover {
            text-decoration: underline;
        }
        
        .error-message {
            color: var(--error-color);
            font-size: 0.75rem;
            margin-top: 0.25rem;
        }
        
        .input-error {
            border-color: var(--error-color);
        }
        
        .input-error:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
        }
        
        @media (max-width: 640px) {
            .auth-card {
                padding: 1.5rem;
            }
        }
    </style>
@endsection
