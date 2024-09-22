<?php

include '../connect.php';
include "header.php";
$id = $_GET["id"]; // ques_id
$id1= $_GET['id1']; // exam_id
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
                    <!-- ------- -->
                    <form name="form1" action="" method="post" enctype="multipart/form-data">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header"><strong>Update Questions</strong></div>
                            <div class="card-body card-block">
                                <div class="form-group"><label for="question" class="form-control-label">Question</label><input type="text" name="question" class="form-control" value="<?php echo $question; ?>"></div><br>
                                <div class="form-group"><label for="opt1" class="form-control-label">Option 1</label><input type="text" name="opt1" class="form-control" value="<?php echo $opt1; ?>"></div><br>
                                <div class="form-group"><label for="opt2" class="form-control-label">Option 2</label><input type="text" name="opt2" class="form-control" value="<?php echo $opt2; ?>"></div><br>
                                <div class="form-group"><label for="opt3" class="form-control-label">Option 3</label><input type="text" name="opt3" class="form-control" value="<?php echo $opt3; ?>"></div><br>
                                <div class="form-group"><label for="opt4" class="form-control-label">Option 4</label><input type="text" name="opt4" class="form-control" value="<?php echo $opt4; ?>"></div><br>
                                <div class="form-group"><label for="ans" class="form-control-label">Answer</label><input type="text" name="ans" class="form-control" value="<?php echo $ans; ?>"></div><br>
                                <div class="form-group">
                                    <input type="submit" name="submit1" value="Update Question" class="btn btn-success">
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
    if (isset($_POST['submit1'])){
        mysqli_query($conn,"UPDATE question SET question='$_POST[question]', opt1='$_POST[opt1]',opt2='$_POST[opt2]',opt3='$_POST[opt3]',opt4='$_POST[opt4]',ans='$_POST[ans]' WHERE id=$id");
        ?>
        <script type="text/javascript">
            window.location="add_edit.php?id=<?php echo $id1;?>"
        </script>
        <?php
    }
?>