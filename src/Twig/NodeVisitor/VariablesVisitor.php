<?php

namespace Mailery\Template\Twig\NodeVisitor;

use Twig\NodeVisitor\NodeVisitorInterface;
use Twig\Node\Node;
use Twig\Node\PrintNode;
use Twig\Node\CheckToStringNode;
use Twig\Environment;
use Twig\Node\Expression\NameExpression;
use Twig\Node\Expression\FilterExpression;
use Twig\Node\Expression\FunctionExpression;
use Twig\Node\Expression\GetAttrExpression;

class VariablesVisitor implements NodeVisitorInterface
{

    /**
     * @var array
     */
    private array $variables = [];

    /**
     * @return array
     */
    public function getVariables(): array
    {
        return $this->variables;
    }

    /**
     * @inheritdoc
     */
    public function leaveNode(Node $node, Environment $env): ?Node
    {
        return $node;
    }

    /**
     * @inheritdoc
     */
    public function getPriority(): int
    {
        return 0;
    }

    /**
     * @inheritdoc
     */
    public function enterNode(Node $node, Environment $env): Node
    {
        if (!$node->hasNode('body')) {
            return $node;
        }

        $bodyNodes = iterator_to_array($node->getNode('body')->getNode('0')->getIterator());

        $this->variables = array_unique(
            array_merge (
                $this->variables,
                array_reduce(
                    $bodyNodes,
                    function (array $carrier, Node $node) {
                        if ($node instanceof PrintNode) {
                            $carrier = array_merge($carrier, $this->handleNode($node));
                        }

                        return $carrier;
                    },
                    []
                )
            )
        );

        return $node;
    }

    /**
     * @param PrintNode $node
     * @return array
     */
    private function handleNode(PrintNode $node): array
    {
        $expression = $node->getNode('expr')->getNode('node');
        if ($expression instanceof CheckToStringNode) {
            $expression  = $expression->getNode('expr');
        }

        if ($expression instanceof NameExpression) {
            return [$this->handleNameExpression($expression)];
        }
        if ($expression instanceof FilterExpression) {
            return [$this->handleFilterExpression($expression)];
        }
        if ($expression instanceof FunctionExpression) {
            return $this->handleFunctionExpression($expression);
        }
        if ($expression instanceof GetAttrExpression) {
            return [$this->handleAttributeExpression($expression)];
        }
    }

    /**
     * @param NameExpression $expressionNode
     * @return string
     */
    private function handleNameExpression(NameExpression $expressionNode): string
    {
        return $expressionNode->getAttribute('name');
    }

    /**
     * @param FilterExpression $expressionNode
     * @return string
     */
    private function handleFilterExpression(FilterExpression $expressionNode): string
    {
        $expression = $expressionNode->getNode('node');
        if ($expression instanceof CheckToStringNode) {
            $expression  = $expression->getNode('expr');
        }

        if ($expression instanceof GetAttrExpression) {
            return $this->handleAttributeExpression($expression);
        }

        return $expression->getAttribute('name');
    }

    /**
     * @param FunctionExpression $expressionNode
     * @return array
     */
    private function handleFunctionExpression(FunctionExpression $expressionNode): array
    {
        $arguments = iterator_to_array($expressionNode->getNode('arguments')->getIterator());
        $variables = [];
        foreach ($arguments as $argument) {
            if ($argument instanceof NameExpression) {
                $variables[] = $this->handleNameExpression($argument);
            }
            if ($argument instanceof FilterExpression) {
                $variables[] = $this->handleFilterExpression($argument);
            }
            if ($argument instanceof FunctionExpression) {
                $variables = array_merge($variables, $this->handleFunctionExpression($argument));
            }
            if ($argument instanceof GetAttrExpression) {
                $variables[] = $this->handleAttributeExpression($argument);
            }
        }

        return $variables;
    }

    /**
     * @param GetAttrExpression $expressionNode
     * @return string
     */
    private function handleAttributeExpression(GetAttrExpression $expressionNode): string
    {
        $prefix = null;

        if (($expression = $expressionNode->getNode('node')) instanceof GetAttrExpression) {
            return implode(
                '.',
                [
                    $this->handleAttributeExpression($expression),
                    $expressionNode->getNode('attribute')->getAttribute('value')
                ]
            );
        }

        return implode(
            '.',
            array_filter([
                $prefix,
                $expressionNode->getNode('node')->getAttribute('name'),
                $expressionNode->getNode('attribute')->getAttribute('value')
            ])
        );
    }

}
