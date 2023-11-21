<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="style.css" />
    <link rel="shortcut icon" href="./img/book.svg" type="image/x-icon" />
    <script defer src="./script.js"></script>
    <title>Lista gości</title>
  </head>
  <body>
    <header>
      <nav class="nav">
        <div class="container flex jc-sb">
          <img src="./img/book.svg" alt="book" class="nav__logo" />
          <ul class="nav__ul flex ai-c gap">
            <li><a href="index.php" class="nav__link">Zobacz księge</a></li>
            <li><a href="./addpost.php" class="nav__link">Dodaj wpis</a></li>
          </ul>
        </div>
      </nav>
    </header>
    <main class="container">
      <form action="./index.php" method="get" class="retrive-bar flex jc-sb ai-c">
        <div class="flex ai-c sm-gap">
          <label for="entries">Pokaż</label>
          <select name="number-of-records" id="entries" class="retrive-bar__select" onchange="this.form.submit()">
            <option value="all" <?php echo (isset($_GET['number-of-records']) && $_GET['number-of-records'] == 'all') ? 'selected' : ''; ?>>Wszystkie</option>
            <option value="10" <?php echo (isset($_GET['number-of-records']) && $_GET['number-of-records'] == '10') ? 'selected' : ''; ?>>10</option>
            <option value="50" <?php echo (isset($_GET['number-of-records']) && $_GET['number-of-records'] == '50') ? 'selected' : ''; ?>>50</option>
            <option value="100" <?php echo (isset($_GET['number-of-records']) && $_GET['number-of-records'] == '100') ? 'selected' : ''; ?>>100</option>
          </select>
          <label for="entries">wpisy/wpisów</label>
        </div>

        <div class="retrive-bar__search-bar flex ai-c sm-gap">
          <img src="./img/search.svg" alt="search" />
          <input type="text" name="search-string"/>
        </div>
      </form>

      <table class="table">
        <thead>
          <tr>
            <th>Imie</th>
            <th>Email</th>
            <th>Czas</th>
            <th>Status</th>
            <th>Wiadomość</th>
            <th>Akcje</th>
          </tr>
        </thead>
        <tbody>
          <?php
            require_once "./database.php";

            $sql = "SELECT * FROM `goscie`";
            
            
            if(isset($_GET["search-string"]) && (empty($_GET["search-string"]) === false)) {
              $sql .= " WHERE `name` LIKE '%?%' OR `email` LIKE '%?%' OR `message` LIKE '%?%' OR `date` LIKE '%?%' OR `status` LIKE '%?%' ";
            }

            if(isset($_GET["number-of-records"]) && empty($_GET["number-of-records"]) === false && $_GET["number-of-records"] !== "all") {
              $sql .= " LIMIT {$_GET["number-of-records"]} ";
            }

            $stmt = $conn->prepare($sql);
            
            if(isset($_GET["search-string"])) {
              $stmt->bind_param("sssss", $_GET["search-string"], $_GET["search-string"], $_GET["search-string"], $_GET["search-string"], $_GET["search-string"]);
            }

            if(isset($_GET["number-of-records"]) && $_GET["number-of-records"] !== "all") {
              $stmt->bind_param("i", $_GET["number-of-records"]);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  echo <<<END
                      <tr data-id="{$row["id"]}" data-name="{$row["name"]}" data-email="{$row["email"]}" data-message="{$row["message"]}">
                          <td>{$row["name"]}</td>
                          <td>{$row["email"]}</td>
                          <td>{$row["date"]}</td>
                          <td class='txt-a-c'>
                              <span class='indicator'>{$row["status"]}</span>
                          </td>
                          <td class='txt-a-c'>
                              <button class='btn' onclick="showMessage('{$row["message"]}')">Wiadomość</button>
                          </td>
                          <td class='flex jc-c gap'>
                              <button class='action-btn' onclick="openEdit(this)">
                                  <svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                      <path d='M5 19H6.425L16.2 9.225L14.775 7.8L5 17.575V19ZM3 21V16.75L16.2 3.575C16.4 3.39167 16.6208 3.25 16.8625 3.15C17.1042 3.05 17.3583 3 17.625 3C17.8917 3 18.15 3.05 18.4 3.15C18.65 3.25 18.8667 3.4 19.05 3.6L20.425 5C20.625 5.18333 20.7708 5.4 20.8625 5.65C20.9542 5.9 21 6.15 21 6.4C21 6.66667 20.9542 6.92083 20.8625 7.1625C20.7708 7.40417 20.625 7.625 20.425 7.825L7.25 21H3ZM15.475 8.525L14.775 7.8L16.2 9.225L15.475 8.525Z'/>
                                  </svg>
                              </button>
                              <button class='action-btn' onclick="deletePost({$row['id']})">
                                  <svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                      <path d='M7 21C6.45 21 5.97917 20.8042 5.5875 20.4125C5.19583 20.0208 5 19.55 5 19V6H4V4H9V3H15V4H20V6H19V19C19 19.55 18.8042 20.0208 18.4125 20.4125C18.0208 20.8042 17.55 21 17 21H7ZM17 6H7V19H17V6ZM9 17H11V8H9V17ZM13 17H15V8H13V17Z'/>
                                  </svg>
                              </button>
                          </td>
                      </tr>
              END;
                  }
              }

              $stmt->close();
              $conn->close();
          ?>
        </tbody>
      </table>
    </main>
    <div class="message hidden" data-message-element="">
      <button class="close-btn" type="button"  onclick="closeInfo(this)">
        <img src="./img/close.svg" alt="close">
      </button>
      <p></p>
    </div>
    
    <form action="functions.php" method="post" class="edit-form form hidden" data-edit-post="">
      <button class="close-btn" type="button"  onclick="closeInfo(this)">
        <img src="./img/close.svg" alt="close">
      </button>
      <input type="hidden" value="" name="id" id="id">
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
      <button type="submit" class="button">Edytuj</button>
    </form>

    <div class="info-blur hidden" data-info-blur></div>
  </body>
</html>
