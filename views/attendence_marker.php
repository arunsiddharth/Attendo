<?php
echo "Following Students Were Identified:</br>";
echo $table;
echo "Should Attendo Mark the attendence?</br>";
?>
<form action="attendence.php" method="POST">
    <div class="radio">
        <label><input class="form-control" name="reply" value="yes" type="button"/>Yes</label>
    </div>
    <div class="radio">
    <label><input class="form-control" name="reply" value="no" type="button"/>No</label>
    </div>
    <div class="form-group">
        <button class="btn btn-default" type="submit">
            <span aria-hidden = "true" class="glyphicon glyphicon-log-in"></span>
            SUBMIT
        </button>
    </div>
</form>