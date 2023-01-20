<?php

$icon_path = '../imgs/icon_auth.png';

if (isset($_SESSION['user_id'])) {
  $icon_path = '../imgs/icon_acc.png';
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="icon"
      href="https://cdn-icons-png.flaticon.com/512/1687/1687357.png"
    />
    <title>Maps</title>
    <link rel="stylesheet" href="/CSS/style.css" />
  </head>
  <body>
    <header>
      <span>ZOO WALKING</span>
    </header>
    <main>
    <div class="container">
      <div class="map" id="map"></div>
      <div class="buttons">
        <label>Есть освещение<input type="checkbox" class="has-lightning" value="yes" /></label>
        <label>Размер площадки</label>
        <select name="area" id="areaSelect">
          <option value="base">Все площадки</option>
          <option value="small">Маленькая</option>
          <option value="medium">Средняя</option>
          <option value="large">Большая</option>
        </select>
        <label>На площадке должно быть:</label>
        <select name="elements" id="elementsSelect">
          <option value="base">Не выбрано</option>
          <option value="barrier">Барьер</option>
          <option value="urn">Урна</option>
          <option value="chute">Горка</option>
        </select>
        <h2 class="places__title">Подходящие площадки</h2>
        <div class="places">
        </div>
      </div>
      <form action="auth.php" class="account" method="post">
        <div class="accountIcon">
          <img class="iconAuth" src="<?=$icon_path?>" alt="Иконка входа">
        </div>
        <button class="account_btn" name="account">Вход / Регистрация</button>
      </form>
    </div>
  </main>
    <script
      src="https://api-maps.yandex.ru/2.1/?apikey=5eca22fe-0a55-452a-8d5e-e64f4be09851&lang=ru_RU"
      type="text/javascript"
    ></script>
    <script src="/JS/script.js"></script>

    <script>
      <?php
        include "connect_db.php";

        $result = mysqli_query($connection, "
        select *
        from open_data
        ");

        $row = mysqli_fetch_assoc($result);
        $data = "['".$row['location']."', '".$row['area']."', '".$row['elements']."', '".$row['lightning']."', '".$row['geodata_center']."']";
        
        while ($row = mysqli_fetch_assoc($result)) {
          $data .= ", ['".$row['location']."', '".$row['area']."', '".$row['elements']."', '".$row['lightning']."', '".$row['geodata_center']."']";
        }
       
        

        echo "
        getCenters([".$data."]);
        ymaps.ready(init);
        ";
      ?>
      
    </script>

    <!-- <script>
      act();
      console.log(111);
    </script> -->

    <footer>
      <span></span>
    </footer>
  </body>
</html>
