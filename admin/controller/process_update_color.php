<?php
    include('../config/db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $specid = $_POST["colorid"];
        $specvalue = $_POST["color_name"];

        if (empty($specvalue)) {
            echo "Color cannot be empty.";
            exit;
        }
        $specvalue = strtoupper($specvalue);

        try {
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $specvalue = $conn->real_escape_string($specvalue);

            $sql = "UPDATE tblcolor_m SET tblColor_ColorName = '$specvalue' WHERE tblColor_PK = '$specid'";

            $result = $conn->query($sql);

            if ($result) {
                header("Location: ../colorAED.php?colorupdated=1");
                exit;
            } else {
                header("Location: ../colorAED.php?colorupdated=0");
                echo "Error: " . $conn->error;
                exit;
            }
            $conn->close();
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
            exit;
        }
    }
?>