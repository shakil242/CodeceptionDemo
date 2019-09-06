<?php
namespace Page;

class BlogPost
{
    public static $listURL = '/blog-admin';
    public static $PURL = '/blog-admin/new';
    public static $editURL = '/blog-admin/edit/';
    public static $addPostLink = 'a[href="/blog-admin/new"]';
    public static $post_title = 'form input[name=post_title]';
    public static $post_permalink = 'form input[name=post_permalink]';
    public static $post_content = 'form input[name=post_content]';
    public static $post_description = 'form input[name=post_description]';
    public static $post_feature_image = 'form input[name=post_feature_image]';
    public static $post_status = 'form input[name=post_status]';
    public static $createButton = 'Create Post';
    public static $saveButton = 'form button[type=submit]';
    protected $tester;
    public function __construct(\AcceptanceTester $I)
    {
        $this->tester = $I;
        $testUrl = getenv('TIC_TEST_URL');
        if (!empty($testUrl)) {
            $I->amOnUrl($testUrl);
        }
    }

}
