@extends('layouts.master')
@section('stylesheets')
    <link href="{{asset('css/auth.css')}}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="{{asset('js/auth.js')}}" defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <!-- Login Form -->
            <div class="col-md-4 offset-md-8 form-note">
                <form action="/login" method="post" id="login">
                    <h1>Sign In</h1>

                    <input id="email" type="email" placeholder="Email" class="form-control mb-1" name="email" v-model="login.email" required>
                    <a id='EmailErr' class="popper"><span v-if='"email" in login.errors' v-text="login.errors.email[0]"></span></a>

                    <input id="password" type="password" placeholder="Password" class="form-control mb-1" name="password" v-model="login.password" required>
                    <a id="PasswordErr" class="popper"><span v-if='"password" in login.errors' v-text="login.errors.password[0]"></span></a>

                    <div class="form-group ml-4">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" v-model="login.remember">
                        <label for="remember">Remember me</label>
                    </div>

                    {{csrf_field()}}
                    <button class="btn" :class='{"disable": (login.disableBtn || !isBtnReady)}' type="submit" @click.prevent="signIn">Sign in</button>
                    <a href="#" class="text register">New user?</a> |
                    <a href="{{route('password.request')}}" class="text login">Forgot your password?</a>

                </form>

                <form action="register" method="post" id="registration">
                    <h1>Sign Up</h1>

                    <input id="name" type="text" placeholder="Name" class="form-control mb-1" name="name" v-model="register.name">
                    <a id='NameErr' class="popper"><span v-if='"name" in register.errors' v-text="register.errors.name[0]"></span></a>

                    <input id="email2" type="email" placeholder="Email" class="form-control mb-1" name="email" v-model="register.email" autocomplete="off">
                    <a id='EmailErr2' class="popper"><span v-if='"email" in register.errors' v-text="register.errors.email[0]"></span></a>

                    <input id="password2" type="password" placeholder="Password" class="form-control mb-1" name="password" v-model="register.password">
                    <a id="PasswordErr2" class="popper"><span v-if='"password" in register.errors' v-text="register.errors.password[0]"></span></a>

                    {{csrf_field()}}
                    <button class="btn" :class='{"disable": (register.disableBtn || !isBtn2Ready)}' @click.prevent="signUp">Sign up</button>

                    <a href="#" class="text login">Already a user?</a>
                </form>

            </div><!-- login Form -->
        </div>
    </div>
@endsection
