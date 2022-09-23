@extends('layout.main')
@section('container')

    <div class="row justify-content-center">
      @if(session()->has('success'))
          <div class="alert alert-success">
              {{ session()->get('success')}}
          </div>
      @endif

      @if(session()->has('loginError'))
          <div class="alert alert-danger">
              {{ session()->get('loginError')}}
          </div>
      @endif

      @if(session()->has('logout'))
          <div class="alert alert-success">
              {{ session()->get('logout')}}
          </div>
      @endif

        <div class="col-md-5">
            <main class="form-signin">
                <h1 class="h3 mb-3 fw-normal text-center">Please Login</h1>
                <form action="/" method="POST">              
                  @csrf
                  <div class="form-floating">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="" placeholder="name@example.com" autocomplete="off" value="{{ old('email') }}" required autofocus>
                    <label for="floatingInput">Email address</label>
                    @error('email')
                        <div class="invalid-feedback">
                          {{ $message }}
                        </div>
                    @enderror
                  </div>
                  <div class="form-floating">
                    <input type="password" name="password" class="form-control" id="" placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                  </div>

                  <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
                </form>
                <small class="d-block text-center mt-3">Not Registered? <a href="/register">Register Now</a></small>
            </main>
        </div>
    </div>
@endsection