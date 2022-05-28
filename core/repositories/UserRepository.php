<?php

namespace core\repositories;

use core\entities\user\User;
use core\repositories\exceptions\NotFoundException;

class UserRepository
{
    /**
     * @param $id
     * @return User
     */
    public function get($id)
    {
        if (!$model = User::findOne($id)) {
            throw new NotFoundException('Model not found.');
        }
        return $model;
    }

    public function findByUsernameOrEmail($value)
    {
        return User::find()->andWhere(['or', ['username' => $value], ['email' => $value]])->one();
    }

    public function getByEmail($email)
    {
        return $this->getBy(['email' => $email]);
    }

    public function add(User $model)
    {
        if (!$model->getIsNewRecord()) {
            throw new \RuntimeException('Adding existing model.');
        }
        if (!$model->insert(false)) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function save(User $model)
    {
        if ($model->getIsNewRecord()) {
            throw new \RuntimeException('Saving new model.');
        }
        if ($model->update(false) === false) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function delete(User $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }

    public function getByPasswordResetToken($token)
    {
        return $this->getBy(['password_reset_token' => $token]);
    }

    public function getByVerificationToken($token)
    {
        return $this->getBy(['email_verification_token' => $token]);
    }

    public function existsByPasswordResetToken($token)
    {
        return (bool) User::findByPasswordResetToken($token);
    }

    public function existByVerficationToken($token)
    {
        return (bool) User::find()->where(['email_verification_token' => $token])->exists();
    }

    private function getBy(array $condition)
    {
        if (!$user = User::find()->andWhere($condition)->limit(1)->one()) {
            throw new NotFoundException('User not found.');
        }
        return $user;
    }
} 