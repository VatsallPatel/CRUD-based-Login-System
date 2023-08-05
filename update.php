<!DOCTYPE html>

<?php

include 'connection.php';

$id = $_GET['id'];

$errors = [];

if (isset($_POST['update'])) {
    $name = mysqli_real_escape_string($db,$_POST['name']);
    if (empty($name)) {
        $errors[] = "Name is required";
    }

    $email = mysqli_real_escape_string($db,$_POST['email']);
    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors[] = "Invalid email address";
    } elseif (!preg_match('/\.com$/', $email)) {
        $errors[] = "Invalid email address";
    }

    $password = mysqli_real_escape_string($db,$_POST['password']);
    if (empty($password)) {
        $errors[] = "Password is required";
    }

    if (empty($errors)) {
        $name = mysqli_real_escape_string($db,$_POST['name']);
        $email = mysqli_real_escape_string($db,$_POST['email']);
        $password = mysqli_real_escape_string($db,$_POST['password']);
        $query = "UPDATE user SET `name`='$name',`email`='$email',`password`='$password' WHERE id = $id";

        $result = mysqli_query($db, $query);

        if($result)
        {
            header('Location: read.php?msg=Record updated successfully');
        }
        else
        {
            echo mysqli_error($db);
        }

    }
}

?>

<html>

    <head>

        <title>CRUD based Login</title>  

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    
    </head>

    <body margin-top="25%">

        <center>

            <?php

                $sql = "SELECT * FROM user WHERE id = $id LIMIT 1";

                $results = mysqli_query($db, $sql);

                $row = mysqli_fetch_assoc($results);

            ?>

            <table style="margin-top:100px;" cellspacing="10px" cellpadding="10px">

                <form action="update.php" method="POST">
                    <tr>
                        <td colspan="2"><h1 style="font-size: 50px; font-family: times new roman;">Update User</h1></td>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td><label>Name</label></td>
                            <td><input type="text" class="form-control" id="name" name="name" value="<?php echo $row['name']; ?>"></td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td><label>Email address</label></td>
                            <td><input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>"></td>
                        </div>
                    </tr>
                    <tr>
                        <div class="form-group">
                            <td><label>Password</label></td>
                            <td><input type="password" class="form-control" id="password" name="password" value="<?php echo $row['password']; ?>"></td>
                        </div>
                    </tr>
                    <tr>
                        <td colspan="2"><button type="submit" class="btn btn-success" name="update">Update</button><td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php if (!empty($errors)) : ?>
                                <div class="alert alert-danger" role="alert">
                                    <ul>
                                        <?php foreach ($errors as $error) : ?>
                                            <li><?php echo $error; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                </form>  

            </table>

        </center>

    </body>

</html>