Products View

<table>


<tr>
    <th>Product ID</th>
    <th>Product Name</th>
</tr>

<?php
foreach($products as $product){
?>

<tr>
    <td><?php echo $product["id"]; ?></td>
    <td><?php echo $product["name"]; ?></td>
</tr>
<?php
}

?>
</table>