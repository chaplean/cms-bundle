Feature: Create page

  Background:
    Given I load default datafixture with "Chaplean\Bundle\CmsBundle\"

  Scenario: I can click to add page
    Given I am on "/administration/pages"
    When I click on ".dropdown.sonata-actions a"
    When I click on ".dropdown-menu a"
    Then I should be on "/administration/page"

  Scenario: I can see fields
    Given I am on "/administration/page"
    When I wait Ajax
    When I wait 10000 millisec
    When I fill in "chaplea_cms_page_route_form_path" with "/super/path/sp"
    When I fill in "chaplea_cms_page_route_form_menuName" with "super-menu"
    When I fill in "chaplea_cms_page_route_form_rollover" with "supmeny"
    When I fill in "chaplea_cms_page_route_form_page_metaDescription" with "This is super menu"
    When I fill in "chaplea_cms_page_route_form_page_title" with "Super Menu"
    When I select "1" from "chaplea_cms_page_route_form_publication_status"
#    When I fill in "chaplea_cms_page_route_form_publication_datePublicationBegin" with "10/11/2015"
#    When I fill in "chaplea_cms_page_route_form_publication_datePublicationEnd" with "20/11/2015"
#    When I fill in "chaplea_cms_page_route_form_page_content" with "This is a super content of super menu"
    When I click on ".save"
    When I wait 10000 millisec
    Then I should see "Page créée"
#
#  Scenario: I see my new page
#    Given I am on "/administration/pages"
#    When I wait Ajax
#    When I fill in "filter-page" with "super"
#    Then I should see 1 "#pages-list tbody tr" element
