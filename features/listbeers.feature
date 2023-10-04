# This file contains a user story for listing beers

Feature:
    In order to prove that the list of beers from API is correct
    As a user
    I want to have a list filtered and non-filtered of beers

    Scenario: It receives a list of beers from API
        When sending a request to "/beer/2"
        Then the response should be received

    Scenario: It receives a list of beers from API filtered by food
        When sending a request to "/beers/chicken"
        Then the response should be received
