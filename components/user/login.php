<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to the welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}

// Include config file
$path = $_SERVER['DOCUMENT_ROOT'];
$path .= "/shoes/";
require_once($path . 'connectPDO.php');

// Define variables and initialize with empty values
$email = $password = "";
$email_err = $password_err = "";

// Processing form data when the form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if email is empty
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter email.";
    } else{
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if(empty($email_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, email, password, role FROM users WHERE email = :email";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_email = $email;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if email exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    // Fetch the result
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $id = $row["id"];
                    $hashed_password = $row["password"];
                    $role = $row["role"];

                    if(password_verify($password, $hashed_password)){
                        // Password is correct, so start a new session
                        session_start();

                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $id;
                        $_SESSION["email"] = $email;
                        $_SESSION["role"] = $role;

                        // Redirect user to welcome page
                        $url = 'http://' . $_SERVER['HTTP_HOST']; // Get server
                        $url .= "/shoes/";
                        header('Location: ' . $url, TRUE, 302);
                        exit;
                    } else{
                        // Display an error message if the password is not valid
                        $password_err = "The password you entered was not valid.";
                    }
                } else{
                    // Display an error message if the email doesn't exist
                    $email_err = "No account found with that email.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($pdo);
}
?>

<?php require($path . 'templates/header.php') ?>

<div class="wrapper mx-auto">
    <h2>Login</h2>
    <p>Please fill in your credentials to login.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
            <span class="help-block"><?php echo $email_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        <p>Forgot Password? <a href="reset-password.php">Reset Password</a>.</p>
    </form>
</div>

<?php require($path . 'templates/footer.php') ?>
