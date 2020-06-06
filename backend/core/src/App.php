<?php declare(strict_types=1);

namespace App;

use App\Application\Application;
use App\Application\Routing\RoutingFactory;
use App\Auth\AuthService;

class App
{
    private static ?FirebaseConnector $firebaseConnector = null;

    public static function Application()
    {
        return new Application(new RoutingFactory());
    }

    /**
     * @return FirebaseConnector
     */
    public static function FirebaseConnector(): FirebaseConnector
    {
        if ( ! self::$firebaseConnector) {
            self::$firebaseConnector = FirebaseConnector::make(getenv('FIREBASE_AUTH_KEY'));
        }

        return self::$firebaseConnector;
    }

    public static function AuthService()
    {
        return new AuthService(self::FirebaseConnector());
    }
}
