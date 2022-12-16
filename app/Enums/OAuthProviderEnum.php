<?php

namespace App\Enums;

enum OAuthProviderEnum: string
{
    case GITHUB = 'github';
    case FACEBOOK = 'facebook';
    case GOOGLE = 'google';
    case TWITTER = 'twitter';
}
