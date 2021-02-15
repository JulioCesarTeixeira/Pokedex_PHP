<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="css/style.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
          rel="stylesheet">
    <title>Pokedex</title>
</head>
<body>

<?php

if (isset($_GET['run'])) {
//api call
    function findPokemon(string $id): array
    {
        return json_decode(file_get_contents("https://pokeapi.co/api/v2/pokemon/" . $id), true, 512, JSON_THROW_ON_ERROR);
    }

//ID, name, img, moves
    $id = $_GET["pokemon-id"];
    $pokemon = findPokemon($id);
    $name = $pokemon['name'];
    $pokeImg = $pokemon['sprites']['front_default'];
    $backImg = $pokemon['sprites']['back_default'];
    $moves = $pokemon['moves'];

    require 'evolutions.php';
}
?>


<img id="logo" src="imgs/pokedex.png" alt="pokedex-logo">
<div class="container">
    <div class="search-wrapper">
        <div class="input-container">
            <form action="index.php" method="get">
                <label for="pokemon-id"></label>
                <input type="text" name="pokemon-id" id="pokemon-id" placeholder="Pokemon ID or Name"/>
                <input class="button" type="submit" name="run">
            </form>

        </div>
    </div>
    <div id="tpl-pokemon">
        <ul>
            <div class="pokemon-wrapper">
                <li class="pokemon">
                    <h4 class="title">
                        <em class="ID-number">
                            <?php
                            echo $id;
                            ?>
                        </em>
                        <strong class="name">
                            <?php
                            echo " - " . $name;
                            ?>
                        </strong>
                    </h4>
                    <img id="img-pokemon" src="
                    <?php
                    echo $pokeImg;
                    ?>
                            " alt="pokemon">
                </li>
                <li id="moves">
                    <h4>Moves</h4>
                    <div id="get-moves">
                        <?php
                        //4 random moves will be evoked; shorter loop version that accommodates any pokemon
                        shuffle($moves);
                        foreach (array_slice($moves, 0, 4) as $k => $v) {
                            echo "<p>" . $v['move']['name'] . "</p>";
                        }

                        //old fashioned working loop
                        //                        for ($i = 0; $i < $MAX_MOVES; $i++)
                        //                            if(count($pokemon->moves) < 2) { //ditto fix of one move
                        //                                echo "<p>" . $pokemon->moves[0]->move->name . "</p>";
                        //                                return;
                        //                            } else if (count($pokemon->moves) > 1){
                        //                                echo "<p>" . $pokemon->moves[$i]->move->name . "</p>";
                        //                            }
                        ?>
                    </div>
                </li>
                <div class="right-container">
                    <li id="all-evolutions">
                        <h4>Evolutions</h4>
                        <div id="evolution-images">
                            <?php
                            findEvolution($pokemon);
                            ?>
                    </li>
                </div>
            </div>
        </ul>
    </div>
</div>

</body>
</html>