#!/usr/bin/env bash

# Run your build command
composer install --no-interaction --no-ansi --no-scripts

# Run your post-build command
echo "Running post-build command"
