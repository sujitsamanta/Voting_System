


<?php include 'component/admin_header.php'; 
// $admin_name = !empty($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin';
// $admin_initial = strtoupper(substr($admin_name, 0, 1));

// Handle deletion
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $conn->query("DELETE FROM agent WHERE id = $delete_id");
    header("Location: admin_view_agent.php");
    exit;
}

// Fetch agents
$sql = "SELECT * FROM agent ORDER BY id DESC";
$result = $conn->query($sql);
?>

 <!-- All Agents Section -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">All Agents</h3>
                    <div class="flex items-center space-x-3">
                        <input type="text" id="searchInput" placeholder="Search agents..."
                            class="px-3 py-1 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <a href="admin_add_agent.php">
                            <button
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Agent
                            </button>
                        </a>


                    </div>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DOB</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Party Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Symbol Photo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agent Photo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody id="agentsTableBody" class="bg-white divide-y divide-gray-200">
                                <?php if ($result->num_rows > 0): ?>
                                    <?php $i = 1; while($row = $result->fetch_assoc()): ?>
                                <!-- Sample Row -->
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $i++; ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($row['name']); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['dob']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"><?php echo htmlspecialchars($row['name_of_party']); ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if (!empty($row['symbol'])): ?>

                                        <img src="<?php echo htmlspecialchars($row['symbol']); ?>" alt="Symbol" class="h-8 w-8 object-contain rounded" />
                                    <?php else: ?>
                                         <span class="text-gray-400">No Photo</span>
                                    <?php endif; ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php if (!empty($row['image'])): ?>
                                        <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Agent" class="h-10 w-10 rounded-full object-cover" />
                                        <?php else: ?>
                                        <span class="text-gray-400">No Photo</span>
                                    <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center gap-2">
                                            <a href="admin_update_agent.php?id=<?php echo $row['id']; ?>">
                                                <button class="px-3 py-1 rounded-md text-white bg-indigo-600 hover:bg-indigo-700">Update</button>
                                            </a>
                                            <a href="admin_view_agent.php?delete=<?php echo $row['id']; ?>"onclick="return confirm('Are you sure you want to delete this agent?');">
                                                <button name="delete" class="px-3 py-1 rounded-md text-white bg-red-600 hover:bg-red-700">Delete</button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                                <?php endif; ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



<?php include 'component/admin_footer.php'; ?>