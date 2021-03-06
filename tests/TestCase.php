<?php

use App\Exceptions\Handler;
use App\User;
use Illuminate\Contracts\Debug\ExceptionHandler;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    protected $user;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create();
        $this->be($this->user);
    }

    public function disableExceptionHandling()
    {
        $this->app->instance(ExceptionHandler::class, new class extends Handler{
            public function __construct(){}
            public function report(Exception $e){}
            public function render($request, Exception $e){
                throw $e;
            }
        });
    }
}
