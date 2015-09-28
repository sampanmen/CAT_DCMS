<form action="" method="POST">
    Field: <input type="text" name="formPostTitle"><br/>
    Field2(optional): <textarea name="formPostDescription" ><?php echo mysql_real_escape_string($_POST['formPostDescription']); ?></textarea>
    <input type="submit">
</form>

<?php
$varFormPostDescription = htmlspecialchars($_POST['formPostDescription'],ENT_QUOTES);
echo $varFormPostDescription;
echo "<br>".$_POST['formPostDescription']."<br>";
?>