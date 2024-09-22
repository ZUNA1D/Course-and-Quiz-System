<?php
include '../connect.php';
include "header.php";
$id=$_GET["id"];
$res=mysqli_query($conn, "SELECT * FROM exam WHERE id=$id");
while($row=mysqli_fetch_array($res)){
    $course=$row["course"];
    $topic=$row["topic"];
    $time=$row["time"];
}
?>
    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
            <form name="form1" action="" method="post">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header"><strong>Edit Exam</strong></div>
                            <div class="card-body card-block">
                                <div class="form-group"><label for="company" class=" form-control-label">Course</label><input type="text" name="coursename" class="form-control" value="<?php echo $course ?>"></div>

                                <div class="form-group"><label for="vat" class=" form-control-label">Topic</label><input type="text" name="topicname" class="form-control" value="<?php echo $topic ?>"></div>

                                <div class="form-group"><label for="vat" class=" form-control-label">Time
                                </label><input type="text" name="examtime" class="form-control" value="<?php echo $time ?>"></div>

                                <div class="form-group">
                                    <input type="submit" name="submit1" value="Update Exam" class="btn btn-success">
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
            

        </div>
    </div>

    <?php
        if (isset($_POST["submit1"])){
            mysqli_query($conn, "UPDATE exam SET course='$_POST[coursename]', topic='$_POST[topicname]', time='$_POST[examtime]' WHERE id=$id") or die(mysqli_error($conn));
        
    ?>

    <script type="text/javascript">
        window.location="t_exam_type.php";
    </script>

    <?php

        }
    ?>

  </section>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>