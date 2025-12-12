#!/bin/bash
mkdir -p wp-content
# Check if wp-content is empty
if [ -z "$(ls -A wp-content)" ]; then
    echo "Populating wp-content from wordpress:latest image..."
    # We use user 33 (www-data) or similar? 
    # Standard WP container runs as root/www-data.
    # If we run as root in the container, the files will be owned by root on the host (usually).
    # We might want to chown them to the current user?
    # But usually docker setup is tricky with permissions.
    # For now, let's just copy.
    docker run --rm -v "$(pwd)/wp-content:/target" wordpress:latest bash -c "cp -r /usr/src/wordpress/wp-content/* /target/"
    echo "Done."
else
    echo "wp-content is not empty, skipping population."
fi
