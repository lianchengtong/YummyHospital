<?php

namespace common\models\interfaces;

use common\models\User;

interface InterfaceUserAuth
{
    public function getAccessToken();

    public function getRefreshToken();

    public function getIsExpire();

    public function updateRefreshToken($newToken);

    public function updateAccessToken($newToken);

    public function getOpenID();

    public function setRefreshTokenExpire($timeDuration);

    public function setAccessTokenExpire($timeDuration);

    public function needRefreshToken();

    public function setAuthData($authData);

    public function connectWithUser(User $user);
}