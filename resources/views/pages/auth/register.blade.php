<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <title>Responsive Auth UI</title> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            background-color: #f9fafb;
        }
        .auth-container {
            max-width: 700px;
            margin: auto;
            padding: 30px;
            background: whitealiceblue;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .form-control-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            /* transform: translateY(-50%);
            color: #888; */
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
        .small-btn {        
            font-size: 12px;  /* Make text smaller */
            padding: 4px 8px; /* Reduce padding */
            width: auto;      /* Adjust width automatically */
            min-width: 80px;  /* Set a minimum width */
            border-radius: 10px; /* Keep rounded shape but smaller */
        }

    </style>
    <script>
        const base_url = "{{env('API_BASE_URL')}}";
    </script>
    <title>Register-Page</title>
</head>
<body>
     
    <div class="d-flex min-vh-100 justify-content-center align-items-center">
        <div class="auth-container">
        <div class="d-flex align-items-center mb-4">
    <!-- Back Button -->
    <button class="btn p-0 me-2 rounded-circle" onclick="window.history.back()" style="border: none; background: transparent;">
        <svg class="custom-icon" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 16 16">
            <!-- Outer Circle -->
            <path class="circle" fill="white" d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0"/>
            <!-- Inner Arrow -->
            <path class="arrow" fill="black" d="M11.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5z"/>
        </svg>
    </button>

    <!-- Heading -->
    <h2 class="m-0" style="font-size: 32px">Welcome to Ready Server</h2>
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

            
            <form id="auth-form ">
                <div class="mb-4 form-group ">
                    <i class="fas fa-envelope form-control-icon "></i>
                    <input type="email" id="email" class="form-control ps-4 rounded-pill" style="
                        height: 50px;
                        "placeholder="Email address" required>
                </div>
                <div class="mb-4 form-group">
                    <input type="password" id="password" class="form-control ps-4 pe-5 rounded-pill" style="
                        height: 50px; "placeholder="Password" required>
                    <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
                </div>
                <div id="otp-section" class="mb-3 form-group d-none" >
                    <input type="text" id="otp" class="form-control ps-4 rounded-pill" style="
                    height: 50px; " placeholder="Enter OTP">
                </div>
                <button type="button" class="btn btn-primary w-100 "style="border-radius: 30px; height: 50px;" id="submit-btn">Sign Up</button>
            </form>
        </div>
    </div>
    
    <script>
        let sessionToken = '';
        let isSignUp = true;
        let otpSent = false;

        function togglePassword() {
            let passwordInput = document.getElementById('password');
            let icon = document.querySelector('.toggle-password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        function toggleForm(signUp) {
            // isSignUp = signUp;
            // document.getElementById('otp-section').classList.add('d-none');
            // document.getElementById('submit-btn').textContent = signUp ? 'Sign Up' : 'Log In';
        }

        document.getElementById('submit-btn').addEventListener('click', function () {
            if(otpSent) this.innerHTML = 'Verify Token';

            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            
            if (!email || !password) {
                alert('Please fill in all fields.');
                return;
            }

            try{
                if (isSignUp) {
                    if (!otpSent) {
                        // Start Registration
                        fetch(`${base_url}/apv/registration/start`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ email })
                        })
                        .then(res => res.json())
                        .then(data => {
                            console.log(data)

                            if (data?.errorCode) return alert('Error: ' + data?.message);

                            sessionToken = data.sessionToken;
                            alert('OTP sent to your email!');
                            document.getElementById('otp-section').classList.remove('d-none');
                            document.getElementById('submit-btn').textContent = 'Verify OTP';
                            otpSent = true;
                        })
                        .catch(err => alert('Error: ' + err.message));
                    } else {
                        // Verify OTP
                        const otp = document.getElementById('otp').value;
                        fetch(`${base_url}/apv/registration/verify-otp`, {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ sessionToken, otp })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'OTP_Verified') {
                                alert('OTP Verified! Completing registration...');
                                return fetch(`${base_url}/apv/registration/complete`, {
                                    method: 'POST',
                                    headers: { 'Content-Type': 'application/json' },
                                    body: JSON.stringify({ sessionToken, email, password })
                                });
                            } else {
                                throw new Error('Invalid OTP');
                            }
                        })
                        .then(res => res.json())
                        .then(() => {
                            alert('Registration Complete!');
                            window.location = '/dashboard';
                        })
                        .catch(err => alert('Error: ' + err.message));
                    }
                } else {
                    // Login
                    fetch(`${base_url}/apv/auth/login`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ email, password, userType: 'USER', authType: 'EMAIL_PASSWORD' })
                    })
                    .then(res => res.json())
                    .then(data => {
                        localStorage.setItem('user', JSON.stringify(data));
                        localStorage.setItem('token', data.sessionToken);
                        alert('Login Successfully!');
                        window.location = '/dashboard';
                    })
                    .catch(err => alert('Error logging in: ' + err.message));
                }
            }
            catch(err){
                err => alert('Error: ' + err.message)
            }
        });
    </script>
</body>
</html>