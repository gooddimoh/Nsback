<?php

namespace core\entities\user;

use core\helpers\TokenTimer;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Html;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $api_key
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property float $balance
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $email_verification_token
 * @property int $email_verified
 * @property string $verification_contact
 * @property string $password write-only password
 * @property string $ip
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
    public const STATUS_DELETED = 0;
    public const STATUS_ACTIVE = 10;

    public const STATUS_ACTIVE_LIST = [self::STATUS_ACTIVE];

    public static function requestSignup($username, $email, $password, $ip)
    {
        $user = new static();
        $user->username = $username;
        $user->email = $email;
        $user->setPassword($password);
        $user->created_at = time();
        $user->status = self::STATUS_ACTIVE;
        $user->balance = 0;
        $user->generateAuthKey();
        $user->generateApiKey();
        $user->ip = $ip;

        return $user;
    }

    public function edit($username, $email)
    {
        $this->username = $username;
        $this->setEmail($email);
    }

    public function withdrawBalance($sum)
    {
        if ($sum > $this->balance) {
            throw new \DomainException("Недостаточно средств на балансе");
        }

        $this->balance -= $sum;
    }

    public function getEncodedUsername()
    {
        return Html::encode($this->username);
    }

    public function getUsernameEncoded()
    {
        return Html::encode($this->username);
    }

    public function changePassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public function changeUsername($username)
    {
        $this->username = $username;
    }

    public function isEmailEquivalent($email)
    {
        return $this->email === $email;
    }

    public function setEmail($email)
    {
        if (!$this->isEmailEquivalent($email)) {
            $this->email = $email;
            $this->moveEmailToUnverified();
        }
    }

    public function addBalance($sum)
    {
        $this->balance += $sum;
    }

    public function writeOffBalance($sum)
    {
        $this->balance -= $sum;
    }

    public function getPrettyBalance()
    {
        return Yii::$app->formatter->asCurrency($this->balance);
    }

    public function requestVerifyEmail()
    {
        if ($this->isEmailVerified()) {
            throw new \DomainException("Ваш аккаунт уже верифицирован");
        }
        if (!empty($this->email_verification_token) &&
            TokenTimer::isTokenNotExpire($this->email_verification_token, Yii::$app->params['user.emailVerificationTokenExpire'])) {
            throw new \DomainException("Верификация e-mail уже запрашивалась. Вы можете попробовать ещё раз через 5 минут.");
        }

        $this->email_verification_token = TokenTimer::generateToken();
    }

    public function isEmailVerified(): bool
    {
        return (bool)$this->email_verified;
    }

    public function moveEmailToVerified()
    {
        $this->email_verified = 1;
    }

    public function moveEmailToUnverified()
    {
        $this->email_verified = 0;
    }

    public function getVerificationContact()
    {
        return $this->verification_contact;
    }

    public function requestPasswordReset()
    {
        if (!empty($this->password_reset_token) && self::isPasswordResetTokenValid($this->password_reset_token)) {
            throw new \DomainException('Сброс пароля уже запрашивался. Вы можете попробовать ещё раз через час. ');
        }
        $this->password_reset_token = TokenTimer::generateToken();
    }

    public function resetPassword($password)
    {
        if (empty($this->password_reset_token)) {
            throw new \DomainException('Сброс пароля не запрашивался.');
        }
        $this->setPassword($password);
        $this->password_reset_token = null;
    }

    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        return TokenTimer::isTokenNotExpire($token, Yii::$app->params['user.passwordResetTokenExpire']);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    public function isActive()
    {
        return in_array($this->status, self::STATUS_ACTIVE_LIST);
    }

    /**
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken(string $token)
    {
        if (!static::isResetTokenValid($token, 'user.passwordResetTokenExpire')) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE_LIST,
        ]);
    }

    /**
     * @param string $token password reset token
     * @param string $tokenType
     * @return bool
     */
    public static function isResetTokenValid(string $token, string $tokenType)
    {
        if (empty($token)) {
            return false;
        }

        return TokenTimer::isTokenNotExpire($token, Yii::$app->params[$tokenType]);
    }

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function attributeLabels()
    {
        return [
            'created_at' => 'Регистрация',
            'updated_at' => 'Редактирован',
            'username' => 'Логин',
            'balance' => 'Баланс',
            'email_verified' => 'E-Mail подтвержден',
            'ip' => 'IP',
        ];
    }

    public function behaviors()
    {
        return [TimestampBehavior::class];
    }


    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }


    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE_LIST]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['api_key' => $token]);
    }

}
