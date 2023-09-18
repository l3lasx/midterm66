<?php
include("dbconnect/dbconnect.php");

if (isset($_GET['band_id']) && isset($_GET['type'])) {

    $band_id = $_GET['band_id'];
    $type = $_GET['type'];

    $sql = "SELECT * FROM bands INNER JOIN bandgenres ON bands.GenreID = bandgenres.GenreID WHERE BandID = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $band_id);
    $stmt->execute();
    $result = $stmt->get_result();
}

$row = $result->fetch_assoc();
$rescreen = "show.php?band_id=" . $band_id . "&type=" . $type;

if (isset($_GET['band_id']) && isset($_GET['vote'])) {
    $sql = "Update bands SET Score = Score + 1 WHERE BandID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $band_id);
    $stmt->execute();

    header("Location: $rescreen");
    exit();
}
?>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CSMSU Music Award 2023</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="style/show.css">

</head>

<body class="bg">
    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row">
            <div class="col-12" style="display: flex; justify-content: end;">
                <h1 class="text-light">CS MSU Music Award 2023</h1>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-12" style="display: flex; justify-content: start;">
                <h3 class="text-light"><a class="text-info" href="index.php?type=<?= $type ?>" style="text-decoration: none; ">หน้าแรก </a>/ <?= $row['BandName'] ?></h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12" style="display: flex; justify-content: center;">
                <div class="card" style="width: 75%; margin-top:20px">
                    <img class="card-img-top" src="<?= $row['ImageURL'] ?>" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title"><?= $row['BandName'] ?> - <?= $row['GenreName'] ?></h5>
                        <p class="card-text"><?= $row['information'] ?></p>
                        <div style="display: flex; justify-content: end; align-items: center;">
                            <form action="show.php">
                                <input type="hidden" name="band_id" value="<?= $row['BandID'] ?>">
                                <input type="hidden" name="type" value="<?= $type ?>">
                                <input type="hidden" name="vote">
                                <button type="submit" class="btn" onclick="return confirm('ยืนยันการโหวต <?= $row['BandName'] ?>')">
                                    <i class="fa-solid fa-heart" style="color: red; font-size: 16pt;">
</i>
                                </button>(<?= $row['Score'] ?>)
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <?php

        ?>
    </div>



</body>