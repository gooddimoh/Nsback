<?php

namespace core\helpers\bulk;

class BulkResult
{
    private $success = [];
    private $fail = [];

    public function addSuccess($id)
    {
        $this->success[] = $id;
    }

    public function addFail($id, $message)
    {
        $this->success[] = ['id' => $id, 'message' => $message];
    }

    public function prepareForPrint($textSuccess = null, $textFail = null, $divider = "<br>")
    {
        $result = null;

        foreach ($this->success as $success) {
            $result .= "$textSuccess | ID: $success $divider";
        }
        foreach ($this->fail as $fail) {
            $result .= "$textFail. Ошибка: {$fail['message']} | ID: {$fail['id']} $divider";
        }

        return $result;
    }

}