Feature: Create page

  Background:
    Given I load default datafixture with "Chaplean\Bundle\CmsBundle\"

  Scenario: I can click to add page
    Given I am on "/administration/posts"
    When I click on ".dropdown.sonata-actions a"
    When I click on ".dropdown-menu a"
    Then I should be on "/administration/post"

  Scenario: I can see fields
    Given I am on "/administration/post"
    When I wait Ajax
    When I select "news" from "chaplean_cms_post_form_category"
    When I fill in "chaplean_cms_post_form_page_metaDescription" with "This is super menu"
    When I fill in "chaplean_cms_post_form_page_title" with "Super Menu"
    When I select "1" from "chaplean_cms_post_form_publication_status"
    When I click on "#chaplean_cms_post_form_publication_isHighlighted_1"
#    When I fill in "chaplean_cms_page_route_form_publication_datePublicationBegin" with "10/11/2015"
#    When I fill in "chaplean_cms_page_route_form_publication_datePublicationEnd" with "20/11/2015"
#    When I fill in "chaplean_cms_page_route_form_page_content" with "This is a super content of super menu"
    When I click on ".save"
    Then I should see "Article créé"