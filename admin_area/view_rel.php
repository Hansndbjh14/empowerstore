<?php

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php', '_self')</script>";
    exit();
}

include("includes/db.php");

$query = "
    SELECT 
        p.product_title AS product_name, 
        b.product_title AS bundle_name, 
        r.quantity 
    FROM 
        product_bundle_relations r
    JOIN 
        products p ON r.product_id = p.product_id
    JOIN 
        products b ON r.bundle_id = b.product_id
";

$result = mysqli_query($con, $query);

?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / View Stock
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-cubes fa-fw"></i> Inventory Stock
                </h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>No.</th>                              
                                <th>Nama produk</th>
                                <th>jumlah produk</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                $i++;
                                $bundle_name = $row['bundle_name'];
                                $quantity = $row['quantity'];
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td><?php echo $bundle_name; ?></td>
                                <td><?php echo $quantity; ?></td>
                            </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
