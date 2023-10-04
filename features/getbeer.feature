# This file contains a user story for getting the detail of a Beer

Feature:
    In order to prove that the getter of the API works fine
    As a user
    I want to get de detail of beer

    Scenario: It receives the detail of a beer
        When sending a request to "/beer/1"
        Then the response should be received
        Then I should see the in the detail the identifier '"id":1'
