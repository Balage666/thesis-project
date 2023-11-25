@extends('layouts.auth.base')

@section('title')
    <title>Login</title>
@endsection


@section('content')
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card shadow-2-strong authFormCardBackground" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">

                        <h1 class="mb-5">Hi!</h1>

                        <h3 class="mb-7">Please, type your email and password!</h3>

                        <form action="{{ url('/auth/log-on') }}" method="post">

                            @csrf

                            <x-base-components.forms.input
                                id="email"
                                name="email"
                                type="email"
                                label="Email"
                                placeholder="Enter your email"
                                forError="{{ $errors->first('email') }}"
                            />

                            <x-base-components.forms.input
                                id="password"
                                name="password"
                                type="password"
                                label="Password"
                                placeholder="Type your password"
                                forError="{{ $errors->first('password') }}"
                            />

                            {{--TODO: implement the backend behind this --}}
                            {{-- <div class="form-check d-flex justify-content-start mb-4">
                                <input class="form-check-input" type="checkbox" value="" id="checkbox" />
                                <label class="form-check-label" for="checkbox"> Remember password </label>
                            </div> --}}

                            <div class="d-grid gap-2">
                                <button class="btn btn-lg authSubmitButtonBackground" type="submit">Login</button>

                            </div>
                        </form>


                        <hr class="my-4">

                        <div class="d-grid">
                            <button class="btn btn-lg signInWithGoogleButtonBackground"
                                type="submit"><i class="fab fa-google me-2"></i> Sign in with google</button>
                        </div>

                        <hr class="my-4">

                        <div class="d-grid">

                            <h4 class="text-start">I'm new here!</h4>

                            <div class="d-grid">
                                <button class="btn btn-outline btn-lg authNormalButtonBackground" type="button">Register</button>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
