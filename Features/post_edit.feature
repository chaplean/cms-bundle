Feature: Edit posts

  Background:
    Given I load default datafixture with "Chaplean\Bundle\CmsBundle\"
    Given I load database

  Scenario: I can see fields
    Given I am on "/administration/post/1"
    Then I should see a "#chaplean_cms_post_form_page_metaDescription" element
    Then I should see a "#chaplean_cms_post_form_page_title" element
    Then I should see a "#chaplean_cms_post_form_page_subtitle" element
    Then I should see a "#chaplean_cms_post_form_publication_status" element
    Then I should see a "#chaplean_cms_post_form_publication_datePublicationBegin" element
    Then I should see a "#chaplean_cms_post_form_publication_datePublicationEnd" element
    Then I should see a "#chaplean_cms_post_form_page_content" element
    Then I should see a ".save" element
    Then I should see a ".save-and-quit" element
    Then I should see a ".cancel" element

  Scenario: I can save a post
    Given I am on "/administration/post/1"
    When I fill in "chaplean_cms_post_form_page_title" with "post-update-1"
    When I click on ".save"
    When I wait Ajax
    Then I should see "Article mis à jour"

  Scenario: I see update post
    Given I am on "/administration/post/1"
    Then I should see "post-update-1" in input "#chaplean_cms_post_form_page_title"

  Scenario: I cancel edit
    Given I am on "/administration/post/1"
    When I fill in "chaplean_cms_post_form_page_title" with "post-1"
    When I click on ".cancel"
    When I click on ".modal-footer .btn.btn-primary"
    Then I should be on "/administration/posts"

  Scenario: I change publication
    Given I am on "/administration/post/1"
    When I select "2" from "chaplean_cms_post_form_publication_status"
    When I click on ".save"
    When I am on "/administration/post/1"
    Then the "2" option from "chaplean_cms_post_form_publication_status" is selected

  Scenario: Save and quit
    Given I am on "/administration/post/1"
    When I click on ".save-and-quit"
    Then I am on "/administration/posts"