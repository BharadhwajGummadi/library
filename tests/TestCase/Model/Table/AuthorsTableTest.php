<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AuthorsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AuthorsTable Test Case
 */
class AuthorsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.authors',
        'app.books',
        'app.genres',
        'app.book_issues',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Authors') ? [] : ['className' => 'App\Model\Table\AuthorsTable'];
        $this->Authors = TableRegistry::get('Authors', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Authors);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
    
    public function testView() {
        $result = $this->Authors->view(1);
        $this->assertContains('"status":"success","code":200,"data":{"id":1', $result);
        $this->tearDown();
    }
}
