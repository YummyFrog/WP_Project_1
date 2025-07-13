<?php
session_start();
if (!isset($_SESSION['email'])) {
    header('Location: login.html');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Menu Page</title>
  <style>
    * { box-sizing: border-box; }
    body {
      background-color: #fff;
      font-family: Arial, sans-serif;
      color: #000;
      margin: 0;
      padding: 20px;
    }
    h1 {
      text-align: center;
      border-bottom: 2px solid #000;
      padding: 10px;
    }
    .container {
      max-width: 800px;
      margin: 20px auto;
      text-align: center;
      border: 2px solid #000;
      padding: 20px;
    }
    .game-options {
      display: flex;
      justify-content: space-around;
      margin-bottom: 30px;
    }
    .box {
      border: 2px solid #000;
      width: 150px;
      height: 100px;
      margin: auto;
      line-height: 100px;
      margin-bottom: 10px;
    }
    .button {
      display: inline-block;
      border: 2px solid #000;
      padding: 10px 20px;
      text-decoration: none;
      color: #000;
      margin: 5px;
      cursor: pointer;
    }
    .selected {
      background-color: #ccc;
      font-weight: bold;
    }
    .section {
      border: 2px dashed #000;
      padding: 15px;
      margin-top: 20px;
    }
    .logout {
      display: inline-block;
      border: 2px solid #000;
      padding: 10px 20px;
      text-decoration: none;
      color: #000;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <h1>MENU PAGE</h1>
  <div class="container">
    <h2>PICK YOUR POISON...</h2>

    <div class="game-options">
      <div>
        <div class="box">Picture</div>
        <button class="button" id="newGameBtn">NEW GAME</button>
      </div>
      <div>
        <div class="box">Picture</div>
        <a class="button" href="#">CONTINUE LAST GAME</a>
      </div>
    </div>

    <div id="new-game-options" class="section">
      <h3>NUMBER OF PLAYERS</h3>
      <div id="players">
        <button class="button" data-value="1">1</button>
        <button class="button" data-value="2">2</button>
        <button class="button" data-value="3">3</button>
        <button class="button" data-value="4">4</button>
      </div>

      <h3>DIFFICULTY</h3>
      <div id="difficulty">
        <button class="button" data-value="easy">EASY</button>
        <button class="button" data-value="hard">HARD</button>
      </div>

      <p><small>Select number of players and difficulty before starting a new game.</small></p>
    </div>

    <a class="logout" href="logout.php">LOGOUT</a>
  </div>

  <script>
    let selectedPlayers = null;
    let selectedDifficulty = null;

    // Highlight on select
    document.querySelectorAll('#players .button').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('#players .button').forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        selectedPlayers = btn.getAttribute('data-value');
      });
    });

    document.querySelectorAll('#difficulty .button').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('#difficulty .button').forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        selectedDifficulty = btn.getAttribute('data-value');
      });
    });

    document.getElementById('newGameBtn').addEventListener('click', () => {
      if (!selectedPlayers || !selectedDifficulty) {
        alert("Please select number of players and difficulty!");
        return;
      }

      const targetPage = selectedDifficulty + ".html?players=" + selectedPlayers;
      window.location.href = targetPage;
    });
  </script>
</body>
</html>
