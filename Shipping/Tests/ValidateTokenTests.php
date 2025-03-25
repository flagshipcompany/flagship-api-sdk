<?php

use \PHPUnit\Framework\TestCase;
use Flagship\Shipping\Requests\ValidateTokenRequest;

class ValidateTokenTests extends TestCase{

    private $validateTokenRequest;

    public function testExecute(){
        $this->assertNotNull($this->validateTokenRequest->execute());
        $this->assertSame(0,$this->validateTokenRequest->execute());
    }

    protected function setUp() : void {
        $this->validateTokenRequest = $this->getMockBuilder(ValidateTokenRequest::class)
                                        ->setConstructorArgs(['localhost','testToken','testing','1.0.11'])
                                        ->onlyMethods(['execute'])
                                        ->getMock();
    }
}