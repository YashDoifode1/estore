
        // Simulating a simple session and storage
        const users = [];

        // Handle registration
        document.getElementById('registrationForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const username = document.getElementById('reg-username').value;
            const password = document.getElementById('reg-password').value;

            // Save user details (for simplicity, without encryption)
            users.push({ username, password });
            alert('Registration successful! You can now login.');

            // Clear form
            event.target.reset();
        });

        // Handle login
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const username = document.getElementById('login-username').value;
            const password = document.getElementById('login-password').value;

            // Validate user
            const user = users.find(user => user.username === username && user.password === password);
            if (user) {
                alert(`Welcome, ${username}! You are now logged in.`);
                sessionStorage.setItem('loggedInUser', username);
            } else {
                alert('Invalid username or password.');
            }

            // Clear form
            event.target.reset();
        });

        // Check session
        window.onload = function() {
            const loggedInUser = sessionStorage.getItem('loggedInUser');
            if (loggedInUser) {
                alert(`Welcome back, ${loggedInUser}!`);
            }
        };
   