<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>P2PShare Admin Login</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div id="loginContainer">
        <h1>P2PShare Admin Login</h1>
        <input type="text" class="login" id="username" placeholder="Username">
        <input type="password" class="login" id="password" placeholder="Password">
        <p id="message"></p>
        <button onclick="Login()">Login</button>
    </div>

    <script>
      function Login(){
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;

        fetch("/p2pshare/api/login.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json"
          },
          body: JSON.stringify({ username, password })
        })
        .then(response => response.json())
        .then(data => {
        if (data.success) {
            window.location.href = "admin.php";
          } else {
            document.getElementById("message").textContent = "Invalid credentials.";
          }
        })
        .catch(error => {
          document.getElementById("message").textContent = error.message;
        });
      }
    </script>
</body>
</html>