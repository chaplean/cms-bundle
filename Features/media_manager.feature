Feature: Media Manager

# TODO How to give text-angular the focus when firefox hasn't the focus ?
#
#  Background:
#    Given I load default datafixture with "Chaplean\Bundle\CmsBundle\"
#    Given I am on "/administration/block/3"
#    When I click on ".ta-editor div.ta-bind"
#    When I click on ".open-media-manager"
#
##  Scenario: I can add a media
##    Then I should see a visible "#media-manager" element
##    # TODO: How to upload a file in behat ?
##    # Then I should see a visible ".media-element.active" element
##    Then the media should be uploaded
#
#  Scenario: I can select a file and include it
#    When I click on ".media-element"
#    Then I should see a visible ".media-element.active" element
#    Then I should see 12 visibles ".media-element" elements
#    Then I should see a visible ".pagination" element
#    Then I should see a visible ".media-element.active" element
#    Then I should see "png_7" in the ".media-details" element
#    When I click on "#insert"
#    Then I should not see a visible "#media-manager" element
##    Then the media should be inserted in the wysiwyg editor
#
#  Scenario: I can search for a media by name
#    When I fill in "media-search" with "3"
#    Then I should see 2 visibles ".media-element" elements
#    Then I should see "png_3"
#    Then I should see "pdf_3"
#
#  Scenario: I can order by date
#    When I select "dateUpdate" from "media-sort"
#    Then I should see "png_7" in the ".media-list" element
#
#  Scenario: I can order by name
#    When I select "fileName" from "media-sort"
#    Then I should see "pdf_1" in the ".media-list" element
#
#  Scenario: I can filter by image
#    When I select "image" from "media-type"
#    Then I should see 12 visibles ".media-element" elements
#    Then I should not see a visible ".pagination" element
#    Then I should see "png_1"
#
#  Scenario: I can filter by pdf
#    When I select "pdf" from "media-type"
#    Then I should see 12 visibles ".media-element" elements
#    Then I should not see a visible ".pagination" element
#    Then I should see "pdf_1"
#
##  Scenario: I can edit a media
##    When I click on ".media-element"
##    Then TODO
##    # TODO: How to upload a file in behat ?
#
##  Scenario: I can delete a media
##    When I click on ".media-element"
##    Then I should see "png_7" in the ".media-details" element
##    When I click on "#delete"
##    Then I should not see "png_7"
