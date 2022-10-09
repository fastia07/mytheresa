<?php

class HolidayRequestEntityTest extends \Codeception\Test\Unit
{
    public function testHolidayRequestAttributesAssert()
    {
        $holidayRequest = new \App\Entity\HolidayRequest();

        $holidayRequest->setStatus('pending');
        $this->assertEquals('pending', $holidayRequest->getStatus(), 'Status is not same');

        $holidayRequest->setVacationEndDate(new DateTime("2022-10-10 18:15:56"));
        $this->assertEquals(new DateTime("2022-10-10 18:15:56"), $holidayRequest->getVacationEndDate(), 'End Date is not same');

        $holidayRequest->setVacationStartDate(new DateTime("2022-10-12 18:15:56"));
        $this->assertEquals(new DateTime("2022-10-12 18:15:56"), $holidayRequest->getVacationStartDate(), 'Start Date is not same');
    }
}