<?php
session_start();
include("db_conn.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Please login first'); window.location.href='user_login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];
$success_message = '';
$error_message = '';

// Fetch current user data
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
$user_data = mysqli_fetch_assoc($result);

if (!$user_data) {
    echo "<script>alert('User not found'); window.location.href='user_login.php';</script>";
    exit;
}

// Handle form submission
if (isset($_POST['update_data'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $village = mysqli_real_escape_string($conn, $_POST['village']);
    $po = mysqli_real_escape_string($conn, $_POST['po']);
    $ps = mysqli_real_escape_string($conn, $_POST['ps']);
    $district = mysqli_real_escape_string($conn, $_POST['district']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);
    $pin = mysqli_real_escape_string($conn, $_POST['pincode']);
    
    // Check if email already exists for another user
    $check_email = "SELECT * FROM users WHERE email = '$email' AND id != '$user_id'";
    $email_result = mysqli_query($conn, $check_email);
    
    if (mysqli_num_rows($email_result) > 0) {
        $error_message = 'Email already exists for another user';
    } else {
        // Update user data
        $update_sql = "UPDATE users SET 
            name = '$name', 
            email = '$email', 
            dob = '$dob', 
            gender = '$gender', 
            phone = '$phone', 
            village = '$village', 
            post_office = '$po', 
            police_station = '$ps', 
            district = '$district', 
            state = '$state', 
            pin_code = '$pin' 
            WHERE id = '$user_id'";
        
        if (mysqli_query($conn, $update_sql)) {
            $success_message = 'Profile updated successfully!';
            // Refresh user data
            $result = mysqli_query($conn, "SELECT * FROM users WHERE id = '$user_id'");
            $user_data = mysqli_fetch_assoc($result);
            $_SESSION['user_name'] = $user_data['name'];
        } else {
            $error_message = 'Error updating profile: ' . mysqli_error($conn);
        }
    }
}

// Handle password update
if (isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Verify current password
    if ($current_password !== $user_data['password']) {
        $error_message = 'Current password is incorrect';
    } elseif ($new_password !== $confirm_password) {
        $error_message = 'New passwords do not match';
    } elseif (strlen($new_password) < 6) {
        $error_message = 'Password must be at least 6 characters long';
    } else {
        // Update password
        $password_sql = "UPDATE users SET password = '$new_password' WHERE id = '$user_id'";
        if (mysqli_query($conn, $password_sql)) {
            $success_message = 'Password updated successfully!';
        } else {
            $error_message = 'Error updating password: ' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile - Voting System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <style>
        .tab-content { display: none; }
        .tab-content.active { display: block; }
        .tab-button.active {
            background-color: #2563eb;
            color: white;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-slate-50 via-white to-slate-100 min-h-screen">


    <!-- Main Content -->
    <div class="max-w-6xl mx-auto px-4 py-8">
        <!-- Page Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Update Your Profile</h1>
            <p class="text-gray-600">Keep your information up to date</p>
        </div>

        <!-- Alert Messages -->
        <?php if ($success_message): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                <span class="block sm:inline"><?php echo htmlspecialchars($success_message); ?></span>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <span class="block sm:inline"><?php echo htmlspecialchars($error_message); ?></span>
            </div>
        <?php endif; ?>

        <!-- Tab Navigation -->
        <div class="flex space-x-1 bg-gray-100 p-1 rounded-lg mb-8 max-w-md mx-auto">
            <button class="tab-button active flex-1 py-2 px-4 rounded-md text-sm font-medium transition-colors" 
                    onclick="showTab('profile')">
                Profile Details
            </button>
            <button class="tab-button flex-1 py-2 px-4 rounded-md text-sm font-medium transition-colors" 
                    onclick="showTab('password')">
                Change Password
            </button>
        </div>

        <!-- Profile Details Tab -->
        <div id="profile-tab" class="tab-content active">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-6 md:p-10">
                    <form id="profileForm" class="space-y-8" action="#" method="post" novalidate>
                        <!-- Personal Information Section -->
                        <div>
                            <h2 class="text-lg font-semibold text-slate-700 mb-4">Personal Information</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                                    <input type="text" name="name" value="<?php echo htmlspecialchars($user_data['name']); ?>"
                                        class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                                    <input type="email" name="email" value="<?php echo htmlspecialchars($user_data['email']); ?>"
                                        class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Date of Birth</label>
                                    <input type="date" name="dob" value="<?php echo htmlspecialchars($user_data['dob']); ?>"
                                        class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Phone Number</label>
                                    <input type="tel" name="phone" value="<?php echo htmlspecialchars($user_data['phone']); ?>"
                                        class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-slate-700 mb-2">Gender</label>
                                    <div class="flex items-center gap-6 border border-slate-300 rounded-md px-3 py-2 bg-slate-50">
                                        <label class="inline-flex items-center gap-2 text-slate-700">
                                            <input type="radio" name="gender" value="male" class="h-4 w-4" 
                                                <?php echo ($user_data['gender'] == 'male') ? 'checked' : ''; ?>> 
                                            <span>Male</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 text-slate-700">
                                            <input type="radio" name="gender" value="female" class="h-4 w-4"
                                                <?php echo ($user_data['gender'] == 'female') ? 'checked' : ''; ?>> 
                                            <span>Female</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Address Details Section -->
                        <div>
                            <h2 class="text-lg font-semibold text-slate-700 mb-4">Address Details</h2>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Village</label>
                                    <input type="text" name="village" value="<?php echo htmlspecialchars($user_data['village']); ?>"
                                        class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Post Office</label>
                                    <input type="text" name="po" value="<?php echo htmlspecialchars($user_data['post_office']); ?>"
                                        class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Police Station</label>
                                    <input type="text" name="ps" value="<?php echo htmlspecialchars($user_data['police_station']); ?>"
                                        class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">District</label>
                                    <input type="text" name="district" value="<?php echo htmlspecialchars($user_data['district']); ?>"
                                        class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">State</label>
                                    <input type="text" name="state" value="<?php echo htmlspecialchars($user_data['state']); ?>"
                                        class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Pincode</label>
                                    <input type="text" name="pincode" value="<?php echo htmlspecialchars($user_data['pin_code']); ?>"
                                        class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex items-center justify-between pt-4">
                            <a href="user_dashbord.php" class="text-blue-600 hover:text-blue-800 font-medium">
                                ← Back to Dashboard
                            </a>
                            <div class="flex items-center gap-3">
                                <button type="reset" class="px-4 py-2 rounded-md border border-slate-300 text-slate-700 hover:bg-slate-50">
                                    Reset
                                </button>
                                <button type="submit" name="update_data" 
                                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition">
                                    Update Profile
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Password Change Tab -->
        <div id="password-tab" class="tab-content">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <div class="p-6 md:p-10">
                    <form id="passwordForm" class="space-y-6" action="#" method="post" novalidate>
                        <div class="text-center mb-6">
                            <h3 class="text-lg font-semibold text-gray-900">Change Your Password</h3>
                            <p class="text-gray-600">Enter your current password and choose a new one</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                            <input type="password" name="current_password" 
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                            <input type="password" name="new_password" id="new_password"
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                            <input type="password" name="confirm_password" 
                                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-600 focus:border-blue-600">
                        </div>

                        <div class="flex items-center justify-between pt-4">
                            <a href="user_dashbord.php" class="text-blue-600 hover:text-blue-800 font-medium">
                                ← Back to Dashboard
                            </a>
                            <button type="submit" name="update_password" 
                                class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700 transition">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Remove active class from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => button.classList.remove('active'));
            
            // Show selected tab content
            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
        }

        $(document).ready(function() {
            // Profile form validation
            $("#profileForm").validate({
                rules: {
                    name: { required: true, minlength: 3 },
                    email: { required: true, email: true },
                    dob: { required: true },
                    gender: { required: true },
                    phone: { required: true, digits: true, minlength: 10, maxlength: 10 },
                    village: { required: true },
                    po: { required: true },
                    ps: { required: true },
                    district: { required: true },
                    state: { required: true },
                    pincode: { required: true, digits: true, minlength: 6, maxlength: 6 }
                },
                messages: {
                    name: "Please enter your name (min 3 letters)",
                    email: "Enter a valid email",
                    dob: "Select your date of birth",
                    gender: "Select your gender",
                    phone: "Enter a valid 10-digit phone number",
                    village: "Enter your village",
                    po: "Enter your post office",
                    ps: "Enter your police station",
                    district: "Enter your district",
                    state: "Enter your state",
                    pincode: "Enter a valid 6-digit pincode"
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "gender") {
                        error.insertAfter(element.closest('div'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function(element) {
                    $(element).addClass('border-red-500 ring-2 ring-red-200').removeClass('border-slate-300');
                },
                unhighlight: function(element) {
                    $(element).removeClass('border-red-500 ring-2 ring-red-200').addClass('border-slate-300');
                }
            });

            // Password form validation
            $("#passwordForm").validate({
                rules: {
                    current_password: { required: true },
                    new_password: { required: true, minlength: 6 },
                    confirm_password: { required: true, equalTo: "#new_password" }
                },
                messages: {
                    current_password: "Please enter your current password",
                    new_password: "Password must be at least 6 characters",
                    confirm_password: "Passwords do not match"
                },
                highlight: function(element) {
                    $(element).addClass('border-red-500 ring-2 ring-red-200').removeClass('border-gray-300');
                },
                unhighlight: function(element) {
                    $(element).removeClass('border-red-500 ring-2 ring-red-200').addClass('border-gray-300');
                }
            });
        });
    </script>
</body>
</html>
