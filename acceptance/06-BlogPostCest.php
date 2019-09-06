<?php
use \Codeception\Util\Locator;


class BlogPostCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    public function _after(AcceptanceTester $I)
    {
    }


    /* Tests
     */

    /**
     * checkLinks
     *
     * @group people
     */
    public function checkLinks(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $I->amOnPage(\Page\BlogPost::$listURL);

        try {
            $I->see('Blog');
        } catch (Exception $e) {
            $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        }
        $I->amOnPage(\Page\BlogPost::$listURL);
        $I->seeInCurrentUrl('/blog-admin');
        $I->see('Create New Blog Post');
        $I->click(\Page\BlogPost::$addPostLink);
        $I->seeInCurrentUrl(\Page\BlogPost::$PURL);
        $I->see(' Create New Blog Post');
        $I->amOnPage(\Page\BlogPost::$listURL);
    }

    /**
     * checkAddPost
     *
     * @group people
     */
    public function checkAddPost(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $id = date('ymdHi');
        $converPage = new \Page\BlogPost($I);
        $I->amOnPage('/blog-admin/new');
        $I->fillField('post_title', 'My blog post');
        $I->fillTinyMceEditorByName('post_content', 'sssssssss');
        $I->fillField('post_description', 'sssssssssssssssfweew');
        $I->fillField('post_feature_image', '');
        $I->click('Create Post');
    }
    public function checkEditPost(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $I->amOnPage('/blog-admin/');
        $I->fillField('#managePost_filter input', 'My blog post');
        $I->click("#managePost tr td a");
        $I->see('Update Blog Post');
        $I->fillField('post_title', 'My blog post 2');
        $I->click('Update Post');
    }

    public function checkDeletePost(AcceptanceTester $I, \Page\Login $loginPage)
    {
        $loginPage->login(\Page\Login::$defaultUsername, \Page\Login::$defaultPassword, false);
        $I->amOnPage('/blog-admin/');
        $I->fillField('#managePost_filter input', 'My blog post 2');
        $I->wait(3);
        $I->click("#managePost tr td a.modal-link");
        $I->wait(3);
        $I->see("Are you sure, you'd like to delete this post? This cannot be undone.");
        $I->click('Yes, Remove Post');
    }

}