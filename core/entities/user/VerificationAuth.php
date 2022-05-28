<?php

namespace core\entities\user;

use Exception;
use yii\db\ActiveRecord;

/***
 * @property string $hash
 * @property string $addressee
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $resend_at
 * @property integer $verify_code
 * @property string $ip
 * @property integer $is_confirmed
 * @property integer $attempts
 */
class VerificationAuth extends ActiveRecord
{
    const EXPIRATION_LIMIT = 3600;
    const RESEND_HOLD = 60;
    const ATTEMPTS_LIMIT = 3;
    const LIMIT_OF_TRIES_VERIFICATION_PER_HOUR = 3;

    /**
     * @throws Exception
     */
    public static function make($userId, $addressee, $ip)
    {
        $entity = new static();
        $entity->addressee = $addressee;
        $entity->hash = sha1(uniqid() . $ip . $userId);
        $entity->user_id = $userId;
        $entity->created_at = time();
        $entity->resend_at = time();
        $entity->verify_code = random_int(10000, 99999);
        $entity->ip = $ip;
        $entity->is_confirmed = 0;
        $entity->attempts = 0;

        return $entity;
    }

    public static function tableName()
    {
        return "verification_auth";
    }

    public function isHourVerificationTriesLimitReached($number)
    {
        return $number >= self::LIMIT_OF_TRIES_VERIFICATION_PER_HOUR;
    }

    public function isResendHoldExpired()
    {
        return time() > $this->resend_at + self::RESEND_HOLD;
    }

    public function isExpired()
    {
        return time() > $this->created_at + self::EXPIRATION_LIMIT;
    }

    public function isVerifyCodeEquivalentTo($verifyCode)
    {
        return $this->verify_code == $verifyCode;
    }

    public function countRemainAttempts()
    {
        return self::ATTEMPTS_LIMIT - $this->attempts;
    }

    public function isAttemptsLimitReached()
    {
        return $this->attempts >= self::ATTEMPTS_LIMIT;
    }

    public function addAttempt()
    {
        $this->attempts = $this->attempts + 1;
    }

    public function confirm()
    {
        $this->is_confirmed = 1;
    }

    public function resend()
    {
        $this->resend_at = time();
    }

    public function isConfirmed()
    {
        return $this->is_confirmed;
    }

}