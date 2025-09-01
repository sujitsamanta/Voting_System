<?php
include 'component/admin_header.php';
include 'db_conn.php'; // make sure $conn = mysqli_connect(...) is here

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $startDate = $_POST['start_date'] ?? '';
    $endDate   = $_POST['end_date'] ?? '';
    $startTime = $_POST['start_time'] ?? '';
    $endTime   = $_POST['end_time'] ?? '';

    if ($startDate === '' || $endDate === '' || $startTime === '' || $endTime === '') {
        echo "<script>alert('All fields are required.');</script>";
    } else {
        // Convert to proper datetime for validation
        $starting_datetime = $startDate . ' ' . $startTime;
        $ending_datetime   = $endDate   . ' ' . $endTime;

        if (strtotime($ending_datetime) <= strtotime($starting_datetime)) {
            echo "<script>alert('End time must be after start time.');</script>";
        } else {
            if ($conn) {
                // check if record exists
                $check = mysqli_query($conn, "SELECT id FROM setting LIMIT 1");
                if ($check && mysqli_num_rows($check) > 0) {
                    // update
                    $row = mysqli_fetch_assoc($check);
                    $stmt = mysqli_prepare($conn,
                        "UPDATE setting 
                         SET start_date=?, end_date=?, start_time=?, end_time=?, created_at=NOW() 
                         WHERE id=?"
                    );
                    mysqli_stmt_bind_param($stmt, 'ssssi', $startDate, $endDate, $startTime, $endTime, $row['id']);
                } else {
                    // insert
                    $stmt = mysqli_prepare($conn,
                        "INSERT INTO setting (start_date, end_date, start_time, end_time, created_at) 
                         VALUES (?, ?, ?, ?, NOW())"
                    );
                    mysqli_stmt_bind_param($stmt, 'ssss', $startDate, $endDate, $startTime, $endTime);
                }

                if ($stmt) {
                    if (mysqli_stmt_execute($stmt)) {
                        echo "<script>alert('Voting time window saved successfully.');</script>";
                    } else {
                        echo "<script>alert('Failed to save. Database error.');</script>";
                    }
                    mysqli_stmt_close($stmt);
                }
            } else {
                echo "<script>alert('Database connection not available.');</script>";
            }
        }
    }
}
?>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Set Voting Time Window</h3>
            <p class="mt-1 text-sm text-gray-500">Define the start and end date/time for voting.</p>
        </div>

        <form method="post" class="p-6 space-y-6">
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                <input type="date" id="start_date" name="start_date" required
                       value="<?= htmlspecialchars($_POST['start_date'] ?? '') ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700">Start Time</label>
                <input type="time" id="start_time" name="start_time" required
                       value="<?= htmlspecialchars($_POST['start_time'] ?? '') ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                <input type="date" id="end_date" name="end_date" required
                       value="<?= htmlspecialchars($_POST['end_date'] ?? '') ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
            </div>

            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700">End Time</label>
                <input type="time" id="end_time" name="end_time" required
                       value="<?= htmlspecialchars($_POST['end_time'] ?? '') ?>"
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="flex items-center justify-end gap-3">
                <a href="admin_dashbord.php" class="px-4 py-2 border border-gray-300 rounded-md">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Save Time</button>
            </div>
        </form>
    </div>
</div>

<?php include 'component/admin_footer.php'; ?>
