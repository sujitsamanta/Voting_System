<?php 
include 'component/user_header.php'; 
include 'db_conn.php';

$voter_id = $_SESSION['user_id'] ?? null;
if (!$voter_id) {
    header("Location: user_login.php");
    exit;
}

// ✅ Fetch latest voting settings
$setting_sql = "SELECT * FROM setting ORDER BY id DESC LIMIT 1";
$setting_result = mysqli_query($conn, $setting_sql);
$setting = mysqli_fetch_assoc($setting_result);

// Current timestamp
date_default_timezone_set("Asia/Kolkata");
$current_ts = time();
$vote_allowed = false;

// Compute voting start and end timestamps
if ($setting) {
    $voting_start_ts = strtotime($setting['start_date'] . ' ' . $setting['start_time']);
    $voting_end_ts   = strtotime($setting['end_date'] . ' ' . $setting['end_time']);
    
    if ($current_ts >= $voting_start_ts && $current_ts <= $voting_end_ts) {
        $vote_allowed = true;
        $remaining_seconds = $voting_end_ts - $current_ts;
    } else {
        $remaining_seconds = max($voting_start_ts - $current_ts, 0);
    }
} else {
    $remaining_seconds = 0;
}

// ✅ Check if user already voted today
$check_sql = "SELECT * FROM vote WHERE voter_id = ? AND vote_date = CURDATE()";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $voter_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    echo "<script>alert('⚠️ You have already voted today!'); window.location.href='user_dashbord.php';</script>";
    exit;
}

// Handle vote submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && $vote_allowed) {
    $agent_id = $_POST['candidate'];
    $vote_time = date("H:i:s");

    $sql = "INSERT INTO vote (voter_id, agent_id, vote_date, voting_time) VALUES (?, ?, CURDATE(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $voter_id, $agent_id, $vote_time);

    if ($stmt->execute()) {
        echo "<script>alert('✅ Vote submitted successfully!'); window.location.href='user_dashbord.php';</script>";
        exit;
    } else {
        echo "<script>alert('❌ Error saving vote!');</script>";
    }
}

// Fetch candidates
$candidate_sql = "SELECT * FROM agent";
$candidate_result = mysqli_query($conn, $candidate_sql);

?>

<div id="vote-page" class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-lg shadow-lg p-8">
            <div id="remaining-time" class="mb-6 text-center bg-yellow-100 text-gray-900 font-semibold px-4 py-2 rounded-lg shadow">
                ⏳ Remaining Time: <span id="countdown"></span>
            </div>

            <?php if ($vote_allowed): ?>
                <h2 class="text-3xl font-bold text-gray-900 mb-6 text-center">Cast Your Vote</h2>
                <p class="text-gray-600 mb-8 text-center">Select your preferred candidate:</p>
                
                <form class="space-y-4" method="POST">
                    <?php while($row = mysqli_fetch_assoc($candidate_result)) { ?>
                        <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 hover:border-blue-300 transition-all duration-200">
                            <input type="radio" name="candidate" value="<?php echo $row['id']; ?>" required class="w-4 h-4 text-blue-600">
                            <div class="ml-4 flex items-center gap-6">
                                <div class="w-16 h-16 rounded-full overflow-hidden border">
                                    <img src="../admin/<?php echo htmlspecialchars($row['image']); ?>" alt="Candidate" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900"><?php echo htmlspecialchars($row['name']); ?></div>
                                    <div class="text-gray-600 text-sm"><?php echo htmlspecialchars($row['name_of_party']); ?></div>
                                    <div class="text-gray-500 text-sm">📧 <?php echo htmlspecialchars($row['email']); ?></div>
                                    <div class="text-gray-500 text-sm">🎂 <?php echo htmlspecialchars($row['dob']); ?></div>
                                </div>
                                <div class="ml-auto w-16 h-16 overflow-hidden border rounded-lg">
                                    <img src="../admin/<?php echo htmlspecialchars($row['symbol']); ?>" alt="Party Symbol" class="w-full h-full object-contain">
                                </div>
                            </div>
                        </label>
                    <?php } ?>

                    <div class="flex space-x-4 pt-6">
                        <button type="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                            Submit Vote
                        </button>
                        <button type="button" onclick="window.location.href='dashboard.php'" class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg transition-colors duration-200">
                            Cancel
                        </button>
                    </div>
                </form>
            <?php else: ?>
                <h2 class="text-2xl font-bold text-red-600 text-center">Voting is not active at this time.</h2>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
let remaining = <?php echo $remaining_seconds; ?>;
function updateCountdown() {
    if (remaining <= 0) {
        document.getElementById("countdown").textContent = "Voting Closed";
        return;
    }
    let hours = Math.floor(remaining / 3600);
    let minutes = Math.floor((remaining % 3600) / 60);
    let seconds = remaining % 60;
    document.getElementById("countdown").textContent =
        String(hours).padStart(2,'0') + ":" +
        String(minutes).padStart(2,'0') + ":" +
        String(seconds).padStart(2,'0');
    remaining--;
}
setInterval(updateCountdown, 1000);
updateCountdown();
</script>

<?php include 'component/user_footer.php'; ?>
