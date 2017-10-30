<?php if($flag==1):?>
<form action = "attendence_viewer.php" method="POST">
    <fieldset>
        <div class = "form-group">
            <label for="sel1">Select Date:</label>
                <select name="view_date" required="required" placeholder="Select Date"  class="form-control">
<?php
                foreach($show as $key => $value){
                    echo "<option value='".$key."'}>{$key}</option>";
                }
?>

                </select>
            </label>
        </div>

        <div class = "form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden = "true" class="glyphicon glyphicon-log-in"></span>
                 Submit
            </button>
        </div>
    </fieldset>
</form>

<?php else: {echo $show;}endif?>
