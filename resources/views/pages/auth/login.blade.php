<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f9fafb;
        }
        .auth-container {
            max-width: 700px;
            margin: auto;
            padding: 50px;
            background: whitealiceblue;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .form-control-icon {
            /* position: absolute; */
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }
        .form-group {
            position: relative;
        }
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
        .custom-icon .arrow {
            fill: black;
            transition: fill 0.3s ease;
        }

        .custom-icon:hover .arrow {
            fill: black; /* Change this to any color you want */
        }
    </style>
    <script>
        const base_url = "{{env('API_BASE_URL')}}";
    </script>
</head>
<body>
    <div class="d-flex min-vh-100 justify-content-center align-items-center">
        <div class="auth-container">
        <div class="d-flex align-items-center mb-3">
    <!-- Back Button with Icon -->
    <button class="btn p-0 me-1" onclick="window.history.back()" style="border: none; background: transparent;">
        <svg class="custom-icon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 16 16">
            <!-- Outer Circle -->
            <path class="circle" fill="white" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0"/>
            <!-- Inner Arrow -->
            <path class="arrow" fill="black" d="M11.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
        </svg>
    </button>

    <!-- Heading -->
    <h2 class="m-0" style="font-size: 32px;">Welcome to Ready Server</h2>
</div>

            <div class="gap-2 mb-3">
    <div class="d-flex mb-4">
        <!-- Login Button -->
        <a href="{{ route('login') }}" 
           class="btn btn-outline-primary flex-fill {{ request()->routeIs('login') ? 'btn-primary text-white' : '' }}" 
           style="border-radius: 20px; width: 10%;">
           Log In
        </a>

        <!-- Sign-Up Button -->
        <a href="{{ route('register') }}" 
           class="btn btn-outline-primary flex-fill {{ request()->routeIs('register') ? 'btn-primary text-white' : '' }}" 
           style="border-radius: 20px; width: 10%;">
           Sign Up
        </a>
    </div>
</div>

            
            <form id="auth-form">
                <div class="mb-4 form-group">
                    <i class="fas fa-envelope form-control-icon"></i>
                    <input type="email" id="email" class="form-control ps-4 rounded-pill"style="
                        height: 50px;" placeholder="Email address" required>
                </div>
                <div class="mb-4 form-group">
                    <input type="password" id="password" class="form-control ps-4 pe-5 rounded-pill"style="
                        height: 50px;" placeholder="Password" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                </div>
                
                <button type="button" class="btn btn-primary w-100 rounded-pill" id="submit-btn" style="
                        height: 50px;">Login</button>
                <div class="d-flex justify-content-end mb-3 mt-2">
                    <a href="{{ route('forget.password') }}" class="text-primary">Forgot Password?</a>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        // let sessionToken = '';
        // let isSignUp = true;

        // function togglePassword() {
        //     let passwordInput = document.getElementById('password');
        //     let icon = document.querySelector('.toggle-password');
        //     if (passwordInput.type === 'password') {
        //         passwordInput.type = 'text';
        //         icon.classList.replace('fa-eye', 'fa-eye-slash');
        //     } else {
        //         passwordInput.type = 'password';
        //         icon.classList.replace('fa-eye-slash', 'fa-eye');
        //     }
        // }

        // function toggleForm(signUp) {
        //     isSignUp = signUp;
        //     document.getElementById('otp-section').classList.add('d-none');
        //     document.getElementById('submit-btn').textContent = signUp ? 'Sign Up' : 'Log In';
        // }

        document.getElementById('submit-btn').addEventListener('click', function () {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    if (!email || !password) {
        alert('Please fill in all fields.');
        return;
    }

    fetch(`${base_url}/apv/auth/login`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            email,
            password,
            userType: 'USER',
            authType: 'EMAIL_PASSWORD'
        })
    })
    .then(async res => {
        if (!res.ok) {
            // Handle HTTP errors
            const errorData = await res.json();
            throw new Error(errorData.message || 'Login failed. Please check your credentials.');
        }
        return res.json();
    })
    .then(data => {
        if (data && data.sessionToken) {
            // Store session data
            localStorage.setItem('user', JSON.stringify(data));
            localStorage.setItem('token', data.sessionToken);
            alert('Login Successfully!');
            window.location.href = '/dashboard';
        } else {
            throw new Error('Invalid response from server.');
        }
    })
    .catch(err => {
        alert('Error logging in: ' + err.message);
    });
});

    </script>
</body>
</html>