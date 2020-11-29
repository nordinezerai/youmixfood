<?php

namespace NZ\PlatformBundle\DQL;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
/**
 * StringFunction ::= "FIND_SET_EQUALS" "(" StringPrimary "," StringPrimary ")"
 */
class FindSetEquals extends FunctionNode
{
    // (1)
    public $firstStringExpression = null;
    public $secondStringExpression = null;

    public function parse(\Doctrine\ORM\Query\Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER); // (2)
        $parser->match(Lexer::T_OPEN_PARENTHESIS); // (3)
        $this->firstStringExpression = $parser->StringPrimary(); // (4)
        $parser->match(Lexer::T_COMMA); // (5)
        $this->secondStringExpression = $parser->StringPrimary(); // (6)
        $parser->match(Lexer::T_CLOSE_PARENTHESIS); // (3)
    }

    public function getSql(\Doctrine\ORM\Query\SqlWalker $sqlWalker)
    {
        return 'FIND_SET_EQUALS(' .
            $this->firstStringExpression->dispatch($sqlWalker) . ', ' .
            $this->secondStringExpression->dispatch($sqlWalker) .
        ')'; // (7)
    }
}