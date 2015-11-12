Feature: Edit pages

  Background:
    Given I load default datafixture with "Chaplean\Bundle\CmsBundle\"

  Scenario: I can see field
    Given I am on "/administration/page/1"
    When I wait Ajax
    Then I should see a "#cms_page_title" element
    And I should see a "#cms_page_subtitle" element
    And I should see a "#cms_page_path" element
    And I should see a "#cms_page_menuName" element
    And I should see a "#cms_page_rollover" element
    And I should see a "#cms_page_metaDescription" element
    And I should see a "text-angular" element
    And I should see a ".save" element
    And I should see a ".save-and-quit" element
    And I should see a ".cancel" element

  Scenario: I