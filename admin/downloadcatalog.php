<?php
    require('config/db.php');
    $query = "SELECT * FROM tblproduct_p WHERE tblProduct_P_Status = 1 ORDER BY tblProduct_P_Category";
    
    $result = $conn->query($query);
    $products = array();
    
    while ($row = $result->fetch_assoc()) {
        $product = array(
            'product' => $row,
            'images' => array(),
            'colors' => array(),
            'specifications' => array(),
            'related_products' => array()
        );
    
        // Fetch associated images
        $imageQuery = "SELECT * FROM tblimages_r_product WHERE tblImages_R_Product_ProductFK = " . $row['tblProduct_P_PK'];
        $imageResult = $conn->query($imageQuery);
        while ($imageRow = $imageResult->fetch_assoc()) {
            $product['images'][] = $imageRow;
        }
    
        // Fetch associated colors
        $colorQuery = "SELECT c.* FROM tblcolor_m c
                       INNER JOIN tblcolor_r_product cr ON c.tblColor_PK = cr.tblColor_R_Product_ColorFK
                       WHERE cr.tblColor_R_Product_ProductFK = " . $row['tblProduct_P_PK'];
        $colorResult = $conn->query($colorQuery);
        while ($colorRow = $colorResult->fetch_assoc()) {
            $product['colors'][] = $colorRow;
        }
    
        // Fetch associated specifications
        $specQuery = "SELECT s.*, sr.tblSpecification_R_Product_SpecificationValue
                      FROM tblspecification_m s
                      INNER JOIN tblspecification_r_product sr ON s.tblSpecification_PK = sr.tblSpecification_R_Product_SpecificationFK
                      WHERE sr.tblSpecification_R_Product_ProductFK = " . $row['tblProduct_P_PK'];
        $specResult = $conn->query($specQuery);
        while ($specRow = $specResult->fetch_assoc()) {
            $product['specifications'][] = $specRow;
        }
        // Fetch related products
        $relatedQuery = "SELECT rp.* FROM tblrelated_r_product trp
                         INNER JOIN tblproduct_p rp ON trp.tblRelated_R_Product_RProductFK = rp.tblProduct_P_PK
                         WHERE trp.tblRelated_R_Product_PProductFK = " . $row['tblProduct_P_PK'];
        $relatedResult = $conn->query($relatedQuery);
        while ($relatedRow = $relatedResult->fetch_assoc()) {
            $product['related_products'][] = $relatedRow;
        }
        $products[] = $product;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DYOR - Product Catalog</title>
    <link href="img/favicon.png" rel="icon">
    <link href="img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="lib/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="lib/bootstrap-fileupload/bootstrap-fileupload.css" />
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet">
    <script src="lib/chart-master/Chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="lib/d2i.js"></script>
    <style>
        .action-column {
            width: 100px;
            text-align: center;
        }
        p {
            color: black !important;
        }
        .edit-btn, .delete-btn {
            padding: 8px;
            margin: 2px;
            cursor: pointer;
            border: 1px solid #fff;
            border-radius: 4px;
            text-decoration: none;
            display: inline-block;
        }
        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }
        .delete-btn {
            background-color: #f44336;
            color: white;
        }
        body {
            background: #fff !important;
        }
        .available-colors {
            margin-top: 10px;
        }
        .colors-label {
            font-weight: bold;
        }
        .color-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .color-list li {
            display: inline-block;
            margin-right: 10px;
        }
        .color-list li a {
            display: block;
            width: 25px;
            height: 25px;
            border: 1px solid grey;
            border-radius: 5px;
        }
        .color-list li a:hover {
            border-color: #333;
        }
        .product-container {
            display: flex;
            gap: 20px;
            margin: 10mm;
            page-break-inside: avoid;
        }
        .product-container img {
            border-radius: 10px;
            border: 1px solid #d3986a;
            width: 150px;
            height: 150px;
            object-fit: cover;
        }
        @media print {
            body {
                -webkit-print-color-adjust: exact; /*chrome & webkit browsers*/
                color-adjust: exact; /*firefox & IE */
            }
        }
        .page {
            padding-top: 20mm;
            height: 297mm;
            -webkit-print-color-adjust: exact; /*chrome & webkit browsers*/
            color-adjust: exact; /*firefox & IE */
            page-break-after: always;
            background: url("https://dyorindustries.com/admin/assets/Dyor_Pdf.png");
            background-size:contain;
        }
        #cat-main {
            width: 210mm;
            margin: 0 auto;
            border: none;
            box-shadow: 5px 5px 15px 1px #aaa;
        }
        /* Loader styles */
        #loader {
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #3498db;
            width: 60px;
            height: 60px;
            animation: spin 2s linear infinite;
            display: none;
            z-index: 9999;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body id="cat">
    <div id="cat-main">
        <?php
        $counter = 0;
        $cat = 1;
        foreach ($products as $p):
            if ($counter % 3 == 0 && $counter != 0 && $cat == $p["product"]["tblProduct_P_Category"] ): ?>
                </div>
                <div class="page">
            <?php elseif ($cat != $p["product"]["tblProduct_P_Category"]): ?>
                </div>
                <div class="page">
                <?php $cat = $p["product"]["tblProduct_P_Category"]; $counter=0;
                    if($p["product"]["tblProduct_P_Category"] == 1){
                        echo "<h5 style='text-align:center;color:black;font-weight:800; text-decoration: underline;text-decoration-color:#d3986a;position:relative;top:-15mm;right:-80mm;font-size:30px'>Ho.Re.Ca</h5>";
                    }
                    elseif($p["product"]["tblProduct_P_Category"] == 2){
                        echo "<h5 style='text-align:center;color:black;font-weight:800; text-decoration: underline;text-decoration-color:#d3986a;position:relative;top:-15mm;right:-80mm;font-size:30px'>Medical</h5>";
                    }
                    elseif($p["product"]["tblProduct_P_Category"] == 3){
                        echo "<h5 style='text-align:center;color:black;font-weight:800; text-decoration: underline;text-decoration-color:#d3986a;position:relative;top:-15mm;right:-80mm;font-size:30px'>Salon</h5>";
                    }
                ?>
            <?php elseif ($counter == 0): ?>
            
                <div class="page">
                <?php $cat = 1; 
                    if($p["product"]["tblProduct_P_Category"] == 1){
                        echo "<h5 style='text-align:center;color:black;font-weight:800; text-decoration: underline;text-decoration-color:#d3986a;position:relative;top:-15mm;right:-80mm;font-size:30px'>Ho.Re.Ca</h5>";
                    }
                    
                ?>
            <?php endif; ?>
            <div class="product-container" style="margin-left:10mm !important;margin-right: 10mm; margin-top:5mm; margin-bottom:5mm">
                <div>
                    <img src="<?php echo $p['images'][0]['tblImages_R_Product_ImageURL'] ?>" alt='IMAGE'>
                </div>
                <div>
                    <h4><?= $p["product"]["tblProduct_P_Name"] ?> (SKU: <?= $p["product"]["tblProduct_P_SKU"] ?>)</h4>
                    <p><?= $p["product"]["tblProduct_P_ShortDescription"] ?></p>
                    <div style="display:flex;gap:10px;align-items:center">
                        <h5>• Colors</h5>
                        <div class="available-colors">
                            <ul class="color-list">
                                <?php foreach ($p['colors'] as $c): ?>
                                    <li><a href="#" style="background-color: <?php echo $c['tblColor_ColorName']; ?>"></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table" style="display:flex; justify-content:center">
                <tbody style="width:190mm">
                  <?php
                        $specifications = $p["specifications"];
                        for ($i = 0; $i < count($specifications); $i += 2) {
                            echo "<tr>";
                            for ($j = 0; $j < 2; $j++) {
                                if ($i + $j < count($specifications)) {
                                    echo "<th class='font-weight-semi-bold text-dark pl-0' style='font-size:10px'>" . $specifications[$i + $j]["tblSpecification_Name"] . "</th>";
                                    echo "<td class='pl-4' style='font-size:10px'>" . $specifications[$i + $j]["tblSpecification_R_Product_SpecificationValue"] . "</td>";
                                }
                            }
                            echo "</tr>";
                        }
                    ?>
                </tbody>
             </table>
            <hr style="border: 1px solid black"/>
            <?php
            $counter++;
        endforeach;
        ?>
        </div>
    </div>
    <div id="loader"></div>
    <button id="btn-x" onclick="convertHTMLFileToPDF()" style="position:fixed;top:10px;left:10px;width:150px;height:50px;background:#007bff !important;border:none;color:white;">Download PDF</button>
    <script type="text/javascript">
        async function convertHTMLFileToPDF() {
            const loader = document.getElementById('loader');
            loader.style.display = 'block';

            const { jsPDF } = window.jspdf;
            const doc = new jsPDF('p', 'mm', 'a4');
            const pages = document.querySelectorAll('.page');

            for (const [index, page] of pages.entries()) {
                const canvas = await html2canvas(page, {
                    scale: 1.5,
                    letterRendering: 1,
                });
                const imgData = canvas.toDataURL('image/png');
                const imgProps = doc.getImageProperties(imgData);
                const pdfWidth = doc.internal.pageSize.getWidth();
                const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

                if (index !== 0) {
                    doc.addPage();
                }
                doc.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            }

            doc.save("output.pdf");
            loader.style.display = 'none';
        }
    </script>
</body>
</html>


