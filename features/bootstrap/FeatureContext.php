<?php

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Laracasts\Behat\Context\Migrator;
use PHPUnit_Framework_Assert as PHPunit;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends MinkContext implements Context
{
    use Migrator;

    protected $name;
    protected $email;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @When I register :name :email
     */
    public function iRegister($name, $email)
    {
        $this->name = $name;
        $this->email = $email;
        $this->visit('register');

        $this->fillField('name', $name);
        $this->fillField('email', $email);
        $this->fillField('password', 'password');
        $this->fillField('password-confirm', 'password');

        $this->pressButton('Register');
    }

    /**
     * @Then I should have an account
     */
    public function iShouldHaveAnAccount()
    {
        $this->assertSignedIn();
    }

    /**
     * @Given I have an account :name :email
     */
    public function iHaveAnAccount($name, $email)
    {
        $this->iRegister($name, $email);

        $this->visit('/logout');
    }

    /**
     * @When I sign in
     */
    public function iSignIn()
    {
        $this->visit('/login');

        $this->fillField('email', $this->email);
        $this->fillField('password', 'password');

        $this->pressButton('Login');
    }

    /**
     * @When I sign in with invalid credentials
     */
    public function iSignInWithInvalidCredentials()
    {
        $this->email = 'invalid@email';

        $this->iSignIn();
    }

    /**
     * @Then I should be signed in
     */
    public function iShouldBeSignedIn()
    {
        $this->assertSignedIn();
    }

    /**
     * @Then I should not be logged in
     */
    public function iShouldNotBeLoggedIn()
    {
        PHPUnit::assertTrue(\Auth::guest());

        $this->assertPageAddress('login');
    }

    private function assertSignedIn()
    {
        PHPUnit::assertTrue(\Auth::check());

        $this->assertPageAddress('/');
    }
}
