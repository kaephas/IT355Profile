
<?php
$title = "Guestbook";
include('includes/header.html');
require('../mysqli_connect.php');

$query = 'SELECT name, email, company, linked_in, how_met, comments, signed FROM guestbook';
$result = @mysqli_query($dbc, $query);
$rows = mysqli_num_rows($result);


echo '<div class="container">';
echo '<h1 class="display-4 mb-5 text-center">Guestbook Signatures</h1>';

if($result) {
    /* load datatable */
    echo '<script src="scripts/loadTable.js"></script>';
    /* begin datatable */
        echo '
    <table id="signers" class="display">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Company</th>
                <th>LinkedIn</th>
                <th>How we Met</th>
                <th>Comments</th>
                <th>Date Signed</th>
            </tr>
        </thead>
        <tbody>
        ';

        // retrieve each row and input into table
        while($row = mysqli_fetch_assoc($result)) {

            echo '
            <tr>
                <td>' . $row['name'] . '</td>
                <td>'. $row['email'] . '</td>
                <td>'. $row['company'] . '</td>
                <td>'. $row['linked_in'] . '</td>
                <td>'. $row['how_met'] . '</td>
                <td>'. $row['comments'] . '</td>
                <td>' . date("M d, Y - H:i", strtotime($row['signed'])) . '</td>
            </tr>
         ';

        }
        echo '
        </tbody>
    </table>
    </div>
        ';
} else {
//    query didn't work for some reason....
    echo 'Something went wrong with the database.';
}

?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>