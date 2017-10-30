<?php if($flag==1):?>
<form action = "attendence_viewer.php" method="POST">
    <fieldset>
        <div class = "form-group">
                <select name="view_date" required="required" placeholder="Select Date">
<?php
                foreach($show as $key => $value){
                    echo "<option value={$key}>{$key}</option>";
                }
?>

                </select>
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
