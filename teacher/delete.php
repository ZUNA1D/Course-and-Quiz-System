<?php
    include "../connect.php";
    $id=$_GET["id"];
    mysqli_query($conn, "DELETE FROM exam WHERE id=$id");
?>

<script type="text/javascript"> 
    window.location="t_exam_type.php";
</script>