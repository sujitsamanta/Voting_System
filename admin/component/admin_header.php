<?php
session_start();
include("db_conn.php");

if (!isset($_SESSION['admin_name'])) {
    header("Location: admin_login.php");
    exit;
}



if (isset($_GET['logout'])) {
    // session_start();
    session_unset();
    session_destroy();
    // header('location: user_login.php');
    echo "<script>alert('Logout successfully!'); window.location='admin_login.php';</script>";
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Agent Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in': 'fadeIn 0.3s ease-in-out',
                        'slide-up': 'slideUp 0.3s ease-out'
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                transform: translateY(10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
    </style>
</head>

<body class="bg-gray-50 min-h-screen overflow-y-auto pt-16">
     <!-- Navbar -->
    <header class="bg-white shadow fixed top-0 left-0 right-0 z-50">
        <div class="flex items-center justify-between px-4 py-3">
            <div class="flex items-center space-x-3">
                <!-- <i class="fas fa-vote-yea text-2xl text-indigo-600"></i> -->
                <span class="text-xl font-bold">Admin Panel</span>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-900"><?php echo $_SESSION['admin_name']; ?></p>
                    <p class="text-xs text-gray-500">Administrator</p>
                </div>
                <!-- <div class="h-10 w-10 rounded-full bg-indigo-600 flex items-center justify-center">
                    <span class="text-white font-bold text-lg"></span>
                </div> -->
                <form action="#" method="get">
                    <button name="logout" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition flex items-center space-x-1">
                        <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </header>