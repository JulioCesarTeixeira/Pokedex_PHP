<?php

//evolutions translated from Javascript
function findEvolution(array $pokemon)
{   //API path from pokemon to species to evolution chain
    $species = json_decode(file_get_contents($pokemon['species']['url']), true);
    $evolutionChain = json_decode(file_get_contents($species['evolution_chain']['url']), true);
    //count = .length in JS. Create Var to check the length of arrays for if statements
    $evolvesTo1 = count($evolutionChain['chain']['evolves_to']);
    $evolvesTo2 = count($evolutionChain['chain']['evolves_to']['0']['evolves_to']);
    //$Evolution1 leads to the pokemon itself in the Path and $Evolution2 is the path to the next evolution's name
    $evolution1 = $evolutionChain['chain']['species']['name'];
    $evolution2 = $evolutionChain['chain']['evolves_to']['0']['species']['name'];

    function showEvolution($evolutionName)
    {
        $pokemonSrcImg = findPokemon($evolutionName);
        $imgSrc = $pokemonSrcImg['sprites']['front_default'];
        echo '<a href="http://pokedex.localhost/index.php?pokemon-id=' . $evolutionName . '&run=run%21" id=' . $evolutionName . '>
                    <img src="' . $imgSrc . '" alt="evolution">
                  </a>';
    }

    if ($evolvesTo1 === 0) {
        echo '<p>' . 'This pokemon does not have other transformations' . '</p>';

    } else if ($evolvesTo1 === 1 && $evolvesTo2 === 0) {
        showEvolution($evolution1);
        showEvolution($evolution2);

    } else if ($evolvesTo2 === 1) {
        $evolution3 = $evolutionChain['chain']['evolves_to'][0]['evolves_to'][0]['species']['name'];
        showEvolution($evolution1);
        showEvolution($evolution2);
        showEvolution($evolution3);

    } else if ($evolvesTo1 > 1) {
        foreach ($evolutionChain['chain']['evolves_to'] as $v) {
            $pokemonName = $v['species']['name'];
            showEvolution($pokemonName);
        }
    } else if ($evolvesTo2 === 0) {
        echo "no evolutions";
    }
}