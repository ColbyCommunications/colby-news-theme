@search
Feature: Search Results
  In order to confirm that the standard search is working
  As a Visitor
  I want to test searching for terms

  Scenario: Searching for a term returns the correct number of results
    Given I am on "/?s=html"
    Then I should see "Search Results for: html"
    And I should see 2 "article" elements

  Scenario: Searching for a non-existent term returns no results
    Given I am on "/?s=gibberish"
    Then I should see "Nothing Found"
    And I should see 0 "article" elements