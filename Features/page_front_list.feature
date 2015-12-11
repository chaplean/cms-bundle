Feature: List pages front

  Background:
    Given I load default datafixture with "Chaplean\Bundle\CmsBundle\"
    Given I load database
    Given I am on "/pages"

  Scenario: I can see list
    Then I should see 10 ".page" elements

