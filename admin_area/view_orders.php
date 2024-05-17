<?php
// Check if the user is logged in
if (!isset($_SESSION['admin_email'])) {
    header('Location: login.php');
    exit;
}

// Retrieve all orders with a single query
$query = "SELECT 
    o.order_id, 
    o.customer_id, 
    o.invoice_no, 
    o.product_id, 
    o.qty, 
    o.size, 
    o.order_status, 
    p.product_title, 
    c.customer_email, 
    co.order_date, 
    co.due_amount 
FROM 
    pending_orders o 
LEFT JOIN 
    products p ON o.product_id = p.product_id 
LEFT JOIN 
    customers c ON o.customer_id = c.customer_id 
LEFT JOIN 
    customer_orders co ON o.order_id = co.order_id";

$stmt = mysqli_prepare($con, $query);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Display the orders
?>

<div class="row">
    <div class="col-lg-12">
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / View Orders
            </li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <i class="fa fa-money fa-fw"></i> View Orders
                </h3>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>Customer</th>
                                <th>Invoice</th>
                                <th>Product</th>
                                <th>Qty</th>
                                <th>Size</th>
                                <th>Order Date</th>
                                <th>Total Amount</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
    <?php $i = 1; ?>
    <?php while ($row = mysqli_fetch_assoc($result)) {?>
    <tr>
        <td><?= $i++;?></td>
        <td><?= $row['customer_email'];?></td>
        <td bgcolor="orange"><?= $row['invoice_no'];?></td>
        <td><?= $row['product_title'];?></td>
        <td><?= $row['qty'];?></td>
        <td><?= $row['size'];?></td>
        <td><?= $row['order_date'];?></td>
        <td>$<?= $row['due_amount'];?></td>
        <td>
            <?php if ($row['order_status'] == 'pending') {?>
                <div style="color:red;">Pending</div>
            <?php } else {?>
                Completed
            <?php }?>
        </td>
        <td>
            <a href="index.php?order_delete=<?= $row['order_id'];?>">
                <i class="fa fa-trash-o"></i> Delete
            </a>
        </td>
    </tr>
    <?php }?>
</tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>