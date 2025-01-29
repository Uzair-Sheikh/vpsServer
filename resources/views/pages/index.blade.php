@extends('layout.main')
@section('content')
<div class="page-container">
    @include('component.navigation')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Profile</h2>
                        </div>
                    </div>
                </div>

                <div class="row m-t-25">
                    <div class="col-lg-12" id="Profile">
                        <div class="card">
                            <div class="card-header">User Profile</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="title">Full Name</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="full-name"></span>
                                    </div>
                                    
                                    <div class="col-6">
                                        <span class="title">Email Address</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="user-mail"></span>
                                    </div>
                                    
                                    {{-- <div class="col-6">
                                        <span class="title">Phone No#</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="ph">+92304-9298665</span>
                                    </div> --}}
                                    
                                    {{-- <div class="col-6">
                                        <span class="title">Birthday</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="dob">02-JAN-2001</span>
                                    </div> --}}
                                    
                                    <div class="col-6">
                                        <span class="title">Gender</span>
                                    </div>
                                    <div class="col-6">
                                        <span id="user-gender">Male</span>
                                    </div>
                                    
                                    <div class="col-6">
                                        <span class="title">Complete Address</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="complete-address"></span>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="overview-wrap">
                            <h2 class="title-1">Update Profile</h2>
                        </div>
                    </div>
                </div>

                <div class="row m-t-25">
                    <div class="col-lg-12" id="UpdateProfile">
                        <div class="card">
                            <div class="card-header">Update Profile</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-6 mt-2">
                                        <label for="cc-payment" class="control-label mb-1">Full Name</label>
                                        <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Enter Full Name">
                                    </div>

                                    {{-- <div class="col-lg-6">
                                        <label for="cc-payment" class="control-label mb-1">Last Name</label>
                                        <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Enter Last Name">
                                    </div> --}}
                                    
                                    <div class="col-lg-6 mt-2">
                                        <label for="cc-payment" class="control-label mb-1">Email Address</label>
                                        <input type="email" class="form-control" id="emailAddress" name="emailAddress" placeholder="Enter Email Address">
                                    </div>
                                    
                                    {{-- <div class="col-lg-6">
                                        <label for="cc-payment" class="control-label mb-1">Phone Number</label>
                                        <input type="text" class="form-control" id="ph" name="ph" placeholder="Enter Phone Number">
                                    </div> --}}

                                    {{-- <div class="col-lg-6">
                                        <label for="cc-payment" class="control-label mb-1">Birthday</label>
                                        <input type="date" class="form-control" id="dob" name="dob" placeholder="Enter your birthday">
                                    </div> --}}

                                    <div class="col-lg-6 mt-2">
                                        <label for="cc-number" class="control-label mb-1">Select Gender</label>
                                        <select id="gender" name="gender" class="form-control">
                                            <option value="">Select Gender</option>
                                            <option value="0">Male</option>
                                            <option value="1">Female</option>
                                            <option value="2">Other</option>
                                        </select>
                                    </div>

                                    <div class="col-lg-6 mt-2">
                                        <label for="cc-payment" class="control-label mb-1">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter your address">
                                    </div>
                                    
                                    <div class="col-lg-4 mt-2">
                                        <label for="cc-payment" class="control-label mb-1">Postal Code</label>
                                        <input type="text" class="form-control" id="postalCode" name="postalCode" placeholder="Enter your postal code">
                                    </div>

                                    <div class="col-lg-4 mt-2">
                                        <label for="cc-payment" class="control-label mb-1">State</label>
                                        <input type="text" class="form-control" id="state" name="state" placeholder="Enter your state">
                                    </div>
                                    
                                    <div class="col-lg-4 mt-2">
                                        <label for="cc-payment" class="control-label mb-1">Country</label>
                                        <input type="text" class="form-control" id="country" name="country" placeholder="Enter your country">
                                    </div>
                                </div>
                                
                                <div class="mt-2">
                                    <button id="update-profile-button" onclick="updateProfile()" type="button" class="btn btn-lg btn-info btn-block">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

</div>

<script>
    async function updateProfile() {
        const fdata = {
            firstName: document.getElementById('firstName').value,
            // lastName: document.getElementById('lastName').value,
            email: document.getElementById('emailAddress').value,
            // mobileNo: document.getElementById('ph').value,
            // dateOfBirth: document.getElementById('dob').value,
            gender: document.getElementById('gender').value,
            address: document.getElementById('address').value,
            postalCode: document.getElementById('postalCode').value,
            state: document.getElementById('state').value,
            country: document.getElementById('country').value,
        };

        try {
            const response = await fetch(`${API_URL}/profile`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(fdata),
            });

            if (response.ok) {
                const data = await response.json();
                showAlert(`Profile has been updated!` , 'success');
                getProfile();
                getUserProfile();
            } else {
                const error = await response.json();
                showAlert(`Error updating profile: ${error.message}` , 'error');
            }
        } catch (err) {
            showAlert(`Error updating profile: ${err}` , 'error');
        }
    }

    async function getUserProfile() {
        try {
            if (!token) {
                console.error('Token is missing!');
                return;
            }

            const response = await fetch(`${API_URL}/profile`, {
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${token}`,
                }
            });

            if (response.ok) {
                const data = await response.json();
                const profile = data.profile || {};
                let genderValue;
                // const dob = new Date(profile.dateOfBirth);
                
                if (profile.gender == "MALE") {
                    genderValue = 0;
                } else if (profile.gender === "FEMALE") {
                    genderValue = 1;
                } else {
                    genderValue = 2;
                }
                document.querySelector('.full-name').innerHTML = `${profile.firstName || ''}`.trim() || '-';
                document.querySelector('.user-mail').innerHTML = data.email || '-';
                // document.querySelector('.ph').innerHTML = data.mobileNo ? `${data.mobileCountryCode || ''}${data.mobileNo}` : '-';
                // document.querySelector('.dob').innerHTML = profile.dateOfBirth || '-';
                document.getElementById('user-gender').innerHTML = profile.gender || '-';
                document.querySelector('.complete-address').innerHTML = `${profile.address || ''}, ${profile.postalCode || ''}, ${profile.state || ''}, ${profile.country || ''}`.trim() || '-';
                document.querySelector('#firstName').value = `${profile.firstName || '-'}`;
                // document.querySelector('#lastName').value = `${profile.lastName || '-'}`;
                document.querySelector('#emailAddress').value = `${data.email || '-'}`;
                // document.querySelector('#ph').value = `${data.mobileNo || '-'}`;
                // document.querySelector('#dob').value = `${dob.toLocaleDateString('en-GB') || '-'}`;
                document.querySelector('#gender').value = genderValue;
                document.querySelector('#address').value = `${profile.address || '-'}`;
                document.querySelector('#postalCode').value = `${profile.postalCode || '-'}`;
                document.querySelector('#state').value = `${profile.state || '-'}`;
                document.querySelector('#country').value = `${profile.country || '-'}`;
            } else {
                const error = await response.json();
                showAlert(`Error: ${error.message}`);
            }
        } catch (err) {
            console.error('Error fetching profile:', err);
        }
    }

    getUserProfile();

</script>
@endsection