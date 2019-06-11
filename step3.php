<?php
  session_start();

  if(!isset($_SESSION['criteria'])){
    header('Location: step1.php');
  }

  // Inisialisasi
  $n_criteria = $_SESSION['n_criteria'];
  $n_subject = $_SESSION['n_subject'];
  $criteria = $_SESSION['criteria'];
  $weight = $_SESSION['weight'];
  $type = $_SESSION['type'];
  $subject = $_SESSION['subject'];
  $value = $_SESSION['value'];
  $limit = array();
  $Q = array();

  // Normalisasi matriks
  // a.) Mencari nilai minimal atau maksimal sesuai tipe 
  for($i=0; $i<$n_criteria; $i++){
    if($type[$i] == "benefit"){
      $max = $value[$i];
      
      for($j=0; $j<$n_subject * $n_criteria; $j+=$n_criteria){
        $index = $j + $i;
        if($max < $value[$index]){
          $max = $value[$index];
        }
      }

      $limit[$i] = $max;
    } 
    else if($type[$i] == "cost"){
      $min = $value[$i];

      for($j=0; $j<$n_subject * $n_criteria; $j+=$n_criteria){
        $index = $j + $i;
        if($min > $value[$index]){
          $min = $value[$index];
        }
      }

      $limit[$i] = $min;
    }
  }

  // b.) Menghitung normalisasi
  for($i=0; $i<$n_criteria; $i++){
    if($type[$i] == "benefit"){
      for($j=0; $j<$n_subject * $n_criteria; $j+=$n_criteria){
        $index = $j + $i;
        $value[$index] = $value[$index] / $limit[$i];
      }
    } 
    else if($type[$i] == "cost"){
      for($j=0; $j<$n_subject * $n_criteria; $j+=$n_criteria){
        $index = $j + $i;
        $value[$index] = $limit[$i] / $value[$index];
      }
    }
  }

  // c.) Menghitung Qi
  for($i=0; $i<$n_subject; $i++){
    // step 1
    $row = 0;
    for($j=0; $j<$n_criteria; $j++){
      $index = $j + ($i * $n_criteria);
      $col = $value[$index] * $weight[$j] / 100;
      $row += $col;
      // echo $value[$index] . " dikali " . $weight[$j] / 100 . "<br>";
    }
    // echo $row . "<br>";
    $Q[$i] = 0.5 * $row;

    // step 2
    $row = 1;
    for($j=0; $j<$n_criteria; $j++){
      $index = $j + ($i * $n_criteria);
      $col = pow($value[$index], ($weight[$j] / 100));
      $row *= $col;
      // echo $value[$index] . " dipangkat " . $weight[$j] / 100 . "<br>";
    }
    // echo 0.5 * $row . "<br>";
    $Q[$i] = 0.5 * $row + $Q[$i];
    // echo $Q[$i] . "<br>";
  }

  // d.) Mengurutkan berdasarkan nilai terbesar
  for($i=0; $i<$n_subject; $i++){
    $Q[$i] = array($Q[$i], $subject[$i]);
  }

  sort($Q);
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
  <table>
    <tr>
      <th>Subjek</th>
      <th>Nilai</th>
      <th>Peringkat</th>
    </tr>
    <?php for($i = $n_subject-1; $i >= 0; $i--){ ?>
    <tr>
      <td><?php echo $Q[$i][1]; ?></td>
      <td align="center"><?php echo $Q[$i][0]; ?></td>
      <td align="center"><?php echo $n_subject - $i; ?></td>
    </tr>
    <?php } ?>
  </table>
  <a href="index.php"><button>Hitung Lagi</button></a>
</body>

</html>
