<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ===== BOX ICONS ===== -->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <title>Super Admin Login</title>
    <style>
        /*===== GOOGLE FONTS =====*/
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap');

        /*===== VARIABLES CSS =====*/
        :root {
            /*===== Colors =====*/
            --first-color: linear-gradient(to right, #ff4040, #470000);
            --first-color-dark: #23004D;
            --first-color-light: #A49EAC;
            --first-color-lighten: #F2F2F2;
            /*===== Font and typography =====*/
            --body-font: 'Open Sans', sans-serif;
            --h1-font-size: 1.5rem;
            --normal-font-size: .938rem;
            --small-font-size: .813rem;
        }

        /*===== BASE =====*/
        *, ::before, ::after {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: var(--body-font);
            font-size: var(--normal-font-size);
            color: var(--first-color-dark);
            background: #f5f5f5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h1 {
            margin: 0;
        }

        a {
            text-decoration: none;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        /*===== LOGIN =====*/
        .login {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        .login__content {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .login__img {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .login__img img {
            width: min(60vw, 199px);
        }

        .login__forms {
            position: relative;
            width: 100%;
            max-width: 400px;
            min-height: 300px;
        }

        .login__registre, .login__forgot-form {
            position: absolute;
            top: 0;
            width: 100%;
            background-color: var(--first-color-lighten);
            padding: clamp(1rem, 5vw, 2rem);
            border-radius: 1rem;
            text-align: center;
            box-shadow: 0 8px 20px rgba(35, 0, 77, .2);
            animation-duration: .4s;
            animation-name: animate-login;
        }

        @keyframes animate-login {
            0% { transform: scale(1, 1); }
            50% { transform: scale(1.05, 1.05); }
            100% { transform: scale(1, 1); }
        }

        .login__title {
            font-size: var(--h1-font-size);
            margin-bottom: 1.5rem;
        }

        .login__box {
            display: grid;
            grid-template-columns: max-content 1fr;
            column-gap: .5rem;
            padding: 1rem;
            background-color: #FFF;
            margin-top: 1rem;
            border-radius: .5rem;
            transition: border 0.3s;
        }

        .login__icon {
            font-size: 1.5rem;
            background: var(--first-color);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login__input {
            border: none;
            outline: none;
            font-size: var(--normal-font-size);
            font-weight: 700;
            color: var(--first-color-dark);
            width: 100%;
        }

        .login__input:focus {
            border: 2px solid transparent;
            border-image: var(--first-color);
            border-image-slice: 1;
        }

        .login__input::placeholder {
            font-size: var(--normal-font-size);
            font-family: var(--body-font);
            color: var(--first-color-light);
        }

        .login__forgot {
            display: block;
            width: max-content;
            margin-left: auto;
            margin-top: .5rem;
            font-size: var(--small-font-size);
            font-weight: 600;
            color: #ff4040;
            transition: color 0.3s;
        }

        .login__forgot:hover {
            color: #470000;
        }

        .login__button {
            width: 100%;
            padding: 1rem;
            margin: 1.5rem 0;
            background: var(--first-color);
            color: #FFF;
            font-weight: 600;
            text-align: center;
            border-radius: .5rem;
            border: none;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .login__button:hover {
            opacity: 0.9;
        }

        .login__account, .login__signup {
            font-weight: 600;
            font-size: var(--small-font-size);
        }

        .login__account {
            color: var(--first-color-dark);
        }

        .login__signup {
            color: #ff4040;
            cursor: pointer;
        }

        .login__signup:hover {
            color: #470000;
        }

        /* Show login */
        .block {
            display: block;
        }

        /* Hidden login */
        .none {
            display: none;
        }

        /* Validation Styles */
        .error {
            border: 1px solid #ff4d4d;
        }

        .error-message {
            color: #ff4d4d;
            font-size: var(--small-font-size);
            margin-top: 0.25rem;
            text-align: left;
        }

        /* ===== MEDIA QUERIES =====*/
        @media screen and (min-width: 576px) {
            .login__forms {
                max-width: 348px;
                margin: 0 auto;
            }

            .login__img img {
                width: 250px;
            }
        }

        @media screen and (min-width: 768px) {
            :root {
                --normal-font-size: 1rem;
                --small-font-size: .875rem;
            }

            .login__content {
                flex-direction: row;
                gap: 2rem;
                align-items: center;
                justify-content: center;
            }

            .login__img {
                margin-bottom: 0;
            }

            .login__img img {
                width: 300px;
            }

            .login__forms {
                min-height: 350px;
            }
        }

        @media screen and (min-width: 1024px) {
            .login__img {
                width: 50%;
                max-width: 600px;
                background-color: var(--first-color-lighten);
                border-radius: 1rem;
                padding: 1rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .login__img img {
                width: 390px;
            }

            .login__forms {
                width: 40%;
                max-width: 400px;
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
                <!-- Sign In Form -->
                <form action="<?php echo base_url('auth/superadminlogin'); ?>" class="login__registre block" id="login-in">
                    <h1 class="login__title">Super Admin Sign In</h1>
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
                </form>

                <!-- Forgot Password Form -->
                <form action="<?php echo base_url('auth/superadmin_reset_password'); ?>" class="login__forgot-form none" id="forgot-password-form">
                    <h1 class="login__title">Super Admin Forgot Password</h1>
                    <div class="login__box">
                        <i class='bx bx-at login__icon'></i>
                        <input type="email" name="email" placeholder="Email" class="login__input" required>
                        <div class="error-message" id="forgot-email-error"></div>
                    </div>
                    <button type="submit" class="login__button">Reset Password</button>
                    <div>
                        <span class="login__account">Back to</span>
                        <span class="login__signup" id="back-to-sign-in">Sign In</span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--===== MAIN JS =====-->
    <script>
        // Navigation between forms
        const forgotPassword = document.getElementById('forgot-password'),
              backToSignIn = document.getElementById('back-to-sign-in'),
              loginIn = document.getElementById('login-in'),
              forgotPasswordForm = document.getElementById('forgot-password-form');

        forgotPassword.addEventListener('click', (e) => {
            e.preventDefault();
            loginIn.classList.remove('block');
            forgotPasswordForm.classList.remove('none');
            loginIn.classList.add('none');
            forgotPasswordForm.classList.add('block');
        });

        backToSignIn.addEventListener('click', (e) => {
            e.preventDefault();
            loginIn.classList.remove('none');
            forgotPasswordForm.classList.remove('block');
            loginIn.classList.add('block');
            forgotPasswordForm.classList.add('none');
        });

        // Form validation and submission
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                let isValid = true;

                // Clear previous errors
                form.querySelectorAll('.login__input').forEach(input => {
                    input.classList.remove('error');
                });
                form.querySelectorAll('.error-message').forEach(error => {
                    error.textContent = '';
                });

                if (form.id === 'login-in') {
                    const username = form.querySelector('input[name="username"]');
                    const password = form.querySelector('input[name="password"]');
                    const usernameError = document.getElementById('login-username-error');
                    const passwordError = document.getElementById('login-password-error');

                    if (!username.value.trim()) {
                        usernameError.textContent = 'Username is required';
                        username.classList.add('error');
                        isValid = false;
                    } else if (!/^[a-zA-Z0-9_]{3,20}$/.test(username.value.trim())) {
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

                    if (isValid) {
                        // Simulate successful login and redirect to dashboard
                        // In a real app, this would be handled by the server
                        window.location.href = '<?php echo base_url('superadmin/dashboard'); ?>';
                    }
                }

                if (form.id === 'forgot-password-form') {
                    const email = form.querySelector('input[name="email"]');
                    const emailError = document.getElementById('forgot-email-error');

                    if (!email.value.trim()) {
                        emailError.textContent = 'Email is required';
                        email.classList.add('error');
                        isValid = false;
                    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
                        emailError.textContent = 'Invalid email format';
                        email.classList.add('error');
                        isValid = false;
                    }

                    if (isValid) {
                        form.submit(); // Submit to server for actual processing
                    }
                }
            });
        });
    </script>
</body>
</html>