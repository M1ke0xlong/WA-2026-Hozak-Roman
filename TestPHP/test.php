<?php
$name = "";
$message = "";
$age = 0;

if($_SERVER["REQUEST_METHOD"]=="POST") {
    $name = $_POST["name"];
    $age = $_POST["age"];
    if($name== "Roman") {
        $message = "Ahoj Romčo";
    } else {
        $message = "Neznám tě kys";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
@import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap');
* {
    font-family: "Open Sans", sans-serif;
}
input {
    border-color: gray;
    border-radius: 5px;
    padding: 0.4rem;
}
button {
    border: 0px;
    padding: 0.5rem;
    background-color: #08395aff;
    border-radius: 5px;
    color:white;
}
</style>

<body>
    <h1>Test formuláře</h1>
    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Aspernatur voluptatum provident dicta odio quidem, doloremque, ipsa impedit fuga error dolorem totam ad sapiente nesciunt tempore! Architecto odio animi quaerat ea.</p>
    <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatum, repellendus? Nobis, accusamus illum enim, nostrum dicta cupiditate earum incidunt voluptas saepe voluptatem adipisci a? Iste harum neque non nihil unde.</p>
    <form method="post">
        <input type="text" name="name" placeholder="Zadejte jméno">
        <input type="number" name="age"placeholder="Zadej svůj věk">
        <button type="submit">Odeslat</button>
    </form>
    <p>
        <?php echo "Výstup: "; echo $message; echo ", tvůj věk je: ";echo $age; ?>
    </p>
</body>

</html>