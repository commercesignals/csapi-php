<?php

namespace CommerceSignals;

class Logger {
  public static $level = 0;

  public function out($level, $message) {
    if (self::$level >= $level) {
      print "$message\n";
    }
  }
}
