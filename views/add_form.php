<form action="enroll.php" method="POST" enctype="multipart/form-data">
    <fieldset>

        <div class="form-group">
            <input class="form-control" placeholder="Student Name" type="text" name="name"/>
        </div>
        <div class = "form-group">
            <input class = "form-control" type="file" name="image" placeholder="Select Image" accept="image/*"/>
        </div>
        <div class = "form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden = "true" class="glyphicon glyphicon-log-in"></span>
                 SUBMIT
            </button>
        </div>
    </fieldset>
</form>