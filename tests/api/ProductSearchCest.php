<?php
use Codeception\Util\HttpCode;

/**
 * This class is to test the major API end point with the test data resides in tests/_data/test.sql
 */
class ProductSearchCest
{
    // search by workers about the holiday request they created.
    public function searchProductWithoutCategoryFilter(ApiTester $I)
    {
        $I->sendGet('/products');
        $I->seeResponseCodeIs(HttpCode::NOT_ACCEPTABLE); // 406
    }

    // search by workers about the holiday request they created.
    public function searchProductByCategory(ApiTester $I)
    {
        $I->sendGet('/products?category=boots');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseContainsJson([
            'category' => 'boots',
        ]);
    }

    // search by workers about the holiday request they created.
    public function searchProductByWrongCategory(ApiTester $I)
    {
        $I->sendGet('/products?category=boots123');
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND); // 404
    }

    // search by workers about the holiday request they created.
    public function searchProductWithCorrectPrice(ApiTester $I)
    {
        $I->sendGet('/products?category=boots&price=50000');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK); // 200
    }

    // search by workers about the holiday request they created.
    public function searchProductWithWrongPrice(ApiTester $I)
    {
        $I->sendGet('/products?category=boots&price=1');
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND); // 404
    }

    // search by workers about the holiday request they created.
    public function searchProductWithDiscountedCategory(ApiTester $I)
    {
        $I->sendGet('/products?category=boots');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseContainsJson([
            'discount_percentage' => '30%',
        ]);
    }

    // search by workers about the holiday request they created.
    public function searchProductWithNoDiscountedCategory(ApiTester $I)
    {
        $I->sendGet('/products?category=women');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK); // 200
        $I->seeResponseContainsJson([
            'discount_percentage' => null,
        ]);
    }

}
