<?php
session_start();

if (!isset($_SESSION["loggedIn"]) || $_SESSION["loggedIn"] !== true) {
  header("Location: index.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/style.css">
  <title>P2PShare Admin Panel</title>
</head>
<body>
  <section>
    <div id="adminContainer">
    <div id = "adminPanel">
      <h1>Admin Panel</h1>
      <div id="buttons">
        <button class="adminButton" onclick="SaveUsers()">Save</button>  
        <button class="adminButton" onclick="GetUsers()">Refresh</button>
        <button id="logoutButton" class="adminButton" onclick="LogOut()">Logout</button>
      </div>
    </div>
    <p id="message"></p>
    <div id="userListHeader">
      <p class="flexItem">Username</p>
      <p class="flexItem">Name</p>
      <p class="flexItem">Surename</p>
      <p class="flexItem">Space [B]</p>
      <p class="flexItem">Verified</p>
    </div>
    <div id="userList"></div>
  </div>
  </section>

  <script>
    function GetUsers() {
      const userList = document.getElementById("userList");
    
      userList.replaceChildren();
      
      fetch("api/users.php")
      .then(response => response.json())
      .then(data => {
        data.users.forEach(user => {
          const userRow = document.createElement("div");
          const usernameP = document.createElement("p");
          const nameP = document.createElement("p");
          const surenameP = document.createElement("p");
          const spaceInput = document.createElement("input");
          const verifiedInput = document.createElement("input");

          userRow.classList.add("userRow");
          usernameP.id = "username";
          nameP.id = "name";
          surenameP.id = "surename";
          verifiedInput.id = "verified";
          spaceInput.id = "space";
          verifiedInput.type = "checkbox";
          spaceInput.type = "text";

          usernameP.textContent = user.username;
          nameP.textContent = user.name;
          surenameP.textContent = user.surename;
          spaceInput.value = user.space;
          verifiedInput.checked = user.verified === "1";

          usernameP.classList.add("flexItem");
          nameP.classList.add("flexItem");
          surenameP.classList.add("flexItem");
          spaceInput.classList.add("flexItem");
          verifiedInput.classList.add("flexItem");

          userRow.appendChild(usernameP);
          userRow.appendChild(nameP);
          userRow.appendChild(surenameP);
          userRow.appendChild(spaceInput);
          userRow.appendChild(verifiedInput);

          userList.appendChild(userRow);

          console.log(user);
        })
      })
    }

    function SaveUsers() {
      const userList = document.getElementById("userList");
      const users = [];

      Array.from(userList.children).forEach(row => {
        users.push({
          username: row.querySelector("#username").textContent,
          space: row.querySelector("#space").value,
          verified: row.querySelector("#verified").checked
        });
      });

      console.log(users);

      fetch("api/setusers.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json"
        },
        body: JSON.stringify({users: users})
      })
      .then(response => response.json())
      .then(data => {
        if (data.error) {
          document.getElementById("message").textContent = data.error;
        } else {
          document.getElementById("message").textContent = "";

          GetUsers();
        }
      })
    }

    function LogOut() {
      fetch("api/logout.php")
      .then(() => {
        window.location.href = "index.php";
      })
    }

    GetUsers();
  </script>
</body>
</html>