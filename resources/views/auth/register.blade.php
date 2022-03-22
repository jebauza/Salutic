@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">{{ __('Register') }}</h5>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class=" @error('name') text-danger @enderror">{{ __('Name') }}</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <label class=" @error('last_name1') text-danger @enderror">{{ __('Last Name') }} 1</label>
                                <input type="text" class="form-control @error('last_name1') is-invalid @enderror" name="last_name1" value="{{ old('last_name1') }}" required autocomplete="last_name1" autofocus>
                                @error('last_name1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <label class=" @error('last_name2') text-danger @enderror">{{ __('Last Name') }} 2</label>
                                <input type="text" class="form-control @error('last_name2') is-invalid @enderror" name="last_name2" value="{{ old('last_name2') }}" required autocomplete="last_name2" autofocus>
                                @error('last_name2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class=" @error('email') text-danger @enderror">{{ __('Email Address') }}</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-sm-6 col-md-4">
                                <label class=" @error('phone1') text-danger @enderror">{{ __('Phone') }} 1</label>
                                <input type="tel" class="form-control @error('phone1') is-invalid @enderror" name="phone1" value="{{ old('phone1') }}" required autocomplete="phone">
                                @error('phone1')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-sm-6 col-md-4">
                                <label class=" @error('phone2') text-danger @enderror">{{ __('Phone') }} 2</label>
                                <input type="tel" class="form-control @error('phone2') is-invalid @enderror" name="phone2" value="{{ old('phone2') }}" required autocomplete="phone">
                                @error('phone2')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class=" @error('center') text-danger @enderror">{{ __('Center') }}</label>
                                <select class="custom-select @error('center') is-invalid @enderror" name="center" required>
                                    <option></option>
                                    @foreach($centers as $key => $center)
                                        <option value="{{ $center->ID }}" {{ old('center') == $center->ID ? 'selected' : '' }}>{{ $center->NOMBRE }}</option>
                                    @endforeach
                                </select>
                                @error('center')
                                    <span class="text-danger">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group col-sm-6 col-md-4">
                                <label class=" @error('password') text-danger @enderror">{{ __('Password') }}</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group col-sm-6 col-md-4">
                                <label>{{ __('Confirm Password') }}</label>
                                <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
