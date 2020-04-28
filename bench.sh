#!/bin/sh
set -e

php benchmark/memory_pdo.php

php benchmark/performance_pdo.php
