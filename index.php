<?php
include("dbconnect/dbconnect.php");

$type = "0";

if (isset($_GET['type']) && $_GET['type'] != "0") {
    //type bands
    $type = $_GET['type'];

    $sql = "SELECT * FROM bands WHERE GenreID = ? ORDER BY Score DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $type);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM bands ORDER BY Score DESC";
    $result = $conn->query($sql);
}

$genreQuery = "SELECT * FROM bandgenres";
$genreResult = $conn->query($genreQuery);

$genres = array(
    0 => "วงดนตรีทั้งหมด",
);

while ($genreRow = $genreResult->fetch_assoc()) {
    $genres[$genreRow['GenreID']] = $genreRow['GenreName'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style/index.css">
</head>

<body class="bg">
    <div class="container-fluid" style="margin-top: 20px;">
        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <h1 class="text-light">CSMSU Music Award 2023</h1>
            </div>
        </div>
    </div>

    <div class="container" style="margin-top: 20px;">
        <div class="row">
            <div class="col-12" style="display: flex; justify-content: start;">
                <h3 class="text-light">วงดนตรี</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-3" style="display: flex; justify-content: start;">
                <form action="index.php" method="get">
                    <select class="form-select" aria-label="Default select example" name="type" onchange="this.form.submit()">
                        <?php
                        //asociative array
                        foreach ($genres as $key => $genre) {
                            $selected = ($type == $key) ? "selected" : "";
                            echo "<option value='$key' $selected>$genre</option>";
                        }
                        ?>
                    </select>
                </form>
            </div>
        </div>

        <?php
        $count = 0; //count col
        while ($row = $result->fetch_assoc()) {
            // new row if count % 3 equal 0
            // open tag
            if ($count % 3 == 0) {
                echo '<div class="row" style="margin-top: 20px;">';
            }
        ?>

            <div class="col-4" style="display: flex; justify-content: center;">
                <a href="show.php?band_id=<?= $row['BandID'] ?>&type=<?= $type ?>">
                    <img class="zoom rcorner" src="<?= $row['ImageURL'] ?>" width="100%" height="100%" style="object-fit: cover;">
                </a>
            </div>

        <?php
            $count++;
            // closed tag
            if ($count % 3 == 0) {
                echo '</div>';
            }
        }

        ?>
    </div>

    <div class="row" style="margin-top: 40px;">
        <div class="col-12 text-light" style="display: flex; justify-content: center;">
            Copy โดย บาส CSMSU @ 2023
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
</body>

</html>