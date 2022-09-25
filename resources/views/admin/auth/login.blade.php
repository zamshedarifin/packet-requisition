@extends('layouts.app')
@section('title')
    login
@stop
@section('content')

    <div id="layoutAuthentication" class="btn-secondary">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4 text-dark">Pride Packet Requisition Login</h3></div>
                                <div class="card-body">
                                    <form method="post" action="{{route('admin.login')}}" class="login-form-area">
                                        @csrf
                                        <div class="form-floating mb-3">
                                            <input type="email" name="email" class="form-control form-control-lg  @error('email') is-invalid @enderror" value="{{old('email')}}" id="exampleInputEmail1" placeholder="Username">
                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                            <label for="inputEmail" class="text-dark">Email</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input id="password" type="password"
                                                   class="form-control @error('password') is-invalid @enderror" name="password"
                                                   required autocomplete="current-password">

                                            @error('password')
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                            @enderror
                                            <label for="inputPassword" class="text-dark">Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary" type="submit">Login</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Developed By Pride &copy; {{date('Y')}}</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

 @stop


