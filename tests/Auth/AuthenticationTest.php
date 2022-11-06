<?php

namespace Bow\Tests\Auth;

use Bow\Auth\Auth;
use Bow\Security\Hash;
use Bow\Container\Capsule;
use Bow\Database\Database;
use Bow\Auth\Authentication;
use Bow\Auth\Exception\AuthenticationException;
use Bow\Auth\Guards\JwtGuard;
use Bow\Auth\Guards\SessionGuard;
use Bow\Auth\Guards\GuardContract;
use Bow\Security\CryptoConfiguration;
use Bow\Session\SessionConfiguration;
use Bow\Tests\Auth\Stubs\UserModelStub;
use Policier\Bow\PolicierConfiguration;
use Bow\Tests\Config\TestingConfiguration;

class AuthenticationTest extends \PHPUnit\Framework\TestCase
{
    protected static GuardContract $auth;

    public static function setUpBeforeClass(): void
    {
        $config = TestingConfiguration::getConfig();
        Auth::configure($config["auth"]);

        // Configuration database
        Database::configure($config['database']);
        Database::statement("create table if not exists users (id int primary key auto_increment, name varchar(255), password varchar(255), username varchar(255))");
        Database::table('users')->insert([
            'name' => 'Franck',
            'password' => Hash::make("password"),
            'username' => 'papac'
        ]);

        // Configuration of policier package
        $policier = new PolicierConfiguration(Capsule::getInstance());
        $policier->create($config);
        $policier->run();
    }

    public static function tearDownAfterClass(): void
    {
        Database::statement("drop table if exists users;");
    }

    public function test_it_auth_instance()
    {
        $auth = Auth::getInstance();
        $this->assertInstanceOf(GuardContract::class, $auth);
    }

    public function test_it_should_be_a_default_guard()
    {
        $config = TestingConfiguration::getConfig();
        $auth = Auth::getInstance();

        $this->assertEquals($auth->getName(), $config["auth"]["default"]);
        $this->assertEquals($auth->getName(), "web");
    }

    public function test_it_should_be_session_guard_instance()
    {
        $auth = Auth::getInstance();

        $this->assertInstanceOf(SessionGuard::class, $auth->guard('web'));
    }

    public function test_it_should_be_session_jwt_instance()
    {
        $auth = Auth::getInstance();

        $this->assertInstanceOf(JwtGuard::class, $auth->guard('api'));
    }

    public function test_attempt_login_with_jwt_provider()
    {
        $auth = Auth::getInstance();
        $auth->guard('api');

        $result = $auth->attempts([
            "username" => "papac",
            "password" => "password"
        ]);

        $token = $auth->getToken();
        $user = $auth->user();

        $this->assertTrue($result);
        $this->assertTrue($auth->check());
        $this->assertInstanceOf(Authentication::class, $user);
        $this->assertRegExp("/^([a-zA-Z0-9_-]+\.){2}[a-zA-Z0-9_-]+$/", $token);
    }

    public function test_direct_login_with_jwt_provider()
    {
        $auth = Auth::getInstance();
        $auth->guard('api');
        $auth->login(UserModelStub::first());

        $token = $auth->getToken();
        $user = $auth->user();

        $this->assertInstanceOf(Authentication::class, $user);
        $this->assertTrue($auth->check());
        $this->assertRegExp("/^([a-zA-Z0-9_-]+\.){2}[a-zA-Z0-9_-]+$/", $token);
    }

    public function test_attempt_login_with_jwt_provider_fail()
    {
        $auth = Auth::getInstance();
        $auth->guard('api');

        $result = $auth->attempts([
            "username" => "papac",
            "password" => "passwor"
        ]);

        $this->assertFalse($result);
        $this->assertFalse($auth->check());
        $this->assertNull($auth->getToken());
    }

    public function test_direct_login_with_jwt_provider_fail()
    {
        $auth = Auth::getInstance();
        $auth->guard('api');

        $result = $auth->attempts([
            "username" => "papac",
            "password" => "passwor"
        ]);

        $this->assertFalse($result);
        $this->assertFalse($auth->check());
        $this->assertNull($auth->getToken());
    }

    public function test_attempt_login_with_session_provider()
    {
        $auth = Auth::getInstance();
        $auth->guard('web');

        $result = $auth->attempts([
            "username" => "papac",
            "password" => "password"
        ]);

        $user = $auth->user();

        $this->assertTrue($result);
        $this->assertInstanceOf(Authentication::class, $user);
        $this->assertEquals($user->name, 'Franck');
    }

    public function test_attempt_login_with_session_provider_fail()
    {
        $this->expectException(AuthenticationException::class);
        $auth = Auth::getInstance();
        $auth->guard('web');

        $result = $auth->attempts([
            "username" => "papac",
            "password" => "passwor"
        ]);

        $this->assertFalse($result);
        $this->assertNull($auth->user());
    }

    public function test_direct_login_with_session_provider()
    {
        $this->expectException(AuthenticationException::class);
        $auth = Auth::getInstance();
        $auth->guard('web');
        $auth->login(UserModelStub::first());

        $user = $auth->user();

        $this->assertInstanceOf(Authentication::class, $user);
        $this->assertEquals($user->name, 'Franck');
    }
}
