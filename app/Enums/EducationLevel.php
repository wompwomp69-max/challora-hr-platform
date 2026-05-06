<?php

namespace App\Enums;

enum EducationLevel: string
{
    case SMA_SMK = 'SMA/SMK';
    case D3 = 'D3';
    case S1 = 'S1';
    case S2 = 'S2';
    case S3 = 'S3';
    case DIPLOMA = 'diploma';
    case BACHELOR = 'bachelor';
    case MASTER = 'master';
    case PHD = 'phd';
}
