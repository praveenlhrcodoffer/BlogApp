<?php
// Define the function to print form data
include_once 'dbconnection.php';

// Method to insert post in database -------------------------------------------------------------------------------
function editPost($postId) {

    global $conn;



       // Retrieve the post content from the database
       $getPostQuery = "SELECT * FROM `blogtbl` WHERE `id` = $postId";
       $result = mysqli_query($conn, $getPostQuery);

       if ($result && mysqli_num_rows($result) > 0) {
        $post = mysqli_fetch_assoc($result);

        // echo $post['content'];  
            ?>
            <!-- edit form -->
                <div class="post-item">
                    <form method="POST" action="handleData.php" enctype="multipart/form-data" >
                        <div class="post-title-wrapper">
                            <input type="text" name="title" value="<?php echo $post['title']; ?>">
                        </div>
                        <div class="post-author-wrapper">
                            <input type="text" name="author" value="Mark Gurman" disabled>
                        </div>
                        <div class="post-content-wrapper">
                            <textarea name="content"><?php echo $post['content']; ?></textarea>
                        </div>

                        <div class="post-image-wrapper">
                            <img id="previewImage" style="width: 100px" src="<?php echo $post['image_url']; ?>" />
                        </div>

                        <div class="post-image-wrapper">
                            <input id="fileToUpload" name="fileToUpload" type="file" accept="image/*" onchange="previewFile()" />
                        </div>

                        <script>
                            function previewFile() {
                                var preview = document.getElementById('previewImage');
                                var file = document.getElementById('fileToUpload').files[0];
                                var reader = new FileReader();

                                reader.onloadend = function () {
                                    preview.src = reader.result;
                                }

                                if (file) {
                                    reader.readAsDataURL(file);
                                } else {
                                    preview.src = "";
                                }
                            }
                        </script>

                        <div class="post-crudbtn-wrapper">
                            <input type="hidden" name="post_id" value="<?php echo $postId; ?>">
                            <button type="submit" name="save_edit">Save</button>
                            <a href="index.php" class="cancel">Cancel</a>
                        </div>
                    </form>
                </div>

            <?php


       }

}

function updatePostInDb($postId, $title, $content, $imageFile) {



    global $conn;


    $imagePath = ""; // Initialize image path variable

    // File upload handling
    if ($_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
        $targetDirectory = "images/";
        $targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            // File uploaded successfully, set the image path
            $imagePath = $targetFile;

            echo "image selected success";   
        } else {
            echo "Sorry, there was an error uploading your file.";
            return;
        }
    }
    
    // echo $imagePath;  


    $update_query = "UPDATE `blogtbl` SET `title` = '$title', `content` = '$content', `image_url` = '$imagePath' WHERE `id` = $postId";
    $result = mysqli_query($conn, $update_query);

    if ($result) {
        echo "<script> window.location.href = 'index.php'; </script>";
        exit();
    } else {
        echo "Error updating record:" . mysqli_error($conn);
    }
}


//  Delete Post from database -------------------------------------------------------------------------------
function deletePost($postId){

    global $conn;

    $delete_query = "DELETE FROM `blogtbl` WHERE id = $postId";

    $result = mysqli_query($conn, $delete_query);


    if ($result) {
        // echo "Post deleted successfully";
        echo "<script> window.location.href = 'index.php'; </script>";

        
        // Redirect to a success page or handle as needed
    } else {
        echo "Error deleting record:" . mysqli_error($conn);
    }

    // $delete_query = 'SELECT '
// header("location:index.php");

}




// Insert post in database -------------------------------------------------------------------------------
function insertData()
{
    global $conn; // Access the $conn variable from dbconnection.php
    $title = $_POST["title"];
    $author = $_POST["author"];
    $content = $_POST["content"];

    // $image_file = $_FILES["fileToUpload"];

    // // Exit if no file uploaded
    // if (!isset($image_file)) {
    //     die('No file uploaded.');
    // }
    
    // // Exit if is not a valid image file
    // $image_type = exif_imagetype($image_file["tmp_name"]);
    // if (!$image_type) {
    //     die('Uploaded file is not an image.');
    // }
    
    // // Move the temp image file to the images/ directory
    // move_uploaded_file(
    //     // Temp image location
    //     $image_file["tmp_name"],
    
    //     // New image location
    //     __DIR__ . "/images/" . $image_file["name"]
    // );



    $imagePath = ""; // Initialize image path variable

    // File upload handling
    if ($_FILES["fileToUpload"]["error"] == UPLOAD_ERR_OK) {
        $targetDirectory = "images/";
        $targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
            // File uploaded successfully, set the image path
            $imagePath = $targetFile;

            echo "image selected success";   
        } else {
            echo "Sorry, there was an error uploading your file.";
            return;
        }
    }
    
echo $imagePath;    

    $insert_query = "INSERT INTO `blogtbl` (`title`, `author`, `content`, `created_at`, `image_url`) VALUES ('$title', '$author', '$content', current_timestamp(), '$imagePath')";

    $result = mysqli_query($conn, $insert_query);

    if ($result) {
        // echo "Record inserted successfully";
        echo "<script> window.location.href = 'index.php'; </script>";
        // header("location:index.php");

        // echo '<p>Post added sucessfully</p>';
        exit();
    } else {
        echo "Error inserting record:" . mysqli_error($conn);
    }
}


// Method to get all posts from database -------------------------------------------------------------------------------
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

                <div class="post-image-wrapper">
                <img id="post-image" src="<?php echo $row['image_url']; ?>" alt="Post Image">
                </div>

                <div class="post-content-wrapper">
                    <p>
                        <?php echo  $row['content']; ?>
                    </p>
                </div>

                <div class="post-crudbtn-wrapper">

                <a href="handleData.php?action=edit&id=<?php echo $row['id']; ?>" class="crud-button">Edit</a>
                <a href="handleData.php?action=delete&id=<?php echo $row['id']; ?>" class="crud-button">Delete</a>


                </div>
            </div>
<?php
        }
    }
}




// ------------------------------------------------------------------------------------------------------

if(isset($_GET['action'])) {

    $postId = $_GET['id'];
    
    switch($_GET['action']) {

        case 'edit':
            editPost($postId);
            break;


        case 'delete':
            deletePost($postId);
            break;
    }
}

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Call the function to print form data

    if(isset($_POST["save_edit"])) {

        echo 'editing';

        $postId = $_POST['post_id'];
        $title = $_POST["title"];
        $content = $_POST["content"];

        if(isset($_FILES['fileToUpload']) && $_FILES['fileToUpload']['error'] === UPLOAD_ERR_OK) {
            // Access the uploaded file
            $imageFile = $_FILES['fileToUpload'];
    
            // Handle the uploaded file
            // Here, you can process the uploaded file as needed
        } else {
            // If no file is uploaded or an error occurred
            $imageFile = null;
        }

        // echo '<pre>';

        // var_dump( $imageFile);

        // echo '</pre>';


        updatePostInDb($postId, $title, $content,$imageFile);


    }elseif(isset($_POST["insert"])){
        insertData();
    }

    
}
