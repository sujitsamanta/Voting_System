<?php include 'component/user_header.php'; ?>

     <!-- Vote Page -->
    <div id="vote-page" class="container mx-auto px-4 py-8 ">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-lg p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">Cast Your Vote</h2>
                <p class="text-gray-600 mb-8 text-center">Please select your preferred candidate from the list below:</p>
                
                <form class="space-y-4">
                    <div class="space-y-4">
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 hover:border-blue-300 transition-all duration-200">
                            <input type="radio" name="candidate" value="John Smith" class="w-4 h-4 text-blue-600">
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">John Smith</div>
                                <div class="text-gray-600 text-sm">Independent Party</div>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 hover:border-blue-300 transition-all duration-200">
                            <input type="radio" name="candidate" value="Sarah Johnson" class="w-4 h-4 text-blue-600">
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">Sarah Johnson</div>
                                <div class="text-gray-600 text-sm">Progressive Alliance</div>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 hover:border-blue-300 transition-all duration-200">
                            <input type="radio" name="candidate" value="Michael Brown" class="w-4 h-4 text-blue-600">
                            <div class="ml-4">
                                <div class="font-semibold text-gray-900">Michael Brown</div>
                                <div class="text-gray-600 text-sm">Conservative Union</div>
                            </div>
                        </label>
                    </div>
                    
                    <div class="flex space-x-4 pt-6">
                        <button type="button" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                            Submit Vote
                        </button>
                        <button type="button" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php include 'component/user_footer.php'; ?>
