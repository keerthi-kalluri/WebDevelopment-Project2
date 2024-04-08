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
        'word'=> 'Missionary',
        'hint'=> 'A person sent on a religious mission, especially one sent to promote Christianity in a foreign country.'
    ],
    [
        'word'=> 'miscellaneous',
        'hint'=> 'Consisting of many things of different sorts.'
    ],
	[
        'word'=> 'babbitting',
        'hint'=> 'Lining a surface or bearing with Babbitt metal.'
    ],
    [
        'word'=> 'beautification',
        'hint'=> 'The action or process of improving the appearance of a person or place.'
    ],
    [
        'word'=> 'Sanctuary',
        'hint'=> 'A place of refuge and protection.'
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