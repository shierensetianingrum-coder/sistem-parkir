<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('member:reset-bulanan')
    ->monthlyOn(1, '00:01');