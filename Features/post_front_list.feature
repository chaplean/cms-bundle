Feature: List posts front

  Background:
    Given I load default datafixture with "Chaplean\Bundle\CmsBundle\"
    Given I am on "/posts"

  Scenario: I can see list
    Then I should see 2 "article.block-content-info" elements