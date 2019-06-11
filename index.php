<?php
  session_start();
  session_destroy();
  session_start();

  if(isset($_POST['button'])){
    $_SESSION['n_criteria'] = $_POST['n_criteria'];
    $_SESSION['n_subject'] = $_POST['n_subject'];
    
    header('Location: step1.php');
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Aplikasi SPK</title>
</head>

<body>
  <form method="POST" target="_self">
    <div>Masukkan jumlah kriteria</div>
    <div><input name="n_criteria" type="number" required></div>
    <div>Masukkan jumlah subjek</div>
    <div><input name="n_subject" type="number" required></div>
    <input name="button" type="submit" value="Next">
  </form>
</body>

</html>