<script>
        function showTab(tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Remove active class from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => button.classList.remove('active'));
            
            // Show selected tab content
            document.getElementById(tabName + '-tab').classList.add('active');
            
            // Add active class to clicked button
            event.target.classList.add('active');
        }

        $(document).ready(function() {
            // Profile form validation
            $("#profileForm").validate({
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
                    pincode: { required: true, digits: true, minlength: 6, maxlength: 6 }
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
                    pincode: "Enter a valid 6-digit pincode"
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
                }
            });

            // Password form validation
            $("#passwordForm").validate({
                rules: {
                    current_password: { required: true },
                    new_password: { required: true, minlength: 6 },
                    confirm_password: { required: true, equalTo: "#new_password" }
                },
                messages: {
                    current_password: "Please enter your current password",
                    new_password: "Password must be at least 6 characters",
                    confirm_password: "Passwords do not match"
                },
                highlight: function(element) {
                    $(element).addClass('border-red-500 ring-2 ring-red-200').removeClass('border-gray-300');
                },
                unhighlight: function(element) {
                    $(element).removeClass('border-red-500 ring-2 ring-red-200').addClass('border-gray-300');
                }
            });
        });
    </script>


</body>

</html>