<form action = "register.php" method="POST">
    <fieldset>
        <div class = "form-group">
            <input autocomplete="off" autofocus class="form-control" name="t_name" placeholder="Name" type="text"/>
        </div>
        <div class = "form-group">
            <input class="form-control" name="email_id" placeholder="Email" type="text"/>
        </div>
        <div class = "form-group">
            <input class="form-control" name="password" type="password" placeholder="Password"/>
        </div>
        <div class = "form-group">
            <input class="form-control" name="confirm_password" type="password" placeholder="Password(Again)"/>
        </div>
        <div class = "form-group">
            <button class="btn btn-default" type="submit">
                <span aria-hidden = "true" class="glyphicon glyphicon-log-in"></span>
                 Register
            </button>
        </div>
    </fieldset>
</form>
<div>
    or <a href = "login.php">LOGIN</a> to your account
</div>