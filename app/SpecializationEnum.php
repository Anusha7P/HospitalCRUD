<?php

namespace App;

enum SpecializationEnum: string
{
    case Cardiologist = 'cardiologist';
    case Dermatologist = 'dermatologist';
    case Pediatrician = 'pediatrician';
    case Neurologist = 'neurologist';
    case General = 'general';
}
