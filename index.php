<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Hangman Game</title>
    <link rel="stylesheet"href="style.css">
  </head>

      <h1>Hangman<br>Let's the bloody game begin !</h1>
      <p id="ratefield"></p>
      <form name="rateformular">
      <input name="forfeit" type="text" size="5" maxlength="1">
      <input id="ratebutton" name="ratebutton" type="button" value="Guess" onClick="checkCharacters()">

      <p id="wrongletters">Wrong Letters:</p>
      <img src="./images/h0.png" id="hangman"><br />
      <input name="refresh" type="button" value="New Game" onClick="location.reload()">
      </form>

<?php
//explication
//file() => Chaque ligne du fichier est mise dans un array().
//array_rand() => Tire un index au hasard parmi un array que je peux  ensuite utiliser pour faire $array[$index] et donc j' aurais ma ligne au hasard.

$lines = file('dico.txt', /*FILE_IGNORE_NEW_LINES|*/FILE_SKIP_EMPTY_LINES);
$index = array_rand($lines);
//echo $lines[$index];
?>

<!--mettre dans le php ce code pour preparer la recuperation de la variable enjs-->
<input type="hidden" id="$lines[$index]" name="$lines[$index]"  value= <?php echo $lines[$index]?>/>

      <script>

      // la rappeler le mot secret(mot aleatoire généré par la fonction php) dans le js comme ceci:
       var wordtoguess = document.getElementById("$lines[$index]").value;

          // var wordtoguess = [
          // ["T", "R", "E", "E", "H", "O", "U", "S", "E"],
          //   ["J","A","V","A","S","C","R","I","P","T"],
          //   ["W","E","B","D","E","S","I","G","N"],
          //   ["E","D","U","C","A","T","I","O","N"],
          //   ["C","H","O","C","O","L","A","T","E"],
          //   ["F","R","A","N","C","E"]
          // ]
          var random = Math.floor((Math.random()*(wordtoguess.length-1)));

          var wordlenght = wordtoguess[random]; // the word to guess will be chosen from the array above
          var rateword = new Array(wordlenght.length);
          var error = 0;

          // every letter in the word is symbolized by an underscore in the guessfield
          for (var i = 0; i < rateword.length; i++){
          	rateword[i] = "_ ";
          }

          // prints the guessfield
          function printWordToGuess(){
          	for (var i = 0; i < rateword.length; i++){
          	var ratefield = document.getElementById("ratefield");
          	var letter = document.createTextNode(rateword[i]);
          	ratefield.appendChild(letter);
          	}
          }

          //checks if the the letter provided by the user matches one or more of the letters in the word
          var checkCharacters = function(){
          	var f = document.rateformular;
          	var b = f.elements["forfeit"];
          	var character = b.value; // the letter provided by the user
          	character = character.toUpperCase();
          	for (var i = 0; i < wordlenght.length; i++){
          		if(wordlenght[i] === character){
          			rateword[i] = character + " ";
          			var hit = true;
          		}
          	b.value = "";
          	}

          	//deletes the guessfield and replaces it with the new one
          	var ratefield = document.getElementById("ratefield");
          	ratefield.innerHTML="";
          	printWordToGuess();

          	// if a guessed letter is not in the word, the letter will be put on the "wrong letters" list and the hangman grows
          	if(!hit){
          		var wrongletters = document.getElementById("wrongletters");
          		var letter = document.createTextNode(" " + character);
          		wrongletters.appendChild(letter);
          		error++;
          		var hangman = document.getElementById("hangman");
              hangman.src = "./images/h" + error + ".png";
          	}

          	//checks if all letters have been found
          	var finished = true;
          	for (var i = 0; i < rateword.length; i++){
          		if(rateword[i] === "_ "){
          			finished = false;
          		}
          	}
          	if(finished){
          		window.alert("Well done! You win!!!");
          	}

          	//once you got six wrong letters, you lose
          	if(error === 6){
          		window.alert("Uh...I guess you're dead now.");
          	}
          }

          function init(){
          	printWordToGuess();
          }

          window.onload = init;
      </script>
