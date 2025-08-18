<?php
include 'component/admin_header.php';

$agentId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($agentId === 0 && isset($_POST['id'])) {
    $agentId = intval($_POST['id']);
}

$name = $dob = $party = $symbol = $image = "";

// Prefill data
if ($agentId > 0) {
    $sql = "SELECT * FROM agent WHERE id=$agentId LIMIT 1";
    $res = mysqli_query($conn, $sql);
    if ($res && mysqli_num_rows($res) === 1) {
        $row   = mysqli_fetch_assoc($res);
        $name  = htmlspecialchars($row['name']);
        $dob   = htmlspecialchars($row['dob']);
        $party = htmlspecialchars($row['name_of_party']);
        $symbol= htmlspecialchars($row['symbol']);
        $image = htmlspecialchars($row['image']);
    }
}

// Update
if (isset($_POST['update_agent']) && $agentId > 0) {
    $newName  = mysqli_real_escape_string($conn, $_POST['name']);
    $newDob   = mysqli_real_escape_string($conn, $_POST['dob']);
    $newParty = mysqli_real_escape_string($conn, $_POST['party_name']);

    $newSymbol = $symbol;
    $newImage  = $image;

    if (!is_dir("uploads")) mkdir("uploads", 0755, true);

    if (!empty($_FILES['symbol_file']['tmp_name'])) {
        $file = "uploads/" . uniqid("symbol_") . "_" . basename($_FILES['symbol_file']['name']);
        if (move_uploaded_file($_FILES['symbol_file']['tmp_name'], $file)) $newSymbol = $file;
    }

    if (!empty($_FILES['agent_file']['tmp_name'])) {
        $file = "uploads/" . uniqid("agent_") . "_" . basename($_FILES['agent_file']['name']);
        if (move_uploaded_file($_FILES['agent_file']['tmp_name'], $file)) $newImage = $file;
    }

    $update = "UPDATE agent 
               SET name='$newName', dob='$newDob', name_of_party='$newParty', 
                   symbol='$newSymbol', image='$newImage' 
               WHERE id=$agentId";

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Agent updated successfully!'); window.location='admin_dashbord.php';</script>";
        exit;
    } else {
        echo "<script>alert('Update failed. Try again!');</script>";
    }
}
?>


    <main class="max-w-4xl mx-auto px-4 py-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <form method="post" enctype="multipart/form-data" class="space-y-8">
                <input type="hidden" name="id" value="<?php echo $agentId; ?>">

                <!-- Agent Details -->
                <div>
                    <h2 class="text-sm font-semibold text-gray-700 uppercase mb-4">Agent Details</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm mb-1">Name</label>
                            <input type="text" name="name" value="<?php echo $name; ?>" class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label class="block text-sm mb-1">Date of Birth</label>
                            <input type="date" name="dob" value="<?php echo $dob; ?>" class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm mb-1">Party Name</label>
                            <input type="text" name="party_name" value="<?php echo $party; ?>" class="w-full border rounded-md px-3 py-2 focus:ring-2 focus:ring-blue-600">
                        </div>
                    </div>
                </div>

                <!-- Photos -->
                <div>
                    <h2 class="text-sm font-semibold text-gray-700 uppercase mb-4">Photos</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm mb-2">Party Symbol</label>
                            <div class="flex items-start gap-4">
                                <div class="h-20 w-20 rounded border bg-gray-50 overflow-hidden">
                                    <img src="<?php echo $symbol ?: 'https://via.placeholder.com/80'; ?>" class="h-full w-full object-contain">
                                </div>
                                <input type="file" name="symbol_file" accept="image/*" class="text-sm">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm mb-2">Agent Photo</label>
                            <div class="flex items-start gap-4">
                                <div class="h-20 w-20 rounded-full border bg-gray-50 overflow-hidden">
                                    <img src="<?php echo $image ?: 'https://via.placeholder.com/80'; ?>" class="h-full w-full object-cover">
                                </div>
                                <input type="file" name="agent_file" accept="image/*" class="text-sm">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between">
                    <a href="admin_dashbord.php" class="px-4 py-2 rounded-md border text-gray-700 hover:bg-gray-50">Cancel</a>
                    <button type="submit" name="update_agent" class="px-5 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">Update Agent</button>
                </div>
            </form>
        </div>
    </main>
<?php include 'component/admin_footer.php'; ?>

