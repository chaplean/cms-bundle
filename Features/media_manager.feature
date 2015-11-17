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

  Scenario: I can select a file and include it
    When I click on ".media-element"
    Then I should see a visible ".media-element.active" element
    Then I should see 9 visibles ".media-element" elements
    Then I should see a visible ".media-element.active" element
    Then I should see "test-selected-file.png"
    When I click on "#insert"
    Then I should not see a visible "#media-manager" element
    # TODO: Check that the media is inserted in the wysiwyg editor

  Scenario: I can search for a media by name
    When I fill in "media-search" with "test"
    Then I should see 1 visibles ".media-element" elements

  Scenario: I can order by date
    # TODO

  Scenario: I can order by name
    # TODO

  Scenario: I can filter by images
    # TODO

  Scenario: I can filter by pdf
    # TODO

  Scenario: I can edit a media and validate
    # TODO

  Scenario: I can edit a media and cancel
    # TODO

  Scenario: I can delete a media
    # TODO
