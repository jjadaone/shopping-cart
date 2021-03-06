<?php 
    include 'config/functions.php';
    include 'includes/header2.php'; 
?>


<link rel="stylesheet" type="text/css" href="assets/css/review.css">
<div class="row">
    <div class="container">
        <div class="review-card">
            <h1>REVIEW FORM</h1><br>
            <form action="create-review.php" method="POST">

                <input type="hidden" name="product_id" value="<?php echo $_GET['id']; ?>">
                <label for="rating">Rating</label>
                <input type="number"  name="rating" min="1" max="5" required placeholder="1-5"><br><br>
                
                <label for="review">Review</label>
                <textarea type="text" name="review"placeholder="Write your review here" required></textarea>
                <input class="btn btn-primary" type="submit" name="submit-review" value="Submit Review">
            </form>
        
        </div>
    </div>
</div>

<?php

    if (isset($_POST['submit-review']) && isset($_POST['product_id']) && $_SESSION['id']) {
        echo $_POST['product_id'];
        echo $_POST['rating'];
        
        $data = [
            'product_id' => $_POST['product_id'],
            'user_id' => $_SESSION['id'],
            'rating' => $_POST['rating'],
            'review' => $_POST['review'],
            'date_created' => date("Y-m-d"),
        ];

        $review->addReview($data);
        header("location:single-product.php?id=" . $_POST['product_id']);

    } 

?>
<?php include 'includes/footer.php'; ?>