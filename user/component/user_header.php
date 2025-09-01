<?php
session_start();
include("db_conn.php");

if (!isset($_SESSION['user_name'])) {
    header("Location: user_login.php");
    exit;
}

if (isset($_GET['logout'])) {
    // session_start();
    session_unset();
    session_destroy();
    // header('location: user_login.php');
    echo "<script>alert('Logout successfully!'); window.location='user_login.php';</script>";

    exit;
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VoteApp - Online Voting Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
        <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


</head>

<body class="bg-gray-50 min-h-screen">
    <!-- Navigation Bar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-white text-2xl font-bold">VoteApp</h1>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:block">
                    <div class="ml-10 flex items-baseline space-x-4">
                        <a href="user_dashbord.php"
                            class="<?= basename($_SERVER['PHP_SELF']) == 'user_dashbord.php' ? 'bg-blue-700 ' : '' ?> nav-link text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Home
                        </a>
                        <a href="user_vote_form.php"
                            class="<?= basename($_SERVER['PHP_SELF']) == 'user_vote_form.php' ? 'bg-blue-700 ' : '' ?> nav-link text-white hover:bg-blue-700  px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Vote
                        </a>
                        <a href="user_vote_result.php"
                            class="<?= basename($_SERVER['PHP_SELF']) == 'user_vote_result.php' ? 'bg-blue-700 ' : '' ?> nav-link text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Results
                        </a>
                        <a href="user_profile.php"
                            class="<?= basename($_SERVER['PHP_SELF']) == 'user_profile.php' ? 'bg-blue-700 ' : '' ?> nav-link text-white hover:bg-blue-700 px-3 py-2 rounded-md text-sm font-medium transition-colors duration-200">
                            Profile
                        </a>
                    </div>
                </div>

                <!-- Logout Button -->
                <div class="flex items-center">
                    <form action="#" method="get">
                        <button type="submit" name="logout"
                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors duration-200 flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </nav>
