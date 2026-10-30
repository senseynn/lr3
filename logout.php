<?php
require 'vendor/autoload.php';
session_start();
use App\Auth;

Auth::logout();