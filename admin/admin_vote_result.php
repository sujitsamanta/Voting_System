<?php 
include 'component/admin_header.php';
include 'db_conn.php';

date_default_timezone_set('Asia/Kolkata'); // Set timezone
$currentTime = new DateTime();

$isVotingActive = false;

if ($conn) {
    // Get the latest voting time settings
    $query = "SELECT start_date, end_date, start_time, end_time 
              FROM setting 
              ORDER BY id DESC LIMIT 1"; // Use id instead of created_at
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $settings = mysqli_fetch_assoc($result);

        // Combine date and time into DateTime objects
        $startDateTime = DateTime::createFromFormat('Y-m-d H:i:s', $settings['start_date'].' '.$settings['start_time']);
        $endDateTime   = DateTime::createFromFormat('Y-m-d H:i:s', $settings['end_date'].' '.$settings['end_time']);

        // Check if voting is active
        if ($currentTime >= $startDateTime && $currentTime <= $endDateTime) {
            $isVotingActive = true;
        }
    }
}

// Redirect to admin dashboard with alert during voting
if ($isVotingActive) {
    echo "<script>
            alert('Results page is blocked during active voting.');
            window.location.href='admin_dashbord.php';
          </script>";
    exit();
}

// ------------------- Show Voting Results -------------------
$results = [];
$totalVotes = 0;

if ($conn) {
    $query = "SELECT a.id, a.name, a.name_of_party, a.email, a.dob, a.image, a.symbol, 
                     COUNT(v.id) as vote_count
              FROM agent a 
              LEFT JOIN vote v ON a.id = v.agent_id 
              GROUP BY a.id 
              ORDER BY vote_count DESC";

    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $results[] = $row;
            $totalVotes += $row['vote_count'];
        }
    }
}
?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">Voting Results</h2>
        
        <?php if ($totalVotes > 0): ?>
            <div class="mb-6">
                <p class="text-lg font-medium text-gray-700">Total Votes: <?php echo $totalVotes; ?></p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Candidate</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Party</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Votes</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($results as $candidate): ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full object-cover" src="<?php echo htmlspecialchars($candidate['image']); ?>" alt="<?php echo htmlspecialchars($candidate['name']); ?>">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($candidate['name']); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo htmlspecialchars($candidate['email']); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo htmlspecialchars($candidate['name_of_party']); ?></div>
                                <div class="text-sm text-gray-500">
                                    <img class="h-8 w-8 object-contain" src="<?php echo htmlspecialchars($candidate['symbol']); ?>" alt="Party Symbol">
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo $candidate['vote_count']; ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php 
                                $percentage = $totalVotes > 0 ? ($candidate['vote_count'] / $totalVotes) * 100 : 0;
                                echo number_format($percentage, 2) . '%';
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="text-gray-500 text-lg mb-4">No votes have been cast yet.</div>
                <p class="text-gray-400">Voting results will be displayed here once votes are submitted.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'component/admin_footer.php'; ?>
