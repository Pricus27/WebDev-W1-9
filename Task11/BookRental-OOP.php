<?php
class Book {
    public $Title;
    public $Author;
    public $Year;
    public $isAvailable;

    public function __construct($Title, $Author, $Year, bool $isAvailable = true) {
        $this->Title = $Title;
        $this->Author = $Author;
        $this->Year = $Year;
        $this->isAvailable = $isAvailable;
    }

    public function DisplayLibrary() {
        $avail = $this->isAvailable ? 'Yes' : 'No';
        return "Title: {$this->Title} | Author: {$this->Author} | Year: {$this->Year} | Available: {$avail}";
    }

    public function borrowBook() {
        if ($this->isAvailable) {
            $this->isAvailable = false;
            return "You have successfully borrowed {$this->Title}.";
        }
        return "{$this->Title} is currently not available.";
    }

    public function returnBook() {
        if (!$this->isAvailable) {
            $this->isAvailable = true;
            return "{$this->Title} has been returned successfully.";
        }
        return "{$this->Title} was not borrowed in the first place.";
    }

}

$book1 = new Book("Game Of Thrones", "George R.R. Martin", "1996");
$book2 = new Book("The Umbrella Academy", "Gerard Way", "2007");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Book Rental</title>
</head>
<body>
    <div class="container py-5" style="margin-top: 100px">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="h4 fw-bold mt-2" style="text-align: center;">Book Rental</h2>
                        <p class="text-muted mb-3" style="text-align: center;">Select a book, then choose an action.</p>

                        <?php
                        echo "<h5 class='mt-2'>Display Book Info</h5>";
                        echo '<p>' . $book1->DisplayLibrary() . '</p>';

                        echo "<hr><h5>Borrow the Book</h5>";
                        echo '<p>' . $book1->borrowBook() . '</p>';

                        echo "<br><h5>Try Borrowing Again</h5>";
                        echo '<p>' . $book2->borrowBook() . '</p>';

                        echo "<hr><h5>Display Book Info After Borrowing</h5>";
                        echo '<p>' . $book1->DisplayLibrary() . '</p>';

                        echo "<hr><h5>Return the Book</h5>";
                        echo '<p>' . $book1->returnBook() . '</p>';

                        echo "<br><h5>Try Returning Again</h5>";
                        echo '<p>' . $book2->returnBook() . '</p>';

                        echo "<hr><h5>Display Book Info After Returning</h5>";
                        echo '<p>' . $book1->DisplayLibrary() . '</p>';
                        echo '<p>' . $book2->DisplayLibrary() . '</p>';
                        ?>
                    </div>
                </div>  
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>