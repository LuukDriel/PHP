<?php 

class Movie {
    // Privé eigenschappen
    private $title;
    private $releaseYear;
    private $genre; // Nieuwe eigenschap voor genre
    private $rating; // Nieuwe eigenschap voor beoordeling

    // Constructor om eigenschappen in te stellen
    public function __construct($title, $releaseYear, $genre, $rating) {
        $this->setTitle($title);
        $this->setReleaseYear($releaseYear);
        $this->setGenre($genre); // Genre instellen via setter
        $this->setRating($rating); // Beoordeling instellen via setter
    }

    // Getter voor titel
    public function getTitle() {
        return $this->title;
    }

    // Setter voor titel
    public function setTitle($title) {
        if (strlen($title) > 0) {
            $this->title = $title;
        } else {
            echo "Titel kan niet leeg zijn.<br>";
        }
    }

    // Getter voor releasejaar
    public function getReleaseYear() {
        return $this->releaseYear;
    }

    // Setter voor releasejaar
    public function setReleaseYear($releaseYear) {
        if (is_numeric($releaseYear) && strlen($releaseYear) == 4) {
            $this->releaseYear = $releaseYear;
        } else {
            echo "Ongeldig releasejaar.<br>";
        }
    }

    // Getter voor genre
    public function getGenre() {
        return $this->genre;
    }

    // Setter voor genre
    public function setGenre($genre) {
        if (strlen($genre) > 0) {
            $this->genre = $genre;
        } else {
            echo "Genre kan niet leeg zijn.<br>";
        }
    }

    // Getter voor beoordeling
    public function getRating() {
        return $this->rating;
    }

    // Setter voor beoordeling
    public function setRating($rating) {
        if (is_numeric($rating) && $rating >= 0 && $rating <= 10) {
            $this->rating = $rating;
        } else {
            echo "Ongeldige beoordeling. Moet tussen 0 en 10 liggen.<br>";
        }
    }

    // Methode om filminformatie weer te geven
    public function displayInfo() {
        echo "Titel: " . $this->getTitle() . "<br>";
        echo "Releasejaar: " . $this->getReleaseYear() . "<br>";
        echo "Genre: " . $this->getGenre() . "<br>";
        echo "Beoordeling: " . $this->getRating() . "<br>";
    }
}



$Movie1 = new Movie("Inception", 2010, "Science Fiction", 8.8);
$Movie1->displayInfo();
echo "<br>";
$Movie2 = new Movie("The Godfather", 1972, "Crime", 9.2);
$Movie2->displayInfo();

?>