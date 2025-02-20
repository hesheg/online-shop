<?php

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (isset($_SESSION['user_id'])) {

    $user_id = $_SESSION['user_id'];

    $pdo = new PDO("pgsql:host=db; port=5432; dbname=db;", username: "dbuser", password: "dbpwd");
    $stmt = $pdo->query("SELECT * FROM users WHERE id = $user_id");
    $user = $stmt->fetch();
} else {
    header('Location: /login');
}

?>

<div class="container">
    <h1>Edit Profile</h1>
    <hr>

            <form action="/edit_profile" method="POST" class="form example">
                <div class="form-group">
                    <label class="col-md-3 control-label">Username:</label>
                    <div class="col-md-8">
                        <label>
                            <input name="name" class="form-control" type="text" value="<?php echo $user['name']; ?>">
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <label>
                            <input name="email" class="form-control" type="text" value="<?php echo $user['email']; ?>">
                        </label>
                    </div>
                </div>


<!--                <div class="form-group">-->
<!--                    <label class="col-md-3 control-label">Password:</label>-->
<!--                    <div class="col-md-8">-->
<!--                        <input class="form-control" type="password" value="--><?php //echo $user['password']; ?><!--">-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="form-group">-->
<!--                    <label class="col-md-3 control-label">Confirm password:</label>-->
<!--                    <div class="col-md-8">-->
<!--                        <input class="form-control" type="password" value="--><?php ////echo $user['psw-repeat']; ?><!--">-->
<!--                    </div>-->
<!--                </div>-->
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input type="submit" class="btn btn-primary" value="Save Changes">
                        <span></span>
                        <input type="reset" class="btn btn-default" value="Cancel">
                    </div>
                </div>
            </form>
</div>
<hr>

<style>
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:300);



    .jumbotron-flat {
        background-color: solid #4DB8FFF;
        height: 100%;
        border: 1px solid #4DB8FF;
        background: white;
        width: 100%;
        text-align: center;
        overflow: auto;
        color: var(--dark-color);
    }

    .paymentAmt {
        color: var(--dark-color);
        font-size: 80px;
    }

    .centered {
        text-align: center;
    }

    .title {
        padding-top: 15px;
        color: var(--dark-color);
    }
</style>

