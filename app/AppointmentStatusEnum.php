<?php

namespace App;

enum AppointmentStatusEnum: string
{
    case Scheduled = 'Scheduled';
    case Completed = 'Completed';
    case Cancelled = 'Cancelled';

    case Pending = 'Pending';
}
