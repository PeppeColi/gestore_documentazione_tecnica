#!/bin/bash

docker-compose up -d

docker exec -u 501 gestore_documentazione_tecnica_standalone_php bash -c "src/install.sh"

