#!/bin/bash

if fuser -v /dev/video0 > /dev/null 2>&1; then
    printf "busy"
else
    printf "free"
fi