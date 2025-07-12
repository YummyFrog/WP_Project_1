<?php
session_start();
if (!isset($_SESSION['email'])) {
    // Not logged in
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
    }
    .button {
      display: inline-block;
      border: 2px solid #000;
      padding: 10px 20px;
      text-decoration: none;
      color: #000;
      margin: 5px;
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
        <a class="button" href="#new-game-options">NEW GAME</a>
      </div>
      <div>
        <div class="box">Picture</div>
        <a class="button" href="easy.html">CONTINUE LAST GAME</a>
      </div>
    </div>

    <div id="new-game-options" class="section">
      <h3>NUMBER OF PLAYERS</h3>
      <a class="button" href="#">1</a>
      <a class="button" href="#">2</a>
      <a class="button" href="#">3</a>
      <a class="button" href="#">4</a>
      <br><br>
      <a class="button" href="easy.html">EASY</a>
      <a class="button" href="hard.html">HARD</a>
      <p><small>Will only show up when the player clicks new game</small></p>
    </div>

    <a class="logout" href="logout.php">LOGOUT</a>
  </div>
</body>
</html>
