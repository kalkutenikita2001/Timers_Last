<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- ===== BOX ICONS ===== -->
        <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
        <title>Admin Login</title>
        <style>
            /*===== GOOGLE FONTS =====*/
            @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap');

            /*===== VARIABLES CSS =====*/
            :root{
                /*===== Colores =====*/
                --first-color: red;
                --first-color-dark: #23004D;
                --first-color-light: #A49EAC;
                --first-color-lighten: #F2F2F2;
                /*===== Font and typography =====*/
                --body-font: 'Open Sans', sans-serif;
                --h1-font-size: 1.5rem;
                --normal-font-size: .938rem;
                --small-font-size: .813rem;
            }

            @media screen and (min-width: 768px){
                :root{
                    --normal-font-size: 1rem;
                    --small-font-size: .875rem;
                }
            }

            /*===== BASE =====*/
            *,::before,::after{
                box-sizing: border-box;
            }

            body{
                margin: 0;
                padding: 0;
                font-family: var(--body-font);
                font-size: var(--normal-font-size);
                color: var(--first-color-dark);
            }

            h1{
                margin: 0;
            }

            a{
                text-decoration: none;
            }

            img{
                max-width: 100%;
                height: auto;
                display: block;
            }

            /*===== LOGIN =====*/
            .login{
                display: grid;
                grid-template-columns: 100%;
                height: 100vh;
                margin-left: 1.5rem;
                margin-right: 1.5rem;
            }

            .login__content{
                display: grid;
            }

            .login__img{
                justify-self: center;
            }

            .login__img img{
                width: 199px;
                margin-top: 1.5rem;
            }

            .login__forms{
                position: relative;
                height: 368px;
            }

            .login__registre, .login__create, .login__forgot-form{
                position: absolute;
                bottom: 1rem;
                width: 100%;
                background-color: var(--first-color-lighten);
                padding: 2rem 1rem;
                border-radius: 1rem;
                text-align: center;
                box-shadow: 0 8px 20px rgba(35,0,77,.2);
                animation-duration: .4s;
                animation-name: animate-login;
            }

            @keyframes animate-login{
                0%{
                    transform: scale(1,1);
                }
                50%{
                    transform: scale(1.1,1.1);
                }
                100%{
                    transform: scale(1,1);
                }
            }

            .login__title{
                font-size: var(--h1-font-size);
                margin-bottom: 2rem;
            }

            .login__box{
                /* display: grid; */
                grid-template-columns: max-content 1fr;
                column-gap: .5rem;
                padding: 1.125rem 1rem;
                background-color: #FFF;
                margin-top: 1rem;
                border-radius: .5rem;
            }

            .login__icon{
                font-size: 1.5rem;
                color: var(--first-color);
            }

            .login__input{
                border: none;
                outline: none;
                font-size: var(--normal-font-size);
                font-weight: 700;
                color: var(--first-color-dark);
            }

            .login__input::placeholder{
                font-size: var(--normal-font-size);
                font-family: var(--body-font);
                color: var(--first-color-light);
            }

            .login__forgot{
                display: block;
                width: max-content;
                margin-left: auto;
                margin-top: .5rem;
                font-size: var(--small-font-size);
                font-weight: 600;
                color: var(--first-color-light);
            }

            .login__button{
                /* display: block; */
                padding: 1rem;
                margin: 2rem 0;
                background-color: var(--first-color);
                color: #FFF;
                font-weight: 600;
                text-align: center;
                border-radius: .5rem;
                transition: .3s;
            }

            .login__button:hover{
                background-color: var(--first-color-dark);
            }

            .login__account, .login__signin, .login__signup{
                font-weight: 600;
                font-size: var(--small-font-size);
            }

            .login__account{
                color: var(--first-color-dark);
            }

            .login__signin, .login__signup{
                color: var(--first-color);
                cursor: pointer;
            }

            .login__social{
                margin-top: 2rem;
            }

            .login__social-icon{
                font-size: 1.5rem;
                color: var(--first-color-dark);
                margin: 0 1.5rem;
            }

            /*Show login*/
            .block{
                display: block;
            }

            /*Hidden login*/
            .none{
                display: none;
            }

            /* Validation Styles */
            .error{
                border: 1px solid #ff4d4d;
            }

            .error-message{
                color: #ff4d4d;
                font-size: var(--small-font-size);
                margin-top: 0.25rem;
                text-align: left;
            }

            /* ===== MEDIA QUERIES =====*/
            @media screen and (min-width: 576px){
                .login__forms{
                    width: 348px;
                    justify-self: center;
                }
            }

            @media screen and (min-width: 1024px){
                .login{
                    height: 100vh;
                    overflow: hidden;
                }

                .login__content{
                    grid-template-columns: repeat(2, max-content);
                    justify-content: center;
                    align-items: center;
                    margin-left: 10rem;
                }

                .login__img{
                    display: flex;
                    width: 600px;
                    height: 588px;
                    background-color: var(--first-color-lighten);
                    border-radius: 1rem;
                    padding-left: 1rem;
                }

                .login__img img{
                    width: 390px;
                    margin-top: 0;
                }

                .login__registre, .login__create, .login__forgot-form{
                    left: -11rem;
                }

                .login__registre{
                    bottom: -2rem;
                }

                .login__create{
                    bottom: -5.5rem;
                }

                .login__forgot-form{
                    bottom: -2rem;
                }
            }
        </style>
    </head>
    <body>
        <div class="login">
            <div class="login__content">
                <div class="login__img">
                    <img src="<?php echo base_url('assets/images/timeersbadmintonacademy_logo.png'); ?>" alt="Logo">
                </div>

                <div class="login__forms">
                    <form action="<?php echo base_url('auth/admin_login'); ?>" class="login__registre block" id="login-in">
                        <h1 class="login__title">Admin Sign In</h1>
                        <div class="login__box">
                            <i class='bx bx-user login__icon'></i>
                            <input type="text" name="username" placeholder="Username" class="login__input" required>
                            <div class="error-message" id="login-username-error"></div>
                        </div>
                        <div class="login__box">
                            <i class='bx bx-lock-alt login__icon'></i>
                            <input type="password" name="password" placeholder="Password" class="login__input" required>
                            <div class="error-message" id="login-password-error"></div>
                        </div>
                        <a href="#" class="login__forgot" id="forgot-password">Forgot password?</a>
                        <button type="submit" class="login__button">Sign In</button>
                        <div>
                            <span class="login__account">Don't have an Account ?</span>
                            <span class="login__signin" id="sign-up">Sign Up</span>
                        </div>
                    </form>

                    <form action="<?php echo base_url('auth/admin_signup'); ?>" class="login__create none" id="login-up">
                        <h1 class="login__title">Admin Create Account</h1>
                        <div class="login__box">
                            <i class='bx bx-user login__icon'></i>
                            <input type="text" name="username" placeholder="Username" class="login__input" required>
                            <div class="error-message" id="signup-username-error"></div>
                        </div>
                        <div class="login__box">
                            <i class='bx bx-at login__icon'></i>
                            <input type="email" name="email" placeholder="Email" class="login__input" required>
                            <div class="error-message" id="signup-email-error"></div>
                        </div>
                        <div class="login__box">
                            <i class='bx bx-lock-alt login__icon'></i>
                            <input type="password" name="password" placeholder="Password" class="login__input" required>
                            <div class="error-message" id="signup-password-error"></div>
                        </div>
                        <button type="submit" class="login__button">Sign Up</button>
                        <div>
                            <span class="login__account">Already have an Account ?</span>
                            <span class="login__signup" id="sign-in">Sign In</span>
                        </div>
                        <div class="login__social">
                            <a href="#" class="login__social-icon"><i class='bx bxl-facebook' ></i></a>
                            <a href="#" class="login__social-icon"><i class='bx bxl-twitter' ></i></a>
                            <a href="#" class="login__social-icon"><i class='bx bxl-google' ></i></a>
                        </div>
                    </form>

                    <form action="<?php echo base_url('auth/admin_reset_password'); ?>" class="login__forgot-form none" id="forgot-password-form">
                        <h1 class="login__title">Admin Forgot Password</h1>
                        <div class="login__box">
                            <i class='bx bx-at login__icon'></i>
                            <input type="email" name="email" placeholder="Email" class="login__input" required>
                            <div class="error-message" id="forgot-email-error"></div>
                        </div>
                        <button type="submit" class="login__button">Reset Password</button>
                        <div>
                            <span class="login__account">Back to </span>
                            <span class="login__signup" id="back-to-sign-in">Sign In</span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!--===== MAIN JS =====-->
        <script>
            const signUp = document.getElementById('sign-up'),
                signIn = document.getElementById('sign-in'),
                forgotPassword = document.getElementById('forgot-password'),
                backToSignIn = document.getElementById('back-to-sign-in'),
                loginIn = document.getElementById('login-in'),
                loginUp = document.getElementById('login-up'),
                forgotPasswordForm = document.getElementById('forgot-password-form');

            signUp.addEventListener('click', (e) => {
                e.preventDefault();
                loginIn.classList.remove('block');
                loginUp.classList.remove('none');
                forgotPasswordForm.classList.remove('block');
                loginIn.classList.add('none');
                loginUp.classList.add('block');
                forgotPasswordForm.classList.add('none');
            });

            signIn.addEventListener('click', (e) => {
                e.preventDefault();
                loginIn.classList.remove('none');
                loginUp.classList.remove('block');
                forgotPasswordForm.classList.remove('block');
                loginIn.classList.add('block');
                loginUp.classList.add('none');
                forgotPasswordForm.classList.add('none');
            });

            forgotPassword.addEventListener('click', (e) => {
                e.preventDefault();
                loginIn.classList.remove('block');
                loginUp.classList.remove('block');
                forgotPasswordForm.classList.remove('none');
                loginIn.classList.add('none');
                loginUp.classList.add('none');
                forgotPasswordForm.classList.add('block');
            });

            backToSignIn.addEventListener('click', (e) => {
                e.preventDefault();
                loginIn.classList.remove('none');
                loginUp.classList.remove('block');
                forgotPasswordForm.classList.remove('block');
                loginIn.classList.add('block');
                loginUp.classList.add('none');
                forgotPasswordForm.classList.add('none');
            });

            // Validation Logic
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    let isValid = true;

                    if (form.id === 'login-in') {
                        const username = form.querySelector('input[name="username"]');
                        const password = form.querySelector('input[name="password"]');
                        const usernameError = document.getElementById('login-username-error');
                        const passwordError = document.getElementById('login-password-error');

                        usernameError.textContent = '';
                        passwordError.textContent = '';
                        username.classList.remove('error');
                        password.classList.remove('error');

                        if (!username.value) {
                            usernameError.textContent = 'Username is required';
                            username.classList.add('error');
                            isValid = false;
                        } else if (!/^[a-zA-Z0-9_]{3,20}$/.test(username.value)) {
                            usernameError.textContent = 'Username must be 3-20 characters, alphanumeric or underscore';
                            username.classList.add('error');
                            isValid = false;
                        }

                        if (!password.value) {
                            passwordError.textContent = 'Password is required';
                            password.classList.add('error');
                            isValid = false;
                        } else if (password.value.length < 6) {
                            passwordError.textContent = 'Password must be at least 6 characters';
                            password.classList.add('error');
                            isValid = false;
                        }

                        if (isValid) form.submit();
                    }

                    if (form.id === 'login-up') {
                        const username = form.querySelector('input[name="username"]');
                        const email = form.querySelector('input[name="email"]');
                        const password = form.querySelector('input[name="password"]');
                        const usernameError = document.getElementById('signup-username-error');
                        const emailError = document.getElementById('signup-email-error');
                        const passwordError = document.getElementById('signup-password-error');

                        usernameError.textContent = '';
                        emailError.textContent = '';
                        passwordError.textContent = '';
                        username.classList.remove('error');
                        email.classList.remove('error');
                        password.classList.remove('error');

                        if (!username.value) {
                            usernameError.textContent = 'Username is required';
                            username.classList.add('error');
                            isValid = false;
                        } else if (!/^[a-zA-Z0-9_]{3,20}$/.test(username.value)) {
                            usernameError.textContent = 'Username must be 3-20 characters, alphanumeric or underscore';
                            username.classList.add('error');
                            isValid = false;
                        }

                        if (!email.value) {
                            emailError.textContent = 'Email is required';
                            email.classList.add('error');
                            isValid = false;
                        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                            emailError.textContent = 'Invalid email format';
                            email.classList.add('error');
                            isValid = false;
                        }

                        if (!password.value) {
                            passwordError.textContent = 'Password is required';
                            password.classList.add('error');
                            isValid = false;
                        } else if (password.value.length < 6) {
                            passwordError.textContent = 'Password must be at least 6 characters';
                            password.classList.add('error');
                            isValid = false;
                        }

                        if (isValid) form.submit();
                    }

                    if (form.id === 'forgot-password-form') {
                        const email = form.querySelector('input[name="email"]');
                        const emailError = document.getElementById('forgot-email-error');

                        emailError.textContent = '';
                        email.classList.remove('error');

                        if (!email.value) {
                            emailError.textContent = 'Email is required';
                            email.classList.add('error');
                            isValid = false;
                        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
                            emailError.textContent = 'Invalid email format';
                            email.classList.add('error');
                            isValid = false;
                        }

                        if (isValid) form.submit();
                    }
                });
            });
        </script>
    </body>
</html>
