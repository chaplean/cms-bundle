Feature: Bloc Training Request

  Background:
    Given I add datafixture "Chaplean\Bundle\CmsBundle\DataFixtures\Liip\LoadPageRouteData"
    Given I add datafixture "Chaplean\Bundle\CmsBundle\DataFixtures\Liip\LoadPublicationData"
    Given I add datafixture "Chaplean\Bundle\CmsBundle\DataFixtures\Liip\LoadPublicationStatusData"
    Given I load database
    Given I am on "/administration/pages"

  Scenario: I see the pages list
    When I wait for Angular
    Then I should see a "#pages-list" element
