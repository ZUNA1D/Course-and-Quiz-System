<?php
include "header.php";
?>
    <div class="all-content-wrapper">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-8">
            <div class="card my-5">
              <div class="card-body">
                <h5 class="card-title text-center mb-4">Select Exam</h5>
                <?php
                $res=mysqli_query($conn, "SELECT * FROM exam");
                while($row=mysqli_fetch_array($res)){
                  ?>
                  <button type="button" class="btn btn-success form-control" 
                          onclick="set_exam_session(<?php echo $row['id']; ?>, <?php echo $row['time']; ?>);">
                    <?php echo htmlspecialchars($row["course"]." : ".$row['topic']); ?>
                  </button>
                  <?php
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <script>
  function set_exam_session(examId, examTime) {
    fetch('set_exam_session.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'exam_id=' + examId + '&exam_time=' + examTime
    })
    .then(response => response.text())
    .then(data => {
      if (data === 'success') {
        window.location.href = 'exam.php';
      } else {
        alert('Error setting exam session');
      }
    });
  }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>