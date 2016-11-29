Feature: testing
  In order to see if this works
  As a developer
  I want to figure out how to use Behat

  Scenario: Home Page
    Given I am on the homepage
    Then the url should match "/"
    And I can do something with Laravel