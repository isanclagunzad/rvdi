#!/bin/bash

BIN_DIR=/usr/local/bin

# Function to attempt PHP version switching
switch_php_version() {
    # Check if $BIN_DIR/php7 exists
    if [ -e $BIN_DIR/php7 ]; then
        # Rename $BIN_DIR/php to $BIN_DIR/php8 if it isn't already renamed
        if [ ! -e $BIN_DIR/php8 ]; then
            mv $BIN_DIR/php $BIN_DIR/php8
        fi

        # Rename $BIN_DIR/php7 to $BIN_DIR/php
        mv $BIN_DIR/php7 $BIN_DIR/php
        echo "Switched to PHP7."
    elif type php &>/dev/null; then
        # If PHP7 isn't available, check for any php command availability
        echo "Using the available PHP version."
    else
        echo "No PHP command is available."
        exit 1
    fi
}

# Revert to the original PHP configuration
revert_php_version() {
    # Revert only if $BIN_DIR/php7 was used
    if [ -e $BIN_DIR/php7 ]; then
        mv $BIN_DIR/php $BIN_DIR/php7
        if [ -e $BIN_DIR/php8 ]; then
            mv $BIN_DIR/php8 $BIN_DIR/php
        fi
        echo "Reverted to original PHP version."
    fi
}

# Attempt to switch PHP versions
switch_php_version

# Running composer with the provided parameter
composer "$1"
status=$?

# Revert PHP versions regardless of composer's exit status
revert_php_version

# Exit with the original exit status of the composer command
exit $status
