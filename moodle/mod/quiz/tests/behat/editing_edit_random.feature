@mod @mod_quiz @javascript
Feature: Editing random questions already in a quiz based on category and tags
  In order to have better assessment
  As a teacher
  I want to be able to update how questions are randomly picked from the question bank

  Background:
    Given the following "users" exist:
      | username | firstname | lastname | email          |
      | teacher1 | Teacher   | 1        | t1@example.com |
    And the following "courses" exist:
      | fullname | shortname |
      | Course 1 | C1        |
    And the following "course enrolments" exist:
      | user     | course | role           |
      | teacher1 | C1     | editingteacher |
    And the following "activities" exist:
      | activity   | name    | intro                                             | course | idnumber |
      | quiz       | Quiz 1  | Quiz 1 for testing the Add random question form   | C1     | quiz1    |
      | qbank      | Qbank 1 | Qbank 1 for testing the Edit random question form | C1     | qbank1   |
    And the following "question categories" exist:
      | contextlevel    | reference | name                |
      | Activity module | quiz1     | Questions Category 1|
      | Activity module | quiz1     | Questions Category 2|
      | Activity module | qbank1    | Questions Category 3|
    And the following "questions" exist:
      | questioncategory     | qtype | name            | user     | questiontext    |
      | Questions Category 1 | essay | question 1 name | admin    | Question 1 text |
      | Questions Category 1 | essay | question 2 name | teacher1 | Question 2 text |
      | Questions Category 3 | essay | question 3 name | teacher1 | Question 3 text |
    And the following "core_question > Tags" exist:
      | question        | tag   |
      | question 1 name | easy  |
      | question 1 name | essay |
      | question 2 name | hard  |
      | question 2 name | essay |
      | question 3 name | essay |

  Scenario: Editing tags on one slot does not delete the rest
    Given I am on the "Quiz 1" "mod_quiz > Edit" page logged in as "teacher1"
    And I open the "last" add to quiz menu
    And I follow "a random question"
    # To actually reproduce MDL-68733 it would be better to set tags easy,essay here, and then below just delete one tag.
    # However, the state of Behat for autocomplete fields does not let us actually do that.
    And I apply question bank filter "Tag" with value "easy"
    And I press "Add random question"
    And I open the "Page 1" add to quiz menu
    And I follow "a random question"
    And I apply question bank filter "Tag" with value "hard"
    And I press "Add random question"
    And I follow "Add page break"
    When I click on "Configure question" "link" in the "Random (Questions Category 1) based on filter condition with tags: easy" "list_item"
    And I apply question bank filter "Tag" with value "essay"
    And I press "Update filter conditions"
    Then I should see "Random (Questions Category 1) based on filter condition with tags: essay" on quiz page "1"
    And I should see "Random (Questions Category 1) based on filter condition with tags: hard" on quiz page "2"
    And I click on "Configure question" "link" in the "Random (Questions Category 1) based on filter condition with tags: hard" "list_item"
    And "hard" "autocomplete_selection" should be visible

  Scenario: Switch banks when editing a random question
    Given I am on the "Quiz 1" "mod_quiz > Edit" page logged in as "teacher1"
    And I open the "last" add to quiz menu
    And I follow "a random question"
    And I apply question bank filter "Tag" with value "essay"
    And I press "Add random question"
    When I click on "Configure question" "link" in the "Random (Questions Category 1) based on filter condition with tags: essay" "list_item"
    And I press "Switch bank"
    And I click on "Qbank 1" "link" in the "Select question bank" "dialogue"
    And the field "filter-value-qtagids" matches value "essay"
    And I apply question bank filter "Category" with value "Questions Category 3 (1)"
    And I should see "question 3 name"
    And I press "Update filter conditions"
    Then I should see "Random (Questions Category 3) based on filter condition with tags: essay" on quiz page "1"

  Scenario: "Go back" from bank switcher keeps existing filter values.
    Given I am on the "Quiz 1" "mod_quiz > Edit" page logged in as "teacher1"
    And I open the "last" add to quiz menu
    And I follow "a random question"
    And I apply question bank filter "Tag" with value "essay"
    And I press "Add random question"
    When I click on "Configure question" "link" in the "Random (Questions Category 1) based on filter condition with tags: essay" "list_item"
    And the field "filter-value-category" matches value "&nbsp;&nbsp;&nbsp;Questions Category 1 (2)"
    And the field "filter-value-qtagids" matches value "essay"
    And I press "Switch bank"
    And I press "Go back"
    Then the field "filter-value-category" matches value "&nbsp;&nbsp;&nbsp;Questions Category 1 (2)"
    And the field "filter-value-qtagids" matches value "essay"
