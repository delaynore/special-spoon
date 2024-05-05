<?php

namespace App\Enums;

enum AttacmentType: string
{
    case IMAGE = 'image';
    case VIDEO = 'video';
    case AUDIO = 'audio';
    case FILE = 'file';
}
