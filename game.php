<?php
/* @route http://dev.wfprojects.com/hangman/game.php */

session_start();

$letters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
$WON = false;

// Live variables here


// ALl the body parts
$bodyParts = ["nohead","head","body","hand","hands","leg","legs"];


// Random words for the game and you to guess
$words = [
    [
        'word' => 'guitar',
        'hint' => 'A musical instrument with strings.'
    ],
    [
        'word' => 'oxygen',
        'hint' => 'A colorless, odorless gas essential for life.'
    ],
	[
        'word'=> 'mountain',
        'hint'=> 'A large natural elevation of the Earth"s surface.'
    ],
    [
        'word'=> 'painting',
        'hint'=> 'An art form using colors on a surface to create images or expression.'
    ],
    [
        'word'=> 'astronomy',
        'hint'=> 'The scientific study of celestial objects and phenomena.'
    ],
    [
        'word'=> 'football',
        'hint'=> 'A popular sport played with a spherical ball.'
    ],
    [
        'word'=> 'chocolate',
        'hint'=> 'A sweet treat made from cocoa beans.'
    ],
    [
        'word'=> 'butterfly',
        'hint'=> 'An insect with colorful wings and a slender body.'
    ],
    [
        'word'=> 'history',
        'hint'=> 'The study of past events and human civilization.'
    ],
    [
        'word'=> 'pizza',
        'hint'=> 'A savory dish consisting of a round, flattened base with toppings.'
    ],
    [
        'word'=> 'jazz',
        'hint'=> 'A genre of music characterized by improvisation and syncopation.'
    ],
    [
        'word'=> 'camera',
        'hint'=> 'A device used to capture and record images or videos.'
    ],
    [
        'word'=> 'diamond',
        'hint'=> 'A precious gemstone known for its brilliance and hardness.'
    ],
    [
        'word'=> 'adventure',
        'hint'=> 'An exciting or daring experience.'
    ],
    [
        'word'=> 'science',
        'hint'=> 'The systematic study of the structure and behavior of the physical and natural world.'
    ],
    [
        'word'=> 'bicycle',
        'hint'=> 'A human-powered vehicle with two wheels.'
    ],
    [
        'word'=> 'sunset',
        'hint'=> 'The daily disappearance of the sun below the horizon.'
    ],
    [
        'word'=> 'coffee',
        'hint'=> 'A popular caffeinated beverage made from roasted coffee beans.'
    ],
    [
        'word'=> 'dance',
        'hint'=> 'A rhythmic movement of the body often performed to music.'
    ],
    [
        'word'=> 'galaxy',
        'hint'=> 'A vast system of stars, gas, and dust held together by gravity.'
    ],
    [
        'word'=> 'orchestra',
        'hint'=> 'A large ensemble of musicians playing various instruments.'
    ],
    [
        'word'=> 'volcano',
        'hint'=> 'A mountain or hill with a vent through which lava, rock fragments, hot vapor, and gas are ejected.'
    ],
    [
        'word'=> 'novel',
        'hint'=> 'A long work of fiction, typically with a complex plot and characters.'
    ],
    [
        'word'=> 'sculpture',
        'hint'=> 'A three-dimensional art form created by shaping or combining materials.'
    ],
    [
        'word'=> 'symphony',
        'hint'=> 'A long musical composition for a full orchestra, typically in multiple movements.'
    ],
    [
        'word'=> 'architecture',
        'hint'=> 'The art and science of designing and constructing buildings.'
    ],
    [
        'word'=> 'ballet',
        'hint'=> 'A classical dance form characterized by precise and graceful movements.'
    ],
    [
        'word'=> 'astronaut',
        'hint'=> 'A person trained to travel and work in space.'
    ],
    [
        'word'=> 'waterfall',
        'hint'=> 'A cascade of water falling from a height.'
    ],
    [
        'word'=> 'technology',
        'hint'=> 'The application of scientific knowledge for practical purposes.'
    ],
    [
        'word'=> 'rainbow',
        'hint'=> 'A meteorological phenomenon that is caused by reflection, refraction, and dispersion of light.'
    ],
    [
        'word'=> 'universe',
        'hint'=> 'All existing matter, space, and time as a whole.'
    ],
    [
        'word'=> 'piano',
        'hint'=> 'A musical instrument played by pressing keys that cause hammers to strike strings.'
    ],
    [
        'word'=> 'vacation',
        'hint'=> 'A period of time devoted to pleasure, rest, or relaxation.'
    ],
    [
        'word'=> 'rainforest',
        'hint'=> 'A dense forest characterized by high rainfall and biodiversity.'
    ],
    [
        'word'=> 'theater',
        'hint'=> 'A building or outdoor area in which plays, movies, or other performances are staged.'
    ],
    [
        'word'=> 'telephone',
        'hint'=> 'A device used to transmit sound over long distances.'
    ],
    [
        'word'=> 'language',
        'hint'=> 'A system of communication consisting of word"s, gestures, and syntax.'
    ],
    [
        'word'=> 'desert',
        'hint'=> 'A barren or arid land with little or no precipitation.'
    ],
    [
        'word'=> 'sunflower',
        'hint'=> 'A tall plant with a large yellow flower head.'
    ],
    [
        'word'=> 'fantasy',
        'hint'=> 'A genre of imaginative fiction involving magic and supernatural elements.'
    ],
    [
        'word'=> 'telescope',
        'hint'=> 'An optical instrument used to view distant objects in space.'
    ],
    [
        'word'=> 'breeze',
        'hint'=> 'A gentle wind.'
    ],
    [
        'word'=> 'oasis',
        'hint'=> 'A fertile spot in a desert where water is found.'
    ],
    [
        'word'=> 'photography',
        'hint'=> 'The art, process, or practice of creating images by recording light or other electromagnetic radiation.'
    ],
    [
        'word'=> 'safari',
        'hint'=> 'An expedition or journey, typically to observe wildlife in their natural habitat.'
    ],
    [
        'word'=> 'planet',
        'hint'=> 'A celestial body that orbits a star and does not produce light of its own.'
    ],
    [
        'word'=> 'river',
        'hint'=> 'A large natural stream of water flowing in a channel to the sea, a lake, or another such stream.'
    ],
    [
        'word'=> 'tropical',
        'hint'=> 'Relating to or situated in the region between the Tropic of Cancer and the Tropic of Capricorn.'
    ],
    [
        'word'=> 'mysterious',
        'hint'=> 'Difficult or impossible to understand, explain, or identify.'
    ],
    [
        'word'=> 'enigma',
        'hint'=> 'Something that is mysterious, puzzling, or difficult to understand.'
    ],
    [
        'word'=> 'paradox',
        'hint'=> 'A statement or situation that contradicts itself or defies intuition.'
    ],
    [
        'word'=> 'puzzle',
        'hint'=> 'A game, toy, or problem designed to test ingenuity or knowledge.'
    ],
    [
        'word'=> 'whisper',
        'hint'=> 'To speak very softly or quietly, often in a secretive manner.'
    ],
    [
        'word'=> 'shadow',
        'hint'=> 'A dark area or shape produced by an object blocking the light.'
    ],
    [
        'word'=> 'secret',
        'hint'=> 'Something kept hidden or unknown to others.'
    ],
    [
        'word'=> 'curiosity',
        'hint'=> 'A strong desire to know or learn something.'
    ],
    [
        'word'=> 'unpredictable',
        'hint'=> 'Not able to be foreseen or known beforehand; uncertain.'
    ],
    [
        'word'=> 'obfuscate',
        'hint'=> 'To confuse or bewilder someone; to make something unclear or difficult to understand.'
    ],
    [
        'word'=> 'unveil',
        'hint'=> 'To make known or reveal something previously secret or unknown.'
    ],
    [
        'word'=> 'illusion',
        'hint'=> 'A false perception or belief; a deceptive appearance or impression.'
    ],
    [
        'word'=> 'moonlight',
        'hint'=> 'The light from the moon.'
    ],
    [
        'word'=> 'vibrant',
        'hint'=> 'Full of energy, brightness, and life.'
    ],
    [
        'word'=> 'nostalgia',
        'hint'=> 'A sentimental longing or wistful affection for the past.'
    ],
    [
        'word'=> 'brilliant',
        'hint'=> 'Exceptionally clever, talented, or impressive.'
    ]
];


function getCurrentPicture($part){
    return "./images/hangman_". $part. ".svg";
}


function startGame(){
   
}

// restart the game. Clear the session variables
function restartGame(){
    session_destroy();
    session_start();

}

// Get all the hangman Parts
function getParts(){
    global $bodyParts;
    return isset($_SESSION["parts"]) ? $_SESSION["parts"] : $bodyParts;
}

// add part to the Hangman
function addPart(){
    $parts = getParts();
    array_shift($parts);
    $_SESSION["parts"] = $parts;
}

// get Current Hangman Body part
function getCurrentPart(){
    $parts = getParts();
    return $parts[0];
}

// get the current words
function getCurrentWord(){
  //  return "HANGMAN"; // for now testing
    global $words;
    if(!isset($_SESSION["word"]) && empty($_SESSION["word"])){
        $key = array_rand($words);
        $_SESSION["word"] = 
         [
            "word" => $words[$key]["word"],
            "hint" => $words[$key]["hint"]
        ];
    }
    return $_SESSION["word"];
}



// user responses logic

// get user response
function getCurrentResponses(){
    return isset($_SESSION["responses"]) ? $_SESSION["responses"] : [];
}

function addResponse($letter){
    $responses = getCurrentResponses();
    array_push($responses, $letter);
    $_SESSION["responses"] = $responses;
}

// check if pressed letter is correct
function isLetterCorrect($letter){
    $word1 = getCurrentWord();
    $word = $word1["word"];
    $max = strlen($word) - 1;
    for($i=0; $i<= $max; $i++){
        if($letter == $word[$i]){
            return true;
        }
    }
    return false;
}

// is the word (guess) correct

function isWordCorrect(){
    $guess1 = getCurrentWord();
    $guess = $guess1["word"];
    $responses = getCurrentResponses();
    $max = strlen($guess) - 1;
    for($i=0; $i<= $max; $i++){
        if(!in_array($guess[$i],  $responses)){
            return false;
        }
    }
    return true;
}

// check if the body is ready to hang

function isBodyComplete(){
    $parts = getParts();
    // is the current parts less than or equal to one
    if(count($parts) <= 1){
        return true;
    }
    return false;
}

// manage game session

// is game complete
function gameComplete(){
    return isset($_SESSION["gamecomplete"]) ? $_SESSION["gamecomplete"] :false;
}


// set game as complete
function markGameAsComplete(){
    $_SESSION["gamecomplete"] = true;
}

// start a new game
function markGameAsNew(){
    $_SESSION["gamecomplete"] = false;
}



/* Detect when the game is to restart. From the restart button press*/
if(isset($_GET['start'])){
    restartGame();
}


/* Detect when Key is pressed */
if(isset($_GET['kp'])){
    $currentPressedKey = isset($_GET['kp']) ? $_GET['kp'] : null;
    // if the key press is correct
    if($currentPressedKey 
    && isLetterCorrect($currentPressedKey)
    && !isBodyComplete()
    && !gameComplete()){
        
        addResponse($currentPressedKey);
        if(isWordCorrect()){
            $WON = true; // game complete
            markGameAsComplete();
        }
    }else{
        // start hanging the man :)
        if(!isBodyComplete()){
           addPart(); 
           if(isBodyComplete()){
               markGameAsComplete(); // lost condition
           }
        }else{
            markGameAsComplete(); // lost condition
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hangman Game</title>
    <link rel="stylesheet" href="css/style.css">
</head>
    <body>
        <!-- Main app display -->
        <div class="container">
            <!-- Display the image here -->
            <div class="hangman-box">
                 <img src="<?php echo getCurrentPicture(getCurrentPart());?>"/>
          
                <!-- Indicate game status -->
               <?Php if(gameComplete()):?>
                    <h1>GAME COMPLETE</h1>
                <?php endif;?>
                <?php if($WON  && gameComplete()):
                   // <p style="color: darkgreen; font-size: 25px;">You Won! HURRAY! :)</p>
                   $hintfinal = getCurrentWord()["word"];
                   $modalText = 'You found the word' ;
                   $modalImageSrc = 'victory.gif' ;
                   $modalTitle =  'Congrats!';

                    // Output the modal HTML
                    echo "<div class='game-modal' >";
                    echo "<div class='content'>";
                    echo "<img src='images/$modalImageSrc' alt='Game Over Image'>";
                    echo "<h4>$modalTitle</h4>";
                    echo "<p>$modalText <b>$hintfinal</b></p>";
                    echo "<form method='get'>";
                    echo "<button type='submit' name='start' style='width:100%'>Restart Game</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";

                    // Add JavaScript to show the modal
                    echo "<script>";
                    echo "document.addEventListener('DOMContentLoaded', function() {";
                    echo "document.querySelector('.game-modal').classList.add('show');";
                    echo "});";
                    echo "</script>";?>
                <?php elseif(!$WON  && gameComplete()): 
                   // <p style="color: darkred; font-size: 25px;">You LOST! OH NO! :(</p>
                   $hintfinal = getCurrentWord()["word"];
                   $modalText = 'The correct word was:' ;
                   $modalImageSrc = 'lost.gif' ;
                   $modalTitle =  'Game Over!';

                    // Output the modal HTML
                    echo "<div class='game-modal' >";
                    echo "<div class='content'>";
                    echo "<img src='images/$modalImageSrc' alt='Game Over Image'>";
                    echo "<h4>$modalTitle</h4>";
                    echo "<p>$modalText <b>$hintfinal</b></p>";
                    echo "<form method='get'>";
                    echo "<button type='submit' name='start' style='width:100%'>Restart Game</button>";
                    echo "</form>";
                    echo "</div>";
                    echo "</div>";

                    // Add JavaScript to show the modal
                    echo "<script>";
                    echo "document.addEventListener('DOMContentLoaded', function() {";
                    echo "document.querySelector('.game-modal').classList.add('show');";
                    echo "});";
                    echo "</script>";?>
                <?php endif;?>
                <h1>Hangman the Game</h1>
                </div>
                <div class="game-box">
                <div class="word-display" >

                <!-- Display the current guesses -->
                <?php 
                 $guess1 = getCurrentWord();
                 $guess = $guess1["word"];
                 $hint = $guess1["hint"];
                 $maxLetters = strlen($guess) - 1;
                for($j=0; $j<= $maxLetters; $j++): $l = $guess[$j]; ?>
                    <?php if(in_array($l, getCurrentResponses())):?>
                        <span style="font-size: 35px; border-bottom: 3px solid #000; margin-right: 5px;"><?php echo $l;?></span>
                    <?php else: ?>
                        <span style="font-size: 35px; border-bottom: 3px solid #000; margin-right: 5px;">&nbsp;&nbsp;&nbsp;</span>
                    <?php endif;?>
                <?php endfor;?>
                <br>
                <h4 class="hint-text">Hint:<b> <?php echo "$hint"; ?> </b></h4>
            </div>
                <div class="keyboard" >
                    <form method="get">
                    <?php
                        $max = strlen($letters) - 1;
                        for ($i = 97; $i <= 122; $i++) {
                            $letter = chr($i);
                            echo "<button style='margin-right: 5px;margin-bottom: 5px;' type='submit' name='kp' value='". $letter . "'>".
                            $letter . "</button>"; 
                        }
                    ?>
                    <br><br>
                    <!-- Restart game button -->
                    <button type="submit" name="start" style="width:100%">Restart Game</button>
                    </form>
                </div>

            
            
                </div>
            
        </div>
        
</body>
    
    
</html>