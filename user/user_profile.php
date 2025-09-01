<?php
include 'component/user_header.php';

// Check if user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    echo "<script>alert('Please login first'); window.location.href='user_login.php';</script>";
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch current user data
$sql = "SELECT * FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "<script>alert('Database error: " . mysqli_error($conn) . "'); window.location.href='user_login.php';</script>";
    exit;
}

$user_data = mysqli_fetch_assoc($result);

if (!$user_data) {
    echo "<script>alert('User not found'); window.location.href='user_login.php';</script>";
    exit;
}
?>

<!-- Main Content -->
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Page Header -->
    <div class="text-center mb-8">
        <div class="mx-auto w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mb-4">
            <svg class="w-12 h-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Profile</h1>
        <p class="text-gray-600">View your complete profile information</p>
    </div>

    <!-- Profile Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 px-6 py-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold"><?php echo htmlspecialchars($user_data['name']); ?></h2>
                    <p class="text-blue-100 mt-1"><?php echo htmlspecialchars($user_data['email']); ?></p>
                </div>
                <div class="text-right">
                    <div class="bg-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                        User ID: <?php echo $user_data['id']; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Content -->
        <div class="p-6 md:p-10">
            <!-- Personal Information Section -->
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path d="M12 12a5 5 0 100-10 5 5 0 000 10z" />
                            <path fill-rule="evenodd" d="M.458 20.292A11.944 11.944 0 0112 18c3.183 0 6.086 1.24 8.242 3.292a.75.75 0 001.058-1.062A13.444 13.444 0 0012 16.5c-3.694 0-7.053 1.41-9.3 3.73a.75.75 0 101.058 1.062z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <h3 class="text-lg font-semibold text-gray-900">Personal Information</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Full Name</label>
                        <p class="text-gray-900 font-medium"><?php echo htmlspecialchars($user_data['name']); ?></p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Email Address</label>
                        <p class="text-gray-900 font-medium"><?php echo htmlspecialchars($user_data['email']); ?></p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Date of Birth</label>
                        <p class="text-gray-900 font-medium">
                            <?php echo $user_data['dob'] ? date('F j, Y', strtotime($user_data['dob'])) : 'Not specified'; ?>
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Gender</label>
                        <p class="text-gray-900 font-medium capitalize">
                            <?php echo $user_data['gender'] ? htmlspecialchars($user_data['gender']) : 'Not specified'; ?>
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Phone Number</label>
                        <p class="text-gray-900 font-medium"><?php echo htmlspecialchars($user_data['phone']); ?></p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Account Status</label>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span class="text-green-700 font-medium">Active</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Address Information Section -->
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M11.47 3.841a.75.75 0 011.06 0l7.07 7.07a7.5 7.5 0 11-10.607 10.607L3.923 15.55a7.5 7.5 0 0110.607-10.607l-3.06 3.06a3 3 0 10-4.243 4.243l4.596 4.597a3 3 0 104.243-4.243l-4.596-4.596a4.5 4.5 0 116.364 6.364l-4.596 4.596a4.5 4.5 0 11-6.364-6.364l7.07-7.07z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <h3 class="text-lg font-semibold text-gray-900">Address Details</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Village</label>
                        <p class="text-gray-900 font-medium"><?php echo htmlspecialchars($user_data['village']); ?></p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Post Office</label>
                        <p class="text-gray-900 font-medium"><?php echo htmlspecialchars($user_data['post_office']); ?></p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Police Station</label>
                        <p class="text-gray-900 font-medium"><?php echo htmlspecialchars($user_data['police_station']); ?></p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">District</label>
                        <p class="text-gray-900 font-medium"><?php echo htmlspecialchars($user_data['district']); ?></p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">State</label>
                        <p class="text-gray-900 font-medium"><?php echo htmlspecialchars($user_data['state']); ?></p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Pincode</label>
                        <p class="text-gray-900 font-medium"><?php echo htmlspecialchars($user_data['pin_code']); ?></p>
                    </div>
                </div>
            </div>

            <!-- Account Information Section -->
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M12 1.5l8.485 4.243v5.73c0 5.246-3.61 10.12-8.485 11.027-4.875-.907-8.485-5.78-8.485-11.028V5.743L12 1.5zm0 6.75a3 3 0 00-3 3v1.5a.75.75 0 001.5 0V11.25a1.5 1.5 0 113 0v1.5a.75.75 0 001.5 0V11.25a3 3 0 00-3-3z" clip-rule="evenodd" />
                        </svg>
                    </span>
                    <h3 class="text-lg font-semibold text-gray-900">Account Information</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Registration Date</label>
                        <p class="text-gray-900 font-medium">
                            <?php 
                            // Assuming there's a created_at field, if not, you can add one
                            echo 'Registered User';
                            ?>
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <label class="block text-sm font-medium text-gray-500 mb-1">Last Updated</label>
                        <p class="text-gray-900 font-medium">
                            <?php 
                            // You can add a last_updated field to track this
                            echo 'Recently';
                            ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                <a href="user_dashbord.php" 
                   class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-medium text-center hover:bg-gray-200 transition-colors">
                    ← Back to Dashboard
                </a>
                <a href="user_update_detail.php" 
                   class="flex-1 bg-blue-600 text-white px-6 py-3 rounded-lg font-medium text-center hover:bg-blue-700 transition-colors">
                    Edit Profile
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats Card -->
    <div class="mt-8 bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-blue-600">1</div>
                    <div class="text-sm text-gray-500">Active Account</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-green-600">✓</div>
                    <div class="text-sm text-gray-500">Profile Complete</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-purple-600">∞</div>
                    <div class="text-sm text-gray-500">Voting Access</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'component/user_footer.php'; ?>
