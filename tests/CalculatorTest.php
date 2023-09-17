<?php

namespace CalculatorViaMagicMethod\Tests;

use CalculatorViaMagicMethod\Calculator;

class CalculatorTest extends ExtendedTestCase
{
    private Calculator $calculator;

    public function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    /** @test */
    public function it_can_throw_an_exception_when_a_wrong_method_name()
    {
        $this->expectException(\BadMethodCallException::class);
        $this->expectExceptionMessageMatches('/^Method .+ was not found. Check/');

        $this->calculator->wrong();
    }

    /** @test */
    public function it_can_throw_an_exception_when_no_arguments_are_provided()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('at least');

        $this->calculator->add();
    }

    public function testFindOperationReturnExpected()
    {
        $method = $this->getPrivateMethod($this->calculator, 'findOperation');

        $this->assertEquals('Addition', $method->invokeArgs($this->calculator, ['add']));
        $this->assertEquals('Addition', $method->invokeArgs($this->calculator, ['addition']));
    }

    public function testResultReturnInitial()
    {
        $initial = 0;

        $this->assertSame($initial, (new Calculator())->result());
    }

    public function testAdditionReturnExpectedWhenEmptyState()
    {
        $this->calculator->add(22);

        $this->assertSame(22, $this->calculator->result());
    }

    public function testResetReturnExpected()
    {
        $this->calculator->add(22);

        $this->assertSame(22, $this->calculator->result());

        $this->calculator->reset();

        $this->assertSame(0, $this->calculator->result());
    }

    /**
     * @dataProvider provideDataConvertZeroTrailingToInteger
     */
    public function testConvertZeroTrailingToIntegerReturnExpected($expected, $value)
    {
        $method = $this->getPrivateMethod($this->calculator, 'convertZeroTrailingToInteger');

        $this->assertSame($expected, $method->invokeArgs($this->calculator, [$value]));
    }

    public function provideDataConvertZeroTrailingToInteger()
    {
        return [
            'Zero is untouched' => [0, 0],
            'Int is untouched' => [22, 22],
            'Trailing .0 to int' => [32, 32.0],
            'Trailing .something_and_0 to float' => [28.33, 28.330],
        ];
    }
}
