<?php
// Define the function to print form data
include 'dbconnection.php';

// Method to insert post in database 



function insertData()
{
    global $conn; // Access the $conn variable from dbconnection.php
    $title = $_POST["title"];
    $author = $_POST["author"];
    $content = $_POST["content"];



    $insert_query = "INSERT INTO `blogtbl` (`title`, `author`, `content`, `created_at`) VALUES ('$title', '$author', '$content', current_timestamp())";
    $result = mysqli_query($conn, $insert_query);

    if ($result) {
        // echo "Record inserted successfully";
        // echo "<script> window.location.href = 'index.php'; </script>";
        header("location:index.php");

        // echo '<p>Post added sucessfully</p>';
        exit();
    } else {
        echo "Error inserting record:" . mysqli_error($conn);
    }
}


// Method to get all posts from database 
function getPostsList()
{

    global $conn;

    $get_query = "SELECT * FROM `blogtbl` ORDER BY created_at DESC";

    $get_res = mysqli_query($conn, $get_query);


    if (mysqli_num_rows($get_res) > 0) {


        while ($row = mysqli_fetch_assoc($get_res)) {

?>
            <div class="post-item">

                <div class="post-title-wrapper">
                    <p> <?php echo  $row['title']; ?> </p>
                </div>

                <div class="post-author-wrapper">
                    <p>Mark Gurman</p>
                    <p id="createdate"> - <?php echo  $row['created_at']; ?></p>
                </div>

                <div class="post-content-wrapper">
                    <p>
                        <?php echo  $row['content']; ?>
                    </p>
                </div>

                <div class="post-content-wrapper">
                    <p>
                        <?php echo  $row['content']; ?>
                    </p>
                </div>

                <div class="post-crudbtn-wrapper">
                    <button onclick="" id="edit-btn" class="crud-button">Edit</button>
                    <button id="delete-btn" class="crud-button">Delete</button>
                </div>
            </div>
<?php
        }
    }
}


// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Call the function to print form data
    insertData();
}
