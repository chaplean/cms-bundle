Feature: List pages

  Background:
    Given I load default datafixture with "Chaplean\Bundle\CmsBundle\"
    Given I am on "/administration/posts"

  Scenario: I see list pages
    Then I should see 10 "#posts-list tbody tr" elements

  Scenario: I can click on page
    And I fill in "filter-post" with "page-video-1"
#    And I click on "table tbody tr:nth-child(5) td:nth-child(2) a"
    And I click on "table tbody tr td a"
    Then I should be on "/administration/post/12"