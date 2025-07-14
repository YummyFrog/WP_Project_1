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
      background-image: url('menubg.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      font-family: Arial, sans-serif;
      color: #000;
      margin: 0;
      padding: 0;
      min-height: 100vh;
      position: relative;
    }
    
    /* Header */
    .header {
      background-color: rgba(255, 255, 255, 0.9);
      text-align: center;
      padding: 20px;
      border-bottom: 3px solid #000;
    }
    
    .header h1 {
      margin: 0;
      font-size: 36px;
      font-weight: bold;
      color: #000;
    }
    
    /* Main content */
    .main-title {
      text-align: center;
      font-size: 48px;
      font-weight: bold;
      color: #FFD700;
      text-shadow: 3px 3px 0px #000;
      margin: 40px 0;
    }
    
    /* Game options */
    .game-options {
      display: flex;
      justify-content: center;
      gap: 200px;
      margin: 50px 0;
      align-items: flex-end;
    }
    
    .game-option {
      display: flex;
      flex-direction: column;
      align-items: center;
      text-align: center;
      position: relative;
    }
    
    .snake-image {
      width: 200px;
      height: 200px;
      margin-bottom: 20px;
      object-fit: contain;
      display: block;
    }
    
    .game-button {
      background-color: #FFD700;
      border: 4px solid #000;
      padding: 15px 30px;
      font-size: 18px;
      font-weight: bold;
      color: #000;
      cursor: pointer;
      text-decoration: none;
      display: block;
      transition: all 0.3s ease;
      min-width: 200px;
      text-align: center;
    }
    
    .game-button:hover {
      background-color: #FFA500;
      transform: scale(1.05);
    }
    
    /* Settings section (initially hidden) */
    .settings-section {
      display: none;
      background-color: rgba(255, 255, 255, 0.95);
      border: 4px dashed #000;
      margin: 50px auto;
      padding: 40px;
      width: 800px;
      text-align: center;
      position: relative;
    }
    
    .settings-section.show {
      display: block;
    }
    
    .settings-section h3 {
      font-size: 24px;
      font-weight: bold;
      color: #FFD700;
      text-shadow: 2px 2px 0px #000;
      margin-bottom: 20px;
    }
    
    .option-buttons {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-bottom: 40px;
    }
    
    .option-button {
      background-color: #FFD700;
      border: 3px solid #000;
      padding: 12px 25px;
      font-size: 16px;
      font-weight: bold;
      color: #000;
      cursor: pointer;
      transition: all 0.3s ease;
      min-width: 80px;
    }
    
    .option-button:hover {
      background-color: #FFA500;
    }
    
    .option-button.selected {
      background-color: #000;
      color: #FFD700;
    }
    
    .settings-note {
      font-size: 14px;
      color: #000;
      margin-top: 20px;
      font-weight: bold;
    }
    
    /* Helper text */
    .helper-text {
      position: absolute;
      right: -220px;
      top: 50%;
      transform: translateY(-50%);
      background-color: rgba(255, 255, 255, 0.9);
      padding: 20px;
      border: 2px solid #000;
      font-size: 14px;
      color: #000;
      width: 200px;
      text-align: center;
      font-weight: bold;
    }
    
    /* Logout button */
    .logout {
      position: fixed;
      bottom: 30px;
      left: 30px;
      background-color: #FF0000;
      border: 3px solid #000;
      padding: 12px 25px;
      font-size: 16px;
      font-weight: bold;
      color: #FFF;
      text-decoration: none;
      transition: all 0.3s ease;
    }
    
    .logout:hover {
      background-color: #CC0000;
      transform: scale(1.05);
    }
    
    /* Responsive adjustments */
    @media (max-width: 1200px) {
      .game-options {
        gap: 100px;
      }
      
      .helper-text {
        display: none;
      }
      
      .settings-section {
        width: 90%;
        max-width: 800px;
      }
    }
    
    @media (max-width: 768px) {
      .game-options {
        flex-direction: column;
        gap: 50px;
        align-items: center;
      }
      
      .main-title {
        font-size: 36px;
      }
      
      .option-buttons {
        flex-wrap: wrap;
        gap: 15px;
      }
      
      .snake-image {
        width: 150px;
        height: 150px;
      }
      
      .game-button {
        min-width: 180px;
      }
    }
  </style>
</head>
<body>
  <div class="header">
    <h1>MENU PAGE</h1>
  </div>
  
  <div class="main-title">PICK YOUR POISON...</div>
  
  <div class="game-options">
    <div class="game-option">
      <img src="snake1.png" alt="Snake 1" class="snake-image">
      <button class="game-button" id="newGameBtn">NEW GAME</button>
    </div>
    <div class="game-option">
      <img src="snake2.png" alt="Snake 2" class="snake-image">
      <button class="game-button" id="continueBtn">CONTINUE LAST GAME</button>
    </div>
  </div>
  
  <div class="settings-section" id="settingsSection">
    
    <h3>NUMBER OF PLAYERS</h3>
    <div class="option-buttons" id="players">
      <button class="option-button" data-value="1">1</button>
      <button class="option-button" data-value="2">2</button>
      <button class="option-button" data-value="3">3</button>
      <button class="option-button" data-value="4">4</button>
    </div>

    <h3>DIFFICULTY</h3>
    <div class="option-buttons" id="difficulty">
      <button class="option-button" data-value="easy">EASY</button>
      <button class="option-button" data-value="hard">HARD</button>
    </div>

    <p class="settings-note">Select number of players and difficulty before starting a new game.</p>
  </div>

  <a class="logout" href="logout.php">LOGOUT</a>

  <script>
    let selectedPlayers = null;
    let selectedDifficulty = null;
    let settingsVisible = false;

    // Show settings when NEW GAME is clicked
    document.getElementById('newGameBtn').addEventListener('click', () => {
      if (!settingsVisible) {
        document.getElementById('settingsSection').classList.add('show');
        settingsVisible = true;
        return;
      }
      
      // If settings are already visible, proceed with game start
      if (!selectedPlayers || !selectedDifficulty) {
        alert("Please select number of players and difficulty!");
        return;
      }
      const targetPage = selectedDifficulty + ".html?players=" + selectedPlayers;
      window.location.href = targetPage;
    });

    // Selection highlighting for players
    document.querySelectorAll('#players .option-button').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('#players .option-button').forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        selectedPlayers = btn.getAttribute('data-value');
      });
    });

    // Selection highlighting for difficulty
    document.querySelectorAll('#difficulty .option-button').forEach(btn => {
      btn.addEventListener('click', () => {
        document.querySelectorAll('#difficulty .option-button').forEach(b => b.classList.remove('selected'));
        btn.classList.add('selected');
        selectedDifficulty = btn.getAttribute('data-value');
      });
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