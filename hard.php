<?php
session_start();

$numPlayers = isset($_GET['players']) ? intval($_GET['players']) : 1;
$loadParam = isset($_GET['load']) ? $_GET['load'] : 'false';

// Initialize game state
if (!isset($_SESSION['hard_game']) || $loadParam !== 'true') {
  $_SESSION['hard_game'] = [
    'playerPositions' => array_fill(0, $numPlayers, 0),
    'currentPlayer' => 0,
    'gameOver' => false,
    'numPlayers' => $numPlayers,
    'lastRoll' => 0
  ];
}

$game = $_SESSION['hard_game'];

// Handle dice roll
if (isset($_POST['roll']) && !$game['gameOver']) {
  $roll = rand(1, 6);
  $game['lastRoll'] = $roll;
  
  $pos = $game['playerPositions'][$game['currentPlayer']] + $roll;
  if ($pos > 100) $pos = 100;
  
  // Hard mode snakes and ladders - more challenging
  $snakes = [17 => 7, 54 => 34, 62 => 19, 87 => 24, 99 => 78];
  $ladders = [4 => 14, 28 => 48, 40 => 59];
  
  if (isset($snakes[$pos])) $pos = $snakes[$pos];
  elseif (isset($ladders[$pos])) $pos = $ladders[$pos];
  
  $game['playerPositions'][$game['currentPlayer']] = $pos;
  
  if ($pos === 100) {
    $game['gameOver'] = true;
  } else {
    $game['currentPlayer'] = ($game['currentPlayer'] + 1) % $game['numPlayers'];
  }
  
  $_SESSION['hard_game'] = $game;
}

// Handle save game
if (isset($_POST['save'])) {
  // In a real implementation, you would save to database
  // For now, we'll just show a message
  $saveMessage = "Game saved!";
}

$playerColors = ['red', 'blue', 'green', 'purple'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Hard Game Board</title>
  <style>
    body {
      background: url('menubg.png') no-repeat center center fixed;
      background-size: cover;
      font-family: Arial, sans-serif;
      color: #fff;
      margin: 0;
      padding: 20px;
      min-height: 100vh;
    }
    
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    
    .back-btn {
      background: transparent;
      border: 3px solid #fff;
      color: #fff;
      padding: 10px 20px;
      font-size: 18px;
      cursor: pointer;
      border-radius: 5px;
      display: flex;
      align-items: center;
      gap: 10px;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
      text-decoration: none;
    }
    
    .back-btn:hover {
      background: rgba(255,255,255,0.2);
    }
    
    .game-container {
      display: flex;
      gap: 20px;
      justify-content: center;
      align-items: flex-start;
    }
    
    .main-board {
      background: rgba(255,255,255,0.95);
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.3);
    }
    
    h1 {
      text-align: center;
      color: #000;
      margin: 0 0 20px 0;
      font-size: 24px;
    }
    
    .turn-info {
      text-align: center;
      margin-bottom: 20px;
      font-size: 20px;
      font-weight: bold;
      color: #000;
    }
    
    .board-wrapper {
      position: relative;
      width: 500px;
      height: 500px;
      border: 3px solid #000;
      border-radius: 10px;
      overflow: hidden;
    }
    
    .board {
      display: grid;
      grid-template-columns: repeat(10, 50px);
      grid-template-rows: repeat(10, 50px);
      width: 500px;
      height: 500px;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 1;
      background: #fff;
    }
    
    .square {
      border: 1px solid #000;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
      font-size: 12px;
      font-weight: bold;
    }
    
    .player {
      position: absolute;
      width: 20px;
      height: 20px;
      border-radius: 50%;
      border: 2px solid #000;
      z-index: 10;
    }
    
    .snake-line {
      position: absolute;
      background: red;
      z-index: 2;
      pointer-events: none;
    }
    
    .ladder-line {
      position: absolute;
      background: green;
      z-index: 2;
      pointer-events: none;
    }
    
    .right-panel {
      display: flex;
      flex-direction: column;
      gap: 20px;
    }
    
    .player-pieces {
      background: #FFD700;
      border: 3px solid #000;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .player-pieces h3 {
      margin: 0 0 15px 0;
      color: #000;
      text-shadow: none;
    }
    
    .piece-display {
      display: flex;
      flex-direction: column;
      gap: 10px;
      align-items: center;
    }
    
    .piece-item {
      display: flex;
      align-items: center;
      gap: 10px;
      color: #000;
      font-weight: bold;
      text-shadow: none;
    }
    
    .piece-dot {
      width: 20px;
      height: 20px;
      border-radius: 50%;
      border: 2px solid #000;
    }
    
    .dice-container {
      background: #FFD700;
      border: 3px solid #000;
      border-radius: 10px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .dice-container h3 {
      margin: 0 0 15px 0;
      color: #000;
      text-shadow: none;
    }
    
    .dice {
      width: 80px;
      height: 80px;
      border: 3px solid #000;
      background: #000;
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 24px;
      font-weight: bold;
      cursor: pointer;
      transition: transform 0.3s;
      user-select: none;
      margin: 0 auto;
      border-radius: 5px;
      text-decoration: none;
    }
    
    .dice:hover {
      transform: scale(1.1);
    }
    
    .roll-result {
      margin-top: 15px;
      font-size: 16px;
      color: #000;
      text-shadow: none;
    }
    
    .save-game {
      background: #FFD700;
      border: 3px solid #000;
      border-radius: 10px;
      padding: 15px;
      text-align: center;
      cursor: pointer;
      transition: background 0.3s;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      text-decoration: none;
      display: block;
    }
    
    .save-game:hover {
      background: #FFE55C;
    }
    
    .save-game-text {
      color: #000;
      font-weight: bold;
      font-size: 16px;
      text-shadow: none;
    }
    
    .save-game-desc {
      color: #000;
      font-size: 14px;
      margin-top: 5px;
      text-shadow: none;
    }
    
    .win-message {
      text-align: center;
      margin-top: 20px;
      font-size: 24px;
      color: #00ff00;
      font-weight: bold;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
    }
    
    .player-red { background-color: red; }
    .player-blue { background-color: blue; }
    .player-green { background-color: green; }
    .player-purple { background-color: purple; }
  </style>
</head>
<body>
  <div class="header">
    <a href="menu.php" class="back-btn">
      <span>←</span> Back to menu
    </a>
  </div>
  
  <div class="game-container">
    <div class="main-board">
      <h1>Hard Game Board</h1>
      <div class="turn-info">
        <?php if (!$game['gameOver']): ?>
          Player <?php echo $game['currentPlayer'] + 1; ?>'s Turn (<?php echo $playerColors[$game['currentPlayer']]; ?>)
        <?php endif; ?>
      </div>
      
      <div class="board-wrapper">
        <div class="board">
          <?php
            // Generate board squares
            for ($visualRow = 0; $visualRow < 10; $visualRow++) {
              $actualRow = 9 - $visualRow;
              $rowNumbers = [];
              $startNum = $actualRow * 10 + 1;
              
              for ($i = 0; $i < 10; $i++) {
                $rowNumbers[] = $startNum + $i;
              }
              
              if ($actualRow % 2 === 1) {
                $rowNumbers = array_reverse($rowNumbers);
              }
              
              foreach ($rowNumbers as $num) {
                echo "<div class='square' data-num='$num'>";
                echo $num;
                
                // Show players on this square
                foreach ($game['playerPositions'] as $playerIdx => $pos) {
                  if ($pos === $num) {
                    $color = $playerColors[$playerIdx];
                    echo "<div class='player player-$color'></div>";
                  }
                }
                
                echo "</div>";
              }
            }
          ?>
        </div>
        
        <!-- Draw lines for snakes and ladders using CSS - More snakes and ladders for hard mode -->
        <div class="snake-line" style="left: 125px; top: 25px; width: 4px; height: 200px; transform: rotate(45deg);"></div>
        <div class="snake-line" style="left: 325px; top: 125px; width: 4px; height: 350px; transform: rotate(45deg);"></div>
        <div class="snake-line" style="left: 175px; top: 175px; width: 4px; height: 200px; transform: rotate(45deg);"></div>
        <div class="snake-line" style="left: 275px; top: 225px; width: 4px; height: 300px; transform: rotate(45deg);"></div>
        <div class="snake-line" style="left: 475px; top: 25px; width: 4px; height: 200px; transform: rotate(45deg);"></div>
        
        <div class="ladder-line" style="left: 75px; top: 375px; width: 4px; height: 150px; transform: rotate(-45deg);"></div>
        <div class="ladder-line" style="left: 225px; top: 275px; width: 4px; height: 200px; transform: rotate(-45deg);"></div>
        <div class="ladder-line" style="left: 375px; top: 175px; width: 4px; height: 200px; transform: rotate(-45deg);"></div>
      </div>
      
      <?php if ($game['gameOver']): ?>
        <div class="win-message">
          🎉 Player <?php echo $game['currentPlayer'] + 1; ?> Wins! 🎉
        </div>
      <?php endif; ?>
    </div>
    
    <div class="right-panel">
      <div class="player-pieces">
        <h3>Players</h3>
        <div class="piece-display">
          <?php for ($i = 0; $i < $game['numPlayers']; $i++): ?>
            <div class="piece-item">
              <div class="piece-dot" style="background-color: <?php echo $playerColors[$i]; ?>;"></div>
              <span>Player <?php echo $i + 1; ?></span>
            </div>
          <?php endfor; ?>
        </div>
      </div>
      
      <div class="dice-container">
        <h3>Dice</h3>
        <form method="post">
          <button type="submit" name="roll" class="dice" <?php echo $game['gameOver'] ? 'disabled' : ''; ?>>
            <?php echo $game['lastRoll'] > 0 ? $game['lastRoll'] : 'ROLL'; ?>
          </button>
        </form>
        <div class="roll-result">
          Number Rolled: <?php echo $game['lastRoll'] > 0 ? $game['lastRoll'] : '-'; ?>
        </div>
      </div>
      
      <form method="post">
        <button type="submit" name="save" class="save-game">
          <div class="save-game-text">SAVE GAME</div>
          <div class="save-game-desc">Save game progress to continue later</div>
        </button>
      </form>
      
      <?php if (isset($saveMessage)): ?>
        <div style="color: #00ff00; text-align: center; font-weight: bold;">
          <?php echo $saveMessage; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</body>
</html>