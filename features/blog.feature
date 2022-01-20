@blog
Feature: Blog Post Lists
  In order to confirm that blog posts are displayed on the correct pages
  As a Visitor
  I want to test the index and home templates

  Scenario: A list of posts appears on the homepage (if front page is not defined)
    Given there are 5 posts per page
    And the front page is 0
    And I am on "/"
    Then I should see 5 "article" elements

  Scenario: A list of posts appears on the homepage (if front page is not defined)
    Given there are 10 posts per page
    And the front page is 0
    And I am on "/"
    Then I should see less than 11 "article" elements