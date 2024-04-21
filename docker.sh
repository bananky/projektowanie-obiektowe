#!/bin/zsh

docker run --rm -i -t -v ./:/home/student/projobj/ -p 8000:8000 kprzystalski/projobj-php