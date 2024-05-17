<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Project\Models\User;
use Project\Models\UserManager;

final class AuthTest extends TestCase
{
    private string $username;
    protected function setUp(): void
    {
        $this->username = (string) time();
    }

    public function testUserCanBeCreated()
    {
        $manager = new UserManager();
        $generatedId = $manager->store($this->username, "test");
        $this->assertIsString($generatedId);
    }

    public function testUserCanBeFound()
    {
        $manager = new UserManager();
        $user = $manager->find($this->username);
        $this->assertInstanceOf(User::class, $user);
    }
}





