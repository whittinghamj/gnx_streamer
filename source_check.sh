#!/bin/bash

if fuser -v /dev/video0 > /dev/null 2>&1; then
    printf '%s\n' "device in use"
else
    printf '%s\n' "device available"
fi