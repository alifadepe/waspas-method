<?php
  session_start();

  if(!isset($_SESSION['n_criteria'])){
    header('Location: index.php');
  }

  $n_criteria = $_SESSION['n_criteria'];

  if(isset($_POST['button'])){
    $_SESSION['criteria'] = $_POST['criteria'];
    $_SESSION['weight'] = $_POST['weight'];
    $_SESSION['type'] = $_POST['type'];

    header('Location: step2.php');
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
    <table>
      <tr>
        <th>Kriteria</th>
        <th>Bobot (%)</th>
        <th>Jenis</th>
      </tr>
      <?php for($i=0; $i<$n_criteria; $i++) { ?>
      <tr>
        <td><input name="criteria[]" type="text" required></td>
        <td><input name="weight[]" type="number" required>%</td>
        <td>
          <select name="type[]">
            <option value="benefit">Benefit</option>
            <option value="cost">Cost</option>
          </select>
        </td>
      </tr>
      <?php } ?>
    </table>
    <input name="button" type="submit" value="Next">
  </form>
</body>

</html>