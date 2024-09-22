<?php

include '../connect.php';
include "header.php";

$id = $_GET["id"];
$id1= $_GET['id1'];
$res=mysqli_query($conn, "SELECT * FROM question WHERE id=$id");
$question="";
$opt1="";
$opt2="";
$opt3="";
$opt4="";
$ans="";
while($row=mysqli_fetch_array($res)){
    $question=$row["question"];
    $opt1=$row["opt1"];
    $opt2=$row["opt2"];
    $opt3=$row["opt3"];
    $opt4=$row["opt4"];
    $ans=$row["ans"];
}

?>


<div class="container">



<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <br>
                <h5>Update Question</h5>
            </div>
        </div>
    </div>
</div>


<div class="content mt-3">
    <div class="animated fadeIn">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                    <form name="form1" action="" method="post" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header"><strong>Add Images</strong></div>
                            <div class="card-body card-block">
                                <div class="form-group"><label for="question2" class="form-control-label">Question</label><input type="text" name="fquestion" class="form-control" value="<?php echo $question; ?>"></div><br>
                                <div class="form-group"><img src="<?php echo $opt1;?>" height="100" width="100"><br><label for="opt1" class="form-control-label">Option 1</label><input type="file" name="fopt1" class="form-control" style="padding-bottom: 45px" ></div><br>
                                <div class="form-group"><img src="<?php echo $opt2;?>" height="100" width="100"><br><label for="opt2" class="form-control-label">Option 2</label><input type="file" name="fopt2" class="form-control" style="padding-bottom: 45px"></div><br>
                                <div class="form-group"><img src="<?php echo $opt3;?>" height="100" width="100"><br><label for="opt3" class="form-control-label">Option 3</label><input type="file" name="fopt3" class="form-control" style="padding-bottom: 45px"></div><br>
                                <div class="form-group"><img src="<?php echo $opt4;?>" height="100" width="100"><br><label for="opt4" class="form-control-label">Option 4</label><input type="file" name="fopt4" class="form-control" style="padding-bottom: 45px"></div><br>
                                <div class="form-group"><img src="<?php echo $ans;?>" height="100" width="100"><br><label for="ans" class="form-control-label">Answer</label><input type="file" name="fans" class="form-control" style="padding-bottom: 45px"></div><br>
                                <div class="form-group">
                                    <input type="submit" name="submit2" value="Update Question" class="btn btn-success">
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

</div>

<?php

if (isset($_POST['submit2'])){

    $fopt1=$_FILES["fopt1"]["name"];
    $fopt2=$_FILES["fopt2"]["name"];
    $fopt3=$_FILES["fopt3"]["name"];
    $fopt4=$_FILES["fopt4"]["name"];
    $fans=$_FILES["fans"]["name"];

    $tm=md5(time());
    
    if ($fopt1!=""){
        $dst1="./opt_img/".$tm.$fopt1;
        $dst_db1="opt_img/".$tm.$fopt1;
        move_uploaded_file($_FILES["fopt1"]["tmp_name"],$dst1);
        mysqli_query($conn,"UPDATE question SET question='$_POST[fquestion]', opt1='$dst_db1' WHERE id=$id") or die(mysqli_error($conn));
    }
    
    if ($fopt2!=""){
        $dst2="./opt_img/".$tm.$fopt2;
        $dst_db2="opt_img/".$tm.$fopt2;
        move_uploaded_file($_FILES["fopt2"]["tmp_name"],$dst2);
        mysqli_query($conn,"UPDATE question SET question='$_POST[fquestion]', opt2='$dst_db2' WHERE id=$id") or die(mysqli_error($conn));
    }
    
    if ($fopt3!=""){
        $dst3="./opt_img/".$tm.$fopt3;
        $dst_db3="opt_img/".$tm.$fopt3;
        move_uploaded_file($_FILES["fopt3"]["tmp_name"],$dst3);
        mysqli_query($conn,"UPDATE question SET question='$_POST[fquestion]', opt3='$dst_db3' WHERE id=$id") or die(mysqli_error($conn));
    }
    
    if ($fopt4!=""){
        $dst4="./opt_img/".$tm.$fopt4;
        $dst_db4="opt_img/".$tm.$fopt4;
        move_uploaded_file($_FILES["fopt4"]["tmp_name"],$dst4);
        mysqli_query($conn,"UPDATE question SET question='$_POST[fquestion]', opt1='$dst_db4' WHERE id=$id") or die(mysqli_error($conn));
    }
    
    if ($fans!=""){
        $dst5="./opt_img/".$tm.$fans;
        $dst_db5="opt_img/".$tm.$fans;
        move_uploaded_file($_FILES["fans"]["tmp_name"],$dst5);
        mysqli_query($conn,"UPDATE question SET question='$_POST[fquestion]', ans='$dst_db5'  WHERE id=$id") or die(mysqli_error($conn));
    }

    mysqli_query($conn,"UPDATE question SET question='$_POST[fquestion]' WHERE id=$id") or die(mysqli_error($conn));
    ?>
    <script type="text/javascript">
        window.location="add_edit.php?id=<?php echo $id1;?>"
    </script>
    <?php

}

?>
