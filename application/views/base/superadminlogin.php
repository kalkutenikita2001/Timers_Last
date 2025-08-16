<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Boxicons CSS -->
    <link href='https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css' rel='stylesheet'>
    <title>Super Admin Login</title>
    <style>
        /* Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap');

        /* Variables CSS */
        :root {
            --first-color: linear-gradient(90deg, #ff4040, #470000);
            --first-color-dark: #2c2f33;
            --first-color-light: #A49EAC;
            --first-color-lighten: #FFFFFF;
            --shadow: 0 8px 20px rgba(35, 0, 77, .2);
            --body-font: 'Open Sans', sans-serif;
            --h1-font-size: clamp(1.5rem, 4vw, 1.75rem);
            --normal-font-size: clamp(0.875rem, 2vw, 1rem);
            --small-font-size: clamp(0.75rem, 1.5vw, 0.875rem);
            --transition: all 0.3s ease;
        }

        /* Base Styles */
        *, ::before, ::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--body-font);
            font-size: var(--normal-font-size);
            color: var(--first-color-dark);
            background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        h1 {
            margin: 0;
            font-size: var(--h1-font-size);
            font-weight: 700;
        }

        a {
            text-decoration: none;
            transition: var(--transition);
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
        }

        /* Login Container */
        .login {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login__content {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            gap: clamp(1rem, 3vw, 2rem);
        }

        .login__img {
            text-align: center;
            margin-bottom: 1rem;
        }

        .login__img img {
            width: min(50vw, 250px);
            border-radius: 0.5rem;
        }

        .login__forms {
            position: relative;
            width: 100%;
            max-width: 400px;
            min-height: 350px;
        }

        .login__registre, .login__forgot-form {
            position: absolute;
            top: 0;
            width: 100%;
            background-color: var(--first-color-lighten);
            padding: clamp(1.5rem, 4vw, 2rem);
            border-radius: 1rem;
            text-align: center;
            box-shadow: var(--shadow);
            transition: var(--transition);
            opacity: 0;
            transform: scale(0.95);
        }

        .block {
            opacity: 1;
            transform: scale(1);
            z-index: 1;
        }

        .none {
            opacity: 0;
            transform: scale(0.95);
            pointer-events: none;
        }

        .login__title {
            margin-bottom: 1.5rem;
            color: var(--first-color-dark);
        }

        .login__box {
            display: flex;
            align-items: center;
            background-color: #F8F9FA;
            margin-top: 1rem;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            transition: var(--transition);
            border: 1px solid #ddd;
            position: relative;
        }

        .login__box:focus-within {
            border-color: #ff4040;
            box-shadow: 0 0 0 0.2rem rgba(255, 64, 64, 0.25);
        }

        .login__icon {
            font-size: 1.5rem;
            background: var(--first-color);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-right: 0.5rem;
        }

        .login__input {
            border: none;
            outline: none;
            font-size: var(--normal-font-size);
            font-weight: 600;
            color: var(--first-color-dark);
            background: transparent;
            width: 100%;
            padding-right: 2rem; /* Space for eye icon */
        }

        .login__input::placeholder {
            color: var(--first-color-light);
            font-weight: 400;
        }

        .login__forgot {
            display: block;
            margin: 0.75rem auto 0;
            font-size: var(--small-font-size);
            font-weight: 600;
            color: #ff4040;
        }

        .login__forgot:hover {
            color: #470000;
            text-decoration: underline;
        }

        .login__button {
            width: 100%;
            padding: 1rem;
            margin: 1.5rem 0;
            background: var(--first-color);
            color: #FFF;
            font-weight: 600;
            border-radius: 0.5rem;
            border: none;
            cursor: pointer;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .login__button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 64, 64, 0.3);
        }

        .login__button:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .login__button::after {
            content: 'Loading...';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: var(--first-color);
        }

        .login__button.loading::after {
            display: flex;
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
            text-decoration: underline;
        }

        /* Password Toggle Button */
        .login__toggle-password {
            position: absolute;
            right: 1rem;
            font-size: 1.2rem;
            background: var(--first-color);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            cursor: pointer;
            transition: var(--transition);
        }

        .login__toggle-password:hover {
            transform: scale(1.1);
        }

        /* Validation Styles */
        .error {
            border-color: #ff4d4d;
            background: #ffeaea;
        }

        .error-message {
            color: #ff4d4d;
            font-size: var(--small-font-size);
            margin-top: 0.25rem;
            text-align: left;
            display: none;
            padding: 0.25rem 0.5rem;
            background: #fff;
            border-radius: 0.25rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .error + .error-message {
            display: block;
        }

        /* Media Queries */
        @media screen and (min-width: 576px) {
            .login__forms {
                max-width: 360px;
                margin: 0 auto;
            }

            .login__img img {
                width: 280px;
            }
        }

        @media screen and (min-width: 768px) {
            .login__content {
                flex-direction: row;
                gap: 3rem;
                align-items: center;
                justify-content: center;
            }

            .login__img {
                margin-bottom: 0;
            }

            .login__img img {
                width: 320px;
            }

            .login__forms {
                min-height: 420px;
            }
        }

        @media screen and (min-width: 1024px) {
            .login__img {
                width: 50%;
                max-width: 600px;
                border-radius: 1rem;
                padding: 1.5rem;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .login__img img {
                width: 400px;
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
                <img src="<?php echo base_url('assets/images/timeersbadmintonacademy_logo.png'); ?>" alt="Logo" aria-label="Timeers Badminton Academy Logo">
            </div>

            <div class="login__forms">
                <!-- Sign In Form -->
                <form action="<?php echo base_url('auth/superadminlogin'); ?>" class="login__registre block" id="login-in" aria-labelledby="signin-title">
                    <h1 class="login__title" id="signin-title">Super Admin Sign In</h1>
                    <div class="login__box">
                        <i class='bx bx-user login__icon' aria-hidden="true"></i>
                        <input type="text" name="username" placeholder="Username" class="login__input" required aria-describedby="login-username-error">
                        <div class="error-message" id="login-username-error"></div>
                    </div>
                    <div class="login__box">
                        <i class='bx bx-lock-alt login__icon' aria-hidden="true"></i>
                        <input type="password" name="password" placeholder="Password" class="login__input" required aria-describedby="login-password-error">
                        <i class='bx bx-show login__toggle-password' aria-label="Toggle password visibility"></i>
                        <div class="error-message" id="login-password-error"></div>
                    </div>
                    <a href="#" class="login__forgot" id="forgot-password" aria-label="Forgot Password">Forgot password?</a>
                    <button type="submit" class="login__button">Sign In</button>
                </form>

                <!-- Forgot Password Form -->
                <form action="<?php echo base_url('auth/superadmin_reset_password'); ?>" class="login__forgot-form none" id="forgot-password-form" aria-labelledby="forgot-password-title">
                    <h1 class="login__title" id="forgot-password-title">Super Admin Forgot Password</h1>
                    <div class="login__box">
                        <i class='bx bx-at login__icon' aria-hidden="true"></i>
                        <input type="email" name="email" placeholder="Email" class="login__input" required aria-describedby="forgot-email-error">
                        <div class="error-message" id="forgot-email-error"></div>
                    </div>
                    <button type="submit" class="login__button">Reset Password</button>
                    <div>
                        <span class="login__account">Back to </span>
                        <span class="login__signup" id="back-to-sign-in" role="button" aria-label="Back to Sign In">Sign In</span>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Form navigation
        const forgotPassword = document.getElementById('forgot-password');
        const backToSignIn = document.getElementById('back-to-sign-in');
        const loginIn = document.getElementById('login-in');
        const forgotPasswordForm = document.getElementById('forgot-password-form');

        function toggleForm(showForm, hideForms) {
            showForm.classList.remove('none');
            showForm.classList.add('block');
            hideForms.forEach(form => {
                form.classList.remove('block');
                form.classList.add('none');
            });
        }

        forgotPassword.addEventListener('click', (e) => {
            e.preventDefault();
            toggleForm(forgotPasswordForm, [loginIn]);
            forgotPasswordForm.querySelectorAll('.login__input').forEach(input => input.classList.remove('error'));
            forgotPasswordForm.querySelectorAll('.error-message').forEach(error => error.textContent = '');
        });

        backToSignIn.addEventListener('click', (e) => {
            e.preventDefault();
            toggleForm(loginIn, [forgotPasswordForm]);
            loginIn.querySelectorAll('.login__input').forEach(input => input.classList.remove('error'));
            loginIn.querySelectorAll('.error-message').forEach(error => error.textContent = '');
        });

        // Password visibility toggle
        document.querySelectorAll('.login__toggle-password').forEach(toggle => {
            toggle.addEventListener('click', () => {
                const input = toggle.previousElementSibling;
                if (input.type === 'password') {
                    input.type = 'text';
                    toggle.classList.remove('bx-show');
                    toggle.classList.add('bx-hide');
                } else {
                    input.type = 'password';
                    toggle.classList.remove('bx-hide');
                    toggle.classList.add('bx-show');
                }
            });
        });

        // Form validation and submission
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                let isValid = true;

                // Clear previous errors
                form.querySelectorAll('.login__input').forEach(input => input.classList.remove('error'));
                form.querySelectorAll('.error-message').forEach(error => error.textContent = '');

                const button = form.querySelector('.login__button');
                button.disabled = true;
                button.classList.add('loading');

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
                    } else if (password.value.length < 8) {
                        passwordError.textContent = 'Password must be at least 8 characters';
                        password.classList.add('error');
                        isValid = false;
                    }

                    if (isValid) {
                        try {
                            // Simulate async server call
                            await new Promise(resolve => setTimeout(resolve, 1000));
                            window.location.href = '<?php echo base_url('superadmin/dashboard'); ?>';
                        } catch (error) {
                            alert('Login failed. Please try again.');
                        }
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
                        try {
                            // Simulate async server call
                            await new Promise(resolve => setTimeout(resolve, 1000));
                            form.submit();
                        } catch (error) {
                            alert('Password reset failed. Please try again.');
                        }
                    }
                }

                button.disabled = false;
                button.classList.remove('loading');
            });

            // Real-time validation
            form.querySelectorAll('.login__input').forEach(input => {
                input.addEventListener('input', () => {
                    const errorMessage = input.nextElementSibling;
                    input.classList.remove('error');
                    errorMessage.textContent = '';

                    if (form.id === 'login-in' && input.name === 'username') {
                        if (input.value.trim() && !/^[a-zA-Z0-9_]{3,20}$/.test(input.value.trim())) {
                            errorMessage.textContent = 'Username must be 3-20 characters, alphanumeric or underscore';
                            input.classList.add('error');
                        }
                    }

                    if (form.id === 'forgot-password-form' && input.name === 'email') {
                        if (input.value.trim() && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value.trim())) {
                            errorMessage.textContent = 'Invalid email format';
                            input.classList.add('error');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>