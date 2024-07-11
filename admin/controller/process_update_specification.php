<?php
    include('../config/db.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $specid = $_POST["specid"];
        $specvalue = $_POST["specvalue"];

        if (empty($specvalue)) {
            echo "specification cannot be empty.";
            exit;
        }
        $specvalue = strtoupper($specvalue);

        try {
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $specvalue = $conn->real_escape_string($specvalue);

            $sql = "UPDATE tblspecification_m SET tblSpecification_Name = '$specvalue' WHERE tblSpecification_PK = '$specid'";

            $result = $conn->query($sql);

            if ($result) {
                header("Location: ../specificationsAED.php?specupdated=1");
                exit;
            } else {
                header("Location: ../specificationsAED.php?specupdated=0");
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