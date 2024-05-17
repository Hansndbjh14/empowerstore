<?php

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php', '_self')</script>";
    exit();
}

include("includes/db.php");

$get_products = "SELECT * FROM products WHERE status = 'product'";
$run_products = mysqli_query($con, $get_products);

$get_bundles = "SELECT * FROM products WHERE status = 'bundle'";
$run_bundles = mysqli_query($con, $get_bundles);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $product_id = $_POST['product_id'];
    $bundle_id = $_POST['bundle_id'];
    $quantity = $_POST['quantity'];

    $insert_relation = "INSERT INTO product_bundle_relations (product_id, bundle_id, quantity) VALUES ('$product_id', '$bundle_id', '$quantity')";
    
    $run_insert = mysqli_query($con, $insert_relation);
    
    if ($run_insert) {
        echo "<script>alert('Relation has been inserted successfully');</script>";
        echo "<script>window.open('index.php?view_relations', '_self')</script>";
    } else {
        echo "<script>alert('Failed to insert relation');</script>";
    }
}

?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / Insert Relation
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-shopping-cart fa-fw"></i> Inventory Management
                </h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" action="" method="post">
                    <div class="form-group">
                        <label class="col-md-3 control-label">Product</label>
                        <div class="col-md-6">
                            <select name="product_id" class="form-control">
                                <option>Select Product</option>
                                <?php
                                while ($row_product = mysqli_fetch_array($run_products)) {
                                    $product_id = $row_product['product_id'];
                                    $product_title = $row_product['product_title'];
                                    echo "<option value='$product_id'>$product_title</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Bundle</label>
                        <div class="col-md-6">
                            <select name="bundle_id" class="form-control">
                                <option>Select Bundle</option>
                                <?php
                                while ($row_bundle = mysqli_fetch_array($run_bundles)) {
                                    $bundle_id = $row_bundle['product_id'];
                                    $bundle_title = $row_bundle['product_title'];
                                    echo "<option value='$bundle_id'>$bundle_title</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label">Quantity</label>
                        <div class="col-md-6">
                            <input type="number" name="quantity" class="form-control" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label"></label>
                        <div class="col-md-6">
                            <input type="submit" name="submit" value="Submit" class="btn btn-primary form-control">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
