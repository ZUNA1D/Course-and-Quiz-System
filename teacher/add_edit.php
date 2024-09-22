<?php

include '../connect.php';
include "header.php";
$id = $_GET["id"];

session_start();
$_SESSION['id']= $id;

$res=mysqli_query($conn, "SELECT * FROM exam WHERE id=$id");
while($row=mysqli_fetch_array($res)){
    $course=$row["course"];
    $topic=$row["topic"];

}
?>


<div class="container">
            
    <div class="breadcrumbs">
        <div class="col-sm-12">
            <div class="page-header float-left">
                <div class="page-title">
                    <p></p>
                    <h4>Add Questions</h4>
                    <h5>Course: <?php echo "<font color='red'>" .$course. "</font>"; ?>, Topic: <?php echo "<font color='red'>" .$topic. "</font>"; ?></h5>
                </div>
            </div>
        </div>
    </div>

    <div class="content mt-3">
        <form name="form1" action="" method="post" enctype="multipart/form-data">
            <div class="row">
                <!-- First Form -->
                <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header"><strong>Add Questions</strong></div>
                            <div class="card-body card-block">
                                <div class="form-group"><label for="question" class="form-control-label">Question</label><input type="text" name="question" class="form-control" placeholder="Add New Question"></div><br>
                                <div class="form-group"><label for="opt1" class="form-control-label">Option 1</label><input type="text" name="opt1" class="form-control" placeholder="Add option"></div><br>
                                <div class="form-group"><label for="opt2" class="form-control-label">Option 2</label><input type="text" name="opt2" class="form-control" placeholder="Add option"></div><br>
                                <div class="form-group"><label for="opt3" class="form-control-label">Option 3</label><input type="text" name="opt3" class="form-control" placeholder="Add option"></div><br>
                                <div class="form-group"><label for="opt4" class="form-control-label">Option 4</label><input type="text" name="opt4" class="form-control" placeholder="Add option"></div><br>
                                <div class="form-group"><label for="ans" class="form-control-label">Answer</label><input type="text" name="ans" class="form-control" placeholder="Add Answer"></div><br>
                                <div class="form-group">
                                    <input type="submit" name="submit1" value="Add Question" class="btn btn-success">
                                </div>
                            </div>
                        </div>
                    
                </div>

                <!-- Second Form -->
                <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header"><strong>Add Question With Images</strong></div>
                            <div class="card-body card-block">
                                <div class="form-group"><label for="question2" class="form-control-label">Question</label><input type="text" name="fquestion" class="form-control"></div><br>
                                <div class="form-group"><label for="opt1" class="form-control-label">Option 1</label><input type="file" name="fopt1" class="form-control" style="padding-bottom: 45px"></div><br>
                                <div class="form-group"><label for="opt2" class="form-control-label">Option 2</label><input type="file" name="fopt2" class="form-control" style="padding-bottom: 45px"></div><br>
                                <div class="form-group"><label for="opt3" class="form-control-label">Option 3</label><input type="file" name="fopt3" class="form-control" style="padding-bottom: 45px"></div><br>
                                <div class="form-group"><label for="opt4" class="form-control-label">Option 4</label><input type="file" name="fopt4" class="form-control" style="padding-bottom: 45px"></div><br>
                                <div class="form-group"><label for="ans" class="form-control-label">Answer</label><input type="file" name="fans" class="form-control" style="padding-bottom: 45px"></div><br>
                                <div class="form-group">
                                    <input type="submit" name="submit2" value="Add Question" class="btn btn-success">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </form>

        <div class="row">
            <div class="col-lg-12">
                <div class="card"> 
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tr>
                                <th>No</th>
                                <th>Question</th>
                                <th>Option 1</th>
                                <th>Option 2</th>
                                <th>Option 3</th>
                                <th>Option 4</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>

                            <?php
                                $res = mysqli_query($conn, "SELECT * FROM question WHERE exam_id='$_SESSION[id]' ORDER by question_no ASC");
                                while($row=mysqli_fetch_array($res)){
                                    echo "<tr>";
                                    echo "<td>"; echo $row['question_no']; echo "</td>";
                                    echo "<td>"; echo $row['question']; echo "</td>";
                                    // opt1
                                    echo "<td>";
                                    if (strpos($row['opt1'],'opt_img/')!==false){
                                        ?>
                                        <img src="<?php echo $row['opt1'];?>" height="50" width="50">
                                        <?php

                                    }else{
                                        echo $row['opt1'];
                                    }
                                    echo "</td>";

                                    // opt2
                                    echo "<td>";
                                    if (strpos($row['opt2'],'opt_img/')!==false){
                                        ?>
                                        <img src="<?php echo $row['opt2'];?>" height="50" width="50">
                                        <?php

                                    }else{
                                        echo $row['opt2'];
                                    }
                                    echo "</td>";
                                    
                                    // opt3
                                    echo "<td>";
                                    if (strpos($row['opt3'],'opt_img/')!==false){
                                        ?>
                                        <img src="<?php echo $row['opt3'];?>" height="50" width="50">
                                        <?php

                                    }else{
                                        echo $row['opt3'];
                                    }
                                    echo "</td>";

                                    // opt4
                                    echo "<td>";
                                    if (strpos($row['opt4'],'opt_img/')!==false){
                                        ?>
                                        <img src="<?php echo $row['opt4'];?>" height="50" width="50">
                                        <?php

                                    }else{
                                        echo $row['opt4'];
                                    }
                                    echo "</td>";

                                    // edit
                                    echo "<td>";
                                    if (strpos($row['opt4'],'opt_img/')!==false){
                                        ?>
                                        <a href="edit_option_img.php?id=<?php echo $row['id'];?>&id1=<?php echo $id; ?>">Edit</a>
                                        <?php  // id is ques_id,   id1 is exam_id

                                    }else{
                                        ?>
                                        <a href="edit_option.php?id=<?php echo $row['id'];?>&id1=<?php echo $id; ?>">Edit</a>
                                        <?php
                                    }
                                    echo "</td>";

                                    // delete
                                    echo "<td>";
                                        ?> 
                                        <a href="delete_option.php?id=<?php echo $row['id'];?>&id1=<?php echo $id; ?>">Delete</a>
                                        <?php
                                    echo "</td>";
                                
                                    echo "</tr>";
                                }
                            ?>
                        </table>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

    
            



  </section>
<!-- form 1 -->
<?php

if (isset($_POST['submit1'])){

$loop = 0;

$count=0;
$res=mysqli_query($conn, "SELECT * FROM question WHERE exam_id='$_SESSION[id]' ORDER BY id ASC") or die(mysqli_error($conn));

$count = mysqli_num_rows($res);

if ($count==0){
    echo "Exam does not exist";

}else{
    while($row=mysqli_fetch_array($res)){
        $loop=$loop+1;
        $id = $row["id"];
        mysqli_query($conn, "UPDATE question set question_no='$loop' WHERE id='$id'"); // here id is- question id
    }
}

$loop=$loop+1;
mysqli_query($conn, "INSERT INTO question(exam_id,question_no,question,opt1,opt2,opt3,opt4,ans) VALUES('$_SESSION[id]','$loop','$_POST[question]','$_POST[opt1]','$_POST[opt2]','$_POST[opt3]','$_POST[opt4]','$_POST[ans]')") or die(mysqli_error($conn));

?>
<script type="text/javascript">
    alert("Question Added Successfully");
    window.location.href=window.location.href;
</script>
<?php

}

?>

<!-- FORM 2 -->
<?php

if (isset($_POST['submit2'])){

$loop = 0;

$count=0;
$res=mysqli_query($conn, "SELECT * FROM question WHERE exam_id='$_SESSION[id]' ORDER BY id ASC") or die(mysqli_error($conn));

$count = mysqli_num_rows($res);

if ($count==0){

}else{
    while($row=mysqli_fetch_array($res)){
        $loop=$loop+1;
        $id = $row["id"];
        mysqli_query($conn, "UPDATE question set question_no='$loop' WHERE id='$id'");
    }
}

$loop=$loop+1;

$tm=md5(time());

$fnm1=$_FILES["fopt1"]["name"];
$dst1="./opt_img/".$tm.$fnm1;
$dst_db1="opt_img/".$tm.$fnm1;
move_uploaded_file($_FILES["fopt1"]["tmp_name"],$dst1);

$fnm2=$_FILES["fopt2"]["name"];
$dst2="./opt_img/".$tm.$fnm2;
$dst_db2="opt_img/".$tm.$fnm2;
move_uploaded_file($_FILES["fopt2"]["tmp_name"],$dst2);

$fnm3=$_FILES["fopt3"]["name"];
$dst3="./opt_img/".$tm.$fnm3;
$dst_db3="opt_img/".$tm.$fnm3;
move_uploaded_file($_FILES["fopt3"]["tmp_name"],$dst3);

$fnm4=$_FILES["fopt4"]["name"];
$dst4="./opt_img/".$tm.$fnm4;
$dst_db4="opt_img/".$tm.$fnm4;
move_uploaded_file($_FILES["fopt4"]["tmp_name"],$dst4);

$fnm5=$_FILES["fans"]["name"];
$dst5="./opt_img/".$tm.$fnm5;
$dst_db5="opt_img/".$tm.$fnm5;
move_uploaded_file($_FILES["fans"]["tmp_name"],$dst5);

mysqli_query($conn, "INSERT INTO question(exam_id,question_no,question,opt1,opt2,opt3,opt4,ans) VALUES('$_SESSION[id]','$loop','$_POST[fquestion]','$dst_db1','$dst_db2','$dst_db3','$dst_db4','$dst_db5')") or die(mysqli_error($conn));

?>
<script type="text/javascript">
    alert("Question Added Successfully");
    window.location.href=window.location.href;
</script>
<?php

}

?>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>