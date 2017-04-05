<?php

namespace CommerceSignals;

class Logger {
  public static $level = 0;

  public static function out($level, $message) {
    if (self::$level >= $level) {
      print "$message\n";
    }
  }
}
