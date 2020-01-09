<?php

namespace App\Tests;

use App\Tests\AcceptanceTester;

class UserCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function trySuccessLogin(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('email', 'j.mons54@gmail.com');
        $I->fillField('password', 'alaji');
        $I->click('Se connecter');
        $I->see('Vous êtes connecté en tant que j.mons54@gmail.com');
        $I->makeHtmlSnapshot();
    }

    public function tryEmailNotFound(AcceptanceTester $I)
    {
        $I->amOnPage('/login');
        $I->fillField('email', 'faux@gmail.com');
        $I->fillField('password', 'ssss');
        $I->click('Se connecter');
        $I->see('Cette adresse email n\'existe pas.');
    }
}
