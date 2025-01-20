<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forms</title>
</head>
<body>
    <form action="verwerk_registratie.php" method="post">
        <label for="naam">naam:</label>
        <input type="text" name="naam" id="naam" required>

        <label for="email">E-mail:</label>
        <input type="email" name="email" id="email" required>

        <button type="submit">Registreer</button>
    </form>
</body>
</html>