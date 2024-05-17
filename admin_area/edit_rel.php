<?php

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
}

else {

    if (isset($_GET['edit_inv'])) {
        $edit_id = $_GET['edit_inv'];
        $edit_inv = "select * from inventory where inventory_id='$edit_id'";
        $run_edit = mysqli_query($con, $edit_inv);
        $row_edit = mysqli_fetch_array($run_edit);
        $i_id = $row_edit['inventory_id'];
        $i_product_name = $row_edit['product_name'];
        $i_quantity = $row_edit['quantity'];
        $i_in_out = $row_edit['in_out'];
        $i_date = $row_edit['date'];
    }

    ?>

    <div class="row"><!-- 1 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <ol class="breadcrumb"><!-- breadcrumb Starts -->
                <li class="active">
                    <i class="fa fa-dashboard"></i> Dashboard / Inventory
                </li>
            </ol><!-- breadcrumb Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 1 row Ends -->


    <div class="row"><!-- 2 row Starts -->
        <div class="col-lg-12"><!-- col-lg-12 Starts -->
            <div class="panel panel-default"><!-- panel panel-default Starts -->
                <div class="panel-heading"><!-- panel-heading Starts -->
                    <h3 class="panel-title"><!-- panel-title Starts -->
                        <i class="fa fa-list fa-fw"></i> Inventory
                    </h3><!-- panel-title Ends -->
                </div><!-- panel-heading Ends -->
                <div class="panel-body"><!-- panel-body Starts -->
                    <form class="form-horizontal" action="" method="post"><!-- form-horizontal Starts -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Product Name  </label>
                            <div class="col-md-6">
                                <input type="text" name="product_name" class="form-control" value="<?php echo $i_product_name; ?>">
                            </div>
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Quantity  </label>
                            <div class="col-md-6">
                                <input type="number" name="quantity" class="form-control" value="<?php echo $i_quantity; ?>">
                            </div>
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> In/Out  </label>
                            <div class="col-md-6">
                                <select name="in_out" class="form-control">
                                    <option value="<?php echo $i_in_out; ?>"><?php echo $i_in_out; ?></option>
                                    <option value="in">In</option>
                                    <option value="out">Out</option>
                                </select>
                            </div>
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> Date  </label>
                            <div class="col-md-6">
                                <input type="date" name="date" class="form-control" value="<?php echo $i_date; ?>">
                            </div>
                        </div><!-- form-group Ends -->
                        <div class="form-group"><!-- form-group Starts -->
                            <label class="col-md-3 control-label"> </label>
                            <div class="col-md-6">
                                <input type="submit" name="update" class="btn btn-primary form-control" value="Update Inventory">
                            </div>
                        </div><!-- form-group Ends -->
                    </form><!-- form-horizontal Ends -->
                </div><!-- panel-body Ends -->
            </div><!-- panel panel-default Ends -->
        </div><!-- col-lg-12 Ends -->
    </div><!-- 2 row Ends -->


    <?php

    if (isset($_POST['update'])) {
        $product_name = $_POST['product_name'];
        $quantity = $_POST['quantity'];
        $in_out = $_POST['in_out'];
        $date = $_POST['date'];

        $update_inv = "update inventory set product_name='$product_name', quantity='$quantity', in_out='$in_out', date='$date' where inventory_id='$i_id'";
        $run_inv = mysqli_query($con, $update_inv);

        if ($run_inv) {
            echo "<script>alert('Inventory Has Been Updated')</script>";
            echo "<script> window.open('index.php?view_inv','_self') </script>";
        }
    }

    ?>

<?php } ?>