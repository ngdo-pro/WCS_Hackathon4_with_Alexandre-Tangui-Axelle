Feature: Navigate through the website
  In order to access to the website's content
  As a visitor
  I should be able to navigate through the website

  Scenario Outline: Navigation through all pages
    Given I am on "<page>"
    Then the response status code should be 200
    Examples:
      | page       |
      | /          |