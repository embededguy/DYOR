<?php
    include('config/db.php');

    $sql = "SELECT * FROM tblspecification_m";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $pro = [];
        while ($row = $result->fetch_assoc()) {
            $pro[] = $row;
        }
    } else {
        $pro = [];
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DYOR - View Specifiactions</title>
        <!-- Favicons -->
        <link href="img/favicon.png" rel="icon">
        <link href="img/apple-touch-icon.png" rel="apple-touch-icon">
        <!-- Bootstrap core CSS -->
        <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <!--external css-->
        <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="css/zabuto_calendar.css">
        <link rel="stylesheet" type="text/css" href="lib/gritter/css/jquery.gritter.css" />
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/style-responsive.css" rel="stylesheet">
        <script src="lib/chart-master/Chart.js"></script>
        <style>
            tr:nth-child(even) {
                background-color: #f0f0f0;
            }
            tr:nth-child(odd) {
                background-color: #e8e8e8;
            }
            td:hover {
                background-color: #e0e0e0;
            }
            td{
                word-break: break-word;
            }
            th {
                background-color: #fff;
                color: #000;
            }
            tr {
                transition: background-color 0.3s ease;
            }

        </style>
    </head>
    <body>
        <section id="container" style="display:flex;justify-content: center;">
            <?php include 'header.php';?>

            <table class="table table-bordered" style="margin-top: 120px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pro as $prod) : ?>
                    <tr>
                        <td><?php echo $prod['tblSpecification_PK']; ?></td>
                        <td><?php echo $prod['tblSpecification_Name']; ?></td>
                                                                      
                        <td>
                            <!-- View Button -->
                            <a href="specificationsAED.php" class="btn btn-warning btn-sm">Edit</a>

                            <!-- Edit Button -->
                            <a href="specificationsAED.php" class="btn btn-danger btn-sm">Delete</a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </section>
    </body>
</html>