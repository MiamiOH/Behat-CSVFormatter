Feature: CSV Output Test

Background:
  Given a file named "behat.yml" with:
    """
    default:
      formatters:
        CSVFormatter: ~
      extensions:
          miamioh\BehatCSVFormatter\BehatCSVFormatterExtension:
              filename: report.csv
              outputDir: '%paths.base%/results/tests'
              columnList: scenario.name,scenarioRun.startTime
      suites:
          suite1:
              paths:    [ "%paths.base%/features/suite1" ]
          suite2:
              paths:    [ "%paths.base%/features/suite2" ]
    """
  Given a file named "features/bootstrap/FeatureContext.php" with:
    """
    <?php
      use Behat\Behat\Context\CustomSnippetAcceptingContext,
          Behat\Behat\Tester\Exception\PendingException,
          PHPUnit\Framework\Assert;

      class FeatureContext implements CustomSnippetAcceptingContext
      {
          public static function getAcceptedSnippetType() { return 'regex'; }
          /** @When /^I give a passing step$/ */
          public function passingStep() {
            Assert::assertEquals(2, 2);
          }
          /** @When /^I give a failing step$/ */
          public function failingStep() {
            Assert::assertEquals(1, 2);
          }
      }
    """

Scenario: Multiple Suites with multiple results
  Given a file named "features/suite1/suite_failing_with_passing.feature" with:
    """
    @Feature1
    Feature: Suite failing with passing scenarios
      Scenario: Passing scenario
        Then I give a passing step
      Scenario: One Failing step
        Then I give a failing step
      Scenario: Passing and Failing steps
        Then I give a passing step
        Then I give a failing step
    """
  Given a file named "features/suite2/suite_passing.feature" with:
    """
    @Feature2
    Feature: Suite passing
    @Scenario2.1
      Scenario: Passing scenario
        Then I give a passing step
    """
  When I run "behat --no-colors"
  Then report file should exists
  And report file should contain:
    """
    'Passing scenario'
    """
  And report file should contain:
    """
    'Passing and Failing steps'
    """
  And report file should contain:
    """
    ,failed,'Then I give a failing step','
    """
  And report file should contain:
    """
    ,Feature1,
    """
  And report file should contain:
    """
    ,'Feature2,Scenario2.1'
    """
