Feature: List pages

  Background:
    Given I load default datafixture with "Chaplean\Bundle\CmsBundle\"
    Given I am on "/administration/pages"

  Scenario: I see list pages
    When I wait for Angular
    Then I should see 10 "#pages-list tbody tr" elements

  Scenario: I can click on page
    When I wait for Angular
    And I fill in "filter-page" with "page-1-"
    And I click on "table tbody tr td a"
    Then I should be on "/administration/page/1"