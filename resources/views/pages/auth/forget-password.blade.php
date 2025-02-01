<!DOCTYPE html>
<html lang="en">
<head>
    @include('component.head')
    <script>
        const token = localStorage.getItem('token');
        if(token) window.location = '/dashboard';
    </script>
</head>
<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                
                    <div class="login-content">

                        <!-- Start Password Reset Form -->
                        <form id="start-form">
                        <h2 class="mb-3 text-center">Forget Password</h2>
                            <div class="mb-3 ">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="au-input au-input--full"style="border-radius:20px" id="email" name="email" placeholder="Enter your email" required>
                            </div>
                            <button type="button" class="au-btn au-btn--block au-btn--blue2--block m-b-18 h-6" id="start-button"style="color:white;border-radius:20px; height:46px; background:rgb(31, 101, 252)">Start Password Reset</button>
                            <div class="register-link">
                                <p>
                                    Have an account?
                                    <a href="{{url('/login')}}">Sign In Here</a>
                                </p>
                            </div>
                        </form>

                        <!-- OTP Verification Form -->
                        <form id="otp-form" class="mt-4 d-none">
                            <div class="mb-3">
                                <label for="otp" class="form-label">OTP</label>
                                <input type="text" class="au-input au-input--full" id="otp" name="otp" placeholder="Enter OTP" required style="border-radius: 20px;">
                            </div>
                            <button type="button" class="btn btn-primary w-100 mb-3" id="verify-button" style="height: 50px; border-radius: 20px;">Verify OTP</button>
                        </form>

                        <!-- Reset Password Form -->
                        <form id="complete-form" class="mt-4 d-none">
                            <div class="mb-3">
                                <label for="new-password" class="form-label">New Password</label>
                                <input type="password" class="au-input au-input--full" id="new-password" name="new-password" placeholder="Enter new password" required>
                            </div>
                            <button type="button" class="au-btn au-btn--block au-btn--green m-b-20" id="reset-button">Reset Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    @include('component.script')
    <script>
        let sessionToken = '';
        const base_url = `{{env('API_BASE_URL')}}`;
    
        document.getElementById('start-button').addEventListener('click', async function () {
            const email = document.getElementById('email').value;
    
            try {
                const response = await fetch(`${base_url}/apv/auth/request-reset-password`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email,
                        userType: 'USER',
                        authType: 'EMAIL_PASSWORD',
                    }),
                });
    
                if (!response.ok) {
                    throw new Error(await response.text());
                }
    
                const data = await response.json();
                sessionToken = data.sessionToken;
                showAlert('OTP sent to your email!', 'success');
                document.getElementById('start-form').classList.add('d-none');
                document.getElementById('otp-form').classList.remove('d-none');
            } catch (error) {
                showAlert('Error starting password reset: ' + error.message, 'error');
            }
        });
    
        // Verify OTP
        document.getElementById('verify-button').addEventListener('click', async function () {
            const otp = document.getElementById('otp').value;
    
            try {
                const response = await fetch(`${base_url}/apv/auth/verify-reset-password`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        otp
                    }),
                });
    
                if (!response.ok) {
                    throw new Error(await response.text());
                }
    
                const data = await response.json();
    
                if (data.status === 'OTP_Verified') {
                    showAlert('OTP Verified!', 'success');
                    document.getElementById('otp-form').classList.add('d-none');
                    document.getElementById('complete-form').classList.remove('d-none');
                }
            } catch (error) {
                showAlert('Error verifying OTP: ' + error.message, 'error');
            }
        });
    
        // Reset Password (Complete Password Reset)
        document.getElementById('reset-button').addEventListener('click', async function () {
            const email = document.getElementById('email').value;
            const newPassword = document.getElementById('new-password').value;
    
            try {
                const response = await fetch(`${base_url}/apv/auth/reset-password`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        email,
                        newPassword,
                    }),
                });
    
                if (!response.ok) {
                    throw new Error(await response.text());
                }
    
                showAlert('Password reset successfully!', 'success');
                window.location = '/login';
            } catch (error) {
                showAlert('Error resetting password: ' + error.message, 'error');
            }
        });
    </script>
    
</body>
</html>