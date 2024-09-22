<?php
include "../connect.php";
include "header.php";
?>

<div class="container">
        <div class="row justify-content-center">
            <div class="card">
            <div class="breadcrumbs">
                <div class="col-sm-12">
                    <div class="page-header float-left">
                        <div class="page-title">
                            <h5>Select The Course and Topic for adding questions</h5>
                        </div>
                    </div>
                </div>


            <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Course</th>
                        <th scope="col">Topic</th>
                        <th scope="col">Time</th>
                        <th scope="col">Select</th>
                        
                    </tr>
                </thead>
                    <tbody>
                    <?php
                        $count=0;
                        $res=mysqli_query($conn, "SELECT * FROM exam");
                        while($row=mysqli_fetch_array($res))
                        {
                            $count=$count+1;
                            ?>
                            <tr>
                                <th scope="row"><?php echo $count; ?></th>
                                <td><?php echo $row["course"]; ?></td>
                                <td><?php echo $row["topic"]; ?></td>
                                <td><?php echo $row["time"]; ?></td>
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
    </div>

