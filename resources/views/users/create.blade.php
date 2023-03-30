@extends('layouts.global')
@section('title')
    Create new User
@endsection

@section('content')
    <div class="col-md-8">

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form enctype="multipart/form-data" class="bg-white shadow-sm p-3" action="{{ route('users.store') }}" method="POST">

            @csrf
            <label for="name">Name</label>
            <input value="{{ old('name') }}" class="form-control {{ $errors->first('name') ? 'is-invalid' : '' }}"
                placeholder="Full Name" name="name" id="name" type="text" />
            <div class="invalid-feedback">
                {{ $errors->first('name') }}
            </div>
            <br>

            <label for="name">username</label>
            <input value="{{ old('username') }}" class="form-control {{ $errors->first('username') ? 'is-invalid' : '' }}"
                placeholder="username" type="text" name="username" id="username" />
            <div class="invalid-feedback">
                {{ $errors->first('username') }}
            </div>
            <br>

            <label for="name">Roles</label>
            <br>
            <input class="form-control {{ $errors->first('roles') }}" type="checkbox" name="roles[]" id="ADMIN"
                value="ADMIN" />
            <label for="ADMIN">Administrator</label>

            <input class="form-control {{ $errors->first('roles') ? 'is-invalid' : '' }}" type="checkbox" name="roles[]"
                id="STAFF" value="STAFF" />
            <label for="STAFF">Staff</label>

            <input class="form-control {{ $errors->first('roles') ? 'is-invalid' : '' }}" type="checkbox" name="roles[]"
                id="CUSTOMER" value="CUSTOMER" />
            <label for="CUSTOMER">Customer</label>
            <br>

            <div class="invalid-feedback">
                {{ $errors->first('roles') }}
            </div>
            <br>

            <br>
            <label for="phone">Phone Number</label>
            <br>
            <input value="{{ old('phone') }}" class="form-control {{ $errors->first('phone') ? 'is-invalid' : '' }}"
                type="text" name="phone" />
            <div class="invalid-feedback">
                {{ $errors->first('phone') }}
            </div>
            <br>

            <label for="address">Address</label>
            <textarea name="address" id="address" class="form-control {{ $errors->first('address') ? 'is-invalid' : '' }}"></textarea>
            <br>
            <div class="invalid-feedback">
                {{ $errors->first('address') }}
            </div>

            <br>
            <label for="avatar">Avatar image</label>
            <br>
            <input type="file" name="avatar" type="file"
                class="form-control {{ $errors->first('avatar') ? 'is-invalid' : '' }}">
            <div class="invalid-feedback">
                {{ $errors->first('avatar') }}
            </div>

            <hr class="my-4">

            <label for="email">Email</label>
            <input value="{{ old('email') }}" class="form-control {{ $errors->first('email') ? 'is-invalid' : '' }}"
                placeholder="user@gmail.com" type="text" name="email" id="email" />
            <div class="invalid-feedback">
                {{ $errors->first('email') }}
            </div>
            <br>

            <label for="password">Password</label>
            <input class="form-control {{ $errors->first('password') ? 'is-invalid' : '' }}" placeholder="password"
                type="password" name="password" id="password" />
            <div class="invalid-feedback">
                {{ $errors->first('password') }}
            </div>
            <br>


            <label for="passwrod_confirmation">Password Confirmation</label>
            <input class="form-control {{ $errors->first('password_confirmation') ? 'is-invalid' : '' }}"
                placeholder="password confirmation" type="password" name="password_confirmation"
                id="password_confirmation" />
            <div class="invalid-feedback">
                {{ $errors->first('password_confirmations') }}
            </div>
            <br>

            <input class="btn btn-primary" type="submit" value="Save" />

        </form>
    </div>
@endsection
