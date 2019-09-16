<?php

//Connect to database and gain access to $conn variable
include('config/db_connect.php');

//Query for gathering clients and sorting by created_at
$sql = 'SELECT id, name, phone, email FROM clients ORDER BY name';

//Make query and store result
$result = mysqli_query($conn, $sql);

//create an associateive array to store arrays of client information
$clients = mysqli_fetch_all($result, MYSQLI_ASSOC);

//Code for determining index of the "Random" button
$cli_array = array();
foreach ($clients as $cli) {
    array_push($cli_array, $cli);
}
$rand_element = array_rand($cli_array);
if ($rand_element == 0) {
    $rand_element += 1;
}

//Free memory and close connection
mysqli_free_result($result);
mysqli_close($conn);

?>

<!DOCTYPE html>
<html>

<!--HEADER-->
<?php include('templates/header.php'); ?>

<!--SORT BUTTON-->
<div class="container">
    <a href="index.php">
        <div class="sorter">
            Sort (Date)
        </div>
    </a>
</div>

<!--RANDOM BUTTON-->
<div class="container">
    <a href="details.php?id=<?php echo $rand_element; ?>">
        <div class="sorter">
            Random
        </div>
    </a>
</div>

<!--CLIENT CONTACT BUTTON-->
<div class='container'>
    <div class='row' align='center'>
        <?php foreach ($clients as $client) : ?>
            <div>
                <div class='card'>
                    <a href="details.php?id=<?php echo $client['id'] ?>">
                        <img src='img/CFMAdbookTelephone.svg' class='telephone-icon'>
                        <div class='card-content'>
                            <h2><?php echo htmlspecialchars($client['name']); ?></h2>
                            <div class='email-text'><?php echo htmlspecialchars($client['phone']) . '<br>' .
                                                            htmlspecialchars($client['email']); ?></div>
                            <br>
                        </div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!--FOOTER-->
<?php include('templates/footer.php'); ?>

</html>