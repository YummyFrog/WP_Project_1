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
      padding: 0;
    }
    h1 {
      text-align: center;
      border-bottom: 2px solid #000;
      padding: 15px;
      margin: 0;
    }
    .container {
      max-width: 900px;
      margin: 20px auto;
      border: 2px solid #000;
      padding: 20px;
      text-align: center;
    }
    h2 {
      margin-top: 0;
      margin-bottom: 20px;
    }
    .game-top {
      display: flex;
      justify-content: space-around;
      align-items: center;
      margin-bottom: 20px;
    }
    .picture-box {
      border: 2px solid #000;
      width: 150px;
      height: 100px;
      line-height: 100px;
      text-align: center;
      margin-bottom: 10px;
    }
    .game-buttons {
      display: flex;
      justify-content: space-around;
    }
    .button {
      display: inline-block;
      border: 2px solid #000;
      padding: 10px 20px;
      margin: 5px;
      text-decoration: none;
      color: #000;
      cursor: pointer;
      background-color: #fff;
    }
    .selected {
      background-color: #ccc;
      font-weight: bold;
    }
    .section {
      border: 2px dashed #000;
      padding: 15px;
      margin-top: 20px;
      text-align: center;
    }
    .logout {
      display: block;
      border: 2px solid #000;
      width: 150px;
      margin: 30px auto 0;
      padding: 10px 0;
      text-decoration: none;
      color: #000;
      text-align: center;
    }
  </style>
</head>
<body>
  <h1>MENU PAGE</h1>
  <div class="container">
    <h2>PICK YOUR POISON...</h2>

    <div class="game-top">
      <div>
        <div class="picture-box">Picture</div>
        <button class="button" id="newGameBtn">NEW GAME</button>
      </div>
      <div>
        <div class="picture-box">Picture</div>
        <button class="button" id="continueBtn">CONTINUE LAST GAME</button>
      </div>
    </div>

    <div class="section">
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

    // Selection highlighting
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

    // CONTINUE LAST GAME
    document.getElementById('continueBtn').addEventListener('click', () => {
      const easySave = localStorage.getItem('easyGameSave');
      const hardSave = localStorage.getItem('hardGameSave');

      if (!easySave && !hardSave) {
        alert("No saved games found!");
        return;
      }

      if (easySave && !hardSave) {
        const data = JSON.parse(easySave);
        window.location.href = `easy.html?players=${data.numPlayers}&load=true`;
        return;
      }

      if (!easySave && hardSave) {
        const data = JSON.parse(hardSave);
        window.location.href = `hard.html?players=${data.numPlayers}&load=true`;
        return;
      }

      // If both saves exist, ask user which one
      const choice = prompt("You have saves for both Easy and Hard.\nType 'easy' or 'hard' to choose.");
      if (choice && choice.toLowerCase() === 'easy') {
        const data = JSON.parse(easySave);
        window.location.href = `easy.html?players=${data.numPlayers}&load=true`;
      } else if (choice && choice.toLowerCase() === 'hard') {
        const data = JSON.parse(hardSave);
        window.location.href = `hard.html?players=${data.numPlayers}&load=true`;
      } else {
        alert("No valid choice made. Cancelled.");
      }
    });
  </script>
</body>
</html>
