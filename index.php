<?php
require_once 'templates/header.php';
?>

<?php
$db = new PDO("mysql:host=localhost;dbname=Practice_security", "root", "mysql");
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['username']) && !empty($_POST['password'])) :
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    $query = "SELECT username, credit_card_number FROM userdata WHERE username= :username and password= :password;";
    error_log("executed query: " . $query);

    $statement = $db->prepare($query);
    $statement->bindParam('username', $username);
    $statement->bindParam('password',$password);
    $statement->execute();
    $list_of_users = $statement->fetch();
   
    if($list_of_users === false){
        echo "invalid";
    }else{

    $username = $list_of_users['username'];
    $credit = $list_of_users['credit_card_number'];

        ?>
            <div class="card m-3">
                <div class="card-header">
                    <span><?php echo $username?></span>
                </div>
                <div class="card-body">
                    <p class="card-text">Your credit card number: <?php echo $credit; ?></p>
                </div>
            </div>
            <hr>
<?php
    }
    endif;
?>

<form action="" method="post" class="m-3">
    <div class="row mb-3 mt-3">
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter Username" name="username">
        </div>
        <div class="col">
            <input type="text" class="form-control" placeholder="Enter password" name="password">
        </div>
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">View your data</button>
    </div>
</form>

<?php
require_once 'templates/footer.php';
?>