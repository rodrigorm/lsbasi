<?php

/**
 * Token types
 *
 * T_EOF (end-of-file) token is used to indicate that
 * there is no more input left for lexical analysis
 */
define('T_INTEGER', 'T_INTEGER');
define('T_PLUS', 'T_PLUS');
define('T_MINUS', 'T_MINUS');
define('T_EOF', 'T_EOF');

class Token {
    /**
     * token type: 'T_INTEGER', 'T_PLUS' or 'T_EOF'
     */
    public $type;

    /**
     * token value: 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, '+' or null
     */
    public $value;

    public function __construct($type, $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * String representation of the class instance.
     * Examples:
     *     Token(T_INTEGER, 3)
     *     Token(T_PLUS, '+')
     */
    public function __toString()
    {
        return sprintf(
            'Token(%s, %s)',
            $this->type,
            var_export($this->value, true)
        );
    }
}

class Interpreter {
    /**
     * client string input, e.g. "3+5"
     */
    private $text;

    /**
     * $this->pos is a index into $this->text
     */
    private $pos = 0;

    /**
     * current token instance
     */
    private $current_token = null;

    public function __construct($text)
    {
        $this->text = $text;
    }

    /**
     * expr -> T_INTEGER T_PLUS T_INTEGER
     */
    public function expr()
    {
        # set current token to the first token taken from the input
        $this->current_token = $this->get_next_token();

        # we expect the current token to be a single-digit integer
        $left = $this->current_token;
        $this->eat([T_INTEGER]);

        # we expect the current token to be a '+' token
        $op = $this->current_token;
        $this->eat([T_PLUS, T_MINUS]);

        # we expect the current token to be a single-digit integer
        $right = $this->current_token;
        $this->eat([T_INTEGER]);
        # after the above call the $this->current is set to
        # T_EOF token

        # at this point T_INTEGER T_PLUS|T_MINUS T_INTEGER sequence of tokens
        # has been successfully found and the method can just
        # return the result of adding two integers, thus
        # effectively interpreting client input
        switch ($op->type)
        {
        case T_PLUS:
            $result = $left->value + $right->value;
            break;
        case T_MINUS:
            $result = $left->value - $right->value;
            break;
        }

        return $result;
    }

    /**
     * Lexical analyzer (also known as scanner or tokenizer)
     *
     * This method is responsible for breaking a sentence
     * apart into tokens. One token at a time.
     */
    private function get_next_token()
    {
        $text = $this->text;

        # is $this->pos index past the end of the $this->text?
        # if so, then return T_EOF token because there is no more
        # input left to convert into tokens
        if ($this->pos > strlen($text) - 1)
        {
            return new Token(T_EOF, null);
        }

        # get a character at the position $this->pos and decide
        # what token to create based on the single character
        $current_char = $text[$this->pos];

        # if the character is a digit the convert it to
        # integer, create a T_INTEGER token, increment $this->pos
        # index to point to the next character after the digit,
        # and return the T_INTEGER token

        if (ctype_digit($current_char))
        {
            $value = '';
            do {
                $current_char = $text[$this->pos];
                $value .= $current_char;
                $this->pos += 1;
            } while ($this->pos < strlen($text) && ctype_digit($text[$this->pos]));

            return new Token(T_INTEGER, intval($value));
        }

        if ($current_char === '+')
        {
            $token = new Token(T_PLUS, $current_char);
            $this->pos += 1;
            return $token;
        }

        if ($current_char === '-')
        {
            $token = new Token(T_MINUS, $current_char);
            $this->pos += 1;
            return $token;
        }

        if ($current_char === ' ')
        {
            $this->pos += 1;
            return $this->get_next_token();
        }

        $this->error();
    }

    private function eat(array $token_types)
    {
        # compare the current token type with the passed token
        # type and if they match then "eat" the current token
        # and assign the next token to the $this->current_token,
        # otherwise raise an exception.
        if (in_array($this->current_token->type, $token_types))
        {
            $this->current_token = $this->get_next_token();
        }
        else
        {
            $this->error();
        }
    }

    private function error()
    {
        throw new Exception('Error parsing input');
    }
}

function main()
{
    while (true)
    {
        $text = readline('calc> ');

        if (empty($text))
        {
            break;
        }

        $interpreter = new Interpreter($text);
        echo $interpreter->expr(), "\n";
    }
}

if (realpath($argv[0]) === __FILE__)
{
    main();
}
