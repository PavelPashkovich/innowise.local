<?php

namespace system;

interface Validation
{
    public function validate($data): array|bool;
}