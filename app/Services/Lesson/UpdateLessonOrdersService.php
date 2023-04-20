<?php

namespace App\Services\Lesson;

use App\Exceptions\DomainException;
use App\Models\Lesson;
use Illuminate\Support\Facades\DB;

class UpdateLessonOrdersService
{

    public function __construct()
    {
    }

    public function execute(array $orders)
    {
        DB::beginTransaction();
        try {
            foreach ($orders as $order) {
                $lesson = Lesson::find($order['lesson_id']);
                $lesson->lesson_order = $order['lesson_order'];
                $lesson->save();
            }

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();

            throw new DomainException(['There was an error trying to update the lessons'], 500);
        }
    }
}
