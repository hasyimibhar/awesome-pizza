<?php

namespace AwesomePizza;

class User extends Model
{
    /**
     * User name.
     *
     * @var string
     */
    public $name;

    /**
     * User email
     *
     * @var string
     */
    public $email;

    /**
     * User password hash.
     *
     * @var string
     */
    public $password;

    /**
     * User password remember token.
     *
     * @var string
     */
    public $remember_token;
}
