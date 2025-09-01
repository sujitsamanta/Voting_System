<?php include 'component/user_header.php'; ?>
<!-- Home Page -->
<div id="home-page" class="container mx-auto px-4 py-8">
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <h2 class="text-4xl font-bold text-gray-900 mb-4">Welcome to VoteApp</h2>
        <p class="text-xl text-gray-600 mb-8 max-w-2xl mx-auto">
            Your secure and reliable online voting platform. Cast your vote and view real-time results with complete
            transparency.
        </p>
    </div>

    <!-- Main Action Buttons -->
    <div class="flex flex-col md:flex-row justify-center items-center space-y-6 md:space-y-0 md:space-x-8 mb-12">
        <!-- Give Vote Button -->
        <a href="user_vote_form.php">
            <div class="w-full md:w-auto">
                <button
                    class="w-full md:w-auto bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-bold py-6 px-12 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-xl">Give Vote</span>
                </button>
                <p class="text-center text-gray-500 mt-2">Cast your ballot securely</p>
            </div>
        </a>


        <!-- Show Results Button -->
         <a href="user_vote_result.php">
            <div class="w-full md:w-auto">
            <button
                class="w-full md:w-auto bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white font-bold py-6 px-12 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                    </path>
                </svg>
                <span class="text-xl">Show Results</span>
            </button>
            <p class="text-center text-gray-500 mt-2">View live voting statistics</p>
        </div>
         </a>

        <!-- View Profile Button -->
        <a href="user_profile.php">
            <div class="w-full md:w-auto">
                <button
                    class="w-full md:w-auto bg-gradient-to-r from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 text-white font-bold py-6 px-12 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-xl">View Profile</span>
                </button>
                <p class="text-center text-gray-500 mt-2">See your complete profile</p>
            </div>
        </a>

        <!-- Update Profile Button -->
        <a href="user_update_detail.php">
            <div class="w-full md:w-auto">
                <button
                    class="w-full md:w-auto bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white font-bold py-6 px-12 rounded-lg shadow-lg transform hover:scale-105 transition-all duration-200 flex items-center justify-center space-x-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                    </svg>
                    <span class="text-xl">Update Profile</span>
                </button>
                <p class="text-center text-gray-500 mt-2">Edit your personal information</p>
            </div>
        </a>
        
    </div>



    <?php include 'component/user_footer.php'; ?>