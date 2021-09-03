<?php

interface HolidayInterface{
    public function isHoliday($today);
    public function addHoliday($date);
}