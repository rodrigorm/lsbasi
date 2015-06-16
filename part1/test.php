<?php
require_once __DIR__ . '/../twest.php';
require_once __DIR__ . '/calc1.php';

it('represent a integer token as string', (string)(new Token(T_INTEGER, 3)) === 'Token(T_INTEGER, 3)');
it('represent a plus token as string', (string)(new Token(T_PLUS, '+')) === "Token(T_PLUS, '+')");
it('return integer token type', (new Token(T_INTEGER, 3))->type === T_INTEGER);
it('return integer token value', (new Token(T_INTEGER, 3))->value === 3);
it('return plus token value', (new Token(T_PLUS, '+'))->value === '+');
it('interpret 3+4', (new Interpreter('3+4'))->expr() === 7);
it('interpret 3+5', (new Interpreter('3+5'))->expr() === 8);
it('interpret 3+9', (new Interpreter('3+9'))->expr() === 12);
it('interpret 12+3', (new Interpreter('12+3'))->expr() === 15);
it('interpret 3+10', (new Interpreter('3+10'))->expr() === 13);
it('interpret 12 + 3', (new Interpreter('12 + 3'))->expr() === 15);
it('interpret 12  + 3', (new Interpreter('12  + 3'))->expr() === 15);
it('interpret 3-4', (new Interpreter('3-4'))->expr() === -1);
it('interpret 3-5', (new Interpreter('3-5'))->expr() === -2);
it('interpret 3-9', (new Interpreter('3-9'))->expr() === -6);
it('interpret 12-3', (new Interpreter('12-3'))->expr() === 9);
it('interpret 3-10', (new Interpreter('3-10'))->expr() === -7);
it('interpret 12 - 3', (new Interpreter('12 - 3'))->expr() === 9);
it('interpret 12  - 3', (new Interpreter('12  - 3'))->expr() === 9);
