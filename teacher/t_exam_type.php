<?php

include '../connect.php';
include "header.php";
session_start();

?>


    <div class="container">
        <div class="row justify-content-center">
            <div class="card">
            <form name="form1" action="" method="post">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header"><strong>Add Exam</strong></div>
                            <div class="card-body card-block">
                                <div class="form-group"><label for="company" class=" form-control-label">Course</label><input type="text" name="coursename" class="form-control"></div>

                                <div class="form-group"><label for="vat" class=" form-control-label">Topic</label><input type="text" name="topicname" class="form-control"></div>

                                <div class="form-group"><label for="vat" class=" form-control-label">Time
                                </label><input type="text" name="examtime" class="form-control"></div>

                                <div class="form-group">
                                    <input type="submit" name="submit1" value="Add Exam" class="btn btn-success">
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <strong class="card-title">Exam Category</strong>
                            </div>
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Course</th>
                                            <th scope="col">Topic</th>
                                            <th scope="col">Time</th>
                                            <th scope="col">Edit</th>
                                            <th scope="col">Delete</th>
                                            <th scope="col">Add Question</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    <?php
                                        $count=0;
                                        $res=mysqli_query($conn, "SELECT * FROM exam WHERE teacher_id='$_SESSION[teacher_id]'");
                                        while($row=mysqli_fetch_array($res))
                                        {
                                            $count=$count+1;
                                            ?>
                                            <tr>
                                                <th scope="row"><?php echo $count; ?></th>
                                                <td><?php echo $row["course"]; ?></td>
                                                <td><?php echo $row["topic"]; ?></td>
                                                <td><?php echo $row["time"]; ?></td>
                                                <td><a href="edit.php?id=<?php echo $row["id"]; ?>">Edit</a></td>
                                                <td><a href="delete.php?id=<?php echo $row["id"]; ?>">Delete</a></td>
                                                <td><a href="add_edit.php?id=<?php echo $row["id"]; ?>">Select</a></td>
                                            </tr>

                                            <?php
                                        }
                                            ?>
                                    </tbody>
                                </table>
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
            mysqli_query($conn, "INSERT INTO exam(teacher_id, course, topic, time) values('$_SESSION[teacher_id]','$_POST[coursename]','$_POST[topicname]','$_POST[examtime]')") or die(mysqli_error($conn)); 
        
    ?>

    <script type="text/javascript">
        window.location.href=window.location.href;
    </script>
<?php
        }
    ?>

  </section>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>