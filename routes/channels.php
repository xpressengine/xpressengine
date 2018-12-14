<?php
/**
 * channels.php
 *
 * PHP version 7
 *
 * @category    Routes
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
 */

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
