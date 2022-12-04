<?php

declare(strict_types=1);

namespace Mailery\Template\Tests\Twig\NodeVisitor;

use Mailery\Template\Twig\NodeVisitor\TemplateVariablesVisitor;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;

class TemplateVariablesVisitorTest extends TestCase
{

    /**
     * @var Environment
     */
    private Environment $twig;

    /**
     * @var TemplateVariablesVisitor
     */
    private TemplateVariablesVisitor $visitor;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->twig = new Environment(
            new ArrayLoader(),
            [
                'charset' => 'utf-8',
            ]
        );

        $this->visitor = new TemplateVariablesVisitor();

        $this->twig->addNodeVisitor($this->visitor);
    }

    /**
     * @return void
     */
    public function testCollectVariables(): void
    {
        $actual = [];

        $this->twig->createTemplate('simple variable {{ variable1 }}');
        $actual[] = 'variable1';
        $this->assertEquals($this->visitor->getVariables(), $actual);

        $this->twig->createTemplate('simple variable {{ variable1.level1 }}');
        $actual[] = 'variable1.level1';
        $this->assertEquals($this->visitor->getVariables(), $actual);

        $this->twig->createTemplate('simple variable {{ variable1.level1.level2 }}');
        $actual[] = 'variable1.level1.level2';
        $this->assertEquals($this->visitor->getVariables(), $actual);
    }

    /**
     * @return void
     */
    public function testCollectVariablesWithFilter(): void
    {
        $actual = [];

        $this->twig->createTemplate('simple variable {{ variable2|upper }}');
        $actual[] = 'variable2';
        $this->assertEquals($this->visitor->getVariables(), $actual);

        $this->twig->createTemplate('simple variable {{ variable2.level1|upper }}');
        $actual[] = 'variable2.level1';
        $this->assertEquals($this->visitor->getVariables(), $actual);

        $this->twig->createTemplate('simple variable {{ variable2.level1.level2|upper }}');
        $actual[] = 'variable2.level1.level2';
        $this->assertEquals($this->visitor->getVariables(), $actual);
    }

    /**
     * @group function
     * @return void
     */
    public function testCollectVariablesWithFunction(): void
    {
        $actual = [];

        $this->twig->createTemplate('simple variable {{ min(variable3) }}');
        $actual[] = 'variable3';
        $this->assertEquals($this->visitor->getVariables(), $actual);

        $this->twig->createTemplate('simple variable {{ min(variable3.level1) }}');
        $actual[] = 'variable3.level1';
        $this->assertEquals($this->visitor->getVariables(), $actual);

        $this->twig->createTemplate('simple variable {{ min(variable3.level1.level2) }}');
        $actual[] = 'variable3.level1.level2';
        $this->assertEquals($this->visitor->getVariables(), $actual);
    }

    /**
     * @return void
     */
    public function testCollectMixedVariables(): void
    {
        $this->twig->createTemplate(<<<TWIG
simple variable {{ variable1 }}
multiline {{ variable2 }}
nested variable {{ variable2.level1 }}

filters {{ variable3|upper }}
filters {{ variable3.level1|upper }}
functions {{ max(variable4, variable5|upper, min(variable6), variable7.level1) }}
TWIG
        );

        $this->assertEquals(
            $this->visitor->getVariables(),
            [
                0 => 'variable1',
                1 => 'variable2',
                2 => 'variable2.level1',
                3 => 'variable3',
                4 => 'variable3.level1',
                5 => 'variable4',
                6 => 'variable5',
                7 => 'variable6',
                8 => 'variable7.level1',
            ]
        );
    }

}
