<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forms</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <form action="verwerk_registratie.php" method="post" class="container mt-5">
        <div class="form-group">
            <label for="naam">naam:</label>
            <input type="text" name="naam" id="naam" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required>
        </div>
        <button type="submit">Registreer</button>
    </form>
</body>
</html>