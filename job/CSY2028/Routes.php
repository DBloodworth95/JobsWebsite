<?php
namespace CSY2028;

use Authentication\Authentication;

interface Routes{
    public function getRoutes(): array;
    public function getAuth(): Authentication;
    public function getVarsForLayout($title, $output): array;
}