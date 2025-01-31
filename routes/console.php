<?php

use Illuminate\Support\Facades\Schedule;

// Reset demo environment daily at midnight
Schedule::command('migrate:fresh')->dailyAt('00:00');
Schedule::command('db:seed')->dailyAt('00:00');
