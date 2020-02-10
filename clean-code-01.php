private printGuessStatistics($candidate, $count) {
    $number;
    $verb;
    $pluralModifier;

    if ($count == 0) {
        $number = "no";
        $verb = "are";
        $pluralModifier = "s";
    } else if ($count == 1) {
        $number = "1";
        $verb = "is";
        $pluralModifier = "";
    } else {
        $number = $count;
        $verb = "are";
        $pluralModifier = "s";
    }

    $guessMessage = "The $verb $number $candidate$pluralModifier";
    
    echo $guessMessage;
}