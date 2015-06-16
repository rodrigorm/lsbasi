<?php
require_once __DIR__ . '/../twest.php';
require_once __DIR__ . '/calc1.php';

it('represent a integer token as string', (string)(new Token(T_INTEGER, 3)) === 'Token(T_INTEGER, 3)');
it('represent a plus token as string', (string)(new Token(T_PLUS, '+')) === "Token(T_PLUS, '+')");
it('return integer token type', (new Token(T_INTEGER, 3))->type === T_INTEGER);
it('return integer token value', (new Token(T_INTEGER, 3))->value === 3);
it('return plus token value', (new Token(T_PLUS, '+'))->value === '+');
it('intepret 3+4', (new Interpreter('3+4'))->expr() === 7);
it('intepret 3+5', (new Interpreter('3+5'))->expr() === 8);
it('intepret 3+9', (new Interpreter('3+9'))->expr() === 12);
