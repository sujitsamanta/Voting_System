<?php
session_start();
include("db_conn.php");
if (isset($_POST['add_data'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    // $phone = $_POST['phone'];
    $village = $_POST['village'];
    $po = $_POST['po'];
    $ps = $_POST['ps'];
    $district = $_POST['district'];
    $state = $_POST['state'];
    $pin = $_POST['pincode'];
    $pass = $_POST['password'];

    $_SESSION['form_data'] = $_POST;      //for store the data in session
    $check = "SELECT * from users where email = '$email'";
    $check_user = mysqli_query($conn,$check);
    $row_count = mysqli_num_rows($check_user);
    if($row_count == 1){
        echo "<script>alert('Email already exists'); window.location.href = 'user_registration.php'</script>";
        exit;

        // header('location:registration.php');
    }
    else{
        $sql = "INSERT INTO users(name,email,dob,gender,phone,village,post_office,police_station,districe,state,pin_code,password) VALUES ('$name','$email','$dob','$gender','$phone','$village','$po','$ps','$district','$state','$pin','$pass')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
          unset($_SESSION['form_data']); // Clear stored form data
            echo "<script>alert('Registration Successful'); window.location.href = 'user_login.php';</script>";
            exit;
            
        }
    }
    
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registration Form</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Inter', system-ui, -apple-system, Segoe UI, Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', sans-serif; }
    .fade-in { animation: fadeIn 0.7s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(12px); } to { opacity: 1; transform: translateY(0); } }
    label.error { color: #ef4444; font-size: 0.85rem; margin-top: 6px; display: block; }
  </style>
</head>
<body class="relative min-h-screen bg-gradient-to-br from-slate-50 via-white to-slate-100 flex items-center justify-center px-4">
  <!-- Decorative background blobs -->
  <div class="pointer-events-none absolute inset-0 overflow-hidden" aria-hidden="true">
    <div class="absolute -top-20 -left-20 h-72 w-72 rounded-full bg-blue-200 blur-3xl opacity-40"></div>
    <div class="absolute -bottom-24 -right-24 h-80 w-80 rounded-full bg-indigo-200 blur-3xl opacity-40"></div>
  </div>

  <div class="relative w-full max-w-4xl rounded-2xl overflow-hidden shadow-2xl fade-in">
   

    <!-- Right form panel -->
    <div class="bg-white p-6 md:p-10">
      <div class="mb-6 text-center md:text-left">
        <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Create your account</h1>
        <p class="text-slate-500 mt-1">Fill in the details below to register</p>
      </div>

      <form id="registrationForm" class="space-y-8" action="#" method="post" novalidate>
        <!-- Section: Personal Information -->
        <div>
          <div class="flex items-center gap-2 mb-4">
            <span class="text-blue-600">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path d="M12 12a5 5 0 100-10 5 5 0 000 10z"/><path fill-rule="evenodd" d="M.458 20.292A11.944 11.944 0 0112 18c3.183 0 6.086 1.24 8.242 3.292a.75.75 0 001.058-1.062A13.444 13.444 0 0012 16.5c-3.694 0-7.053 1.41-9.3 3.73a.75.75 0 101.058 1.062z" clip-rule="evenodd"/></svg>
            </span>
            <h2 class="text-sm font-semibold text-slate-700 tracking-wide uppercase">Personal Information</h2>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">Name</label>
              <input autocomplete="name" type="text" name="name" class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="Enter your full name" value="<?php echo isset($_SESSION['form_data']['name']) ? htmlspecialchars($_SESSION['form_data']['name']) : ''; ?>">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
              <input autocomplete="email" type="email" name="email" class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="e.g. name@example.com" value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">Date of Birth</label>
              <input autocomplete="bday" type="date" name="dob" class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600" value="<?php echo isset($_SESSION['form_data']['dob']) ? htmlspecialchars($_SESSION['form_data']['dob']) : ''; ?>">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">Phone Number</label>
              <input autocomplete="tel" inputmode="numeric" pattern="\d{10}" type="tel" name="phone" class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="10-digit mobile number" value="<?php echo isset($_SESSION['form_data']['phone']) ? htmlspecialchars($_SESSION['form_data']['phone']) : ''; ?>">
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-slate-700 mb-2">Gender</label>
              <div class="flex items-center gap-6 border border-slate-300 rounded-md px-3 py-2 bg-slate-50">
                <label class="inline-flex items-center gap-2 text-slate-700"><input type="radio" name="gender" value="male" class="h-4 w-4" <?php if(isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == 'male') echo 'checked'; ?>> <span>Male</span></label>
                <label class="inline-flex items-center gap-2 text-slate-700"><input type="radio" name="gender" value="female" class="h-4 w-4" <?php if(isset($_SESSION['form_data']['gender']) && $_SESSION['form_data']['gender'] == 'female') echo 'checked'; ?>> <span>Female</span></label>
              </div>
            </div>
          </div>
        </div>

        <!-- Section: Address Details -->
        <div>
          <div class="flex items-center gap-2 mb-4">
            <span class="text-blue-600">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M11.47 3.841a.75.75 0 011.06 0l7.07 7.07a7.5 7.5 0 11-10.607 10.607L3.923 15.55a7.5 7.5 0 0110.607-10.607l-3.06 3.06a3 3 0 10-4.243 4.243l4.596 4.597a3 3 0 104.243-4.243l-4.596-4.596a4.5 4.5 0 116.364 6.364l-4.596 4.596a4.5 4.5 0 11-6.364-6.364l7.07-7.07z" clip-rule="evenodd"/></svg>
            </span>
            <h2 class="text-sm font-semibold text-slate-700 tracking-wide uppercase">Address Details</h2>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">Village</label>
              <input autocomplete="address-line1" type="text" name="village" class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="Village" value="<?php echo isset($_SESSION['form_data']['village']) ? htmlspecialchars($_SESSION['form_data']['village']) : ''; ?>">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">Post Office</label>
              <input autocomplete="address-line2" type="text" name="po" class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="Post Office" value="<?php echo isset($_SESSION['form_data']['po']) ? htmlspecialchars($_SESSION['form_data']['po']) : ''; ?>">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">Police Station</label>
              <input autocomplete="address-line3" type="text" name="ps" class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="Police Station" value="<?php echo isset($_SESSION['form_data']['ps']) ? htmlspecialchars($_SESSION['form_data']['ps']) : ''; ?>">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">District</label>
              <input autocomplete="address-level2" type="text" name="district" class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="District" value="<?php echo isset($_SESSION['form_data']['district']) ? htmlspecialchars($_SESSION['form_data']['district']) : ''; ?>">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">State</label>
              <input autocomplete="address-level1" type="text" name="state" class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="State" value="<?php echo isset($_SESSION['form_data']['state']) ? htmlspecialchars($_SESSION['form_data']['state']) : ''; ?>">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">Pincode</label>
              <input autocomplete="postal-code" type="text" inputmode="numeric" pattern="\\d{6}" name="pincode" class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="6-digit pincode" value="<?php echo isset($_SESSION['form_data']['pincode']) ? htmlspecialchars($_SESSION['form_data']['pincode']) : ''; ?>">
            </div>
            <!-- <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">Pincode</label>
              <input autocomplete="postal-code" type="text" inputmode="numeric" pattern="\\d{6}" name="pincode" class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="6-digit pincode" value="<?php echo isset($_SESSION['form_data']['pincode']) ? htmlspecialchars($_SESSION['form_data']['pincode']) : ''; ?>">
            </div> -->
          </div>
        </div>

        <!-- Section: Security -->
        <div>
          <div class="flex items-center gap-2 mb-4">
            <span class="text-blue-600">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5"><path fill-rule="evenodd" d="M12 1.5l8.485 4.243v5.73c0 5.246-3.61 10.12-8.485 11.027-4.875-.907-8.485-5.78-8.485-11.028V5.743L12 1.5zm0 6.75a3 3 0 00-3 3v1.5a.75.75 0 001.5 0V11.25a1.5 1.5 0 113 0v1.5a.75.75 0 001.5 0V11.25a3 3 0 00-3-3z" clip-rule="evenodd"/></svg>
            </span>
            <h2 class="text-sm font-semibold text-slate-700 tracking-wide uppercase">Security</h2>
          </div>
          <div class="grid grid-cols-1 gap-4">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
              <div class="relative">
                <input id="password" type="password" name="password" class="w-full border border-slate-300 bg-slate-50 rounded-md px-3 py-2 pr-12 focus:bg-white focus:ring-2 focus:ring-blue-600 focus:border-blue-600" placeholder="At least 6 characters" value="<?php echo isset($_SESSION['form_data']['password']) ? htmlspecialchars($_SESSION['form_data']['password']) : ''; ?>">
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 text-sm text-blue-600 hover:text-blue-700">Show</button>
              </div>
              <div class="mt-3">
                <div class="h-2 w-full bg-slate-200 rounded" aria-hidden="true">
                  <div id="passwordStrengthBar" class="h-2 w-0 rounded bg-red-500 transition-all"></div>
                </div>
                <p id="passwordHint" class="text-xs text-slate-600 mt-2">Use a mix of letters, numbers and symbols.</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between pt-2">
          <p class="text-xs text-slate-500">We respect your privacy. Your info is only used to create your account.</p>
          <div class="flex items-center gap-3">
            <button type="reset" class="px-4 py-2 rounded-md border border-slate-300 text-slate-700 hover:bg-slate-50">Reset</button>
            <button type="submit" name="add_data" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition disabled:opacity-60 disabled:cursor-not-allowed">Register</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      function updateStrengthMeter(value) {
        var score = 0;
        if (value.length >= 6) score++;
        if (/[A-Z]/.test(value)) score++;
        if (/[0-9]/.test(value)) score++;
        if (/[^A-Za-z0-9]/.test(value)) score++;

        var widths = ['0%', '25%', '50%', '75%', '100%'];
        var colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-lime-500', 'bg-green-600'];

        var bar = $('#passwordStrengthBar');
        bar.removeClass('bg-red-500 bg-orange-500 bg-yellow-500 bg-lime-500 bg-green-600');
        bar.addClass(colors[score]);
        bar.css('width', widths[score]);

        var hint = 'Use a mix of letters, numbers and symbols.';
        if (score <= 1) hint = 'Very weak password';
        else if (score === 2) hint = 'Weak: add numbers or symbols';
        else if (score === 3) hint = 'Good: add a symbol for stronger security';
        else if (score >= 4) hint = 'Strong password';
        $('#passwordHint').text(hint);
      }

      $('#password').on('input', function(){
        updateStrengthMeter(this.value);
      });

      $('#togglePassword').on('click', function(){
        const input = $('#password')[0];
        const isPassword = input.type === 'password';
        input.type = isPassword ? 'text' : 'password';
        $(this).text(isPassword ? 'Hide' : 'Show');
      });

      $("#registrationForm").validate({
        rules: {
          name: { required: true, minlength: 3 },
          email: { required: true, email: true },
          dob: { required: true },
          gender: { required: true },
          phone: { required: true, digits: true, minlength: 10, maxlength: 10 },
          village: { required: true },
          po: { required: true },
          ps: { required: true },
          district: { required: true },
          state: { required: true },
          pincode: { required: true, digits: true, minlength: 6, maxlength: 6 },
          password: { required: true, minlength: 6 }
        },
        messages: {
          name: "Please enter your name (min 3 letters)",
          email: "Enter a valid email",
          dob: "Select your date of birth",
          gender: "Select your gender",
          phone: "Enter a valid 10-digit phone number",
          village: "Enter your village",
          po: "Enter your post office",
          ps: "Enter your police station",
          district: "Enter your district",
          state: "Enter your state",
          pincode: "Enter a valid 6-digit pincode",
          password: "Password must be at least 6 characters"
        },
        errorPlacement: function(error, element) {
          if (element.attr("name") == "gender") {
            error.insertAfter(element.closest('div'));
          } else {
            error.insertAfter(element);
          }
        },
        highlight: function(element) {
          $(element).addClass('border-red-500 ring-2 ring-red-200').removeClass('border-slate-300');
        },
        unhighlight: function(element) {
          $(element).removeClass('border-red-500 ring-2 ring-red-200').addClass('border-slate-300');
        },
        invalidHandler: function(event, validator) {
          if (validator.errorList.length) {
            $('html, body').animate({ scrollTop: $(validator.errorList[0].element).offset().top - 120 }, 300);
          }
        },
        submitHandler: function(form) {
          const $btn = $(form).find('button[name="add_data"]');
          $btn.prop('disabled', true).text('Registering...');
          form.submit();
        }
      });
    });
  </script>

</body>
</html>