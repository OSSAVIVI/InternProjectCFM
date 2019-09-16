<?php

//Connect to database and gain access to $conn variable
include('config/db_connect.php');

//Checks if we are redirecting this page after pressing the DELETE button previously
if (isset($_POST['delete'])) {
    //Stores the id to delete using the hidden field from the EDLETE form
    $id_to_delete = mysqli_real_escape_string($conn, $_POST['id_to_delete']);

    $sql = "DELETE FROM clients WHERE id = $id_to_delete";

    if (mysqli_query($conn, $sql)) {
        //success
        header('Location: index.php');
    } else {
        //error
        echo 'QUERY ERROR: ' . mysqli_error($conn);
    }
}

//Check GET request id paramater
if (isset($_GET['id'])) {

    $id = mysqli_real_escape_string($conn, $_GET['id']);

    //make sql
    $sql = "SELECT * FROM clients WHERE id = $id";

    $result = mysqli_query($conn, $sql);

    //fetch result in array format
    $client_info = mysqli_fetch_assoc($result);

    //Handles bad ids due to AUTO INCREMENT after DELETE
    if (!$client_info) {
        while (!$client_info) {

            $id = random_int(1, 50);

            //make sql
            $sql = "SELECT * FROM clients WHERE id = $id";

            $result = mysqli_query($conn, $sql);

            //fetch result in array format
            $client_info = mysqli_fetch_assoc($result);
        }
    }

    //Free memory and close connection
    mysqli_free_result($result);
    mysqli_close($conn);

    //print_r($client_info);
    //echo $client_info['email'];
}

?>

<!DOCTYPE html>
<html>

<!--HEADER-->
<?php include('templates/header.php'); ?>

<div class='container'>

    <?php if ($client_info) : ?>

        <!-- CLIENT DETAILS (displayed on page) -->
        <h1><?php echo htmlspecialchars($client_info['name']); ?></h1>
        <ul>
            <li class='card-details'><span class='card-details-2'>Phone: </span><?php echo $client_info['phone']; ?></li>
            <li class='card-details'><span class='card-details-2'>Email: </span><?php echo $client_info['email']; ?></li>
            <li class='card-details'><span class='card-details-2'>Created: </span><?php echo $client_info['created_at']; ?></li>
        </ul>

        <!-- UPDATE FORM -->
        <form action='update.php' method='POST'>
            <input type='hidden' name='id_to_update' value="<?php echo $client_info['id']; ?>">
            <input type='hidden' name='name_to_update' value="<?php echo $client_info['name']; ?>">
            <input type='hidden' name='phone_to_update' value="<?php echo $client_info['phone']; ?>">
            <input type='hidden' name='email_to_update' value="<?php echo $client_info['email']; ?>">
            <input type='submit' name='update' value='Update Client' class='update-button'>
        </form><br>

        <!-- DELETE FORM -->
        <form action='details.php' method='POST'>
            <input type='hidden' name='id_to_delete' value="<?php echo $client_info['id']; ?>">
            <input type='submit' name='delete' value='Delete Client' class='delete-button'>
        </form>


    <?php else : ?>
        <!-- Display this if the id in the URL query does not match a roecord form database -->
        <h1>No client found.</h1>
    <?php endif; ?>

</div>

<!--FOOTER-->
<?php include('templates/footer.php'); ?>

</html>