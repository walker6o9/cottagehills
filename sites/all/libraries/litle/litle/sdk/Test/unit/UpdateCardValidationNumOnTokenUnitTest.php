<?php
/*
 * Copyright (c) 2011 Litle & Co.
 *
 * Permission is hereby granted, free of charge, to any person
 * obtaining a copy of this software and associated documentation
 * files (the "Software"), to deal in the Software without
 * restriction, including without limitation the rights to use,
 * copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following
 * conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
 * OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
 * OTHER DEALINGS IN THE SOFTWARE.
 */
namespace litle\sdk\Test\unit;

use litle\sdk\LitleOnlineRequest;

class UpdateCardValidationNumOnTokenUnitTest extends \PHPUnit_Framework_TestCase
{
    public function test_simple()
    {
        $hash_in = array(
            'orderId' => '1',
            'litleToken' => '123456789101112',
            'cardValidationNum' => '123');
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
            ->method('request')
            ->with($this->matchesRegularExpression('/.*<orderId>1.*<litleToken>123456789101112.*<cardValidationNum>123.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->updateCardValidationNumOnToken($hash_in);
    }

    public function test_orderIdIsOptional()
    {
        $hash_in = array(
            'litleToken' => '123456789101112',
            'cardValidationNum' => '123');
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
            ->method('request')
            ->with($this->matchesRegularExpression('/.*<litleToken>123456789101112.*<cardValidationNum>123.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->updateCardValidationNumOnToken($hash_in);
    }

    public function test_litleTokenIsRequired()
    {
        $hash_in = array(
            'cardValidationNum' => '123');
        $litleTest = new LitleOnlineRequest();
        $this->setExpectedException('InvalidArgumentException', "Missing Required Field: /litleToken/");
        $retOb = $litleTest->updateCardValidationNumOnToken($hash_in);
    }

    public function test_cardValidationNumIsRequired()
    {
        $hash_in = array(
            'litleToken' => '123456789101112');
        $litleTest = new LitleOnlineRequest();
        $this->setExpectedException('InvalidArgumentException', "Missing Required Field: /cardValidationNum/");
        $retOb = $litleTest->updateCardValidationNumOnToken($hash_in);
    }

    public function test_loggedInUser()
    {
        $hash_in = array(
            'loggedInUser' => 'gdake',
            'merchantSdk' => 'PHP;8.14.0',
            'orderId' => '1',
            'litleToken' => '123456789101112',
            'cardValidationNum' => '123');
        $mock = $this->getMock('litle\sdk\LitleXmlMapper');
        $mock->expects($this->once())
            ->method('request')
            ->with($this->matchesRegularExpression('/.*merchantSdk="PHP;8.14.0".*loggedInUser="gdake" xmlns=.*>.*/'));

        $litleTest = new LitleOnlineRequest();
        $litleTest->newXML = $mock;
        $litleTest->updateCardValidationNumOnToken($hash_in);
    }

}
