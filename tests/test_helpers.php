<?php

trait testHelpers
{

    public function signIn($attributes = [])
    {
        $this->user = $this->createUser($attributes);

        $this->be($this->user);
    }

    protected function createUser($attributes)
    {
        return factory(\App\User::class)->create($attributes);
    }
}