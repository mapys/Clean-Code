class GuessStatisticsMessage {
    private $number;
    private $verb;
    private $pluralModifier;

    public make($candidate, $count) {
        $this->createPluralDependentMessageParts($count);
        return "The $this->verb $this->number $candidate$this->pluralModifier";
    }

    private createPluralDependentMessageParts($count) {
        if ($count == 0) {
            $this->thereAreNoLetters();
        } else if ($count == 1) {
            $this->thereIsOneLetter();
        } else {
            $this->thereAreManyLetters($count);
        }
    }

    private thereAreManyLetters($count) {
        $this->number = $count;
        $this->verb = "are";
        $this->pluralModifier = "s";
    }

    private thereIsOneLetter() {
        $this->number = "1";
        $this->verb = "is";
        $this->pluralModifier = "";
    }

    private thereAreNoLetters() {
        $this->number = "no";
        $this->verb = "are";
        $this->pluralModifier = "s";
    }
}