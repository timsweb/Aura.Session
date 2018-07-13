<?php
/**
 *
 * This file is part of Aura for PHP.
 *
 * @license http://opensource.org/licenses/bsd-license.php BSD
 *
 */
namespace Aura\Session;

/**
 *
 * A factory to create a Session manager. Lets make session a singleton shall we?
 *
 * @package Aura.Session
 *
 */
class SessionFactory
{
    private static $instance;

    /**
     *
     * Creates a new Session manager.
     *
     * @param array $cookies An array of cookie values, typically $_COOKIE.
     *
     * @param callable|null $delete_cookie Optional: An alternative callable
     * to invoke when deleting the session cookie. Defaults to `null`.
     *
     * @return Session New Session manager instance
     */
    public function newInstance(array $cookies, $delete_cookie = null)
    {
        if (self::$instance) {
            return self::$instance;
        }

        $phpfunc = new Phpfunc;
        self::$instance = new Session(
            new SegmentFactory,
            new CsrfTokenFactory(new Randval($phpfunc)),
            $phpfunc,
            $cookies,
            $delete_cookie
        );
        return self::$instance;
    }

    public static function get()
    {
        if (!self::$instance) {
            throw new \RuntimeException('Session instance not setup by calling ' . __CLASS__. '::newInstance');
        }
        return self::$instance;
    }
}
