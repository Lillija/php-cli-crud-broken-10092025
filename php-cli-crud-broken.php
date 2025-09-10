<?php


function loadBooks() {
    if (file_exists('data.json')) {
        $json = file_get_contents('data.json');
        return json_decode($json, true); // Decode the JSON data to an array
    }
    return [];
}

// Save books to 'data.json'
function saveBooks($books) {
    $json = json_encode($books, JSON_PRETTY_PRINT); // Convert the books array to JSON format
    file_put_contents('data.json', $json); // Save the JSON data back to the file
}

function showAllBooks($books) {
    foreach ($books as $book) {
        displayBook($book);
    }
}

function showBook($books) {
    $id = readline("Enter book id: ");
    foreach ($books as $book) {
        if ($book['id'] == $id) {
            displayBook($book);
            return;
        }
    }
    echo "Book not found!\n";
}

function addBook(&$books) {
    $title = readline("Enter title: ");
    $author = readline("Enter author: ");
    $id = count($books) + 1; // Create a new unique ID
    $books[] = ['id' => $id, 'title' => $title, 'author' => $author];
    saveBooks($books); // Save the updated books to data.json
}

function deleteBook(&$books) {
    $id = readline("Enter book ID you want to delete: ");
    foreach ($books as $key => $book) {
        if ($book['id'] == $id) {
            unset($books[$key]);
            echo "Book deleted\n";
            saveBooks($books); // Save the updated books to data.json
            return;
        }
    }
    echo "Book not found\n";
}

function displayBook($book) {
    echo "ID: {$book['id']} // Title: " . $book['title'] . " // Author: " . $book['author'] . "\n\n";
}

// Main program starts here
$books = loadBooks(); // Load books from data.json

echo "\n\nWelcome to the Library\n";
$continue = true;

do {
    echo "\n\n";
    echo "1 - Show all books\n";
    echo "2 - Show a book\n";
    echo "3 - Add a book\n";
    echo "4 - Delete a book\n";
    echo "5 - Quit\n\n";
    $choice = readline();

    switch ($choice) {
        case 1:
            showAllBooks($books);
            break;
        case 2:
            showBook($books);
            break;
        case 3:
            addBook($books);
            break;
        case 4:
            deleteBook($books);
            break;
        case 5:
            echo "Goodbye!\n";
            $continue = false;
            break;
        default:
            echo "Invalid choice\n";
    };

} while ($continue);
