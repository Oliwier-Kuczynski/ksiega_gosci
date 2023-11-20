<?php
include_once "./database.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST["name"];
  $email = $_POST["email"];
  $message = $_POST["message"];

  $sql = "INSERT INTO `goscie` (`name`, `email`, `message`) VALUES ('$name', '$email', '$message')";
  $result = $conn->query($sql);
  if(!$result) {
    echo "Nie udało się dodać wpisu";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <link rel="shortcut icon" href="./img/book.svg" type="image/x-icon" />
    <title>Lista gości</title>
  </head>
  <body>
    <header>
      <nav class="nav">
        <div class="container flex jc-sb">
          <img src="./img/book.svg" alt="book" class="nav__logo" />
          <ul class="nav__ul flex ai-c gap">
            <li><a href="./index.php" class="nav__link">Zobacz księge</a></li>
            <li><a href="#" class="nav__link">Dodaj wpis</a></li>
          </ul>
        </div>
      </nav>
    </header>
    <main class="container">
      <form action="./addpost.php" method="post" class="form">
        <div>
          <label for="name">Imie</label>
          <input type="text" name="name" id="name" />
        </div>
        <div>
          <label for="email">Email</label>
          <input type="email" name="email" id="email" />
        </div>
        <div>
          <label for="message">Wiadomość</label>
          <textarea
            name="message"
            id="message"
            cols="40"
            rows="10"
            style="resize: vertical"
          ></textarea>
        </div>
        <button type="submit" class="button">Dodaj</button>
      </form>
    </main>
  </body>
</html>
