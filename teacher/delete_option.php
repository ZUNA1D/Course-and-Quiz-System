<?php

include '../connect.php';

$id = $_GET["id"]; // ques id
$id1= $_GET['id1']; // exam id
$res=mysqli_query($conn, "DELETE FROM question WHERE id=$id");

?>

<script type="text/javascript">
        window.location="add_edit.php?id=<?php echo $id1;?>"
</script>