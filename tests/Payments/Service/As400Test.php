<?php

class Payments_Service_As400Test extends \PHPUnit\Framework\TestCase
{
    public function testProcessingBankPayments()
    {
$contact = $this->getMockBuilder(Contact_Model_Contact::class)
    ->setMethods(['getContactId', 'getName'])
    ->getMock();

$contact->expects($this->any())
    ->method('getContactId')
    ->will($this->returnValue(1));

$contact->expects($this->any())
    ->method('getName')
    ->will($this->returnValue('Foo Bar'));

$contactMapper = $this->getMockBuilder(Contact_Model_Mapper_Contact::class)
    ->setMethods(['findContactByBankAccount'])
    ->getMock();

$contactMapper->expects($this->any())
    ->method('findContactByBankAccount')
    ->will($this->returnValue($contact));

$paymentsMapper = $this->getMockBuilder(Invoice_Model_Mapper_Payments::class)
    ->setMethods(['updatePayment'])
    ->getMock();

$logMock = new Zend_Log_Writer_Mock();
$logger = new Zend_Log();
$logger->setWriter($logMock);
$logger->setPriority(Zend_Log::DEBUG);

$as400 = new Payments_Service_As400();
$as400->addMapper($contactMapper, Contact_Model_Mapper_Contact::class)
    ->addMapper($paymentsMapper, Invoice_Model_Mapper_Payments::class)
    ->setPath(__DIR__ . DIRECTORY_SEPARATOR . '_files')
    ->setLogger($logger);

$as400->processBankPayments();
$this->assertCount(3, $logMock->events);
$this->assertEquals('Processing 401341345', $logMock->events[1]);
$this->assertEquals(
    'Found contact "Foo Bar" for bank account BE93522511513933',
    $logMock->events[2]
);
}
}