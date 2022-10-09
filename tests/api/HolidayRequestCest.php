<?php

use Codeception\Util\HttpCode;

/**
 * This class is to test the major API end point with the test data resides in tests/_data/test.sql
 */
class HolidayRequestCest
{
    // Create Holiday requests.
    public function createCreateHolidayRequestViaAPI(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/workers/holiday_requests', json_encode([
            'author' => 1, //this is author id taking from test data
            'vacationStartDate' => '2022-10-10 18:15:56',
            'vacationEndDate' => '2022-10-13 18:15:56'
        ]));

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK); // 200

    }

    // Create Holiday requests with insufficient leave balance
    public function createCreateHolidayRequestWithInsufficientLeaveBalanceViaAPI(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/workers/holiday_requests', json_encode([
            'author' => 11, //author id taking from test data
            'vacationStartDate' => '2022-10-10 18:15:56',
            'vacationEndDate' => '2022-10-13 18:15:56'
        ]));

        $I->seeResponseCodeIs(HttpCode::FORBIDDEN); // 403
    }

    // Check by worker about the remaining leaves
    public function checkHolidayRemainingBalanceViaApi(ApiTester $I)
    {
        $I->sendGet('/workers/1/remaning_leaves');
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseIsJson();
        $I->seeResponseMatchesJsonType([
            'result' => 'integer',
        ]);
    }

    // search by workers about the holiday request they created.
    public function searchHolidayRequestsStatusPendingByWorkerViaApi(ApiTester $I)
    {
        $I->sendGet('/workers/1/holiday_requests?status=pending');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK); // 200
    }

    // search by workers about the holiday request they created.
    public function searchHolidayRequestsStatusRejectedByWorkerViaApi(ApiTester $I)
    {
        $I->sendGet('/workers/1/holiday_requests?status=rejected');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK); // 200
    }

    // search by workers about the holiday request they created.
    public function searchHolidayRequestsStatusApprovedByWorkerViaApi(ApiTester $I)
    {
        $I->sendGet('/workers/1/holiday_requests?status=approved');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK); // 200
    }

    // search by workers about the holiday request they created.
    public function searchWorkerByWorkerId(ApiTester $I)
    {
        $I->sendGet('/managers/search_workers?id=1');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK); // 200
    }

    // search by workers about the holiday request they created.
    public function searchHolidayRequestsByStatusPendingByManager(ApiTester $I)
    {
        $I->sendGet('/managers/worker_holiday_requests?status=pending');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK); // 200
    }

    // search by workers about the holiday request they created.
    public function searchHolidayRequestsByStatusRejectedByManager(ApiTester $I)
    {
        $I->sendGet('/managers/worker_holiday_requests?status=rejected');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK); // 200
    }

    // search by workers about the holiday request they created.
    public function searchHolidayRequestsByStatusApproveByManager(ApiTester $I)
    {
        $I->sendGet('/managers/worker_holiday_requests?status=approved');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK); // 200
    }

    // search by worker overlap holiday by date range
    public function searchOverlapHolidayRequestsByDateRangeByManager(ApiTester $I)
    {
        $I->sendGet('/managers/worker_overlap_requests?startDate=2022-10-24&endDate=2022-11-03');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK); // 200
    }

    // search by worker overlap holiday by date range
    public function approveHolidayRequestByManagerViaAPI(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/managers/update_holiday_requests', json_encode([
            'holidayRequestId' => 2, //this is author id taking from test data
            'managerId' => 2,
            'status' => 'approved'
        ]));

        // it can match tree-like structures as well
        $I->seeResponseContainsJson([
            'resolvedBy' => [
                'name' => 'Mrs. Mollie Feeney DVM',
            ],
            'status' => 'approved'
        ]);
    }

    // search by worker overlap holiday by date range
    public function rejectHolidayRequestByManagerViaAPI(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/managers/update_holiday_requests', json_encode([
            'holidayRequestId' => 2, //this is author id taking from test data
            'managerId' => 2,
            'status' => 'rejected'
        ]));

        // it can match tree-like structures as well
        $I->seeResponseContainsJson([
            'resolvedBy' => [
                'name' => 'Mrs. Mollie Feeney DVM',
            ],
            'status' => 'rejected'
        ]);
    }


}
