<?php
use PaulGibbs\WordpressBehatExtension\Context\RawWordpressContext;
use PaulGibbs\WordpressBehatExtension\Driver\WpcliDriver;

use Behat\Behat\Tester\Exception\PendingException;

/**
 * Define application features from the specific context.
 */
class FeatureContext extends RawWordpressContext {
    protected $wpcli;
    /**
     * Initialise context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the context constructor through behat.yml.
     */
    public function __construct() {
        parent::__construct();
        $this->wpcli = new WpcliDriver('', 'https://wp-testing.lndo.site','/usr/local/bin/wp' );
    }


    /**
    * Checks, that less than (?P<num>\d+) CSS elements exist on the page
    * Example: Then I should see less than 5 "div" elements
    * Example: And I should see < 5 "div" elements
    *
    * @Then /^(?:|I )should see (less than|<) (?P<num>\d+) "(?P<element>[^"]*)" elements?$/
    */
   public function assertLessThanNumElements($num, $element)
   {
       $elList = $this->getSession()->getPage()->findAll('css', $element);

       if ( is_array($elList) ) {
            $elCount = count($elList);
       } else {
           $elCount = 0;
       }

       assert($elCount < $num, sprintf('Expected less than "%s" matches; "%s" found.', $num, $elCount));
   }

    /**
    * Checks, that more than (?P<num>\d+) CSS elements exist on the page
    * Example: Then I should see more than 5 "div" elements
    * Example: And I should see greater than 5 "div" elements
    * Example: And I should see > 5 "div" elements
    *
    * @Then /^(?:|I )should see (more than|greater than|>) (?P<num>\d+) "(?P<element>[^"]*)" elements?$/
    */
   public function assertGreaterThanNumElements($num, $element)
   {
       $elList = $this->getSession()->getPage()->findAll('css', $element);

       if ( is_array($elList) ) {
            $elCount = count($elList);
       } else {
           $elCount = 0;
       }

       assert($elCount > $num, sprintf('Expected less than "%s" matches; "%s" found.', $num, $elCount));
   }

   /**
    * Changes the posts_per_page setting to (?P<posts_per_page>\d+)
    * Example: Given there are 10 posts per page
    * Example: Given that there are 5 posts per page
    *
    * @Given /^(?:|that )there are (?P<posts_per_page>\d+) posts per page$/
    */
   public function setPostsPerPage($posts_per_page) {
    $this->wpcli->wpcli('option', 'update', ['posts_per_page', $posts_per_page]);
   }

   /**
    * Sets the home page to static page with the ID (?P<page_id>\d+)
    * Example: Given the front page is 2
    * Example: Given front page is 10
    * Example: Given that the front page is 0
    *
    * @Given the front page is :page_id
    */
   public function frontPageIs($page_id) {
        if ($page_id == 0) {
            $this->wpcli->wpcli('option', 'update', ['show_on_front', 'posts']);
        } else {
            $this->wpcli->wpcli('option', 'update', ['show_on_front', 'page']);
            $this->wpcli->wpcli('option', 'update', ['page_on_front', $page_id]);
        }
   }
}
