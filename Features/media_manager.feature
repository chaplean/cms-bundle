Feature: Media Manager

  Background:
    Given I load default datafixture with "Chaplean\Bundle\CmsBundle\"
    Given I am on "/administration/page/1"
    When I wait Ajax
    When I click on ".open-media-manager"

  Scenario: I can add a media
    Then I should see a visible "#media-manager" element
    # TODO: How to upload a file in behat ?
    # Then I should see a visible ".media-element.active" element
    Then the media should be uploaded

  Scenario: I can select a file and include it
    When I click on ".media-element"
    Then I should see a visible ".media-element.active" element
    Then I should see 9 visibles ".media-element" elements
    Then I should see a visible ".pagination" element
    Then I should see a visible ".media-element.active" element
    Then I should see "png_1" in the ".media-details" element
    When I click on "#insert"
    Then I should not see a visible "#media-manager" element
    Then the media should be inserted in the wysiwyg editor

  Scenario: I can search for a media by name
    When I fill in "media-search" with "1"
    Then I should see 2 visibles ".media-element" elements
    Then I should see "png_1"
    Then I should see "pdf_1"

  Scenario: I can order by date
    When I select "date" from "media-sort"
    Then it should be sorted by date
    # TODO

  Scenario: I can order by name
    When I select "name" from "media-sort"
    Then it should be sorted by name
    # TODO

  Scenario: I can filter by image
    When I select "image" from "media-type"
    Then I should see 9 visibles ".media-element" elements
    Then I should not see a visible ".pagination" element
    Then I should see "png_1"

  Scenario: I can filter by pdf
    When I select "pdf" from "media-type"
    Then I should see 9 visibles ".media-element" elements
    Then I should not see a visible ".pagination" element
    Then I should see "pdf_1"

  Scenario: I can edit a media
    When I click on ".media-element"
    Then TODO
    # TODO

  Scenario: I can delete a media
    When I click on ".media-element"
    Then TODO
    # TODO
