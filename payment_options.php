<div class="box"><!-- box Starts -->

<?php

$session_email = $_SESSION['customer_email'];

$select_customer = "select * from customers where customer_email='$session_email'";

$run_customer = mysqli_query($con,$select_customer);

$row_customer = mysqli_fetch_array($run_customer);

$customer_id = $row_customer['customer_id'];


?>

<h1 class="text-center"></h1>

<p class="lead text-center">

<a href="order.php?c_id=<?php echo $customer_id; ?>">Pay now</a>

</p>
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

<th >Product</th>

<th>Quantity</th>

<th>Unit Price</th>

<th>Size</th>


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

$only_price = $row_cart['p_price'];

$get_products = "select * from products where product_id='$pro_id'";

$run_products = mysqli_query($con,$get_products);

while($row_products = mysqli_fetch_array($run_products)){

$product_title = $row_products['product_title'];

$product_img1 = $row_products['product_img1'];

$sub_total = $only_price*$pro_qty;

$_SESSION['pro_qty'] = $pro_qty;

$total += $sub_total;

?>

<tr><!-- tr Starts -->

<td>
  
  <a href="#" > <?php echo $product_title; ?> </a></td>

<td>
 
  <?php echo $pro_qty; ?> 
</td>

<td>

Rp<?php echo $only_price; ?>.00

</td>

<td>

<?php echo $pro_size; ?>

</td>



<td>

Rp<?php echo $sub_total; ?>.00

</td>

</tr><!-- tr Ends -->

<?php } } ?>

</tbody><!-- tbody Ends -->

<tfoot><!-- tfoot Starts -->

<tr>

<th colspan="4"> Total </th>

<th colspan="2"> Rp<?php echo $total; ?>.00 </th>

</tr>

</tfoot><!-- tfoot Ends -->

</table><!-- table Ends --><!-- form-inline pull-right Ends -->

</div><!-- table-responsive Ends -->


</p>

<center><!-- center Starts -->




<?php

$i = 0;


$ip_add = getRealUserIp();

$get_cart = "select * from cart where ip_add='$ip_add'";

$run_cart = mysqli_query($con,$get_cart);

while($row_cart = mysqli_fetch_array($run_cart)){

$pro_id = $row_cart['p_id'];

$pro_qty = $row_cart['qty'];

$pro_price = $row_cart['p_price'];

$get_products = "select * from products where product_id='$pro_id'";

$run_products = mysqli_query($con,$get_products);

$row_products = mysqli_fetch_array($run_products);

$product_title = $row_products['product_title'];

$i++;

?>


<input type="hidden" name="item_name_<?php echo $i; ?>" value="<?php echo $product_title; ?>" >

<input type="hidden" name="item_number_<?php echo $i; ?>" value="<?php echo $i; ?>" >

<input type="hidden" name="amount_<?php echo $i; ?>" value="<?php echo $pro_price; ?>" >

<input type="hidden" name="quantity_<?php echo $i; ?>" value="<?php echo $pro_qty; ?>" >


<?php } ?>
</form>
<!-- form Ends -->




</center><!-- center Ends --></div><!-- box Ends -->
