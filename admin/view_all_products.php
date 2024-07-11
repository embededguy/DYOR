<?php
    include('config/db.php');

    $catid = isset($_GET['category']) ? $_GET['category'] : 0;
    $x = [ '1' => 'Ho.Re.Ca', '2' => 'Medical', '3' => 'Salon & Spa' ];
    if($catid){
        $sql = "SELECT * FROM tblproduct_p WHERE tblProduct_P_Category = '$catid'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $pro = [];
            while ($row = $result->fetch_assoc()) {
                $pro[] = $row;
            }
        } else {
            $pro = [];
        }
    }
    else{
        $sql = "SELECT * FROM tblproduct_p";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $pro = [];
            while ($row = $result->fetch_assoc()) {
                $pro[] = $row;
            }
        } else {
            $pro = [];
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DYOR - View Products</title>
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
            .toggle-btn {
  cursor: pointer;
}

.active-label {
  color: green;
}

.inactive-label {
  color: red;
}

        </style>
    </head>
    <body>
        <section id="container">
            <?php include 'header.php';?>
            <h1 style="margin-top: 120px; color: white; text-align: center;">All Products </h1>
            <table class="table table-bordered" style="margin-top: 30px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Short Description</th>
                    <th>Keywords</th>
                    <th>Status</th>
                    <th>Actions</th>                    
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pro as $prod) : ?>
                    <tr>
                        <td><?php echo $prod['tblProduct_P_PK']; ?></td>
                        <td><?php echo $prod['tblProduct_P_SKU']; ?></td>
                        <td><?php echo $prod['tblProduct_P_Name']; ?></td>
                        
                        <td><?php echo $x[$prod['tblProduct_P_Category']]; ?></td>   
                        <td><?php echo $prod['tblProduct_P_ShortDescription']; ?></td>
                        <td><?php echo $prod['tblProduct_P_MetaKeyWords']; ?></td>  
                        <td>
                            <label>
                                <input type="checkbox" id="<?php echo $prod['tblProduct_P_PK'];?>" class="toggle-btn" <?php echo $prod['tblProduct_P_Status']? 'checked' : ''?>>
                                <span class=<?php echo $prod['tblProduct_P_Status'] ? "active-label": "inactive-label"  ?>><?php echo $prod['tblProduct_P_Status'] ? "Active": "Inactive"?></span>
                                
                            </label>
                        </td>
                        <td>
                            <!-- View Button -->
                            <a href="view_details.php?id=<?php echo $prod['tblProduct_P_PK']; ?>" class="btn btn-info btn-sm">View</a>
                            <!-- Edit Button -->
                            <a href="product_edit.php?id=<?php echo $prod['tblProduct_P_PK']; ?>" class="btn btn-warning btn-sm">Edit</a>

                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </section>
    </body>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get all toggle buttons
        var toggleBtns = document.querySelectorAll('.toggle-btn');

        toggleBtns.forEach(function(btn) {
            btn.addEventListener('change', function() {
            var itemId = btn.id; // Get the ID of the clicked toggle button
            var statusLabel = btn.parentElement.querySelector('.active-label, .inactive-label');
            var status = btn.checked ? '1' : '0';
      
            var xhr = new XMLHttpRequest();
            var url = "./update_status.php"; // 
        
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-Type", "application/json");
        
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert("Updated Status");
                    } else {
                        alert("Updation Failed: " + response.message);
                    }
                }
            };

            var data = JSON.stringify({id: itemId, status: status});

            xhr.send(data);

          // Toggle active and inactive labels
            if (btn.checked) {
                statusLabel.classList.remove('inactive-label');
                statusLabel.classList.add('active-label');
                statusLabel.textContent = 'Active';
            } else {
                statusLabel.classList.remove('active-label');
                statusLabel.classList.add('inactive-label');
                statusLabel.textContent = 'Inactive';
            }
        });
      });
    });
    </script>
</html>