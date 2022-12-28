<?php

namespace tests\User;

use app\models\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;
    private string $dataSource = 'gorest_rest_api';

    protected function setUp(): void
    {
        $this->user = new User;
        require_once __DIR__ . '/../../config/gorest_api.php';

//        $this->user = $this->getMockBuilder('\app\models\User')->getMock();
    }

    protected function tearDown(): void
    {
        unset($this->user);
    }

    /**
     * @param $correctPage
     * @param $incorrectPage
     * @return void
     * @dataProvider allDataProvider
     */
    public function testAll($correctPage, $incorrectPage): void
    {
        $dataSource = $this->dataSource;

        $result = $this->user->all($correctPage, $dataSource);
        $this->assertNotEmpty($result['success']);

        $result = $this->user->all($incorrectPage, $dataSource);
        $this->assertEmpty($result['success']);

//        $user = $this->user;
//        $user->expects($this->once())
//            ->method('all')
//            ->will($this->returnValue(['success' => [], 'error'=> '']));
//        $this->assertEquals(['success' => [], 'error'=> ''], $user->all($data, $this->dataSource));
    }

    public function allDataProvider(): array
    {
        return [
            [
                'correctPage' => ['per_page' => 10, 'page' => 2],
                'incorrectPage' => ['per_page' => 10, 'page' => 892]
            ],
        ];
    }

    /**
     * @param $correctId
     * @param $incorrectId
     * @return void
     * @dataProvider findDataProvider
     */
    public function testFind($correctId, $incorrectId): void
    {
        $dataSource = $this->dataSource;

        $result = $this->user->find($correctId, $dataSource);
        $this->assertEmpty($result['error'], $result['error']);

        $result = $this->user->find($incorrectId, $dataSource);
        $this->assertNotEmpty($result['error'], $result['error']);

    }

    public function findDataProvider(): array
    {
        return [
            [
                'correctId' => 893,
                'incorrectId' => 70,
            ]
        ];
    }

    /**
     * @param $invalidEmail
     * @param $emailAlreadyExists
     * @param $correctData
     * @return void
     * @dataProvider insertDataProvider
     */
    public function testInsert($invalidEmail, $emailAlreadyExists, $correctData): void
    {
        $dataSource = $this->dataSource;

        $result = $this->user->insert($invalidEmail, $dataSource);
        $this->assertNotEmpty($result['error'], $result['error']);

        $result = $this->user->insert($emailAlreadyExists, $dataSource);
        $this->assertNotEmpty($result['error'], $result['error']);

        $result = $this->user->insert($correctData, $dataSource);
        $this->assertEmpty($result['error'], $result['error']);
    }

    public function insertDataProvider(): array
    {
        return [
            [
                'invalidEmail' => [
                    'name' => 'Rocket',
                    'email' => str_shuffle('qwertyuiopasd'),
                    'gender' => 'male',
                    'status' => 'active'
                ],
                'emailAlreadyExists' => [
                    'name' => 'Rocket',
                    'email' => 'rocket@marvel.com',
                    'gender' => 'male',
                    'status' => 'active'
                ],
                'correctData' => [
                    'name' => 'Rocket',
                    'email' => str_shuffle('qwertyuiopasd') . '@mail.com',
                    'gender' => 'male',
                    'status' => 'active'
                ],
            ]
        ];
    }

    /**
     * @param $invalidId
     * @param $emailAlreadyExists
     * @param $correctData
     * @return void
     * @dataProvider updateDataProvider
     */
    public function testUpdate($invalidId, $emailAlreadyExists, $correctData): void
    {
        $dataSource = $this->dataSource;

        $result = $this->user->update($invalidId, $dataSource);
        $this->assertNotEmpty($result['error'], $result['error']);

        $result = $this->user->update($emailAlreadyExists, $dataSource);
        $this->assertNotEmpty($result['error'], $result['error']);

        $result = $this->user->update($correctData, $dataSource);
        $this->assertEmpty($result['error'], $result['error']);
    }

    public function updateDataProvider(): array
    {
        return [
            [
                'invalidId' => [
                        'id' => '5',
                        'name' => 'Rocket',
                        'email' => str_shuffle('qwertyuiopasd'),
                        'gender' => 'male',
                        'status' => 'active'
                ],
                'emailAlreadyExists' => [
                        'id' => '4356',
                        'name' => 'Rocket',
                        'email' => 'rocket@marvel.com',
                        'gender' => 'male',
                        'status' => 'active'
                ],
                'correctData' => [
                        'id' => '11077',
                        'name' => 'Rocket',
                        'email' => str_shuffle('qwertyuiopasd') . '@mail.com',
                        'gender' => 'male',
                        'status' => 'active'
                ],
            ]
        ];
    }

    /**
     * @param $incorrectId
     * @return void
     * @dataProvider deleteDataProvider
     */
    public function testDelete($incorrectId): void
    {
        $dataSource = $this->dataSource;

        $result = $this->user->delete($incorrectId, $dataSource);
        $this->assertNotEmpty($result['error'], $result['error']);
    }

    public function deleteDataProvider(): array
    {
        return [
            'incorrectId5' => [5],
            'incorrectId67' => [67],
            'incorrectId89298' => [89298],
        ];
    }
}