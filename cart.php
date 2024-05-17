<?php

session_start();

include("includes/db.php");
include("includes/header.php");
include("functions/functions.php");
include("includes/main.php");

?>


  <!-- MAIN -->
  <main>
    <!-- HERO -->
    <div class="nero">
      <div class="nero__heading">
        <span class="nero__bold">SHOP</span> Cart
      </div>
      <p class="nero__text">
      </p>
    </div>
  </main>



<div id="content" ><!-- content Starts -->
<div class="container" ><!-- container Starts -->



<div class="col-md-9" id="cart" ><!-- col-md-9 Starts -->

<div class="box" ><!-- box Starts -->

<form action="cart.php" method="post" enctype="multipart-form-data" ><!-- form Starts -->

<h1> Shopping Cart </h1>

<?php

$ip_add = getRealUserIp();

$select_cart = "select * from cart where ip_add='$ip_add'";

$run_cart = mysqli_query($con,$select_cart);

$count = mysqli_num_rows($run_cart);

?>

<p class="text-muted" > You currently have <?php echo $count; ?> item(s) in your cart. </p>

<div class="table-responsive" ><!-- table-responsive Starts -->

<table class="table" ><!-- table Starts -->

<thead><!-- thead Starts -->

<tr>

<th colspan="2" >Product</th>

<th>Quantity</th>

<th>Unit Price</th>

<th>Size</th>

<th colspan="1">Delete</th>

<th colspan="2"> Sub Total </th>


</tr>

</thead><!-- thead Ends -->

<tbody><!-- tbody Starts -->

<?php

$total = 0;

while($row_cart = mysqli_fetch_array($run_cart)){

$pro_id = $row_cart['p_id'];

$pro_size = $row_cart['size'];

$pro_qty = $row_cart['qty'];

$price_asli = $row_cart['price_asli'];

$only_price = $row_cart['p_price'];

// $persentase_diskon = $d / 100; // Misalnya, diskon 10%, maka persentase diskonnya adalah 0.1 (10% dalam desimal)

// Hitung harga setelah diskon
$diskon = $row_cart['diskon'];

$get_products = "select * from products where product_id='$pro_id'";

$run_products = mysqli_query($con,$get_products);

while($row_products = mysqli_fetch_array($run_products)){

$product_title = $row_products['product_title'];

$product_img1 = $row_products['product_img1'];

// Hitung subtotal dengan mengalikan harga setelah diskon dengan jumlah produk yang dibeli
$sub_total = ($price_asli - ($price_asli * ($diskon / 100))) * $pro_qty ;

$_SESSION['pro_qty'] = $pro_qty;

$total += $sub_total;

?>

<tr><!-- tr Starts -->

<td>

<img src="admin_area/product_images/<?php echo $product_img1; ?>" >

</td>

<td>

<a href="#" > <?php echo $product_title; ?> </a>

</td>

<td>
<input type="text" name="quantity" value="<?php echo $_SESSION['pro_qty']; ?>" data-product_id="<?php echo $pro_id; ?>" class="quantity form-control">
</td>

<td>

Rp<?php echo $only_price; ?>.00

</td>

<td>

<?php echo $pro_size; ?>

</td>

<td>
<input type="checkbox" name="remove[]" value="<?php echo $pro_id; ?>">
</td>

<td>

Rp. <?php echo $sub_total; ?>.00

</td>

</tr><!-- tr Ends -->

<?php } } ?>

</tbody><!-- tbody Ends -->

<tfoot><!-- tfoot Starts -->

<tr>

<th colspan="5"> Total </th>

<th colspan="2"> Rp. <?php echo $total; ?>.00 </th>

</tr>

</tfoot><!-- tfoot Ends -->

</table><!-- table Ends -->

<div class="form-inline pull-right"><!-- form-inline pull-right Starts -->

<div class="form-group"><!-- form-group Starts -->

<label>Coupon Code : </label>
<input type="text" name="code" class="form-control">

</div><!-- form-group Ends -->

<input class="btn btn-primary" type="submit" name="apply_coupon" value="Apply Coupon Code" >
</div><!-- form-inline pull-right Ends -->

</div><!-- table-responsive Ends -->


<div class="box-footer"><!-- box-footer Starts -->

<div class="pull-left"><!-- pull-left Starts -->

<a href="index.php" class="btn btn-default">

<i class="fa fa-chevron-left"></i> Continue Shopping

</a>

</div><!-- pull-left Ends -->

<div class="pull-right"><!-- pull-right Starts -->

<button class="btn btn-info" type="submit" name="update" value="Update Cart">

<i class="fa fa-refresh"></i> Update Cart

</button>

<a href="checkout.php" class="btn btn-success">

Proceed to Checkout <i class="fa fa-chevron-right"></i>

</a>

</div><!-- pull-right Ends -->

</div><!-- box-footer Ends -->

</form><!-- form Ends -->


</div><!-- box Ends -->



<?php

function update_cart()
{
    global $con;

    if (isset($_POST['update'])) {
        foreach ($_POST['remove'] as $remove_id) {
            $delete_product = "DELETE FROM cart WHERE p_id='$remove_id'";
            $run_delete = mysqli_query($con, $delete_product);

            if ($run_delete) {
                echo "<script>window.open('cart.php','_self')</script>";
            }
        }
    }
}

echo @$up_cart = update_cart();

?>



<div id="row same-height-row"><!-- row same-height-row Starts -->

<div class="col-md-3 col-sm-6"><!-- col-md-3 col-sm-6 Starts -->

<div class="box same-height headline"><!-- box same-height headline Starts -->

<h3 class="text-center"> You may like these Products </h3>

</div><!-- box same-height headline Ends -->

</div><!-- col-md-3 col-sm-6 Ends -->

<?php

$get_products = "SELECT * FROM products ORDER BY rand() LIMIT 0,3";
$run_products = mysqli_query($con, $get_products);

while ($row_products = mysqli_fetch_array($run_products)) {
    $pro_id = $row_products['product_id'];
    $pro_title = $row_products['product_title'];
    $pro_price = $row_products['product_price'];
    $pro_img1 = $row_products['product_img1'];
    $pro_label = $row_products['product_label'];
    $manufacturer_id = $row_products['manufacturer_id'];

    $get_manufacturer = "SELECT * FROM manufacturers WHERE manufacturer_id='$manufacturer_id'";
    $run_manufacturer = mysqli_query($db, $get_manufacturer);
    $row_manufacturer = mysqli_fetch_array($run_manufacturer);
    $manufacturer_name = $row_manufacturer['manufacturer_title'];
    $pro_psp_price = $row_products['product_psp_price'];
    $pro_url = $row_products['product_url'];

    if ($pro_label == "Sale" || $pro_label == "Gift") {
        $product_price = "<del>Rp $pro_price</del>";
        $product_psp_price = "| Rp $pro_psp_price";
    } else {
        $product_psp_price = "";
        $product_price = "Rp $pro_price";
    }

    $product_label = "";
    if ($pro_label != "") {
        $product_label = "
            <a class='label sale' href='#' style='color:black;'>
                <div class='thelabel'>$pro_label</div>
                <div class='label-background'></div>
            </a>
        ";
    }

    echo "
        <div class='col-md-3 col-sm-6 center-responsive'>
            <div class='product'>
                <a href='$pro_url'>
                    <img src='admin_area/product_images/$pro_img1' class='img-responsive'>
                </a>
                <div class='text'>
                    <center>
                        <p class='btn btn-warning'>$manufacturer_name</p>
                    </center>
                    <hr>
                    <h3><a href='$pro_url'>$pro_title</a></h3>
                    <p class='price'>$product_price $product_psp_price</p>
                    <p class='buttons'>
                        <a href='$pro_url' class='btn btn-default'>View Details</a>
                        <a href='$pro_url' class='btn btn-danger'>
                            <i class='fa fa-shopping-cart'></i> Add To Cart
                        </a>
                    </p>
                </div>
                $product_label
            </div>
        </div>
    ";
}

?>



</div><!-- row same-height-row Ends -->


</div><!-- col-md-9 Ends -->

<div class="col-md-3"><!-- col-md-3 Starts -->

<div class="box" id="order-summary"><!-- box Starts -->

<div class="box-header"><!-- box-header Starts -->

<h3>Order Summary</h3>

</div><!-- box-header Ends -->

<p class="text-muted">
Shipping and additional costs are calculated based on the values you have entered.
</p>

<div class="table-responsive"><!-- table-responsive Starts -->

<table class="table"><!-- table Starts -->

<tbody><!-- tbody Starts -->


<tr>
  <?php
    $sub_totals = $price_asli * $pro_qty; // Calculate subtotal
  ?>
  <td> Order Price </td>
  <th><span style="text-decoration: none;">Rp.<?php echo $sub_totals; ?>.00</span></th>
</tr>
<?php
$check_coupons = 0;
if(isset($_POST['apply_coupon'])){
    $code = $_POST['code'];

    if($code == ""){
        // Lakukan sesuatu jika kode kosong
    } else {
        $get_coupons = "SELECT * FROM coupons WHERE coupon_code='$code'";
        $run_coupons = mysqli_query($con, $get_coupons);
        $check_coupons = mysqli_num_rows($run_coupons);
    
        if($check_coupons == 1){
            $row_coupons = mysqli_fetch_array($run_coupons);
            $coupon_pro = $row_coupons['product_id'];
            $coupon_price = $row_coupons['coupon_price'];
            $coupon_limit = $row_coupons['coupon_limit'];
            $coupon_used = $row_coupons['coupon_used'];
    
            if($coupon_limit == $coupon_used){
                echo "<script>alert('Your Coupon Code Has Been Expired')</script>";
            } else {
                $get_cart = "SELECT * FROM cart WHERE p_id='$coupon_pro' AND ip_add='$ip_add'";
                $run_cart = mysqli_query($con, $get_cart);
                $check_cart = mysqli_num_rows($run_cart);
    
                if($check_cart == 1){
                    // Update nilai diskon pada produk yang sesuai dengan kupon
                    $update_cart = "UPDATE cart SET diskon='$coupon_price' WHERE p_id='$coupon_pro' AND ip_add='$ip_add'";
                    $run_update = mysqli_query($con, $update_cart);
    
                    if($run_update){
                        // Tambahkan penggunaan kupon ke dalam database
                        $add_used = "UPDATE coupons SET coupon_used=coupon_used+1 WHERE coupon_code='$code'";
                        $run_used = mysqli_query($con, $add_used);
                        echo "<script>alert('Your Coupon Code Has Been Applied')</script>";
                        echo "<script>window.open('cart.php','_self')</script>";
                    } else {
                        echo "<script>alert('Failed to apply coupon')</script>";
                    }
                } else {
                    echo "<script>alert('Product Does Not Exist In Cart')</script>";
                }
            }
        } else {
            echo "<script>alert('Your Coupon Code Is Not Valid')</script>";
        }
    }
}
?>

<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "ecom_store";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Inisialisasi total diskon
    $total_diskon = 0;

    // Query untuk mengambil data dari tabel cart
    $result = $conn->query("SELECT * FROM cart");

    // Loop melalui hasil query dan menampilkan data serta menghitung total diskon
    while ($row = $result->fetch_assoc()) {
        ?>
        <tr>
            <td>Diskon</td>
            <th><?php echo isset($row['diskon']) ? $row['diskon'] . '%' : '0%'; ?></th>
        </tr>
        <?php
        // Menambahkan diskon dari setiap item ke total diskon
        $total_diskon += isset($row['diskon']) ? $row['diskon'] : 0;
    }

    // Menampilkan total diskon di luar loop
   

    // Menutup koneksi database
    $conn->close();
?>




<?php

// Hitung total harga setelah diskon
$total_discounted = $total;

// Tambahkan pajak dan ongkir
$shipping_cost = 10000; // Rp 10.000
$tax = 1000; // Rp 1.000

// Total pembayaran setelah ditambahkan pajak dan ongkir
$total_payment = $total_discounted + $shipping_cost + $tax;


?>

<tr>
    <td>Shipping</td>
    <th>Rp <?php echo number_format($shipping_cost, 2); ?></th>
</tr>

<tr>
    <td>Tax</td>
    <th>Rp <?php echo number_format($tax, 2); ?></th>
</tr>

<tr class="total">
    <td>Total</td>
    <th>Rp <?php echo number_format($total_payment, 2); ?></th>
</tr>


</tbody><!-- tbody Ends -->

</table><!-- table Ends -->

</div><!-- table-responsive Ends -->

</div><!-- box Ends -->

</div><!-- col-md-3 Ends -->

</div><!-- container Ends -->
</div><!-- content Ends -->



<?php

include("includes/footer.php");

?>

<script src="js/jquery.min.js"> </script>

<script src="js/bootstrap.min.js"></script>

<script>

$(document).ready(function(data){

$(document).on('keyup', '.quantity', function(){

var id = $(this).data("product_id");

var quantity = $(this).val();

if(quantity  != ''){

$.ajax({

url:"change.php",

method:"POST",

data:{id:id, quantity:quantity},

success:function(data){

$("body").load('cart_body.php');

}




});


}




});




});



</script>

</body>
</html>
