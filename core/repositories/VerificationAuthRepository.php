<?php

namespace core\repositories;

use core\entities\user\VerificationAuth;
use core\repositories\exceptions\NotFoundException;

class VerificationAuthRepository
{
    /**
     * @param $hash
     * @return VerificationAuth
     */
    public function get($hash)
    {
        return $this->getBy(['hash' => $hash]);
    }

    protected function getBy(array $condition = [])
    {
        if (!$model = VerificationAuth::findOne($condition)) {
            throw new NotFoundException('Verification is not found');
        }
        return $model;
    }

    public function getByHashAndVerifyCode($hash, $verifyCode)
    {
        return $this->getBy(['hash' => $hash, 'verify_code' => $verifyCode]);
    }

    public function countLastTriesByIp($ip)
    {
        return VerificationAuth::find()->where("FROM_UNIXTIME(`created_at`) >= NOW() - INTERVAL 15 MINUTE")
            ->andWhere(['ip' => $ip])
            ->andWhere(['is_confirmed' => 0])
            ->count();
    }

    public function save(VerificationAuth $model)
    {
        if (!$model->save(false)) {
            throw new \RuntimeException('Saving error.');
        }
    }

    public function delete(VerificationAuth $model)
    {
        if (!$model->delete()) {
            throw new \RuntimeException('Deleting error.');
        }
    }

} 