Feature: Membership
  Who
  What
  Why

  Scenario: Registration
    When I register "dallin" "dallinis@hotmail.com"
    Then I should have an account

  Scenario: Authentication
    Given I have an account "dallin" "dallinis@hotmail.com"
    When I sign in
    Then I should be signed in

  Scenario: Failed Authentication
    When I sign in with invalid credentials
    Then I should not be logged in